<?php
require_once "../../models/AlumnoModels.php";

$alumno = new Alumno();
$estudiantes = $alumno->getAll();

// Convertir el array de PHP a JSON para usarlo en JavaScript
$estudiantes_json = json_encode($estudiantes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Inasistencia - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <span class="text-sm text-gray-700 font-medium" id="userName">Docente</span>
            <img id="profileImage"
                 src="../Publico/Imagenes/PerfilPrueba.jpg"
                 alt="Foto docente"
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
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Registrar Inasistencia</h2>

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
            <form id="inasistenciaForm" class="grid grid-cols-1 lg:grid-cols-2 gap-8">

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
                                <label class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
                                <input type="text" id="carrera" name="carrera" readonly
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

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Materia <span class="text-red-500">*</span></label>
                                <select id="materia" name="materia" required
                                        class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                                    <option value="">Seleccione una materia</option>
                                    <option value="Programación I">Programación I</option>
                                    <option value="Base de Datos">Base de Datos</option>
                                    <option value="Desarrollo Web">Desarrollo Web</option>
                                    <option value="Matemática">Matemática</option>
                                    <option value="Inglés Técnico">Inglés Técnico</option>
                                </select>
                                <p id="errorMateria" class="text-sm text-red-600 mt-1 hidden">Seleccione una materia.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                                <textarea id="observaciones" name="observaciones" rows="3"
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
                    <button type="submit" id="submitBtn" disabled
                            class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-save mr-2"></i>Registrar Inasistencia
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    // Convertir el JSON de PHP a un array de JavaScript
    const estudiantes = <?php echo $estudiantes_json; ?>;
    let selectedStudent = null;
    let searchTimeout = null;

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
        document.getElementById('carrera').value = student.carrera;
        document.getElementById('grupo').value = student.grupo;

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
    const materiaSelect = document.getElementById('materia');
    const errorFecha = document.getElementById('errorFecha');
    const errorHora = document.getElementById('errorHora');
    const errorMateria = document.getElementById('errorMateria');

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
        if (!materiaSelect.value) {
            errorMateria.classList.remove('hidden');
        } else {
            errorMateria.classList.add('hidden');
        }

        // Habilitar botón solo si hay estudiante seleccionado y el form es válido
        if (selectedStudent && form.checkValidity() && !fechaEsFutura) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    // Manejar envío del formulario con validación nativa + reglas adicionales
    form.addEventListener('submit', function(e) {
        validarCamposYActualizarUI();
        if (submitBtn.disabled) {
            // Dejar que el navegador muestre la validación nativa si aplica
            e.preventDefault();
            return;
        }
        e.preventDefault();
        // Simulación de éxito (datos estáticos)
        // Aquí en el futuro se haría un POST al servidor
        // Mostrar un pequeño feedback no intrusivo
        if (!document.getElementById('successMsg')) {
            const msg = document.createElement('div');
            msg.id = 'successMsg';
            msg.className = 'mt-4 text-green-700 bg-green-100 border border-green-200 px-4 py-2 rounded';
            msg.textContent = 'Inasistencia registrada exitosamente.';
            form.appendChild(msg);
            setTimeout(() => { msg.remove(); }, 3000);
        }
        resetForm();
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
    document.getElementById('backBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea regresar? Se perderán los datos no guardados.')) {
            window.location.href = 'DashboardDocente.php';
        }
    });

    document.getElementById('logoutBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea cerrar sesión?')) {
            window.location.href = '../Login/Login.php';
        }
    });

    // Enfocar automáticamente en el campo de búsqueda al cargar y setear max en fecha
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('studentSearch').focus();
        setTodayMaxOnFecha();
        validarCamposYActualizarUI();
    });
</script>
</body>
</html>