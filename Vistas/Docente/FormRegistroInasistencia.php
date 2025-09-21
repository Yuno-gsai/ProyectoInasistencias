<?php
session_start();
if(!isset($_SESSION['docente'])){
    header("Location: /ProyectoInasistenciasItca/index.php");
}

$dataDocente = $_SESSION['docente'];

require_once "../../models/AlumnoModels.php";
require_once "../../models/FaltasModel.php";
require_once "../../models/DetalleModel.php";

$alumno = new Alumno();
$faltas = new Faltas();
$detalles = new DetalleModel();

$estudiantes = $alumno->getAll();
$DetallesDocente = $detalles->getAllByDocenteId($dataDocente['id_docente']);
// Convertir el array de PHP a JSON para usarlo en JavaScript

$estudiantes_json = json_encode($estudiantes);
$DetallesDocente_json = json_encode($DetallesDocente);



if(isset($_POST['RegistrarAsistencia'])) {
    $data = [
        'idalumno' => intval($_POST['idalumno']),
        'id_docente' => $dataDocente['id_docente'],
        'id_detalle' => intval($_POST['detalle']),
        'fecha_falta' => $_POST['fechaInasistencia'],
        'cantidadHoras' => $_POST['horasClase'],
        'observacion' => $_POST['observaciones']
    ];
    if($faltas->create($data)){
        echo "<script>
            // Esperar a que el DOM esté completamente cargado
            document.addEventListener('DOMContentLoaded', function() {
                // Verificar si SweetAlert2 está cargado
                if (typeof Swal !== 'undefined') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        width: '350px',
                        padding: '1rem',
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });

                    Toast.fire({
                        icon: 'success',
                        title: 'Inasistencia registrada correctamente',
                        background: '#d4edda',
                        color: '#155724',
                        iconColor: '#28a745',
                        customClass: {
                            container: 'swal2-container-custom',
                            popup: 'swal2-popup-custom',
                            title: 'swal2-title-custom',
                            htmlContainer: 'swal2-html-custom'
                        }
                    });
                    
                    // Limpiar el formulario después de registrar
                    document.getElementById('inasistenciaForm').reset();
                    document.getElementById('studentSearch').value = '';
                    document.getElementById('attendanceForm').classList.add('hidden');
                } else {
                    console.error('Error: SweetAlert2 no está cargado correctamente');
                }
            });
        </script>";
    }
    else{
        echo "<script>
            // Esperar a que el DOM esté completamente cargado
            document.addEventListener('DOMContentLoaded', function() {
                // Verificar si SweetAlert2 está cargado
                if (typeof Swal !== 'undefined') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: true,
                        confirmButtonText: 'Entendido',
                        showCloseButton: true,
                        timer: 5000,
                        timerProgressBar: true,
                        width: '350px',
                        padding: '1rem',
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });

                    Toast.fire({
                        icon: 'error',
                        title: 'Error al registrar la inasistencia',
                        text: 'Por favor, intente nuevamente',
                        background: '#f8d7da',
                        color: '#721c24',
                        iconColor: '#dc3545',
                        customClass: {
                            container: 'swal2-container-custom',
                            popup: 'swal2-popup-custom',
                            title: 'swal2-title-custom',
                            htmlContainer: 'swal2-html-custom'
                        }
                    });
                } else {
                    console.error('Error: SweetAlert2 no está cargado correctamente');
                    alert('Error al registrar la inasistencia. Por favor, intente nuevamente.');
                }
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Inasistencia - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        .search-result:hover {
            background-color: #f3f4f6;
        }
        .form-section {
            transition: all 0.3s ease;
        }
        .highlight {
            background-color: #fef3c7;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<!--Navbar-->
<nav class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-2 flex justify-between items-center">
        <!-- Logo e Identidad -->
        <div class="flex items-center space-x-2">
            <img src="../Publico/Imagenes/ItcaLogo.png" alt="Logo ITCA FEPADE" class="h-8">
            <p class="text-sm font-semibold text-gray-700">Registro de Inasistencias</p>
        </div>
        <!-- Usuario y Botón -->
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-700 font-medium" id="userName"><?php echo $dataDocente['nom_usuario'] . ' ' . $dataDocente['ape_usuario']; ?></span>
            
            <button id="backBtn" type="button"
                    class="flex items-center bg-gray-600 text-white py-1 px-3 rounded-md text-sm hover:bg-gray-700 transition"
                    onclick="history.back()">
                <i class="fas fa-arrow-left mr-1"></i>
                <span class="hidden sm:inline">Regresar</span>
            </button>
            <button id="logoutBtn" type="button"
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
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Registrar Inasistencia</h2>

        <!-- Selectores de Filtrado -->
        <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Selector de Ciclo -->
            <div class="bg-indigo-50 border-l-4 border-indigo-400 p-2 rounded-lg hover:shadow transition-shadow">
                <div class="flex items-center gap-1 mb-1">
                    <i class="fa-solid fa-calendar-days text-indigo-500 text-sm"></i>
                    <h3 class="font-medium text-gray-700 text-sm">Ciclo</h3>
                </div>
                <select id="selectCiclo"
                        class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm py-1.5"
                        aria-label="Seleccione un ciclo">
                    <option value="">Seleccione...</option>
                    <?php 
                    $ciclos = array_unique(array_column($DetallesDocente, 'ciclo'));
                    foreach ($ciclos as $ciclo) { 
                    ?>
                        <option value="<?php echo $ciclo; ?>"><?php echo $ciclo; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Selector de Año -->
            <div class="bg-cyan-50 border-l-4 border-cyan-400 p-2 rounded-lg hover:shadow transition-shadow">
                <div class="flex items-center gap-1 mb-1">
                    <i class="fa-solid fa-calendar text-cyan-500 text-sm"></i>
                    <h3 class="font-medium text-gray-700 text-sm">Año</h3>
                </div>
                <select id="selectYear"
                        class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm py-1.5"
                        aria-label="Seleccione un año"
                        disabled>
                    <option value="">Seleccione ciclo</option>
                </select>
            </div>

            <!-- Selector de Grupo -->
            <div class="bg-emerald-50 border-l-4 border-emerald-400 p-2 rounded-lg hover:shadow transition-shadow">
                <div class="flex items-center gap-1 mb-1">
                    <i class="fa-solid fa-users text-emerald-500 text-sm"></i>
                    <h3 class="font-medium text-gray-700 text-sm">Grupo</h3>
                </div>
                <select id="selectGrupo"
                        class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm py-1.5"
                        aria-label="Seleccione un grupo"
                        disabled>
                    <option value="">Seleccione año</option>
                </select>
            </div>

            <!-- Selector de Materia -->
            <div class="bg-amber-50 border-l-4 border-amber-400 p-2 rounded-lg hover:shadow transition-shadow">
                <div class="flex items-center gap-1 mb-1">
                    <i class="fa-solid fa-book text-amber-500 text-sm"></i>
                    <h3 class="font-medium text-gray-700 text-sm">Materia</h3>
                </div>
                <select id="selectMateria"
                        class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm py-1.5"
                        aria-label="Seleccione una materia"
                        disabled>
                    <option value="">Seleccione año</option>
                </select>
            </div>
        </div>

        <!-- Búsqueda de Estudiante -->
        <div class="mb-8">
            <div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg">
                <div class="flex items-center mb-3">
                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                        <i class="fas fa-search text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800">Buscar Estudiante</h3>
                </div>

                <div class="relative">
                    <input type="text"
                           id="studentSearch"
                           placeholder="Escriba el nombre, apellido o carnet del estudiante..."
                           class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           autocomplete="off">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>

                    <!-- Indicador de búsqueda -->
                    <div id="searchLoader" class="absolute right-3 top-1/2 transform -translate-y-1/2 hidden">
                        <i class="fas fa-spinner fa-spin text-gray-400"></i>
                    </div>

                    <!-- Resultados de búsqueda -->
                    <div id="searchResults" class="absolute z-10 w-full bg-white border border-gray-200 rounded-lg mt-1 shadow-lg hidden max-h-60 overflow-y-auto">
                        <!-- Los resultados se cargarán aquí dinámicamente -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario de Inasistencia (Oculto inicialmente) -->
        <div id="attendanceForm" class="hidden">
            <form method="post" id="inasistenciaForm" class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Información del Estudiante (Solo lectura) -->
                <div class="form-section">
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
                                <input type="text" id="carnet" name="carnet" readonly
                                       class="w-full p-2 bg-gray-100 border border-gray-200 rounded text-gray-600">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" readonly
                                       class="w-full p-2 bg-gray-100 border border-gray-200 rounded text-gray-600">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombres</label>
                                <input type="text" id="nombres" name="nombres" readonly
                                       class="w-full p-2 bg-gray-100 border border-gray-200 rounded text-gray-600">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Materia</label>
                                <input type="text" id="materia" name="materia" readonly
                                       class="w-full p-2 bg-gray-100 border border-gray-200 rounded text-gray-600">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                                <input type="text" id="grupo" name="grupo" readonly
                                       class="w-full p-2 bg-gray-100 border border-gray-200 rounded text-gray-600">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Datos de la Inasistencia (Editable) -->
                <div class="form-section">
                    <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-red-100 p-2 rounded-full mr-3">
                                <i class="fas fa-clipboard-list text-red-600"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800">Datos de la Inasistencia</h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inasistencia <span class="text-red-500">*</span></label>
                                <input type="date" id="fechaInasistencia" name="fechaInasistencia" required
                                       class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                                <p id="errorFecha" class="text-sm text-red-600 mt-1 hidden">La fecha no puede ser futura.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Horas de Clase <span class="text-red-500">*</span></label>
                                <input type="number" id="horasClase" name="horasClase" required min="1" step="1"
                                       placeholder="Ej: 1, 2, 3, 4" 
                                       class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500" />
                                <p id="errorHora" class="text-sm text-red-600 mt-1 hidden">Ingrese un número de horas válido (mínimo 1).</p>
                            </div>
                            <input type="hidden" id="detalle" name="detalle">


                            <!-- <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Materia</label>
                                <input type="text" id="materia" name="materia" readonly class="w-full p-2 bg-gray-100 border border-gray-200 rounded text-gray-600">
                            </div> -->

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                                <textarea id="observaciones" name="observaciones" rows="6"
                                          placeholder="Comentarios adicionales (opcional)"
                                          class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500 resize-none"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Botones de acción -->
                <div class="flex justify-center space-x-4 mt-8 lg:col-span-2">
                    <button type="button" id="cancelBtn"
                            class="bg-gray-500 text-white py-2 px-6 rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </button>
                    <button name="RegistrarAsistencia" type="submit" id="submitBtn" disabled
                            class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-save mr-2"></i>Registrar Inasistencia
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    // Esperar a que el DOM esté completamente cargado
    document.addEventListener('DOMContentLoaded', function() {
        // Botón de regresar
        const backBtn = document.getElementById('backBtn');
        if (backBtn) {
            backBtn.addEventListener('click', function() {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: 'Se perderán los datos no guardados',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, regresar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'DashboardDocente.php';
                    }
                });
            });
        }

        // Botón de cerrar sesión
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Cerrar sesión',
                    text: '¿Está seguro que desea cerrar sesión?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, cerrar sesión',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../Login/Logout.php';
                    }
                });
            });
        }
    });

    // Variable para rastrear el último select modificado
    let ultimoSelectModificado = null;
    
    // Función para manejar el evento de cambio en los select
    function manejarCambioSelect(event) {
        ultimoSelectModificado = event.target;
        actualizarDetalle();
    }
    
    // Agregar event listeners a los select
    document.getElementById("selectCiclo").addEventListener("change", manejarCambioSelect);
    document.getElementById("selectYear").addEventListener("change", manejarCambioSelect);
    document.getElementById("selectGrupo").addEventListener("change", manejarCambioSelect);
    document.getElementById("selectMateria").addEventListener("change", manejarCambioSelect);


    function actualizarDetalle() {
        const cicloSelect = document.getElementById("selectCiclo");
        const yearSelect = document.getElementById("selectYear");
        const grupoSelect = document.getElementById("selectGrupo");
        const materiaSelect = document.getElementById("selectMateria");
        const studentSearch = document.getElementById("studentSearch");
        const attendanceForm = document.getElementById("attendanceForm");
        
        // Deshabilitar búsqueda de estudiante hasta que los select sean válidos
        studentSearch.disabled = true;
        
        // Verificar si todos los select tienen un valor seleccionado
        if (!cicloSelect.value || !yearSelect.value || !grupoSelect.value || !materiaSelect.value) {
            document.getElementById("detalle").value = "";
            // Ocultar formulario si está visible
            if (attendanceForm) {
                attendanceForm.classList.add("hidden");
            }
            return; // Salir si algún select no tiene valor
        }
        
        const ciclo = cicloSelect.options[cicloSelect.selectedIndex].text;
        const year = yearSelect.options[yearSelect.selectedIndex].text;
        const grupo = grupoSelect.options[grupoSelect.selectedIndex].text;
        const materia = materiaSelect.options[materiaSelect.selectedIndex].text;

        // Buscar el detalle que coincida con los 4
        const detalle = detallesDocente.find(d =>
            d.ciclo == ciclo &&
            d.year == year &&
            d.grupo == grupo &&
            d.nombre_materia == materia
        );

        if(detalle) {
            document.getElementById("detalle").value = detalle.id_detalle;
            console.log("ID DETALLE seleccionado:", detalle.id_detalle);
            // Habilitar búsqueda de estudiante cuando los select son válidos
            studentSearch.disabled = false;
            studentSearch.focus();
        } else {
            // Solo limpiar el último select modificado que causó el error
            if (ultimoSelectModificado) {
                ultimoSelectModificado.value = "";
            }
            
            document.getElementById("detalle").value = "";
            
            // Ocultar formulario si está visible
            if (attendanceForm) {
                attendanceForm.classList.add("hidden");
            }
            
            console.log("No se encontró detalle con esa combinación");
                // Mostrar alerta solo si todos los campos estaban llenos
                if (ciclo && year && grupo && materia) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });

                    Toast.fire({
                        icon: 'warning',
                        title: 'Selección inválida: el grupo y la materia no corresponden',
                        background: '#fff3cd',
                        color: '#856404',
                        iconColor: '#ffc107'
                    });
                    
                    // Enfocar el select que causó el error
                    if (ultimoSelectModificado) {
                        setTimeout(() => {
                            ultimoSelectModificado.focus();
                        }, 100);
                    }
                }      }
}


    setTimeout(inicializarValoresPorDefecto, 300);

    // Convertir el JSON de PHP a un array de JavaScript
    const estudiantes = <?php echo $estudiantes_json; ?>;
    const detallesDocente = <?php echo json_encode($DetallesDocente); ?>;
    let selectedStudent = null;
    let searchTimeout = null;

    // Referencias a los elementos del formulario
    const selectCiclo = document.getElementById('selectCiclo');
    const selectYear = document.getElementById('selectYear');
    const selectGrupo = document.getElementById('selectGrupo');
    const selectMateria = document.getElementById('selectMateria');

    // Función para llenar selectores
    function llenarSelect(select, opciones, valorPredeterminado = '') {
        select.innerHTML = '';
        const optionDefault = document.createElement('option');
        optionDefault.value = '';
        optionDefault.textContent = valorPredeterminado;
        select.appendChild(optionDefault);

        opciones.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion.value;
            option.textContent = opcion.text;
            select.appendChild(option);
        });
    }

    // Manejar cambio en ciclo
    selectCiclo.addEventListener('change', function() {
        const ciclo = this.value;
        
        if (ciclo) {
            // Filtrar años disponibles para el ciclo seleccionado y eliminar duplicados
            const añosUnicos = [];
            const añosVistos = new Set();
            
            detallesDocente.forEach(item => {
                if (item.ciclo === ciclo && !añosVistos.has(item.year)) {
                    añosVistos.add(item.year);
                    añosUnicos.push({
                        value: item.year,
                        text: item.year
                    });
                }
            });
            
            // Ordenar los años de mayor a menor
            const años = añosUnicos.sort((a, b) => b.value - a.value);

            // Llenar selector de años
            llenarSelect(selectYear, años, 'Seleccione un año');
            selectYear.disabled = false;
            
            // Deshabilitar y limpiar selectores dependientes
            selectGrupo.disabled = true;
            selectMateria.disabled = true;
            selectGrupo.innerHTML = '<option value="">Seleccione año primero</option>';
            selectMateria.innerHTML = '<option value="">Seleccione año primero</option>';
        } else {
            // Si no hay ciclo seleccionado, deshabilitar y limpiar los demás selectores
            selectYear.disabled = true;
            selectGrupo.disabled = true;
            selectMateria.disabled = true;
            selectYear.innerHTML = '<option value="">Seleccione un ciclo primero</option>';
            selectGrupo.innerHTML = '<option value="">Seleccione año primero</option>';
            selectMateria.innerHTML = '<option value="">Seleccione año primero</option>';
        }
    });

    // Manejar cambio en año
    selectYear.addEventListener('change', function() {
        const ciclo = selectCiclo.value;
        const year = this.value;
        
        if (ciclo && year) {
            // Filtrar grupos disponibles para el ciclo y año seleccionados
            const gruposUnicos = [];
            const gruposVistos = new Set();
            
            detallesDocente.forEach(item => {
                const grupoKey = `${item.id_g}-${item.grupo}`;
                if (item.ciclo === ciclo && item.year == year && !gruposVistos.has(grupoKey)) {
                    gruposVistos.add(grupoKey);
                    gruposUnicos.push({
                        value: item.id_g,
                        text: item.grupo
                    });
                }
            });
            
            // Ordenar los grupos alfabéticamente
            const grupos = gruposUnicos.sort((a, b) => a.text.localeCompare(b.text));

            // Filtrar materias disponibles para el ciclo y año seleccionados
            const materiasUnicas = [];
            const materiasVistas = new Set();
            
            detallesDocente.forEach(item => {
                if (item.ciclo === ciclo && item.year == year && !materiasVistas.has(item.id_m)) {
                    materiasVistas.add(item.id_m);
                    materiasUnicas.push({
                        value: item.id_m,
                        text: item.nombre_materia
                    });
                }
            });
            
            // Ordenar las materias alfabéticamente
            const materias = materiasUnicas.sort((a, b) => a.text.localeCompare(b.text));

            // Llenar selectores de grupo y materia
            llenarSelect(selectGrupo, grupos, 'Seleccione un grupo');
            llenarSelect(selectMateria, materias, 'Seleccione una materia');
            
            // Habilitar selectores
            selectGrupo.disabled = false;
            selectMateria.disabled = false;
        } else {
            // Si no hay año seleccionado, deshabilitar y limpiar selectores de grupo y materia
            selectGrupo.disabled = true;
            selectMateria.disabled = true;
            selectGrupo.innerHTML = '<option value="">Seleccione año primero</option>';
            selectMateria.innerHTML = '<option value="">Seleccione año primero</option>';
        }
    });

    // Actualizar campos ocultos cuando se seleccionan grupo y materia
    selectGrupo.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('grupo').value = selectedOption.text;
    });

    selectMateria.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('materia').value = selectedOption.text;
    });

    document.getElementById('selectGrupo').addEventListener('change', function() {
        const selectedValue = this.options[this.selectedIndex].text;
        document.getElementById("grupo").value = selectedValue;
    });

    document.getElementById('selectMateria').addEventListener('change', function() {
        const selectedValue = this.options[this.selectedIndex].text;
        document.getElementById("materia").value = selectedValue;
    });

    

    // Función para destacar coincidencias en el texto
    function highlightMatch(text, searchTerm) {
        if (!searchTerm.trim()) return text;
        // Escapar correctamente caracteres especiales para el RegExp
        const escaped = searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp(`(${escaped})`, 'gi');
        return text.replace(regex, '<span class="highlight">$1</span>');
    }

    // Normalización: sin mayúsculas, tildes ni signos
    function normalizeText(text) {
        return (text || '')
            .toString()
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '') // quitar diacríticos
            .replace(/[^a-z0-9\s]/g, '') // quitar signos
            .replace(/\s+/g, ' ') // colapsar espacios
            .trim();
    }

    // Función de búsqueda mejorada con normalización
    function searchStudents(searchTerm) {
        const normalizedSearch = normalizeText(searchTerm);

        return estudiantes.filter(student => {
            const fullName = normalizeText(`${student.nombre} ${student.apellido}`);
            const reverseName = normalizeText(`${student.apellido} ${student.nombre}`);
            const nombres = normalizeText(student.nombre);
            const apellidos = normalizeText(student.apellido);
            const carnet = normalizeText(student.carnet);
            
            // Buscar en nombre, apellido o carnet
            return (
                fullName.includes(normalizedSearch) ||
                reverseName.includes(normalizedSearch) ||
                nombres.includes(normalizedSearch) ||
                apellidos.includes(normalizedSearch) ||
                carnet.includes(normalizedSearch)
            );
        }).sort((a, b) => {
            // Priorizar coincidencias exactas en nombres
            const aFullName = normalizeText(`${a.nombre} ${a.apellido}`);
            const bFullName = normalizeText(`${b.nombre} ${b.apellido}`);

            const aStartsWith = aFullName.startsWith(normalizedSearch);
            const bStartsWith = bFullName.startsWith(normalizedSearch);

            if (aStartsWith && !bStartsWith) return -1;
            if (!aStartsWith && bStartsWith) return 1;

            // Ordenar alfabéticamente por nombre
            return a.nombre.localeCompare(b.nombre);
        });
    }

    // Búsqueda dinámica optimizada
    document.getElementById('studentSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.trim();
        const resultsContainer = document.getElementById('searchResults');
        const searchLoader = document.getElementById('searchLoader');
        
        // Limpiar resultados anteriores
        resultsContainer.innerHTML = '';
        resultsContainer.classList.add('hidden');
        
        // Si el término de búsqueda es muy corto, no hacer nada
        if (searchTerm.length < 1) {
            searchLoader.classList.add('hidden');
            return;
        }
        
        // Mostrar indicador de carga
        searchLoader.classList.remove('hidden');
        
        // Usar setTimeout para dar tiempo a la UI de actualizar
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {

            const filteredStudents = searchStudents(searchTerm);
            searchLoader.classList.add('hidden');

            if (filteredStudents.length > 0) {
                resultsContainer.innerHTML = filteredStudents.map(student => {
                    const fullName = `${student.nombre} ${student.apellido}`;
                    const highlightedName = highlightMatch(fullName, searchTerm);
                    const highlightedCarnet = highlightMatch(student.carnet, searchTerm);

                    return `
                        <div class="search-result p-3 cursor-pointer border-b border-gray-100 last:border-b-0 hover:bg-blue-50 transition-colors"
                             data-student='${JSON.stringify(student)}'>
                            <div class="font-medium text-gray-800">${highlightedName}</div>
                            <div class="text-sm text-gray-600">
                                <span>Carnet: ${highlightedCarnet}</span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">${student.email || ''}</div>
                        </div>
                    `;
                }).join('');
                resultsContainer.classList.remove('hidden');
            } else {
                resultsContainer.innerHTML = `
                    <div class="p-4 text-gray-500 text-center">
                        <i class="fas fa-user-slash text-2xl mb-2"></i>
                        <div>No se encontraron estudiantes</div>
                        <div class="text-xs">Intente con otro término de búsqueda</div>
                    </div>
                `;
                resultsContainer.classList.remove('hidden');
            }
        }, 300);
    });

    // Selección de estudiante mejorada
    document.addEventListener('click', function(e) {
        const searchResult = e.target.closest('.search-result');
        if (searchResult && searchResult.dataset.student) {
            const studentData = JSON.parse(searchResult.dataset.student);
            selectStudent(studentData);
        } else if (!e.target.closest('#studentSearch') && !e.target.closest('#searchResults')) {
            document.getElementById('searchResults').classList.add('hidden');
        }
    });

    // Navegación con teclado en resultados de búsqueda
    document.getElementById('studentSearch').addEventListener('keydown', function(e) {
        const resultsContainer = document.getElementById('searchResults');
        const results = resultsContainer.querySelectorAll('.search-result');

        if (results.length === 0) return;

        let selectedIndex = -1;
        results.forEach((result, index) => {
            if (result.classList.contains('bg-blue-100')) {
                selectedIndex = index;
                result.classList.remove('bg-blue-100');
            }
        });

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = (selectedIndex + 1) % results.length;
            results[selectedIndex].classList.add('bg-blue-100');
            results[selectedIndex].scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = selectedIndex <= 0 ? results.length - 1 : selectedIndex - 1;
            results[selectedIndex].classList.add('bg-blue-100');
            results[selectedIndex].scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'Enter' && selectedIndex >= 0) {
            e.preventDefault();
            const studentData = JSON.parse(results[selectedIndex].dataset.student);
            selectStudent(studentData);
        } else if (e.key === 'Escape') {
            resultsContainer.classList.add('hidden');
        }
    });

    function selectStudent(student) {
        selectedStudent = student;

        // Llenar los campos del estudiante
        document.getElementById('carnet').value = student.carnet;
        document.getElementById('apellidos').value = student.apellido;
        document.getElementById('nombres').value = student.nombre;
        document.getElementById('idalumno').value = student.idalumno;

        // Actualizar el campo de búsqueda
        document.getElementById('studentSearch').value = `${student.nombre} ${student.apellido}`;

        // Ocultar resultados y mostrar formulario
        document.getElementById('searchResults').classList.add('hidden');
        document.getElementById('attendanceForm').classList.remove('hidden');

        // Establecer fecha actual por defecto
        const today = new Date();
        const tzOffsetToday = new Date(today.getTime() - (today.getTimezoneOffset() * 60000));
        document.getElementById('fechaInasistencia').value = tzOffsetToday.toISOString().split('T')[0];

        validarCamposYActualizarUI();

        // Scroll suave al formulario
        document.getElementById('attendanceForm').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    // Botón cancelar -> Confirmar y redirigir al dashboard docente
    document.getElementById('cancelBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea cancelar? Se perderán los datos no guardados.')) {
            window.location.href = 'DashboardDocente.php';
        }
    });

    // Utilidades de validación y control de envío
    const form = document.getElementById('inasistenciaForm');
    const submitBtn = document.getElementById('submitBtn');
    const fechaInput = document.getElementById('fechaInasistencia');
    const horasInput = document.getElementById('horasClase');
    const materiaInput = document.getElementById('materia');
    const errorFecha = document.getElementById('errorFecha');
    const errorHora = document.getElementById('errorHora');

    function setTodayMaxOnFecha() {
        const today = new Date();
        const tzOffset = new Date(today.getTime() - (today.getTimezoneOffset() * 60000));
        const todayStr = tzOffset.toISOString().split('T')[0];
        fechaInput.setAttribute('max', todayStr);
    }

    function isFechaFutura(value) {
        if (!value) return false;
        const inputDate = new Date(value + 'T00:00:00');
        const today = new Date();
        today.setHours(0,0,0,0);
        return inputDate > today;
    }

    function validarCamposYActualizarUI() {
        // Validación de fecha no futura
        const fecha = fechaInput.value;
        const fechaEsFutura = isFechaFutura(fecha);
        if (fecha && fechaEsFutura) {
            errorFecha.classList.remove('hidden');
            fechaInput.setCustomValidity('La fecha no puede ser futura.');
        } else {
            errorFecha.classList.add('hidden');
            fechaInput.setCustomValidity('');
        }

        // Validación de horas (número >= 1)
        const horasVal = parseInt(horasInput.value, 10);
        if (!horasInput.value || isNaN(horasVal) || horasVal < 1) {
            errorHora.classList.remove('hidden');
            horasInput.setCustomValidity('Ingrese un número de horas válido (mínimo 1).');
        } else {
            errorHora.classList.add('hidden');
            horasInput.setCustomValidity('');
        }

        // Habilitar botón solo si hay estudiante seleccionado y el form es válido
        if (selectedStudent && form.checkValidity() && !fechaEsFutura) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    // Validar campos antes de enviar el formulario
    form.addEventListener('submit', function(e) {
        // Validar campos
        validarCamposYActualizarUI();
        
        // Si el botón está deshabilitado, prevenir el envío
        if (submitBtn.disabled) {
            e.preventDefault();
            return false;
        }
        
        // Mostrar datos que se van a enviar (para depuración)
        console.log('Datos del formulario:', {
            idalumno: document.getElementById('idalumno').value,
            fechaInasistencia: document.getElementById('fechaInasistencia').value,
            horasClase: document.getElementById('horasClase').value,
            detalle: document.getElementById('detalle').value,
            observaciones: document.getElementById('observaciones').value
        });
        
        // El formulario se enviará normalmente con PHP
        return true;
    });

    // Escuchar cambios para validar en tiempo real
    fechaInput.addEventListener('input', validarCamposYActualizarUI);
    horasInput.addEventListener('input', validarCamposYActualizarUI);
    materiaSelect.addEventListener('change', validarCamposYActualizarUI);

    // Función para resetear el formulario
    function resetForm() {
        selectedStudent = null;
        document.getElementById('studentSearch').value = '';
        document.getElementById('attendanceForm').classList.add('hidden');
        document.getElementById('searchResults').classList.add('hidden');

        // Limpiar campos del formulario
        document.querySelectorAll('input, select, textarea').forEach(field => {
            if (field.id !== 'studentSearch') {
                field.value = '';
            }
        });

        // Ocultar errores y deshabilitar envío
        errorFecha.classList.add('hidden');
        errorHora.classList.add('hidden');
        errorMateria.classList.add('hidden');
        submitBtn.disabled = true;

        // Enfocar en el campo de búsqueda
        document.getElementById('studentSearch').focus();
    }

    // Botón regresar -> Confirmar y redirigir al dashboard docente


    // Función para inicializar los valores por defecto
    function inicializarValoresPorDefecto() {
        // Establecer ciclo y año actual por defecto
        const añoActual = new Date().getFullYear();
        const mesActual = new Date().getMonth() + 1;
        const cicloActual = (mesActual <= 6) ? "I" : "II";
        
        // Asegurarse de que los elementos existan antes de intentar establecer sus valores
        const selectCiclo = document.getElementById('selectCiclo');
        const selectYear = document.getElementById('selectYear');
        
        if (selectCiclo && selectYear) {
            // Establecer el valor del ciclo
            selectCiclo.value = cicloActual;
            
            // Forzar el evento change para cargar los años
            if (selectCiclo.dispatchEvent) {
                const event = new Event('change', { bubbles: true });
                selectCiclo.dispatchEvent(event);
            }
            
            // Usar setTimeout para asegurar que el evento change se haya procesado
            setTimeout(() => {
                // Verificar si el año actual está disponible en las opciones
                const añoExiste = Array.from(selectYear.options).some(option => 
                    option.value == añoActual
                );
                
                // Si el año actual está disponible, seleccionarlo
                if (añoExiste) {
                    selectYear.value = añoActual;
                    // Disparar el evento change del año
                    if (selectYear.dispatchEvent) {
                        const yearEvent = new Event('change', { bubbles: true });
                        selectYear.dispatchEvent(yearEvent);
                    }
                } else if (selectYear.options.length > 0) {
                    // Si el año actual no está disponible, seleccionar el primer año disponible
                    selectYear.selectedIndex = 0;
                    if (selectYear.dispatchEvent) {
                        const yearEvent = new Event('change', { bubbles: true });
                        selectYear.dispatchEvent(yearEvent);
                    }
                }
            }, 100);
        }
    }

    // Enfocar automáticamente en el campo de búsqueda al cargar y setear max en fecha
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('studentSearch').focus();
        setTodayMaxOnFecha();
        validarCamposYActualizarUI();
        
        // Esperar un momento para asegurar que todo el DOM esté listo
    }); 


    // document.getElementById('selectCliclo').addEventListener('change', function() {
    //     const selectedValue = this.value;
    //     document.getElementById('selectYear').value = selectedValue;
    // });

    // document.getElementById('selectYear').addEventListener('change', function() {
    //     const selectedValue = this.value;
    //     console.log('Año seleccionado:', selectedValue);
    // });




</script>
</body>
</html>