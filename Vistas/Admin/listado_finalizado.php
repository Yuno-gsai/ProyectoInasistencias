<?php
session_start();
if(!isset($_SESSION['administrador'])){
    header("Location: /ProyectoInasistenciasItca/index.php");
}
$dataAdmin=$_SESSION['administrador'];

require_once "../../models/SeguimientosModel.php";
$estudiantes = (new SeguimientosModel())->getSeguimientosFinalizados();
var_dump($estudiantes);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimientos Finalizados - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Estilos para el modal */
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
        }
        
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Estilos adicionales para los elementos del modal */
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
            background-color: #DC2626;
            border-radius: 2px;
        }
        .info-card {
            background-color: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
        .status-inactive {
            background-color: #F3F4F6;
            color: #6B7280;
        }
        
        /* Estilos para el modal de historial */
        .modal-backdrop {
            backdrop-filter: blur(4px);
        }
        .modal-content-historial {
            animation: modalFadeIn 0.3s ease-out;
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
    <?php include "menu.php" ?>
     <!-- Título principal -->
     
    <!-- Contenido principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Listado de Finalizados</h1>
            <p class="text-gray-600">Gestión y consulta de información estudiantil</p>
        </div>
        <!-- Formulario de búsqueda -->
        <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-lg mb-6">
            <div class="flex items-center mb-4">
                <div class="bg-red-100 p-2 rounded-full mr-3">
                    <i class="fas fa-filter text-red-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Filtros de búsqueda</h3>
            </div>
            <form class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-48">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Buscar por:</label>
                    <select id="searchType" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent">
                        <option>Seleccione una opción</option>
                        <option>Carnet</option>
                        <option>Nombre</option>
                        <option>Apellido</option>
                        <option>Fecha</option>
                    </select>
                </div>
                
                <div class="flex-1 min-w-48">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Dato:</label>
                    <input type="text" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Ingrese término de búsqueda">
                </div>
                <div>
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-red-700 transition-colors shadow-md">
                        <i class="fas fa-search mr-2"></i>Buscar
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Fecha Ultimo Seguimiento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Motivo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($estudiantes as $estudiante) { ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $estudiante['carnet'];?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $estudiante['nombre'];?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $estudiante['apellido'];?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $estudiante['fecha_estado'];?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $estudiante['ultima_fecha_seguimiento'];?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $estudiante['motivo'];?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <button class="bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-medium hover:bg-red-700 transition-colors duration-200"
                                onclick="verDetalles('<?php echo $estudiante['idalumno'];?>')">
                                    <i class="fas fa-eye mr-1"></i>Ver detalles
                                </button>
                                <button class="bg-blue-600 text-white px-3 py-1 rounded-lg text-xs font-medium hover:bg-blue-700 transition-colors duration-200"
                                onclick="openHistoryModal('<?php echo $estudiante['idalumno'];?>')">
                                    <i class="fas fa-history mr-1"></i>Historial
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                        <!-- Filas adicionales de ejemplo -->
                      
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
                <button class="px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md">
                    1
                </button>
                <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50" disabled>
                    Siguiente
                </button>
            </div>
        </div>
    </main>

    <!-- Modal de detalles del estudiante -->
    <div id="modalDetalles" class="modal">
        <div class="modal-content bg-white rounded-xl">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-8 relative">
                <!-- Botón cerrar mejorado -->
                <button onclick="cerrarModalDetalles()" class="close-btn">×</button>
                
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
                                <div class="text-lg text-red-600 font-medium" id="faltasAcumuladasDisplay">2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Historial -->
    <div id="modalHistorial" class="modal">
        <div class="modal-content bg-white rounded-xl modal-content-historial">
            <div class="p-8 relative">
                <button onclick="cerrarModalHistorial()" class="close-btn">×</button>
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center section-title">Historial de Seguimiento</h2>
                
                <div id="historialContent" class="space-y-4">
                    <!-- El contenido del historial se cargará dinámicamente aquí -->
                </div>
                
                <div class="flex justify-end mt-6">
                    <button onclick="cerrarModalHistorial()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors shadow-md">
                        <i class="fas fa-times mr-2"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Datos de ejemplo para los estudiantes
        const estudiantes = <?php echo json_encode($estudiantes); ?>;
        
        //     {
        //         carnet: "5521",
        //         nombre: "german jose",
        //         apellido: "perdomo moran",
        //         telefono: "77777777",
        //         email: "estudiante.24@itca.edu.sv",
        //         faltas: 2,
        //         ciclo: 2,
        //         año: 2024,
        //         correoPersonal: "german.perdomo@gmail.com",
        //         estadoAlumno: "Activo",
        //         añoEstudio: "2025",
        //         beca: "Sí",
        //         tipoBeca: "Semilla",
        //         carnetCompleto: "12345",
        //         historial: [
        //             {
        //                 tipo: "Llamada telefónica",
        //                 fecha: "15 de septiembre, 2024",
        //                 estado: "Realizada",
        //                 descripcion: "Se contactó al estudiante para verificar su situación académica."
        //             },
        //             {
        //                 tipo: "Correo electrónico",
        //                 fecha: "10 de septiembre, 2024",
        //                 estado: "Enviado",
        //                 descripcion: "Se envió recordatorio sobre las faltas acumuladas."
        //             },
        //             {
        //                 tipo: "Reunión con coordinador",
        //                 fecha: "5 de septiembre, 2024",
        //                 estado: "Pendiente",
        //                 descripcion: "Programada para evaluar situación académica del estudiante."
        //             }
        //         ]
        //     },
        //     {
        //         carnet: "5522",
        //         nombre: "maria elena",
        //         apellido: "rodriguez lopez",
        //         telefono: "88888888",
        //         email: "estudiante.25@itca.edu.sv",
        //         faltas: 1,
        //         ciclo: 1,
        //         año: 2024,
        //         correoPersonal: "maria.rodriguez@gmail.com",
        //         estadoAlumno: "Activo",
        //         añoEstudio: "2025",
        //         beca: "No",
        //         tipoBeca: "N/A",
        //         carnetCompleto: "54321",
        //         historial: [
        //             {
        //                 tipo: "Correo electrónico",
        //                 fecha: "12 de septiembre, 2024",
        //                 estado: "Enviado",
        //                 descripcion: "Se envió información sobre tutorías disponibles."
        //             },
        //             {
        //                 tipo: "Entrevista personal",
        //                 fecha: "8 de septiembre, 2024",
        //                 estado: "Realizada",
        //                 descripcion: "Se evaluaron las dificultades académicas del estudiante."
        //             }
        //         ]
        //     },
        //     {
        //         carnet: "5523",
        //         nombre: "carlos antonio",
        //         apellido: "martinez silva",
        //         telefono: "99999999",
        //         email: "estudiante.26@itca.edu.sv",
        //         faltas: 3,
        //         ciclo: 3,
        //         año: 2024,
        //         correoPersonal: "carlos.martinez@gmail.com",
        //         estadoAlumno: "Suspendido",
        //         añoEstudio: "2025",
        //         beca: "Sí",
        //         tipoBeca: "Completa",
        //         carnetCompleto: "67890",
        //         historial: [
        //             {
        //                 tipo: "Llamada telefónica",
        //                 fecha: "18 de septiembre, 2024",
        //                 estado: "No contestó",
        //                 descripcion: "Se intentó contactar al estudiante sin éxito."
        //             },
        //             {
        //                 tipo: "Correo electrónico",
        //                 fecha: "14 de septiembre, 2024",
        //                 estado: "Enviado",
        //                 descripcion: "Se notificó sobre situación de riesgo académico."
        //             },
        //             {
        //                 tipo: "Visita domiciliaria",
        //                 fecha: "10 de septiembre, 2024",
        //                 estado: "Programada",
        //                 descripcion: "Se programó visita para evaluar situación personal."
        //             }
        //         ]
        //     }
        // ];

        // Función para abrir el modal de detalles
        let estudianteActual = null;

        function verDetalles(idalumno) {
            estudianteActual = estudiantes.find(est => est.idalumno == idalumno);
            if (estudianteActual) {
                // Actualizar elementos con los datos del estudiante
                document.getElementById('carnetDisplay').textContent = estudianteActual.carnet;
                document.getElementById('nombreDisplay').textContent = estudianteActual.nombre;
                document.getElementById('apellidoDisplay').textContent = estudianteActual.apellido;
                document.getElementById('correoInstitucionalDisplay').textContent = estudianteActual.email;
                document.getElementById('estadoDisplay').textContent = estudianteActual.estadoAlumno==1?"Activo":"Inactivo";
                document.getElementById('becaDisplay').textContent = estudianteActual.beca==1?"Sí":"No";
                document.getElementById('tipoBecaDisplay').textContent = estudianteActual.tipobeca;
                document.getElementById('telefonoDisplay').textContent = estudianteActual.telefono;
                document.getElementById('faltasAcumuladasDisplay').textContent = estudianteActual.total_faltas;
                
                // Aplicar estilos según el estado
                const estadoElement = document.getElementById('estadoDisplay');
                estadoElement.className = 'status-badge';
                if (estudianteActual.estadoAlumno === 'Activo') {
                    estadoElement.classList.add('status-active');
                } else if (estudianteActual.estadoAlumno === 'Suspendido') {
                    estadoElement.classList.add('status-suspended');
                } else {
                    estadoElement.classList.add('status-inactive');
                }
                
                // Aplicar estilos según la beca
                const becaElement = document.getElementById('becaDisplay');
                becaElement.className = 'status-badge';
                if (estudianteActual.beca === 'Sí') {
                    becaElement.classList.add('status-active');
                } else {
                    becaElement.classList.add('status-inactive');
                }
                
                // Mostrar modal
                document.getElementById('modalDetalles').classList.add('show');
            }
        }

        // Función para abrir el modal de historial
        function openHistoryModal(idalumno) {
    estudianteActual = estudiantes.find(est => est.idalumno == idalumno);

    const historialContent = document.getElementById('historialContent');
    historialContent.innerHTML = '';

    if (Array.isArray(estudianteActual.seguimientos) && estudianteActual.seguimientos.length > 0) {
        estudianteActual.seguimientos.forEach(s => {
            let borderColor = 'border-red-600';
            if (s.accion?.toLowerCase().includes('llamada')) borderColor = 'border-blue-500';
            else if (s.accion?.toLowerCase().includes('correo') || s.accion?.toLowerCase().includes('email')) borderColor = 'border-green-500';
            else if (s.accion?.toLowerCase().includes('visita')) borderColor = 'border-yellow-500';

            const itemElement = document.createElement('div');
            itemElement.className = `relative bg-gray-50 p-4 rounded-lg shadow-md ${borderColor} border-l-4`;
            itemElement.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-500 font-medium">${s.fecha}</span>
                    <span class="text-sm font-semibold ${borderColor.replace('border', 'text')}">${s.accion}</span>
                </div>
                <p class="text-gray-700">${s.respuesta}</p>
            `;
            historialContent.appendChild(itemElement);
        });
    } else {
        historialContent.innerHTML = "<p class='text-gray-500 text-center'>No hay seguimientos registrados.</p>";
    }

    // Cambiar estas líneas
    const modal = document.getElementById('modalHistorial');
    modal.classList.remove('hidden');
    modal.classList.add('show');
}


        // Función para cerrar el modal de detalles
        function cerrarModalDetalles() {
            document.getElementById('modalDetalles').classList.remove('show');
        }

        // Función para cerrar el modal de historial
        function cerrarModalHistorial() {
            document.getElementById('modalHistorial').classList.remove('show');
        }

        function iniciarSeguimiento() {
            alert('Iniciando seguimiento del estudiante...');
            // Aquí puedes agregar la lógica para iniciar el seguimiento
        }

        function buscarEstudiantes() {
            const tipo = document.getElementById('searchType').value;
            const dato = document.getElementById('searchInput').value.toLowerCase();
            
            if (!tipo || tipo === 'Seleccione una opción' || !dato) {
                alert('Por favor seleccione un tipo de búsqueda e ingrese un dato');
                return;
            }
            
            // Aquí podrías implementar la lógica de búsqueda
            console.log('Buscando por', tipo, ':', dato);
            alert(`Buscando estudiantes por ${tipo}: ${dato}`);
        }

        // Cerrar modales al hacer clic fuera de ellos
        window.onclick = function(event) {
            const modalDetalles = document.getElementById('modalDetalles');
            const modalHistorial = document.getElementById('modalHistorial');
            
            if (event.target === modalDetalles) {
                cerrarModalDetalles();
            }
            if (event.target === modalHistorial) {
                cerrarModalHistorial();
            }
        }

        // Cerrar modales con la tecla Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                cerrarModalDetalles();
                cerrarModalHistorial();
            }
        });
    </script>
</body>
</html>