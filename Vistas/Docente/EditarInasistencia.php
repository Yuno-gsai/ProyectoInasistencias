<?php
session_start();
if(!isset($_SESSION['docente'])){
    header("Location: /ProyectoInasistencias/index.php");
}
require_once "../../models/FaltasModel.php";


$dataDocente=$_SESSION['docente'];

$idInasistenciaId=$_GET['id'];

$inasistencia=new Faltas();
$inasistencias = $inasistencia->getByInasistenciaID($idInasistenciaId);

if(isset($_POST['Actualizar'])){
    // Procesar imagen de justificación si existe
    $justificacion_imagen = $inasistencias['justificacion_imagen']; // Mantener la existente
    
    if(isset($_FILES['justificacion_imagen']) && $_FILES['justificacion_imagen']['error'] === 0) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];
        $allowed_mime = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        
        $filename = $_FILES['justificacion_imagen']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        // Validar tipo MIME real
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['justificacion_imagen']['tmp_name']);
        finfo_close($finfo);
        
        if(in_array($ext, $allowed_ext) && in_array($mime, $allowed_mime) && $_FILES['justificacion_imagen']['size'] <= 5242880) {
            // Eliminar imagen anterior si existe
            if(!empty($inasistencias['justificacion_imagen'])) {
                $old_file = __DIR__ . '/../../uploads/justificaciones/' . $inasistencias['justificacion_imagen'];
                if(file_exists($old_file)) {
                    @unlink($old_file); // @ para suprimir warnings
                }
            }
            
            $newname = 'justificacion_' . time() . '_' . uniqid() . '.' . $ext;
            $upload_path = __DIR__ . '/../../uploads/justificaciones/' . $newname;
            
            // Crear directorio si no existe
            $upload_dir = dirname($upload_path);
            if(!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            if(move_uploaded_file($_FILES['justificacion_imagen']['tmp_name'], $upload_path)) {
                $justificacion_imagen = $newname;
            } else {
                error_log("Error upload editar: No se pudo mover a $upload_path");
            }
        } else {
            error_log("Validación fallida editar - ext: $ext, mime: $mime");
        }
    }
    
    // Eliminar imagen si se solicitó
    if(isset($_POST['eliminar_imagen']) && $_POST['eliminar_imagen'] == '1') {
        if(!empty($inasistencias['justificacion_imagen'])) {
            $old_file = __DIR__ . '/../../uploads/justificaciones/' . $inasistencias['justificacion_imagen'];
            if(file_exists($old_file)) {
                @unlink($old_file); // @ para suprimir warnings
            }
        }
        $justificacion_imagen = null;
    }
    
    $data = [
        'id_inasistencia' => $idInasistenciaId,
        'idalumno' => intval($_POST['idalumno']),
        'id_docente' => $dataDocente['id_docente'],
        'id_detalle' => intval($_POST['detalle']),
        'fecha_falta' => $_POST['fechaInasistencia'],
        'cantidadHoras' => $_POST['horasClase'],
        'observacion' => $_POST['observaciones'],
        'justificacion_texto' => $_POST['justificacion_texto'] ?? null,
        'justificacion_imagen' => $justificacion_imagen,
        'tiene_justificacion' => (!empty($_POST['justificacion_texto']) || $justificacion_imagen) ? 1 : 0
    ];
    if($inasistencia->update($data)){
        // Guardar mensaje de éxito en la sesión
        session_start();
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Inasistencia actualizada correctamente'
        ];
        // Redirigir inmediatamente
        header("Location: /ProyectoInasistencias/Vistas/Docente/CrudInasistencia.php");
        exit();
    } else {
        // Guardar mensaje de error en la sesión
        session_start();
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Error al actualizar la inasistencia',
            'details' => 'Por favor, intente nuevamente'
        ];
        // Redirigir de vuelta al formulario
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }
}


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Inasistencia - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .highlight { background-color: #fef3c7; font-weight: 600; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<!--Navbar-->
<nav class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-2 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <img src="../Publico/Imagenes/ItcaLogo.png" alt="Logo ITCA FEPADE" class="h-8">
            <p class="text-sm font-semibold text-gray-700">Registro de Inasistencias</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-700 font-medium" id="userName">Docente</span>
            <img id="profileImage" src="../Publico/Imagenes/PerfilPrueba.jpg" alt="Foto docente"
                 class="rounded-full w-8 h-8 object-cover border border-gray-200">
            <button id="backBtn"
                    class="flex items-center bg-gray-600 text-white py-1 px-3 rounded-md text-sm hover:bg-gray-700 transition">
                <i class="fas fa-arrow-left mr-1"></i>
                <span class="hidden sm:inline">Regresar</span>
            </button>
            <button id="logoutBtn"
                    class="flex items-center bg-red-600 text-white py-1 px-3 rounded-md text-sm hover:bg-red-700 transition">
                <i class="fas fa-sign-out-alt mr-1"></i>
                <span class="hidden sm:inline">Salir</span>
            </button>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="flex justify-center bg-gray-100 mt-8 px-4">
    <div class="bg-white rounded-xl shadow-lg p-6 max-w-6xl w-full">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Editar Inasistencia</h2>

        <form id="editForm" method="post" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Información del Estudiante (Solo lectura) -->
            <div>
                <div class="bg-green-50 border-l-4 border-green-600 p-4 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-2 rounded-full mr-3">
                            <i class="fas fa-user text-green-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800">Información del Estudiante</h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <input type="hidden" id="idalumno" name="idalumno">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Carnet</label>
                            <input type="text" id="carnet" name="carnet" readonly class="w-full p-2 bg-gray-100 border border-gray-200 rounded text-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                            <input type="text" id="apellidos" name="apellidos" readonly class="w-full p-2 bg-gray-100 border border-gray-200 rounded text-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombres</label>
                            <input type="text" id="nombres" name="nombres" readonly class="w-full p-2 bg-gray-100 border border-gray-200 rounded text-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
                            <input type="text" id="carrera" name="carrera" readonly class="w-full p-2 bg-gray-100 border border-gray-200 rounded text-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                            <input type="text" id="grupo" name="grupo" readonly class="w-full p-2 bg-gray-100 border border-gray-200 rounded text-gray-600">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos de la Inasistencia (Editable) -->
            <div>
                <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-100 p-2 rounded-full mr-3">
                            <i class="fas fa-clipboard-list text-red-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800">Datos de la Inasistencia</h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <input type="hidden" id="detalle" name="detalle">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inasistencia <span class="text-red-500">*</span></label>
                            <input type="date" id="fechaInasistencia" name="fechaInasistencia" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                            <p id="errorFecha" class="text-sm text-red-600 mt-1 hidden">La fecha no puede ser futura.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Horas de Clase <span class="text-red-500">*</span></label>
                            <input type="number" id="horasClase" name="horasClase" required min="1" step="1" placeholder="Ej: 1, 2, 3, 4" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500" />
                            <p id="errorHora" class="text-sm text-red-600 mt-1 hidden">Ingrese un número de horas válido (mínimo 1).</p>
                        </div>
                        <!-- <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Materia</label>
                            <input type="text" id="materia" name="materia" readonly class="w-full p-2 bg-gray-100 border border-gray-200 rounded text-gray-600">
                        </div> -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                            <textarea id="observaciones" name="observaciones" rows="3" placeholder="Comentarios adicionales (opcional)" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500 resize-none"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Justificación -->
            <div class="lg:col-span-2">
                <div class="bg-yellow-50 border-l-4 border-yellow-600 p-4 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="bg-yellow-100 p-2 rounded-full mr-3">
                            <i class="fas fa-file-alt text-yellow-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800">Justificación (Opcional)</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-align-left mr-1"></i>Justificación Escrita
                            </label>
                            <textarea id="justificacion_texto" name="justificacion_texto" rows="4"
                                      placeholder="Escriba la justificación de la inasistencia..."
                                      class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500 resize-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-image mr-1"></i>Documento o Imagen
                            </label>
                            
                            <!-- Imagen actual -->
                            <div id="imagenActual" class="hidden mb-3">
                                <div class="bg-white border border-gray-300 rounded p-2">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-700">Imagen actual:</span>
                                        <button type="button" onclick="eliminarImagen()" class="text-red-600 hover:text-red-800 text-xs">
                                            <i class="fas fa-trash mr-1"></i>Eliminar
                                        </button>
                                    </div>
                                    <img id="imagenActualPreview" src="" alt="Justificación" class="max-w-full h-32 rounded border object-contain">
                                    <p id="imagenActualNombre" class="text-xs text-gray-500 mt-1"></p>
                                </div>
                            </div>
                            <input type="hidden" id="eliminar_imagen" name="eliminar_imagen" value="0">
                            
                            <input type="file" id="justificacion_imagen" name="justificacion_imagen" 
                                   accept="image/*,.pdf"
                                   class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>Formatos: JPG, PNG, PDF (Máx. 5MB)
                            </p>
                            <div id="imagePreview" class="mt-2 hidden">
                                <p class="text-xs text-gray-600 mb-1">Nueva imagen:</p>
                                <img id="previewImg" src="" alt="Vista previa" class="max-w-full h-32 rounded border object-contain">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-center space-x-4 mt-8 lg:col-span-2">
                <button type="button" id="cancelBtn" class="bg-gray-500 text-white py-2 px-6 rounded-lg hover:bg-gray-600 transition">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </button>
                <button type="submit" name="Actualizar" class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 transition">
                    <i class="fas fa-save mr-2"></i>Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    // Datos estáticos base (simulación). En real, se consultaría por ID.

    function getQueryId() {
        const params = new URLSearchParams(window.location.search);
        return parseInt(params.get('id'), 10);
    }

    function setTodayMaxOnFecha(input) {
        const today = new Date();
        const tzOffset = new Date(today.getTime() - (today.getTimezoneOffset() * 60000));
        input.setAttribute('max', tzOffset.toISOString().split('T')[0]);
    }

    function isFechaFutura(value) {
        if (!value) return false;
        const inputDate = new Date(value + 'T00:00:00');
        const today = new Date(); today.setHours(0,0,0,0);
        return inputDate > today;
    }

    function validarCamposYActualizarUI() {
        const fechaInput = document.getElementById('fechaInasistencia');
        const horasInput = document.getElementById('horasClase');
        const errorFecha = document.getElementById('errorFecha');
        const errorHora = document.getElementById('errorHora');


        const fecha = fechaInput.value;
        const fechaEsFutura = isFechaFutura(fecha);
        if (fecha && fechaEsFutura) {
            errorFecha.classList.remove('hidden');
            fechaInput.setCustomValidity('La fecha no puede ser futura.');
        } else {
            errorFecha.classList.add('hidden');
            fechaInput.setCustomValidity('');
        }

        const horasVal = parseInt(horasInput.value, 10);
        if (!horasInput.value || isNaN(horasVal) || horasVal < 1) {
            errorHora.classList.remove('hidden');
            horasInput.setCustomValidity('Ingrese un número de horas válido (mínimo 1).');
        } else {
            errorHora.classList.add('hidden');
            horasInput.setCustomValidity('');
        }

        return document.getElementById('editForm').checkValidity() && !fechaEsFutura;
    }

    // Cargar datos por ID
    document.addEventListener('DOMContentLoaded', function() {
        const id = getQueryId();
        const item =  <?php echo json_encode($inasistencias); ?>;

        document.getElementById('carnet').value = item.carnet;
        document.getElementById('apellidos').value = item.apellido;
        document.getElementById('nombres').value = item.nombre;
        document.getElementById('carrera').value = item.materia;
        document.getElementById('grupo').value = item.grupo;
        document.getElementById('fechaInasistencia').value = item.fecha_falta;
        document.getElementById('horasClase').value = item.cantidadHoras;
        document.getElementById('observaciones').value = item.observacion || '';
        document.getElementById('idalumno').value = item.idalumno;
        document.getElementById('detalle').value = item.id_detalle;
        
        // Cargar justificación
        if(item.justificacion_texto) {
            document.getElementById('justificacion_texto').value = item.justificacion_texto;
        }
        
        // Mostrar imagen actual si existe
        if(item.justificacion_imagen) {
            const imagenActual = document.getElementById('imagenActual');
            const imagenPreview = document.getElementById('imagenActualPreview');
            const imagenNombre = document.getElementById('imagenActualNombre');
            
            imagenActual.classList.remove('hidden');
            imagenPreview.src = '../../uploads/justificaciones/' + item.justificacion_imagen;
            imagenNombre.textContent = item.justificacion_imagen;
        }

        setTodayMaxOnFecha(document.getElementById('fechaInasistencia'));
        validarCamposYActualizarUI();
        
        // Vista previa de nueva imagen
        const fileInput = document.getElementById('justificacion_imagen');
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 5242880) {
                    alert('El archivo no debe superar los 5MB');
                    fileInput.value = '';
                    preview.classList.add('hidden');
                    return;
                }
                
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        preview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.classList.add('hidden');
                }
            }
        });
    });
    
    // Función para eliminar imagen
    function eliminarImagen() {
        if(confirm('¿Está seguro que desea eliminar la imagen de justificación?')) {
            document.getElementById('eliminar_imagen').value = '1';
            document.getElementById('imagenActual').classList.add('hidden');
        }
    }

    // Submit
    document.getElementById('editForm').addEventListener('submit', function(e) {
        if (!validarCamposYActualizarUI()) return;
        // Simular guardado
        const msg = document.createElement('div');
        msg.className = 'mt-4 text-green-700 bg-green-100 border border-green-200 px-4 py-2 rounded lg:col-span-2';
        msg.textContent = 'Cambios guardados exitosamente.';
        document.getElementById('editForm').appendChild(msg);
        setTimeout(() => { window.location.href = 'CrudInasistencia.php'; }, 1200);
    });

    // Eventos
    document.getElementById('fechaInasistencia').addEventListener('input', validarCamposYActualizarUI);
    document.getElementById('horasClase').addEventListener('input', validarCamposYActualizarUI);

    // Navegación
    document.getElementById('backBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea regresar? Se perderán los cambios no guardados.')) {
            window.location.href = 'CrudInasistencia.php';
        }
    });
    document.getElementById('cancelBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea cancelar? Se perderán los cambios no guardados.')) {
            window.location.href = 'CrudInasistencia.php';
        }
    });
    document.getElementById('logoutBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea cerrar sesión?')) {
            window.location.href = '../Login/Login.php';
        }
    });
</script>
</body>
</html>
