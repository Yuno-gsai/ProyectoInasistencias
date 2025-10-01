 <!-- Modal de Historial -->
 <div id="historyModal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full modal-content relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeHistoryModal()" class="close-btn">&times;</button>
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center section-title">Historial de Seguimiento</h2>
                
                <div id="historialContent" class="space-y-4">
                    <!-- El contenido del historial se cargará dinámicamente aquí -->
                </div>
                
                <div class="flex justify-end mt-6">
                    <button onclick="closeHistoryModal()" class="bg-itca-red hover:bg-itca-dark-red text-white px-6 py-2 rounded-lg font-medium transition-colors shadow-md">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Datos de ejemplo para estudiantes
        const estudiantes = [
            {
                carnet: "5521",
                nombre: "German Jose",
                apellido: "Perdomo Moran",
                telefono: "77777777",
                email: "estudiante.24@itca.edu.sv",
                carnetCompleto: "12345",
                personalEmail: "german.perdomo@gmail.com",
                year: "2024",
                status: "Activo",
                historial: [
                    {
                        tipo: "Llamada telefónica",
                        fecha: "15 de septiembre, 2024",
                        estado: "Realizada",
                        descripcion: "Se contactó al estudiante para verificar su situación académica."
                    },
                    {
                        tipo: "Correo electrónico",
                        fecha: "10 de septiembre, 2024",
                        estado: "Enviado",
                        descripcion: "Se envió recordatorio sobre las faltas acumuladas."
                    },
                    {
                        tipo: "Reunión con coordinador",
                        fecha: "5 de septiembre, 2024",
                        estado: "Pendiente",
                        descripcion: "Programada para evaluar situación académica del estudiante."
                    }
                ]
            },
            {
                carnet: "5522",
                nombre: "Maria Elena",
                apellido: "Rodriguez Lopez",
                telefono: "88888888",
                email: "estudiante.25@itca.edu.sv",
                carnetCompleto: "54321",
                personalEmail: "maria.rodriguez@gmail.com",
                year: "2024",
                status: "Activo",
                historial: [
                    {
                        tipo: "Correo electrónico",
                        fecha: "12 de septiembre, 2024",
                        estado: "Enviado",
                        descripcion: "Se envió información sobre tutorías disponibles."
                    },
                    {
                        tipo: "Entrevista personal",
                        fecha: "8 de septiembre, 2024",
                        estado: "Realizada",
                        descripcion: "Se evaluaron las dificultades académicas del estudiante."
                    }
                ]
            },
            {
                carnet: "5523",
                nombre: "Carlos Alberto",
                apellido: "Hernandez Silva",
                telefono: "99999999",
                email: "estudiante.26@itca.edu.sv",
                carnetCompleto: "67890",
                personalEmail: "carlos.hernandez@gmail.com",
                year: "2024",
                status: "Suspendido",
                historial: [
                    {
                        tipo: "Llamada telefónica",
                        fecha: "18 de septiembre, 2024",
                        estado: "No contestó",
                        descripcion: "Se intentó contactar al estudiante sin éxito."
                    },
                    {
                        tipo: "Correo electrónico",
                        fecha: "14 de septiembre, 2024",
                        estado: "Enviado",
                        descripcion: "Se notificó sobre situación de riesgo académico."
                    },
                    {
                        tipo: "Visita domiciliaria",
                        fecha: "10 de septiembre, 2024",
                        estado: "Programada",
                        descripcion: "Se programó visita para evaluar situación personal."
                    }
                ]
            }
        ];

        // Variable para almacenar el estudiante actual
        let estudianteActual = null;

        // Funciones para abrir y cerrar modales
        function openDetailsModal(carnet) {
            estudianteActual = estudiantes.find(est => est.carnet === carnet);
            if (estudianteActual) {
                document.getElementById('studentCarnet').textContent = estudianteActual.carnetCompleto;
                document.getElementById('studentName').textContent = estudianteActual.nombre;
                document.getElementById('studentLastName').textContent = estudianteActual.apellido;
                document.getElementById('studentPhone').textContent = estudianteActual.telefono;
                document.getElementById('studentEmail').textContent = estudianteActual.email;
                document.getElementById('studentPersonalEmail').textContent = estudianteActual.personalEmail;
                document.getElementById('studentYear').textContent = estudianteActual.year;
                
                // Actualizar estado del estudiante
                const statusElement = document.getElementById('studentStatus');
                statusElement.textContent = estudianteActual.status;
                statusElement.className = 'status-badge';
                
                if (estudianteActual.status === 'Activo') {
                    statusElement.classList.add('status-active');
                } else if (estudianteActual.status === 'Suspendido') {
                    statusElement.classList.add('status-suspended');
                } else if (estudianteActual.status === 'Transferido') {
                    statusElement.classList.add('status-transferred');
                }
            }
            
            document.getElementById('detailsModal').classList.remove('hidden');
            document.getElementById('detailsModal').classList.add('flex');
        }

        function closeDetailsModal() {
            document.getElementById('detailsModal').classList.add('hidden');
            document.getElementById('detailsModal').classList.remove('flex');
        }

        function openCancelModal() {
            document.getElementById('cancelModal').classList.remove('hidden');
            document.getElementById('cancelModal').classList.add('flex');
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
            document.getElementById('cancelModal').classList.remove('flex');
        }

        function openHistoryModal() {
            if (estudianteActual) {
                // Limpiar contenido anterior
                const historialContent = document.getElementById('historialContent');
                historialContent.innerHTML = '';
                
                // Cargar historial del estudiante actual
                estudianteActual.historial.forEach(item => {
                    const itemElement = document.createElement('div');
                    itemElement.className = 'bg-gray-50 p-4 rounded-lg border-l-4 border-itca-red';
                    
                    let estadoClass = 'status-active';
                    if (item.estado === 'Pendiente') {
                        estadoClass = 'status-pending';
                    } else if (item.estado === 'No contestó') {
                        estadoClass = 'status-suspended';
                    }
                    
                    itemElement.innerHTML = `
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-gray-800">${item.tipo}</h3>
                                <p class="text-sm text-gray-600">${item.fecha}</p>
                            </div>
                            <span class="status-badge ${estadoClass}">${item.estado}</span>
                        </div>
                        <p class="mt-2 text-gray-700">${item.descripcion}</p>
                    `;
                    
                    historialContent.appendChild(itemElement);
                });
                
                document.getElementById('historyModal').classList.remove('hidden');
                document.getElementById('historyModal').classList.add('flex');
            }
        }

        function closeHistoryModal() {
            document.getElementById('historyModal').classList.add('hidden');
            document.getElementById('historyModal').classList.remove('flex');
        }

        function buscarEstudiantes() {
            const searchType = document.getElementById('searchType').value;
            const searchTerm = document.getElementById('searchTerm').value.toLowerCase();
            
            if (searchType === 'Seleccione una opción' || searchTerm === '') {
                alert('Por favor, seleccione un tipo de búsqueda e ingrese un término.');
                return;
            }
            
            const tablaEstudiantes = document.getElementById('tablaEstudiantes');
            const totalRegistros = document.getElementById('totalRegistros');
            
            // Filtrar estudiantes según el criterio de búsqueda
            const estudiantesFiltrados = estudiantes.filter(est => {
                if (searchType === 'Carnet') {
                    return est.carnet.toLowerCase().includes(searchTerm);
                } else if (searchType === 'Nombre') {
                    return est.nombre.toLowerCase().includes(searchTerm);
                } else if (searchType === 'Apellido') {
                    return est.apellido.toLowerCase().includes(searchTerm);
                }
                return false;
            });
            
            // Actualizar tabla
            tablaEstudiantes.innerHTML = '';
            
            if (estudiantesFiltrados.length === 0) {
                tablaEstudiantes.innerHTML = `
                    <tr>
                        <td colspan="9" class="px-4 py-3 text-center text-gray-500">
                            No se encontraron estudiantes que coincidan con la búsqueda.
                        </td>
                    </tr>
                `;
            } else {
                estudiantesFiltrados.forEach(est => {
                    const row = document.createElement('tr');
                    row.className = 'bg-gray-50 hover:bg-gray-100 transition-colors';
                    
                    // Determinar color de faltas
                    let faltasColor = 'text-orange-500';
                    let faltasTexto = '1 falta';
                    
                    if (est.carnet === '5521') {
                        faltasColor = 'text-red-600';
                        faltasTexto = '2 faltas';
                    } else if (est.carnet === '5523') {
                        faltasColor = 'text-red-600';
                        faltasTexto = '3 faltas';
                    }
                    
                    row.innerHTML = `
                        <td class="px-4 py-3">${est.carnet}</td>
                        <td class="px-4 py-3 text-blue-600 font-medium">${est.nombre}</td>
                        <td class="px-4 py-3 text-blue-600 font-medium">${est.apellido}</td>
                        <td class="px-4 py-3">${est.telefono}</td>
                        <td class="px-4 py-3 text-blue-600">${est.email}</td>
                        <td class="px-4 py-3 ${faltasColor} font-medium">${faltasTexto}</td>
                        <td class="px-4 py-3">${est.carnet === '5521' ? '2' : est.carnet === '5522' ? '1' : '3'}</td>
                        <td class="px-4 py-3">${est.year}</td>
                        <td class="px-4 py-3">
                            <button onclick="openDetailsModal('${est.carnet}')" class="bg-itca-red hover:bg-itca-dark-red text-white px-3 py-1 rounded text-sm transition-colors shadow-sm">
                                Ver detalles
                            </button>
                        </td>
                    `;
                    
                    tablaEstudiantes.appendChild(row);
                });
            }
            
            // Actualizar contador
            totalRegistros.textContent = `Total de registros: ${estudiantesFiltrados.length}`;
        }

        // Cerrar modales al hacer clic fuera
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

        // Cerrar modales con tecla Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDetailsModal();
                closeCancelModal();
                closeHistoryModal();
            }
        });
    </script>