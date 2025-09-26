<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Sistema de Estudiantes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .logo-orange { color: #FF6B00; }
        .bg-itca-red { background-color: #8B1538; }
        .bg-header { background-color: #E5E5E5; }
        .bg-table-header { background-color: #9CA3AF; }
        .bg-table-row { background-color: #D1D5DB; }
        .bg-details { background-color: #E5E7EB; }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 8px;
            max-width: 90vw;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <?php include 'menu.php'; ?>

    <!-- Contenido principal -->
    <div class="container mx-auto px-6 py-8">
        <!-- Título principal -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Listado de Alumnos</h1>
            <p class="text-gray-600">Gestión y consulta de información estudiantil</p>
        </div>

        <!-- Barra de búsqueda -->
        <div class="bg-itca-red px-6 py-5 mb-8 rounded-lg shadow-lg flex items-center space-x-6">
            <div class="flex items-center space-x-2">
                <label class="text-white font-semibold text-sm">Buscar por:</label>
                <select class="px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-red-300 focus:border-transparent" id="searchType">
                    <option value="">Seleccione una opción</option>
                    <option value="carnet">Carnet</option>
                    <option value="nombre">Nombre</option>
                    <option value="apellido">Apellido</option>
                    <option value="email">Email</option>
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <label class="text-white font-semibold text-sm">Dato:</label>
                <input type="text" class="px-4 py-2 border border-gray-300 rounded-md text-sm w-64 focus:ring-2 focus:ring-red-300 focus:border-transparent" id="searchInput" placeholder="Ingrese término de búsqueda">
            </div>
            <button class="bg-red-600 hover:bg-red-700 text-white px-8 py-2 rounded-md font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5" onclick="buscarEstudiantes()">
                Buscar
            </button>
        </div>

        <!-- Tabla de estudiantes -->
        <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Estudiantes Registrados</h2>
                <p class="text-sm text-gray-600 mt-1">Total de registros: 2</p>
            </div>
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-100 to-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Carnet</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Apellido</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Faltas</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Ciclo</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Año</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Acción</th>
                    </tr>
                </thead>
                <tbody id="studentsTable">
                    <tr class="bg-white hover:bg-gray-50 border-b border-gray-200 transition-colors duration-150">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">5521</td>
                        <td class="px-6 py-4 text-sm text-gray-800 capitalize">german jose</td>
                        <td class="px-6 py-4 text-sm text-gray-800 capitalize">perdomo moran</td>
                        <td class="px-6 py-4 text-sm text-gray-800">77777777</td>
                        <td class="px-6 py-4 text-sm text-blue-600">estudiante.24@itca.edu.sv</td>
                        <td class="px-6 py-4 text-sm text-gray-800">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                2 faltas
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800">2</td>
                        <td class="px-6 py-4 text-sm text-gray-800">2024</td>
                        <td class="px-6 py-4">
                            <button class="bg-itca-red text-white px-4 py-2 text-sm rounded-md hover:bg-red-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 font-medium" 
                                    onclick="verDetalles('5521')">
                                Ver detalles
                            </button>
                        </td>
                    </tr>
                    <tr class="bg-gray-50 hover:bg-gray-100 border-b border-gray-200 transition-colors duration-150">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">5522</td>
                        <td class="px-6 py-4 text-sm text-gray-800 capitalize">maria elena</td>
                        <td class="px-6 py-4 text-sm text-gray-800 capitalize">rodriguez lopez</td>
                        <td class="px-6 py-4 text-sm text-gray-800">88888888</td>
                        <td class="px-6 py-4 text-sm text-blue-600">estudiante.25@itca.edu.sv</td>
                        <td class="px-6 py-4 text-sm text-gray-800">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                1 falta
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800">1</td>
                        <td class="px-6 py-4 text-sm text-gray-800">2024</td>
                        <td class="px-6 py-4">
                            <button class="bg-itca-red text-white px-4 py-2 text-sm rounded-md hover:bg-red-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 font-medium" 
                                    onclick="verDetalles('5522')">
                                Ver detalles
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de detalles del estudiante -->
    <div id="modalDetalles" class="modal">
        <div class="modal-content bg-white rounded-xl shadow-2xl">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-8">
                <!-- Botón cerrar -->
                <div class="flex justify-end mb-6">
                    <button onclick="cerrarModal()" class="text-gray-400 hover:text-gray-600 text-3xl font-bold transition-colors duration-200 hover:bg-gray-200 rounded-full w-10 h-10 flex items-center justify-center">
                        ×
                    </button>
                </div>
                
                <div class="flex space-x-10">
                    <!-- Columna izquierda: Foto y carnet -->
                    <div class="flex-shrink-0">
                        <div class="bg-white border-4 border-gray-800 p-3 mb-6 w-64 shadow-lg rounded-lg">
                            <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&cs=tinysrgb&w=300&h=400&fit=crop" 
                                 alt="Foto del estudiante" 
                                 class="w-full h-80 object-cover grayscale rounded">
                        </div>
                        <div class="text-center mb-8">
                            <div class="text-xl font-semibold text-gray-600 mb-2">Carnet</div>
                            <div class="text-4xl font-bold text-gray-800 bg-white px-4 py-2 rounded-lg shadow-md border-2 border-gray-200" id="carnetDisplay">12345</div>
                        </div>
                        <button class="w-full bg-itca-red text-white py-4 px-6 font-semibold hover:bg-red-800 transition-all duration-200 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1" 
                                onclick="iniciarSeguimiento()">
                            Iniciar Seguimiento
                        </button>
                    </div>

                    <!-- Columna derecha: Datos personales -->
                    <div class="flex-1">
                        <div class="mb-8">
                            <h1 class="text-4xl font-bold text-gray-800 mb-2">DATOS PERSONALES</h1>
                            <div class="w-24 h-1 bg-itca-red rounded-full"></div>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-10">
                            <!-- Primera columna -->
                            <div class="space-y-8">
                                <div>
                                    <div class="text-lg font-bold text-gray-800 mb-2">Nombre</div>
                                    <div class="text-lg text-gray-700 bg-white p-3 rounded-lg shadow-sm border border-gray-200" id="nombreDisplay">German Jose</div>
                                </div>
                                
                                <div>
                                    <div class="text-lg font-bold text-gray-800 mb-2">Estado de alumno</div>
                                    <div class="text-lg text-green-700 bg-green-50 p-3 rounded-lg shadow-sm border border-green-200 font-semibold" id="estadoDisplay">Activo</div>
                                </div>
                                
                                <div>
                                    <div class="text-lg font-bold text-gray-800 mb-2">Año</div>
                                    <div class="text-lg text-gray-700 bg-white p-3 rounded-lg shadow-sm border border-gray-200" id="añoDisplay">2025</div>
                                </div>
                                
                                <div>
                                    <div class="text-lg font-bold text-gray-800 mb-2">Tipo de beca</div>
                                    <div class="text-lg text-blue-700 bg-blue-50 p-3 rounded-lg shadow-sm border border-blue-200 font-semibold" id="tipoBecaDisplay">Semilla</div>
                                </div>
                            </div>

                            <!-- Segunda columna -->
                            <div class="space-y-8">
                                <div>
                                    <div class="text-lg font-bold text-gray-800 mb-2">Apellido</div>
                                    <div class="text-lg text-gray-700 bg-white p-3 rounded-lg shadow-sm border border-gray-200" id="apellidoDisplay">Perdomo Moran</div>
                                </div>
                                
                                <div>
                                    <div class="text-lg font-bold text-gray-800 mb-2">Beca</div>
                                    <div class="text-lg text-green-700 bg-green-50 p-3 rounded-lg shadow-sm border border-green-200 font-semibold" id="becaDisplay">Sí</div>
                                </div>
                            </div>

                            <!-- Tercera columna -->
                            <div class="space-y-8">
                                <div>
                                    <div class="text-lg font-bold text-gray-800 mb-2">Correo personal</div>
                                    <div class="text-lg text-blue-600 bg-white p-3 rounded-lg shadow-sm border border-gray-200" id="correoPersonalDisplay">estudiante@gmail.com</div>
                                </div>
                                
                                <div>
                                    <div class="text-lg font-bold text-gray-800 mb-2">Correo Institucional</div>
                                    <div class="text-lg text-blue-600 bg-white p-3 rounded-lg shadow-sm border border-gray-200" id="correoInstitucionalDisplay">estudiante@itca.edu.com</div>
                                </div>
                                
                                <div>
                                    <div class="text-lg font-bold text-gray-800 mb-2">Teléfono</div>
                                    <div class="text-lg text-gray-700 bg-white p-3 rounded-lg shadow-sm border border-gray-200" id="telefonoDisplay">76267471</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Datos de ejemplo para los estudiantes
        const estudiantes = [
            {
                carnet: "5521",
                nombre: "german jose",
                apellido: "perdomo moran",
                telefono: "77777777",
                email: "estudiante.24@itca.edu.sv",
                faltas: 2,
                ciclo: 2,
                año: 2024,
                correoPersonal: "estudiante@gmail.com",
                estadoAlumno: "Activo",
                añoEstudio: "2025",
                beca: "Sí",
                tipoBeca: "Semilla",
                carnetCompleto: "12345"
            },
            {
                carnet: "5522",
                nombre: "maria elena",
                apellido: "rodriguez lopez",
                telefono: "88888888",
                email: "estudiante.25@itca.edu.sv",
                faltas: 1,
                ciclo: 1,
                año: 2024,
                correoPersonal: "maria@gmail.com",
                estadoAlumno: "Activo",
                añoEstudio: "2025",
                beca: "No",
                tipoBeca: "N/A",
                carnetCompleto: "54321"
            }
        ];

        function verDetalles(carnet) {
            const estudiante = estudiantes.find(est => est.carnet === carnet);
            if (estudiante) {
                // Actualizar elementos con los datos del estudiante
                document.getElementById('carnetDisplay').textContent = estudiante.carnetCompleto || estudiante.carnet;
                document.getElementById('nombreDisplay').textContent = estudiante.nombre;
                document.getElementById('apellidoDisplay').textContent = estudiante.apellido;
                document.getElementById('correoPersonalDisplay').textContent = estudiante.correoPersonal;
                document.getElementById('correoInstitucionalDisplay').textContent = estudiante.email;
                document.getElementById('estadoDisplay').textContent = estudiante.estadoAlumno;
                document.getElementById('añoDisplay').textContent = estudiante.añoEstudio;
                document.getElementById('becaDisplay').textContent = estudiante.beca;
                document.getElementById('tipoBecaDisplay').textContent = estudiante.tipoBeca;
                document.getElementById('telefonoDisplay').textContent = estudiante.telefono;
                
                // Mostrar modal
                document.getElementById('modalDetalles').classList.add('show');
            }
        }

        function cerrarModal() {
            document.getElementById('modalDetalles').classList.remove('show');
        }

        function iniciarSeguimiento() {
            alert('Iniciando seguimiento del estudiante...');
            // Aquí puedes agregar la lógica para iniciar el seguimiento
        }

        function buscarEstudiantes() {
            const tipo = document.getElementById('searchType').value;
            const dato = document.getElementById('searchInput').value.toLowerCase();
            
            if (!tipo || !dato) {
                alert('Por favor seleccione un tipo de búsqueda e ingrese un dato');
                return;
            }
            
            // Aquí podrías implementar la lógica de búsqueda
            console.log('Buscando por', tipo, ':', dato);
        }

        // Cerrar modal al hacer clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('modalDetalles');
            if (event.target === modal) {
                cerrarModal();
            }
        }

        // Cerrar modal con la tecla Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                cerrarModal();
            }
        });
    </script>
</body>
</html>