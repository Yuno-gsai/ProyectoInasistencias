<?php
require_once "../../models/FaltasModel.php";
$alumnos = (new Faltas())->getAllAlumnos();
// Asegurarse de que $alumnos sea un array
$alumnos = is_array($alumnos) ? $alumnos : [];
$alumnos_json = json_encode($alumnos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Listado de Estudiantes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Datos de los alumnos
        const alumnosData = <?php echo $alumnos_json; ?>;
        
        // Obtener ciclos y años únicos
        const ciclosUnicos = [...new Set(alumnosData.map(a => a.ciclo).filter(Boolean))].sort();
        const añosUnicos = [...new Set(alumnosData.map(a => a.year).filter(Boolean))].sort((a, b) => b - a);
        
        // Obtener ciclo y año actual
        const fechaActual = new Date();
        const añoActual = fechaActual.getFullYear();
        const mesActual = fechaActual.getMonth() + 1; // Enero es 0
        const cicloActual = mesActual <= 6 ? 'I' : 'II';
        
        // Función para filtrar los alumnos
        function filtrarAlumnos() {
            const ciclo = document.getElementById('filtroCiclo').value;
            const year = document.getElementById('filtroYear').value;
            const busqueda = document.getElementById('busqueda').value.trim().toLowerCase();
            
            // Filtrar alumnos
            const resultados = alumnosData.filter(alumno => {
                // Filtrar por ciclo
                if (ciclo && alumno.ciclo !== ciclo) {
                    return false;
                }
                
                // Filtrar por año
                if (year && alumno.year != year) {
                    return false;
                }
                
                // Si hay texto de búsqueda, buscar en múltiples campos
                if (busqueda) {
                    // Buscar en carnet, nombre, apellido y correo
                    const enCarnet = alumno.carnet && alumno.carnet.toLowerCase().includes(busqueda);
                    const enNombre = alumno.nombre && alumno.nombre.toLowerCase().includes(busqueda);
                    const enApellido = alumno.apellido && alumno.apellido.toLowerCase().includes(busqueda);
                    const enEmail = alumno.email && alumno.email.toLowerCase().includes(busqueda);
                    
                    // Si no coincide con ningún campo, filtrar este alumno
                    if (!enCarnet && !enNombre && !enApellido && !enEmail) {
                        return false;
                    }
                }
                
                return true;
            });
            
            actualizarTabla(resultados);
        }
        
        // Función para actualizar la tabla con los resultados
        function actualizarTabla(alumnos) {
            const tbody = document.getElementById('tablaAlumnos');
            if (!tbody) {
                console.error('No se encontró el elemento con ID tablaAlumnos');
                return;
            }
            tbody.innerHTML = '';
            
            if (alumnos.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="px-4 py-3 text-center text-black">
                            No se encontraron resultados
                        </td>
                    </tr>`;
                return;
            }
            
            alumnos.forEach(alumno => {
                const tr = document.createElement('tr');
                tr.className = 'border-b border-gray-500';
                tr.innerHTML = `
                    <td class="px-4 py-3 text-black">${alumno.carnet}</td>
                    <td class="px-4 py-3 text-black">${alumno.nombre}</td>
                    <td class="px-4 py-3 text-black">${alumno.apellido}</td>
                    <td class="px-4 py-3 text-black">${alumno.telefono || ''}</td>
                    <td class="px-4 py-3 text-black">${alumno.email || ''}</td>
                    <td class="px-4 py-3 text-black">${alumno.total_faltas || 0}</td>
                    <td class="px-4 py-3 text-black">${alumno.ciclo || ''}</td>
                    <td class="px-4 py-3 text-black">${alumno.year || ''}</td>
                    <td class="px-4 py-3">
                        <button class="bg-red-700 hover:bg-red-800 text-white px-3 py-1 text-xs rounded transition-colors">
                            Ver detalles
                        </button>
                    </td>`;
                tbody.appendChild(tr);
            });
        }
        
        // Función para llenar los selectores
        function llenarSelectores() {
            return new Promise((resolve) => {
                const cicloSelect = document.getElementById('filtroCiclo');
                const yearSelect = document.getElementById('filtroYear');
                
                // Llenar ciclos
                if (cicloSelect) {
                    cicloSelect.innerHTML = '<option value="">Todos los ciclos</option>';
                    ciclosUnicos.forEach(ciclo => {
                        const option = document.createElement('option');
                        option.value = ciclo;
                        option.textContent = ciclo;
                        cicloSelect.appendChild(option);
                    });
                }
                
                // Llenar años
                if (yearSelect) {
                    yearSelect.innerHTML = '<option value="">Todos los años</option>';
                    añosUnicos.forEach(year => {
                        const option = document.createElement('option');
                        option.value = year;
                        option.textContent = year;
                        yearSelect.appendChild(option);
                    });
                }
                
                // Esperar al siguiente ciclo de eventos para asegurar que el DOM se haya actualizado
                setTimeout(resolve, 0);
            });
        }

        // Función para aplicar los filtros por defecto
        function aplicarFiltrosPorDefecto() {
            return new Promise((resolve) => {
                const cicloSelect = document.getElementById('filtroCiclo');
                const yearSelect = document.getElementById('filtroYear');
                
                // Establecer valores por defecto si existen en los select
                if (cicloSelect && ciclosUnicos.includes(cicloActual)) {
                    cicloSelect.value = cicloActual;
                }
                
                if (yearSelect && añosUnicos.includes(añoActual)) {
                    yearSelect.value = añoActual;
                }
                
                // Esperar al siguiente ciclo de eventos para asegurar que los valores se hayan establecido
                setTimeout(() => {
                    // Aplicar filtros
                    filtrarAlumnos();
                    resolve();
                }, 0);
            });
        }

        // Inicializar la tabla al cargar la página
        document.addEventListener('DOMContentLoaded', async () => {
            console.log('Datos cargados:', alumnosData); // Para depuración
            
            try {
                // Llenar selectores y esperar a que terminen
                await llenarSelectores();
                
                // Aplicar filtros por defecto
                await aplicarFiltrosPorDefecto();
                
                // Inicializar la tabla si hay datos
                if (alumnosData && alumnosData.length > 0) {
                    // Forzar una nueva ejecución del filtrado después de un pequeño retraso
                    setTimeout(() => {
                        filtrarAlumnos();
                    }, 100);
                } else {
                    console.error('No se encontraron datos de alumnos');
                    const tbody = document.getElementById('tablaAlumnos');
                    if (tbody) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="9" class="px-4 py-3 text-center text-black">
                                    No hay datos disponibles
                                </td>
                            </tr>`;
                    }
                }
            } catch (error) {
                console.error('Error al inicializar la tabla:', error);
            }
        });
    </script>
</head>
<body class="bg-gray-200 min-h-screen">
    <!-- Header -->
    <header class="bg-gray-400 px-6 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo y navegación izquierda -->
            <div class="flex items-center space-x-4">
                <!-- Logo ITCA -->
                <div class="flex items-center">
                    <img src="LogoITCA_2024_FC_Moodle.png" alt="ITCA FEPADE" class="h-10 w-auto">
                </div>
                
                <!-- Botón Inicio -->
                <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 text-sm font-medium transition-colors">
                    Inicio
                </button>
            </div>
            
            <!-- Usuario derecha -->
            <div class="flex items-center space-x-3">
                <!-- Avatar -->
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <!-- Nombre usuario -->
                <span class="text-gray-800 text-sm font-medium">German</span>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="container mx-auto px-6 py-8">
        <!-- Barra de búsqueda y filtros -->
        <div class="bg-red-800 px-6 py-4 mb-6 rounded-t-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Filtro por Ciclo -->
                <div class="flex items-center space-x-3">
                    <label for="filtroCiclo" class="text-white font-medium whitespace-nowrap">Ciclo:</label>
                    <select id="filtroCiclo" onchange="filtrarAlumnos()" class="w-full px-3 py-1 border border-gray-300 rounded text-gray-800 bg-white">
                        <option value="">Todos los ciclos</option>
                        <!-- Se llenará dinámicamente con JavaScript -->
                    </select>
                </div>
                
                <!-- Filtro por Año -->
                <div class="flex items-center space-x-3">
                    <label for="filtroYear" class="text-white font-medium whitespace-nowrap">Año:</label>
                    <select id="filtroYear" onchange="filtrarAlumnos()" class="w-full px-3 py-1 border border-gray-300 rounded text-gray-800 bg-white">
                        <option value="">Todos los años</option>
                        <!-- Se llenará dinámicamente con JavaScript -->
                    </select>
                </div>
                
                <!-- Búsqueda unificada -->
                <div class="flex items-center space-x-3 col-span-2">
                    <label for="busqueda" class="text-white font-medium whitespace-nowrap">Buscar alumno:</label>
                    <input 
                        type="text" 
                        id="busqueda" 
                        onkeyup="filtrarAlumnos()" 
                        placeholder="Buscar por carnet, nombre, apellido o correo..." 
                        class="w-full px-3 py-1 border border-gray-300 rounded text-gray-800 bg-white"
                        autocomplete="off"
                    >
                </div>
            </div>
        </div>

        <!-- Tabla de estudiantes -->
        <div class="bg-gray-400 rounded-b-lg overflow-hidden shadow-lg">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-500">
                        <th class="px-4 py-3 text-left text-black font-semibold">Carnet</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">nombre</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">apellido</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">telefono</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">email</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">Faltas</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">ciclo</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">año</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">accion</th>
                    </tr>
                </thead>
                <tbody id="tablaAlumnos">
                    <!-- Los datos se cargarán dinámicamente con JavaScript -->
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>