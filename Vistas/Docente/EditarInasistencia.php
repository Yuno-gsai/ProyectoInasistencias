<?php
session_start();
if(!isset($_SESSION['docente'])){
    header("Location: /ProyectoInasistenciasItca/index.php");
}
require_once "../../models/FaltasModel.php";


$dataDocente=$_SESSION['docente'];

$idInasistenciaId=$_GET['id'];

$inasistencia=new Faltas();
$inasistencias = $inasistencia->getByInasistenciaID($idInasistenciaId);

if(isset($_POST['Actualizar'])){
    $data = [
        'id_inasistencia' => $idInasistenciaId,
        'idalumno' => intval($_POST['idalumno']),
        'id_docente' => $dataDocente['id_docente'],
        'id_detalle' => intval($_POST['detalle']),
        'fecha_falta' => $_POST['fechaInasistencia'],
        'cantidadHoras' => $_POST['horasClase'],
        'observacion' => $_POST['observaciones']
    ];
    if($inasistencia->update($data)){
        // Guardar mensaje de éxito en la sesión
        session_start();
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Inasistencia actualizada correctamente'
        ];
        // Redirigir inmediatamente
        header("Location: /ProyectoInasistenciasItca/Vistas/Docente/CrudInasistencia.php");
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

        <form id="editForm" method="post" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
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
        const materiaInput = document.getElementById('materia');
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

        if (!materiaSelect.value) {
            errorMateria.classList.remove('hidden');
        } else {
            errorMateria.classList.add('hidden');
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

        setTodayMaxOnFecha(document.getElementById('fechaInasistencia'));
        validarCamposYActualizarUI();
    });

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
    document.getElementById('materia').addEventListener('change', validarCamposYActualizarUI);

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
