<?php
require_once "../../models/FaltasModel.php";
$alumnos = (new Faltas())->getAllAlumnos();

$estudiantes = json_encode($alumnos);
var_dump($estudiantes);

?>
 
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
                        <img src="" 
                             alt="Foto del estudiante" 
                             id="FotoEstudianteDisplay"
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
                    <button class="w-full bg-itca-red text-white py-3 px-6 font-semibold hover:bg-red-800 transition-all duration-200 rounded-lg shadow-md hover:shadow-lg mt-4" 
                            id="historialInasistenciasBtn">
                        <i class="fas fa-history"></i>
                        Historial de Inasistencias
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
                                <div class="text-sm font-semibold text-gray-600 mb-1">Contacto de emergencia</div>
                                <div>
                                    <span id="contactoEmergenciaDisplay" class="text-lg text-gray-800 font-medium">Activo</span>
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
                                <div class="text-sm font-semibold text-gray-600 mb-1">Correo personal</div>
                                <div class="text-lg text-blue-600 font-medium" id="correoPersonalDisplay">estudiante@gmail.com</div>
                            </div>
            
                            
                            <div class="info-card">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Teléfono</div>
                                    <div class="text-lg text-gray-800 font-medium" id="telefonoDisplay">76267471</div>
                                </div>

                                <div class="info-card">
                                <div class="text-sm font-semibold text-gray-600 mb-1">Observaciones</div>
                                <div class="text-lg text-gray-800 font-medium" id="observacionesDisplay">76267471</div>
                            </div>

                            </div>
                            
                        
                    </div>
                    
                    <!-- Información adicional -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Ciclo actual</div>
                            <div id="cicloDisplay" class="text-lg text-gray-800 font-medium">2</div>
                        </div>
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Faltas acumuladas</div>
                            <div id="faltasDisplay" class="text-lg text-red-600 font-medium">2</div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Historial de Inasistencias -->
<div id="modalHistorial" class="modal hidden">
    <div class="modal-content bg-white rounded-xl w-11/12 max-w-6xl">
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 relative">
            <!-- Encabezado del modal -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Historial de Inasistencias</h2>
                <button onclick="cerrarModalHistorial()" class="close-btn">×</button>
            </div>
            
            <!-- Información del estudiante -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <div class="flex items-center gap-4">
                    <img src="" 
                         alt="Foto del estudiante" 
                         id="fotoEstudianteHistorial"
                         class="w-16 h-16 object-cover rounded-full">
                    <div>
                        <h3 id="nombreEstudianteHistorial" class="text-lg font-semibold text-gray-800"></h3>
                        <p id="carnetEstudianteHistorial" class="text-gray-600"></p>
                    </div>
                </div>
            </div>
            
            <!-- Filtros -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha desde</label>
                    <input type="date" id="fechaDesde" class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha hasta</label>
                    <input type="date" id="fechaHasta" class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <div class="flex items-end">
                    <button onclick="filtrarHistorial()" class="w-full bg-itca-red text-white py-2 px-4 font-semibold hover:bg-red-800 transition-all duration-200 rounded-lg shadow-md">
                        Filtrar
                    </button>
                </div>
            </div>
            
            <!-- Tabla de inasistencias -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horas</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observación</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Justificación</th>
                         
                        </tr>
                    </thead>
                    <tbody id="tablaHistorialBody" class="divide-y divide-gray-200">
                        <!-- Las filas se llenarán dinámicamente con JavaScript -->
                    </tbody>
                </table>
            </div>
            
            <!-- Mensaje cuando no hay datos -->
            <div id="sinDatos" class="text-center py-8 hidden">
                <p class="text-gray-500">No se encontraron registros de inasistencias</p>
            </div>
            
            <!-- Pie del modal -->
            <div class="flex justify-between items-center mt-6">
                <div class="text-sm text-gray-500">
                    Total de inasistencias: <span id="totalInasistencias" class="font-semibold">0</span>
                </div>
                <button onclick="cerrarModalHistorial()" class="bg-gray-500 text-white py-2 px-6 font-semibold hover:bg-gray-600 transition-all duration-200 rounded-lg shadow-md">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Datos de ejemplo para los estudiantes
    const estudiantes = <?php echo $estudiantes; ?>;

 

    function verDetalles(carnet,id) {
        cargarHistorialInasistencias(id);

        const estudiante = estudiantes.find(estudiante => estudiante.carnet === carnet);
        if (estudiante) {
            // Actualizar elementos con los datos del estudiante
         
            document.getElementById('carnetDisplay').textContent = estudiante.carnet;
            document.getElementById('nombreDisplay').textContent = estudiante.nombre;
            document.getElementById('apellidoDisplay').textContent = estudiante.apellido;
            document.getElementById('correoPersonalDisplay').textContent = estudiante.email;
            document.getElementById('estadoDisplay').textContent = estudiante.estadoAlumno==1?"Activo":"Inactivo";
            document.getElementById('becaDisplay').textContent = estudiante.beca==1?"Sí":"No";
            document.getElementById('tipoBecaDisplay').textContent = estudiante.tipobeca;
            document.getElementById('telefonoDisplay').textContent = estudiante.telefono;
            document.getElementById('FotoEstudianteDisplay').src = estudiante.foto == "" ? "/ProyectoInasistenciasItca/Vistas/Publico/Imagenes/12225881.png" : estudiante.foto;
            document.getElementById('cicloDisplay').textContent = estudiante.ciclo;
            document.getElementById('faltasDisplay').textContent = estudiante.total_faltas;
            document.getElementById('contactoEmergenciaDisplay').textContent = estudiante.telefono_emergencia;
            document.getElementById('observacionesDisplay').textContent = estudiante.observaciones;
            
            // Aplicar estilos según el estado
            const estadoElement = document.getElementById('estadoDisplay');
            estadoElement.className = 'status-badge';
            if (estudiante.estadoAlumno == 1) {
                estadoElement.classList.add('status-active');
            } else {
                estadoElement.classList.add('status-inactive');
            }
            
            // Aplicar estilos según la beca
            const becaElement = document.getElementById('becaDisplay');
            becaElement.className = 'status-badge';
            if (estudiante.beca == 1) {
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
        const modalHistorial = document.getElementById('modalHistorial');
        
        if (event.target === modal) {
            cerrarModal();
        }
        
        if (event.target === modalHistorial) {
            cerrarModalHistorial();
        }
    };

    // Cerrar modal con la tecla Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            cerrarModal();
            cerrarModalHistorial();
        }
    });

    // ========== FUNCIONES PARA EL MODAL DE HISTORIAL ==========

    // Función para abrir el modal de historial
    document.getElementById('historialInasistenciasBtn').addEventListener('click', function() {
        abrirModalHistorial();
    });

    // Función para abrir el modal de historial
    function abrirModalHistorial() {
        // Obtener datos del estudiante actual
        const carnet = document.getElementById('carnetDisplay').textContent;
        const nombre = document.getElementById('nombreDisplay').textContent;
        const apellido = document.getElementById('apellidoDisplay').textContent;
        const foto = document.getElementById('FotoEstudianteDisplay').src;
        
        // Actualizar información del estudiante en el modal de historial
        document.getElementById('fotoEstudianteHistorial').src = foto;
        document.getElementById('nombreEstudianteHistorial').textContent = `${nombre} ${apellido}`;
        document.getElementById('carnetEstudianteHistorial').textContent = `Carnet: ${carnet}`;
        
        // Cerrar modal de detalles
        cerrarModal();
        
        // Cargar datos del historial

        
        
        // Mostrar modal de historial
        document.getElementById('modalHistorial').classList.remove('hidden');
        document.getElementById('modalHistorial').classList.add('show');
    }

    // Función para cerrar el modal de historial
    function cerrarModalHistorial() {
        document.getElementById('modalHistorial').classList.remove('show');
        document.getElementById('modalHistorial').classList.add('hidden');
        
        // Volver a abrir el modal de detalles
        document.getElementById('modalDetalles').classList.add('show');
    }

    // Función para cargar el historial de inasistencias
    function cargarHistorialInasistencias(id) {
        // Buscar el estudiante por ID
        const estudiante = estudiantes.find(est => est.idalumno == id);
        
        if (!estudiante || !estudiante.faltas_detalle) {
            // Si no hay faltas, mostrar mensaje
            actualizarTablaHistorial([]);
            return;
        }

        // Convertir faltas_detalle a array si es un objeto
        let faltasArray = [];
        if (Array.isArray(estudiante.faltas_detalle)) {
            faltasArray = estudiante.faltas_detalle;
        } else if (typeof estudiante.faltas_detalle === 'object') {
            faltasArray = Object.values(estudiante.faltas_detalle);
        }

        // Mapear los datos al formato esperado por la tabla
        const historial = faltasArray.map(falta => ({
            fecha: falta.fecha_falta,
            horas: falta.cantidadHoras,
            observacion: falta.observacion || 'Sin observación',
            estado: falta.justificandO == 1 ? 'Justificada' : 'Injustificada',
            justificacion: falta.justificaion || 'No hay justificación',
            materia: falta.materia,
            docente: `${falta.nombre_docente} ${falta.apellido_docente}`,
            ciclo: falta.ciclo,
            year: falta.year
        }));
        
        // Ordenar por fecha (más reciente primero)
        historial.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));
        
        // Actualizar la tabla
        actualizarTablaHistorial(historial);
    }

    // Función para actualizar la tabla con los datos del historial
    function actualizarTablaHistorial(datos) {
        const tbody = document.getElementById('tablaHistorialBody');
        const sinDatos = document.getElementById('sinDatos');
        const totalInasistencias = document.getElementById('totalInasistencias');
        
        // Limpiar tabla
        tbody.innerHTML = '';
        
        if (datos.length === 0) {
            sinDatos.classList.remove('hidden');
            totalInasistencias.textContent = '0';
            return;
        }
        
        sinDatos.classList.add('hidden');
        totalInasistencias.textContent = datos.length.toString();
        
        // Llenar tabla con datos
        datos.forEach((falta, index) => {
            const fila = document.createElement('tr');
            fila.className = index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
            
            fila.innerHTML = `
                <td class="py-3 px-4 text-sm text-gray-800">${formatearFecha(falta.fecha)}</td>
                <td class="py-3 px-4 text-sm text-gray-800">${falta.horas} hora(s)</td>
                <td class="py-3 px-4 text-sm text-gray-800">${falta.observacion}</td>
                <td class="py-3 px-4">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${falta.estado === 'Justificada' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                        ${falta.estado}
                    </span>
                </td>
                <td class="py-3 px-4 text-sm text-gray-800">${falta.justificacion || 'No aplica'}</td>
                <td class="py-3 px-4 text-sm text-gray-800">${falta.materia}</td>
                <td class="py-3 px-4 text-sm text-gray-800">${falta.docente}</td>
                <td class="py-3 px-4 text-sm text-gray-800">${falta.ciclo}</td>
                <td class="py-3 px-4 text-sm text-gray-800">${falta.year}</td>
                
            `;
            
            tbody.appendChild(fila);
        });
    }

    // Función para formatear fecha
    function formatearFecha(fecha) {
        const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(fecha).toLocaleDateString('es-ES', opciones);
    }

    // Función para filtrar el historial
    function filtrarHistorial() {
        const fechaDesde = document.getElementById('fechaDesde').value;
        const fechaHasta = document.getElementById('fechaHasta').value;
        
        // Aquí iría la lógica para filtrar los datos según las fechas
        console.log('Filtrando desde:', fechaDesde, 'hasta:', fechaHasta);
        
        // Por ahora, simplemente recargamos los datos
        const carnet = document.getElementById('carnetEstudianteHistorial').textContent.split(': ')[1];
        cargarHistorialInasistencias(carnet);
    }

    // Funciones de ejemplo para las acciones
    function verDetallesFalta(fecha) {
        alert(`Viendo detalles de la falta del ${formatearFecha(fecha)}`);
    }

    function editarFalta(fecha) {
        alert(`Editando falta del ${formatearFecha(fecha)}`);
    }
</script>

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
        background-color: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
    }
    
    .modal.show {
        display: flex;
    }
    
    .modal.hidden {
        display: none;
    }
    
    .close-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 24px;
        font-weight: bold;
        color: #6b7280;
        background: none;
        border: none;
        cursor: pointer;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s;
    }
    
    .close-btn:hover {
        background-color: #f3f4f6;
        color: #374151;
    }

    /* Estilos para los badges de estado */
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        text-align: center;
    }
    
    .status-active {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-inactive {
        background-color: #fee2e2;
        color: #991b1b;
    }

    /* Estilos para las tarjetas de información */
    .info-card {
        background-color: white;
        padding: 1rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    /* Colores personalizados */
    .bg-itca-red {
        background-color: #e63946;
    }

    .hover\:bg-red-800:hover {
        background-color: #b91c1c;
    }
</style>