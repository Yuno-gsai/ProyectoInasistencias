<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Listado de Seguimiento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .modal-backdrop {
            backdrop-filter: blur(4px);
        }
        .itca-red {
            background-color: #8B1538;
        }
        .itca-red-hover:hover {
            background-color: #A91B47;
        }
        .search-bar {
            background-color: #8B1538;
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
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <?php include 'menu.php'; ?>

    <div class="container mx-auto p-6">
        <!-- Título -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Listado de Seguimiento</h1>
            <p class="text-gray-600">Gestión y consulta de información estudiantil</p>
        </div>

        <!-- Barra de búsqueda -->
        <div class="search-bar p-4 rounded-lg mb-6">
            <div class="flex items-center space-x-4">
                
                <div class="flex items-center space-x-2">
                    <label class="text-white font-medium">Buscar por:</label>
                    <select class="px-3 py-2 rounded border-none bg-white">
                        <option>Seleccione una opción</option>
                        <option>Carnet</option>
                        <option>Nombre</option>
                        <option>Apellido</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-white font-medium">Dato:</label>
                    <input type="text" class="px-3 py-2 rounded border-none bg-white" placeholder="Ingrese término de búsqueda">
                </div>
                <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded font-medium">
                    Buscar
                </button>
            </div>
        </div>

        <!-- Sección de resultados -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-1">Estudiantes en Seguimiento</h2>
            <p class="text-gray-600 text-sm">Total de registros: 3</p>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-lg overflow-hidden shadow-lg">
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
                <tbody>
                    <tr class="bg-gray-100">
                        <td class="px-4 py-3">5521</td>
                        <td class="px-4 py-3 text-blue-600">German Jose</td>
                        <td class="px-4 py-3 text-blue-600">Perdomo Moran</td>
                        <td class="px-4 py-3">77777777</td>
                        <td class="px-4 py-3 text-blue-600">estudiante.24@itca.edu.sv</td>
                        <td class="px-4 py-3 text-red-600 font-medium">2 faltas</td>
                        <td class="px-4 py-3">2</td>
                        <td class="px-4 py-3">2024</td>
                        <td class="px-4 py-3">
                            <button onclick="openDetailsModal('5521')" class="itca-red itca-red-hover text-white px-3 py-1 rounded text-sm">
                                Ver detalles
                            </button>
                        </td>
                    </tr>
                    <tr class="bg-white">
                        <td class="px-4 py-3">5522</td>
                        <td class="px-4 py-3 text-blue-600">Maria Elena</td>
                        <td class="px-4 py-3 text-blue-600">Rodriguez Lopez</td>
                        <td class="px-4 py-3">88888888</td>
                        <td class="px-4 py-3 text-blue-600">estudiante.25@itca.edu.sv</td>
                        <td class="px-4 py-3 text-orange-500 font-medium">1 falta</td>
                        <td class="px-4 py-3">1</td>
                        <td class="px-4 py-3">2024</td>
                        <td class="px-4 py-3">
                            <button onclick="openDetailsModal('5522')" class="itca-red itca-red-hover text-white px-3 py-1 rounded text-sm">
                                Ver detalles
                            </button>
                        </td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td class="px-4 py-3">5523</td>
                        <td class="px-4 py-3 text-blue-600">Carlos Alberto</td>
                        <td class="px-4 py-3 text-blue-600">Hernandez Silva</td>
                        <td class="px-4 py-3">99999999</td>
                        <td class="px-4 py-3 text-blue-600">estudiante.26@itca.edu.sv</td>
                        <td class="px-4 py-3 text-red-600 font-medium">3 faltas</td>
                        <td class="px-4 py-3">3</td>
                        <td class="px-4 py-3">2024</td>
                        <td class="px-4 py-3">
                            <button onclick="openDetailsModal('5523')" class="itca-red itca-red-hover text-white px-3 py-1 rounded text-sm">
                                Ver detalles
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Detalles -->
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-gray-200 rounded-lg max-w-6xl w-full p-6 relative">
                <button onclick="closeDetailsModal()" class="close-btn">&times;</button>
                <div class="flex space-x-6">
                    <!-- Foto y Carnet -->
                    <div class="flex-shrink-0">
                        <div class="bg-gray-300 border-4 border-black w-64 h-80 flex items-center justify-center mb-4">
                            <div class="text-8xl">👤</div>
                        </div>
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold">Carnet</h3>
                            <p id="studentCarnet" class="text-xl">12345</p>
                        </div>
                        <div class="space-y-3">
                            <button onclick="openCancelModal()" class="w-full itca-red itca-red-hover text-white px-6 py-3 rounded font-medium">
                                Cancelar Segimiento
                            </button>
                            <button onclick="openHistoryModal()" class="w-full itca-red itca-red-hover text-white px-6 py-3 rounded font-medium">
                                Historial de Segimiento
                            </button>
                        </div>
                    </div>

                    <!-- Datos Personales -->
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold mb-6">DATOS PERSONALES</h2>
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-lg font-bold mb-2">Nombre</label>
                                <p id="studentName" class="text-lg">German Jose</p>
                            </div>
                            <div>
                                <label class="block text-lg font-bold mb-2">Apellido</label>
                                <p id="studentLastName" class="text-lg">Perdomo Moran</p>
                            </div>
                            <div>
                                <label class="block text-lg font-bold mb-2">Estado de alumno</label>
                                <p class="text-lg">Activo</p>
                            </div>
                            <div></div>
                            <div>
                                <label class="block text-lg font-bold mb-2">Año</label>
                                <p class="text-lg">2025</p>
                            </div>
                            <div>
                                <label class="block text-lg font-bold mb-2">Teléfono</label>
                                <p id="studentPhone" class="text-lg">76267471</p>
                            </div>
                            <div>
                                <label class="block text-lg font-bold mb-2">Correo personal</label>
                                <p class="text-lg">estudiante@gmail.com</p>
                            </div>
                            <div></div>
                            <div>
                                <label class="block text-lg font-bold mb-2">Correo Intitucional</label>
                                <p id="studentEmail" class="text-lg">estudiante@itca.edu.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tipo De Accion -->
                    <div class="w-80 bg-gray-400 p-4 rounded">
                        <h3 class="text-xl font-bold mb-4">Tipo De Accion</h3>
                        <input type="text" class="w-full p-2 mb-6 rounded bg-white" readonly>
                        
                        <h3 class="text-xl font-bold mb-4">Detalles</h3>
                        <textarea class="w-full h-40 p-3 rounded resize-none bg-white" readonly>ya no viene porque es muy pobre y no le alcansa para pagar se llamo al alumno y no contesto.</textarea>
                        
                        <button onclick="closeDetailsModal()" class="w-full itca-red itca-red-hover text-white px-6 py-3 rounded font-medium mt-6">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Cancelar Seguimiento -->
    <div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-gray-400 rounded-lg p-8 max-w-lg w-full relative">
                <button onclick="closeCancelModal()" class="close-btn">&times;</button>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xl font-bold mb-4">Estado Final</h3>
                        <select class="w-full p-2 rounded border-none bg-white">
                            <option>Seleccione una opcion</option>
                            <option>Retirado</option>
                            <option>Suspendido</option>
                            <option>Transferido</option>
                        </select>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-bold mb-4">Motivo de Retiro</h3>
                        <textarea class="w-full h-40 p-3 rounded resize-none bg-white">ya no viene porque es muy pobre y no le alcansa para pagar
se llamo al alumno y no contesto.</textarea>
                    </div>
                    
                    <div class="flex justify-end">
                        <button onclick="closeCancelModal()" class="itca-red itca-red-hover text-white px-8 py-3 rounded font-medium">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Historial -->
    <div id="historyModal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-gray-200 rounded-lg max-w-7xl w-full p-6 relative">
                <button onclick="closeHistoryModal()" class="close-btn">&times;</button>
                <h2 class="text-3xl font-bold text-center mb-8">DETALLES DEL SEGIMIENTO</h2>
                
                <div class="flex space-x-6">
                    <!-- Tabla de historial -->
                    <div class="flex-1">
                        <table class="w-full bg-white rounded overflow-hidden">
                            <thead class="bg-gray-400">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold">Tipo de accion</th>
                                    <th class="px-4 py-3 text-left font-bold">fecha</th>
                                    <th class="px-4 py-3 text-left font-bold">hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-gray-100">
                                    <td class="px-4 py-3">llamada por celular</td>
                                    <td class="px-4 py-3">27/09/2025</td>
                                    <td class="px-4 py-3">5:25</td>
                                </tr>
                                <tr class="bg-white">
                                    <td class="px-4 py-3">correo</td>
                                    <td class="px-4 py-3">28/09/2025</td>
                                    <td class="px-4 py-3">5:25</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Formulario lateral -->
                    <div class="w-80 bg-gray-400 p-4 rounded">
                        <h3 class="text-xl font-bold mb-4">Tipo De Accion</h3>
                        <input type="text" class="w-full p-2 mb-6 rounded bg-white" value="llamada a su celular" readonly>
                        
                        <h3 class="text-xl font-bold mb-4">Motivo de Retiro</h3>
                        <textarea class="w-full h-40 p-3 rounded resize-none bg-white" readonly>ya no viene porque es muy pobre y no le alcansa para pagar
se llamo al alumno y no contesto.</textarea>
                    </div>
                </div>
                
                <div class="flex justify-end mt-6">
                    <button onclick="closeHistoryModal()" class="itca-red itca-red-hover text-white px-8 py-3 rounded font-medium">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Datos de estudiantes
        const studentsData = {
            '5521': {
                carnet: '5521',
                name: 'German Jose',
                lastName: 'Perdomo Moran',
                phone: '77777777',
                email: 'estudiante.24@itca.edu.sv'
            },
            '5522': {
                carnet: '5522',
                name: 'Maria Elena',
                lastName: 'Rodriguez Lopez',
                phone: '88888888',
                email: 'estudiante.25@itca.edu.sv'
            },
            '5523': {
                carnet: '5523',
                name: 'Carlos Alberto',
                lastName: 'Hernandez Silva',
                phone: '99999999',
                email: 'estudiante.26@itca.edu.sv'
            }
        };

        function openDetailsModal(carnet) {
            const student = studentsData[carnet];
            if (student) {
                document.getElementById('studentCarnet').textContent = student.carnet;
                document.getElementById('studentName').textContent = student.name;
                document.getElementById('studentLastName').textContent = student.lastName;
                document.getElementById('studentPhone').textContent = student.phone;
                document.getElementById('studentEmail').textContent = student.email;
            }
            document.getElementById('detailsModal').classList.remove('hidden');
        }

        function closeDetailsModal() {
            document.getElementById('detailsModal').classList.add('hidden');
        }

        function openCancelModal() {
            document.getElementById('cancelModal').classList.remove('hidden');
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
        }

        function openHistoryModal() {
            document.getElementById('historyModal').classList.remove('hidden');
        }

        function closeHistoryModal() {
            document.getElementById('historyModal').classList.add('hidden');
        }

        // Cerrar modales al hacer clic fuera de ellos
        window.onclick = function(event) {
            const detailsModal = document.getElementById('detailsModal');
            const cancelModal = document.getElementById('cancelModal');
            const historyModal = document.getElementById('historyModal');
            
            if (event.target === detailsModal) {
                closeDetailsModal();
            }
            if (event.target === cancelModal) {
                closeCancelModal();
            }
            if (event.target === historyModal) {
                closeHistoryModal();
            }
        }
    </script>
</body>
</html>