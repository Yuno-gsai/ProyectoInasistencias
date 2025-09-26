<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Seguimientos Finalizados</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'itca-red': '#B91C1C',
                        'itca-orange': '#EA580C'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <?php include 'menu.php'; ?>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Listado de Seguimientos Finalizados</h1>
            <p class="text-gray-600">Gestión y consulta de seguimientos completados</p>
        </div>

        <!-- Search Section -->
        <div class="bg-gradient-to-r from-red-800 to-red-700 p-6 rounded-lg shadow-lg mb-8">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center space-x-2">
                    <label class="text-white font-medium text-sm">Buscar por:</label>
                    <select class="px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-red-500 bg-white">
                        <option>Selecciona una opción</option>
                        <option>Carnet</option>
                        <option>Nombre</option>
                        <option>Apellido</option>
                        <option>Motivo</option>
                        <option>Estado</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-2">
                    <label class="text-white font-medium text-sm">Dato:</label>
                    <input type="text" class="px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-red-500 bg-white" placeholder="Ingrese término de búsqueda">
                </div>
                
                <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded font-medium text-sm transition-colors shadow-md">
                    Buscar
                </button>
            </div>
        </div>

        <!-- Results Section -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Section Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Seguimientos Finalizados</h2>
                <p class="text-sm text-gray-600 mt-1">Total de registros: 5</p>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Carnet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Apellido</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Fecha Final</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Motivo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Resultado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">5521</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800 cursor-pointer">German Jose</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800 cursor-pointer">Perdomo Moran</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">16/09/25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Retiro Académico</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Finalizado
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Contacto exitoso</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <button class="bg-itca-red text-white px-3 py-1 rounded text-xs font-medium hover:bg-red-700 transition-colors">
                                    Ver detalles
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">5522</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800 cursor-pointer">Maria Elena</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800 cursor-pointer">Rodriguez Lopez</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">14/09/25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Bajo Rendimiento</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Finalizado
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Mejora académica</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <button class="bg-itca-red text-white px-3 py-1 rounded text-xs font-medium hover:bg-red-700 transition-colors">
                                    Ver detalles
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">5523</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800 cursor-pointer">Carlos Alberto</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800 cursor-pointer">Mendez Silva</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">12/09/25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Inasistencias</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Finalizado
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Reintegro exitoso</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <button class="bg-itca-red text-white px-3 py-1 rounded text-xs font-medium hover:bg-red-700 transition-colors">
                                    Ver detalles
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">5524</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800 cursor-pointer">Ana Patricia</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800 cursor-pointer">Gonzalez Ramos</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">10/09/25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Problemas Personales</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Finalizado
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Apoyo brindado</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <button class="bg-itca-red text-white px-3 py-1 rounded text-xs font-medium hover:bg-red-700 transition-colors">
                                    Ver detalles
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">5525</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800 cursor-pointer">Roberto Luis</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800 cursor-pointer">Herrera Castro</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">08/09/25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Cambio de Carrera</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Finalizado
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Traslado completado</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <button class="bg-itca-red text-white px-3 py-1 rounded text-xs font-medium hover:bg-red-700 transition-colors">
                                    Ver detalles
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Mostrando <span class="font-medium">1</span> a <span class="font-medium">5</span> de <span class="font-medium">5</span> resultados
            </div>
            <div class="flex space-x-2">
                <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50" disabled>
                    Anterior
                </button>
                <button class="px-3 py-2 text-sm font-medium text-white bg-itca-red border border-transparent rounded-md">
                    1
                </button>
                <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50" disabled>
                    Siguiente
                </button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-16 py-8 border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 transform rotate-12 rounded-lg shadow-lg flex items-center justify-center">
                                <div class="w-10 h-10 border-4 border-white rounded transform -rotate-12"></div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-4xl font-bold text-itca-red tracking-wider">ITCA</div>
                            <div class="text-2xl font-bold text-itca-red tracking-wider -mt-2">FEPADE</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Search functionality
        document.querySelector('button[class*="bg-red-600"]').addEventListener('click', function() {
            alert('Función de búsqueda activada');
        });

        // Action buttons functionality
        document.querySelectorAll('button[class*="Ver detalles"]').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const carnet = row.querySelector('td').textContent;
                alert('Ver detalles del seguimiento - Carnet: ' + carnet);
            });
        });

        // Name/surname click functionality
        document.querySelectorAll('td.text-blue-600').forEach(cell => {
            cell.addEventListener('click', function() {
                alert('Información del estudiante: ' + this.textContent);
            });
        });
    </script>
</body>
</html>