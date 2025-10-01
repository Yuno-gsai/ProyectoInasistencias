<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Listado de Seguimiento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'itca-red': '#8B1538',
                        'itca-dark-red': '#6A1029',
                        'itca-light-red': '#A91B47',
                        'itca-gray': '#4A5568',
                        'itca-light-gray': '#F7FAFC'
                    }
                }
            }
        }
    </script>
    <style>
        .modal-backdrop {
            backdrop-filter: blur(4px);
        }
        .modal-content {
            animation: modalFadeIn 0.3s ease-out;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 28px;
            font-weight: bold;
            color: #6B7280;
            cursor: pointer;
            z-index: 10;
            transition: all 0.2s;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .close-btn:hover {
            color: #374151;
            background-color: rgba(0, 0, 0, 0.05);
        }
        .student-photo {
            background: linear-gradient(135deg, #E5E7EB 0%, #D1D5DB 100%);
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
            background-color: #8B1538;
            border-radius: 2px;
        }
        .info-card {
            background-color: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #8B1538;
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
        .status-suspended {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        .status-transferred {
            background-color: #FEF3C7;
            color: #92400E;
        }
        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-8">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-itca-red rounded-lg flex items-center justify-center text-white font-bold text-lg">IT</div>
                        <span class="ml-2 text-xl font-bold text-gray-800">ITCA FEPADE</span>
                    </div>
                    <nav class="hidden md:flex space-x-8">
                        <a href="#" class="text-gray-700 hover:text-itca-red px-3 py-2 text-sm font-medium">Inicio</a>
                        <a href="#" class="bg-itca-red text-white px-4 py-2 rounded text-sm font-medium">Seguimiento</a>
                        <a href="#" class="text-gray-700 hover:text-itca-red px-3 py-2 text-sm font-medium">Reportes</a>
                    </nav>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">Administrador</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto p-6 max-w-7xl">
        <!-- Título -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Listado de Seguimiento</h1>
            <p class="text-gray-600">Gestión y consulta de información estudiantil</p>
        </div>

        <!-- Barra de búsqueda -->
        <div class="bg-itca-red p-6 rounded-lg mb-6 shadow-md">
            <div class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-48">
                    <label class="block text-white text-sm font-medium mb-2">Buscar por:</label>
                    <select id="searchType" class="w-full px-3 py-2 rounded border-none bg-white focus:outline-none focus:ring-2 focus:ring-white">
                        <option>Seleccione una opción</option>
                        <option>Carnet</option>
                        <option>Nombre</option>
                        <option>Apellido</option>
                    </select>
                </div>
                <div class="flex-1 min-w-48">
                    <label class="block text-white text-sm font-medium mb-2">Dato:</label>
                    <input id="searchTerm" type="text" class="w-full px-3 py-2 rounded border-none bg-white focus:outline-none focus:ring-2 focus:ring-white" placeholder="Ingrese término de búsqueda">
                </div>
                <div>
                    <button onclick="buscarEstudiantes()" class="bg-white text-itca-red px-6 py-2 rounded font-medium hover:bg-gray-100 transition-colors shadow-md">
                        Buscar
                    </button>
                </div>
            </div>
        </div>

        <!-- Sección de resultados -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-1">Estudiantes en Seguimiento</h2>
            <p id="totalRegistros" class="text-gray-600 text-sm">Total de registros: 3</p>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">CARNET</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">NOMBRE</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">APELLIDO</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">TELÉFONO</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">EMAIL</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">FALTAS</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">CICLO</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">AÑO</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody id="tablaEstudiantes">
                        <tr class="bg-gray-50 hover:bg-gray-100 transition-colors">
                            <td class="px-4 py-3">5521</td>
                            <td class="px-4 py-3 text-blue-600 font-medium">German Jose</td>
                            <td class="px-4 py-3 text-blue-600 font-medium">Perdomo Moran</td>
                            <td class="px-4 py-3">77777777</td>
                            <td class="px-4 py-3 text-blue-600">estudiante.24@itca.edu.sv</td>
                            <td class="px-4 py-3 text-red-600 font-medium">2 faltas</td>
                            <td class="px-4 py-3">2</td>
                            <td class="px-4 py-3">2024</td>
                            <td class="px-4 py-3">
                                <button onclick="openDetailsModal('5521')" class="bg-itca-red hover:bg-itca-dark-red text-white px-3 py-1 rounded text-sm transition-colors shadow-sm">
                                    Ver detalles
                                </button>
                            </td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-100 transition-colors">
                            <td class="px-4 py-3">5522</td>
                            <td class="px-4 py-3 text-blue-600 font-medium">Maria Elena</td>
                            <td class="px-4 py-3 text-blue-600 font-medium">Rodriguez Lopez</td>
                            <td class="px-4 py-3">88888888</td>
                            <td class="px-4 py-3 text-blue-600">estudiante.25@itca.edu.sv</td>
                            <td class="px-4 py-3 text-orange-500 font-medium">1 falta</td>
                            <td class="px-4 py-3">1</td>
                            <td class="px-4 py-3">2024</td>
                            <td class="px-4 py-3">
                                <button onclick="openDetailsModal('5522')" class="bg-itca-red hover:bg-itca-dark-red text-white px-3 py-1 rounded text-sm transition-colors shadow-sm">
                                    Ver detalles
                                </button>
                            </td>
                        </tr>
                        <tr class="bg-gray-50 hover:bg-gray-100 transition-colors">
                            <td class="px-4 py-3">5523</td>
                            <td class="px-4 py-3 text-blue-600 font-medium">Carlos Alberto</td>
                            <td class="px-4 py-3 text-blue-600 font-medium">Hernandez Silva</td>
                            <td class="px-4 py-3">99999999</td>
                            <td class="px-4 py-3 text-blue-600">estudiante.26@itca.edu.sv</td>
                            <td class="px-4 py-3 text-red-600 font-medium">3 faltas</td>
                            <td class="px-4 py-3">3</td>
                            <td class="px-4 py-3">2024</td>
                            <td class="px-4 py-3">
                                <button onclick="openDetailsModal('5523')" class="bg-itca-red hover:bg-itca-dark-red text-white px-3 py-1 rounded text-sm transition-colors shadow-sm">
                                    Ver detalles
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de Detalles -->
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-6xl w-full modal-content relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeDetailsModal()" class="close-btn">&times;</button>
            
            <div class="p-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Foto y Carnet -->
                    <div class="lg:w-1/4 flex flex-col items-center">
                        <div class="student-photo border-4 border-gray-800 w-full h-64 rounded-lg flex items-center justify-center mb-6 shadow-lg">
                            <div class="text-7xl text-gray-600">👤</div>
                        </div>
                        <div class="text-center mb-6 w-full">
                            <h3 class="text-xl font-bold text-gray-700 mb-2">Carnet</h3>
                            <div class="info-card text-center">
                                <p id="studentCarnet" class="text-2xl font-bold text-gray-800">12345</p>
                            </div>
                        </div>
                        <div class="space-y-3 w-full">
                            <button onclick="openCancelModal()" class="w-full bg-itca-red hover:bg-itca-dark-red text-white px-4 py-3 rounded-lg font-medium transition-colors shadow-md">
                                Cancelar Seguimiento
                            </button>
                            <button onclick="openHistoryModal()" class="w-full bg-itca-red hover:bg-itca-dark-red text-white px-4 py-3 rounded-lg font-medium transition-colors shadow-md">
                                Historial de Seguimiento
                            </button>
                        </div>
                    </div>

                    <!-- Datos Personales -->
                    <div class="lg:w-2/4">
                        <h2 class="text-2xl font-bold text-gray-800 section-title">DATOS PERSONALES</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="info-card">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Nombre</label>
                                <p id="studentName" class="text-lg text-gray-800">German Jose</p>
                            </div>
                            <div class="info-card">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Apellido</label>
                                <p id="studentLastName" class="text-lg text-gray-800">Perdomo Moran</p>
                            </div>
                            <div class="info-card">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Estado de alumno</label>
                                <span id="studentStatus" class="status-badge status-active">Activo</span>
                            </div>
                            <div class="info-card">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Año</label>
                                <p id="studentYear" class="text-lg text-gray-800">2025</p>
                            </div>
                            <div class="info-card">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Teléfono</label>
                                <p id="studentPhone" class="text-lg text-gray-800">76267471</p>
                            </div>
                            <div class="info-card">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Correo personal</label>
                                <p id="studentPersonalEmail" class="text-lg text-blue-600">estudiante@gmail.com</p>
                            </div>
                            <div class="info-card md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Correo Institucional</label>
                                <p id="studentEmail" class="text-lg text-blue-600">estudiante@itca.edu.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tipo De Accion -->
                    <div class="lg:w-1/4">
                        <div class="bg-gray-100 p-6 rounded-lg h-full">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 section-title">Tipo De Acción</h3>
                            <div class="mb-6">
                                <input type="text" class="w-full p-3 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-itca-red" value="Llamada telefónica" readonly>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-800 mb-4 section-title">Detalles</h3>
                            <div class="mb-6">
                                <textarea class="w-full h-40 p-3 rounded-lg border border-gray-300 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-itca-red" readonly>Ya no viene porque es muy pobre y no le alcanza para pagar. Se llamó al alumno y no contestó.</textarea>
                            </div>
                            
                            <button onclick="closeDetailsModal()" class="w-full bg-itca-red hover:bg-itca-dark-red text-white px-4 py-3 rounded-lg font-medium transition-colors shadow-md">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Cancelar Seguimiento -->
    <div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full modal-content relative">
            <button onclick="closeCancelModal()" class="close-btn">&times;</button>
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Cancelar Seguimiento</h2>
                
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">Estado Final</h3>
                        <select class="w-full p-3 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-itca-red">
                            <option>Seleccione una opción</option>
                            <option>Retirado</option>
                            <option>Suspendido</option>
                            <option>Transferido</option>
                        </select>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">Motivo de Retiro</h3>
                        <textarea class="w-full h-32 p-3 rounded-lg border border-gray-300 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-itca-red">Ya no viene porque es muy pobre y no le alcanza para pagar. Se llamó al alumno y no contestó.</textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-4 pt-4">
                        <button onclick="closeCancelModal()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button onclick="closeCancelModal()" class="bg-itca-red hover:bg-itca-dark-red text-white px-6 py-2 rounded-lg font-medium transition-colors shadow-md">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   <?php include "modal_historial.php" ?>
</body>
</html>