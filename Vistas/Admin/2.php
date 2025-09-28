<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Estudiantes - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilos para los modales */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
        }
        
        .modal-content {
            margin: auto;
            width: 90%;
            max-width: 1200px;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalFadeIn 0.3s;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Estilos para elementos específicos del modal */
        .info-card {
            background: white;
            border-radius: 6px;
            padding: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 4px solid #B91C1C;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .status-active {
            background-color: #DCFCE7;
            color: #166534;
        }
        
        .status-inactive {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .status-suspended {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: #B91C1C;
            border-radius: 2px;
        }
        
        .student-photo {
            background: linear-gradient(135deg, #E5E7EB 0%, #D1D5DB 100%);
            border: 3px solid #B91C1C;
        }
        
        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 24px;
            font-weight: bold;
            color: #666;
            cursor: pointer;
            z-index: 10;
        }
        
        .close-btn:hover {
            color: #000;
        }
        
        .history-item {
            background-color: #F9FAFB;
            border-left: 4px solid #B91C1C;
        }
        
        /* Estilos específicos para el modal de historial */
        .modal-backdrop {
            display: none;
        }
        
        .modal-backdrop.show {
            display: flex;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'itca-red': '#B91C1C',
                        'itca-dark-red': '#991B1B',
                        'itca-gold': '#D97706'
                    }
                }
            }
        }
    </script>
    
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo y navegación -->
                <div class="flex items-center space-x-8">
                    <div class="flex items-center">
                        <img src="/public/LogoITCA_2024_FC_Moodle.png" alt="ITCA FEPADE" class="h-10 w-auto">
                    </div>
                    <nav class="hidden md:flex space-x-8">
                        <a href="#" class="bg-gray-400 text-white px-4 py-2 rounded text-sm font-medium">Inicio</a>
                        <a href="#" class="text-gray-700 hover:text-itca-red px-3 py-2 text-sm font-medium">Estudiantes</a>
                        <a href="#" class="text-gray-700 hover:text-itca-red px-3 py-2 text-sm font-medium">Reportes</a>
                    </nav>
                </div>
                
                <!-- Usuario y idioma -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">German</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Formulario de búsqueda -->
        <div class="bg-itca-red p-6 rounded-lg shadow-lg mb-8">
            <form class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-48">
                    <label class="block text-white text-sm font-medium mb-2">Buscar por:</label>
                    <select id="searchType" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent">
                        <option>Seleccione una opción</option>
                        <option>Carnet</option>
                        <option>Nombre</option>
                        <option>Apellido</option>
                        <option>Fecha</option>
                    </select>
                </div>
                
                <div class="flex-1 min-w-48">
                    <label class="block text-white text-sm font-medium mb-2">Dato:</label>
                    <input id="searchInput" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent" placeholder="Ingrese el dato a buscar">
                </div>
                
                <div>
                    <button type="button" onclick="buscarEstudiantes()" class="bg-white text-itca-red px-8 py-2 rounded-md font-semibold hover:bg-gray-100 transition-colors duration-200 shadow-md">
                        Buscar
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de resultados -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-400">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Carnet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Apellido</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Fecha Final</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Última Acción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Motivo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">5521</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">german jose</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">perdomo moran</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">16/09/25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">llamada al celular</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Retiro</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <button class="bg-itca-red text-white px-3 py-1 rounded text-xs font-medium hover:bg-itca-dark-red transition-colors duration-200"
                                onclick="verDetalles('5521')">
                                    Ver detalles
                                </button>
                                <button class="bg-itca-red text-white px-3 py-1 rounded text-xs font-medium hover:bg-itca-dark-red transition-colors duration-200"
                                onclick="verHistorial('5521')">
                                    Historial
                                </button>
                            </td>
                        </tr>
                        <!-- Filas adicionales de ejemplo -->
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">5522</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">maria elena</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">rodriguez lopez</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15/09/25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">correo electrónico</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Activo</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <button class="bg-itca-red text-white px-3 py-1 rounded text-xs font-medium hover:bg-itca-dark-red transition-colors duration-200"
                                onclick="verDetalles('5522')">
                                    Ver detalles
                                </button>
                                <button class="bg-itca-red text-white px-3 py-1 rounded text-xs font-medium hover:bg-itca-dark-red transition-colors duration-200"
                                onclick="verHistorial('5522')">
                                    Historial
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">5523</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">carlos antonio</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">martinez silva</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">14/09/25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">visita presencial</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Suspendido</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <button class="bg-itca-red text-white px-3 py-1 rounded text-xs font-medium hover:bg-itca-dark-red transition-colors duration-200"
                                onclick="verDetalles('5523')">
                                    Ver detalles
                                </button>
                                <button class="bg-itca-red text-white px-3 py-1 rounded text-xs font-medium hover:bg-itca-dark-red transition-colors duration-200"
                                onclick="verHistorial('5523')">
                                    Historial
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Paginación -->
        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Mostrando <span class="font-medium">1</span> a <span class="font-medium">3</span> de <span class="font-medium">3</span> resultados
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

  
    
    <?php include 'modal_historial.php'; ?>
</body>
</html>