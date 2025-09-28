
    <!-- Modal de detalles del estudiante - MEJORADO -->
    <div id="modalDetalles" class="modal">
        <div class="modal-content bg-white rounded-xl">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-8 relative">
                <!-- Botón cerrar mejorado -->
                <button onclick="cerrarModal()" class="close-btn">×</button>
                
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Columna izquierda: Foto y carnet -->
                    <div class="lg:w-1/3 flex flex-col items-center">
                        <div class="student-photo p-4 mb-6 w-full max-w-xs rounded-lg shadow-lg flex items-center justify-center">
                            <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&cs=tinysrgb&w=300&h=400&fit=crop" 
                                 alt="Foto del estudiante" 
                                 class="w-full h-64 object-cover rounded">
                        </div>
                        <div class="text-center mb-8 w-full">
                            <div class="text-xl font-semibold text-gray-600 mb-3">Carnet</div>
                            <div class="info-card text-center py-4">
                                <div id="carnetDisplay" class="text-3xl font-bold text-gray-800">12345</div>
                            </div>
                        </div>
                        <button class="w-full bg-itca-red text-white py-3 px-6 font-semibold hover:bg-red-800 transition-all duration-200 rounded-lg shadow-md hover:shadow-lg" 
                                onclick="iniciarSeguimiento()">
                            Iniciar Seguimiento
                        </button>
                    </div>

                    <!-- Columna derecha: Datos personales -->
                    <div class="lg:w-2/3">
                        <div class="mb-8">
                            <h1 class="text-3xl font-bold text-gray-800 mb-2 section-title">DATOS PERSONALES</h1>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Primera columna -->
                            <div class="space-y-6">
                                <div class="info-card">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Nombre</div>
                                    <div class="text-lg text-gray-800 font-medium" id="nombreDisplay">German Jose</div>
                                </div>
                                
                                <div class="info-card">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Estado de alumno</div>
                                    <div>
                                        <span id="estadoDisplay" class="status-badge status-active">Activo</span>
                                    </div>
                                </div>
                                
                                <div class="info-card">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Año</div>
                                    <div class="text-lg text-gray-800 font-medium" id="añoDisplay">2025</div>
                                </div>
                            </div>

                            <!-- Segunda columna -->
                            <div class="space-y-6">
                                <div class="info-card">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Apellido</div>
                                    <div class="text-lg text-gray-800 font-medium" id="apellidoDisplay">Perdomo Moran</div>
                                </div>
                                
                                <div class="info-card">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Beca</div>
                                    <div>
                                        <span id="becaDisplay" class="status-badge status-active">Sí</span>
                                    </div>
                                </div>
                                
                                <div class="info-card">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Tipo de beca</div>
                                    <div class="text-lg text-gray-800 font-medium" id="tipoBecaDisplay">Semilla</div>
                                </div>
                            </div>

                            <!-- Tercera columna -->
                            <div class="space-y-6">
                                <div class="info-card">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Correo personal</div>
                                    <div class="text-lg text-blue-600 font-medium" id="correoPersonalDisplay">estudiante@gmail.com</div>
                                </div>
                                
                                <div class="info-card">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Correo Institucional</div>
                                    <div class="text-lg text-blue-600 font-medium" id="correoInstitucionalDisplay">estudiante@itca.edu.com</div>
                                </div>
                                
                                <div class="info-card">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Teléfono</div>
                                    <div class="text-lg text-gray-800 font-medium" id="telefonoDisplay">76267471</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información adicional -->
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="info-card">
                                <div class="text-sm font-semibold text-gray-600 mb-1">Ciclo actual</div>
                                <div class="text-lg text-gray-800 font-medium">2</div>
                            </div>
                            <div class="info-card">
                                <div class="text-sm font-semibold text-gray-600 mb-1">Faltas acumuladas</div>
                                <div class="text-lg text-red-600 font-medium">2</div>
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
                
                // Aplicar estilos según el estado
                const estadoElement = document.getElementById('estadoDisplay');
                estadoElement.className = 'status-badge';
                if (estudiante.estadoAlumno === 'Activo') {
                    estadoElement.classList.add('status-active');
                } else {
                    estadoElement.classList.add('status-inactive');
                }
                
                // Aplicar estilos según la beca
                const becaElement = document.getElementById('becaDisplay');
                becaElement.className = 'status-badge';
                if (estudiante.beca === 'Sí') {
                    becaElement.classList.add('status-active');
                } else {
                    becaElement.classList.add('status-inactive');
                }
                
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
    





















