<?php
require_once __DIR__ . '/../../models/ExtraModel.php';

$extraModel = new Extra();

// Guardar cambios del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_extra = isset($_POST['id_extra']) && $_POST['id_extra'] !== '' ? (int)$_POST['id_extra'] : null;

    $data = [
        'idalumno'            => $_POST['idalumno'],
        'direccion'           => $_POST['direccion'] ?? null,
        'fecha_nacimiento'    => $_POST['fecha_nacimiento'] ?? null,
        'contacto_emergencia' => $_POST['contacto_emergencia'] ?? null,
        'telefono_emergencia' => $_POST['telefono_emergencia'] ?? null,
        'observaciones'       => $_POST['observaciones'] ?? null,
        'estado'              => $_POST['estado'] ?? 'Activo',
        'motivo'              => $_POST['motivo'] ?? null,
        'fecha_estado'        => $_POST['fecha_estado'] ?? null,
    ];

    if ($id_extra) {
        $extraModel->updateExtra($id_extra, $data);
    } else {
        $extraModel->insertExtra($data);
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Obtener alumnos con datos extra
$alumnos = $extraModel->getAllWithAlumno();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Datos Adicionales de Alumnos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Título y buscador -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Datos Adicionales de Alumnos</h1>
                <p class="text-gray-600 mt-2">Editar información complementaria de los alumnos</p>
            </div>
            <div class="relative w-full md:w-1/3 mt-4 md:mt-0">
                <input type="text" id="buscador" placeholder="Buscar alumnos..." 
                    class="w-full px-4 py-2 pl-10 pr-4 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>

        <!-- Tabla de alumnos -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alumno</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Nacimiento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto Emergencia</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-alumnos" class="bg-white divide-y divide-gray-200">
                        <!-- Los datos se cargarán aquí dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Formulario desplegable para editar datos extra -->
        <div id="formulario-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h2 class="text-xl font-semibold text-gray-800">Editar Datos Adicionales</h2>
                        <button id="cerrar-formulario" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <form id="form-alumno-extra" class="p-6" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="id_extra" id="id_extra">
                        <input type="hidden" name="idalumno" id="idalumno">
                        
                        <!-- Información del alumno (solo lectura) -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <h3 class="text-lg font-medium text-blue-800 mb-2">Información del Alumno</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-blue-600">Nombre:</p>
                                    <p id="info-nombre" class="font-medium">-</p>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-600">Carnet:</p>
                                    <p id="info-carnet" class="font-medium">-</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Campos editables de la tabla ina_alumnos_extra -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                <input type="text" name="direccion" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contacto de Emergencia</label>
                                <input type="text" name="contacto_emergencia" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono de Emergencia</label>
                                <input type="text" name="telefono_emergencia" maxlength="9" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                                <select name="estado" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                    <option value="Suspendido">Suspendido</option>
                                    <option value="Egresado">Egresado</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Motivo del Estado</label>
                                <input type="text" name="motivo" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha del Estado</label>
                                <input type="date" name="fecha_estado" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                                <textarea name="observaciones" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" id="cancelar-formulario" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Cancelar
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Datos reales desde PHP (alumnos + datos extra en un solo arreglo)
        const alumnos = <?php echo json_encode($alumnos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

        // Arreglo de apoyo para acceder rápido solo a los datos extra por idalumno
        const alumnosExtra = alumnos.reduce((acc, alumno) => {
            acc.push({
                id_extra: alumno.id_extra || '',
                idalumno: alumno.idalumno,
                direccion: alumno.direccion || '',
                fecha_nacimiento: alumno.fecha_nacimiento || '',
                contacto_emergencia: alumno.contacto_emergencia || '',
                telefono_emergencia: alumno.telefono_emergencia || '',
                observaciones: alumno.observaciones || '',
                estado: alumno.estado || 'Activo',
                motivo: alumno.motivo || '',
                fecha_estado: alumno.fecha_estado || ''
            });
            return acc;
        }, []);

        // Elementos del DOM
        const tablaAlumnos = document.getElementById('tabla-alumnos');
        const buscador = document.getElementById('buscador');
        const formularioOverlay = document.getElementById('formulario-overlay');
        const formulario = document.getElementById('form-alumno-extra');
        const cerrarFormulario = document.getElementById('cerrar-formulario');
        const cancelarFormulario = document.getElementById('cancelar-formulario');
        const infoNombre = document.getElementById('info-nombre');
        const infoCarnet = document.getElementById('info-carnet');

        // Función para combinar datos de ambas "tablas" (arreglos)
        function combinarDatosAlumnos() {
            return alumnos.map(alumno => {
                const datosExtra = alumnosExtra.find(extra => extra.idalumno === alumno.idalumno) || {};
                return Object.assign({}, alumno, datosExtra);
            });
        }

        // Función para renderizar la tabla de alumnos
        function renderizarTabla(alumnosData) {
            tablaAlumnos.innerHTML = '';
            
            if (alumnosData.length === 0) {
                tablaAlumnos.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No se encontraron alumnos que coincidan con la búsqueda
                        </td>
                    </tr>
                `;
                return;
            }
            
            alumnosData.forEach(alumno => {
                const fila = document.createElement('tr');
                fila.className = 'hover:bg-gray-50';
                
                // Determinar color del estado
                let colorEstado = 'bg-green-100 text-green-800';
                if (alumno.estado === 'Inactivo') {
                    colorEstado = 'bg-red-100 text-red-800';
                } else if (alumno.estado === 'Suspendido') {
                    colorEstado = 'bg-yellow-100 text-yellow-800';
                } else if (alumno.estado === 'Egresado') {
                    colorEstado = 'bg-blue-100 text-blue-800';
                }
                
                fila.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">${alumno.nombre} ${alumno.apellido}</div>
                                <div class="text-sm text-gray-500">${alumno.carnet}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 max-w-xs truncate">${alumno.direccion || 'No registrada'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${alumno.fecha_nacimiento ? new Date(alumno.fecha_nacimiento).toLocaleDateString('es-ES') : 'No registrada'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${alumno.contacto_emergencia || 'No registrado'}</div>
                        <div class="text-sm text-gray-400">${alumno.telefono_emergencia || ''}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${colorEstado}">
                            ${alumno.estado || 'No definido'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-blue-600 hover:text-blue-900 editar-btn" data-id="${alumno.idalumno}">
                            <i class="fas fa-edit mr-1"></i> Editar
                        </button>
                    </td>
                `;
                
                tablaAlumnos.appendChild(fila);
            });
            
            // Agregar eventos a los botones de editar
            document.querySelectorAll('.editar-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const idAlumno = e.target.closest('button').getAttribute('data-id');
                    abrirFormulario(idAlumno);
                });
            });
        }

        // Función para abrir el formulario
        function abrirFormulario(idAlumno) {
            const alumno = alumnos.find(a => a.idalumno == idAlumno);
            const datosExtra = alumnosExtra.find(extra => extra.idalumno == idAlumno) || {};
            
            if (alumno) {
                // Mostrar información del alumno (solo lectura)
                infoNombre.textContent = `${alumno.nombre} ${alumno.apellido}`;
                infoCarnet.textContent = alumno.carnet;
                
                // Llenar el formulario con los datos existentes
                document.getElementById('id_extra').value = datosExtra.id_extra || '';
                document.getElementById('idalumno').value = idAlumno;
                
                // Llenar campos del formulario
                Object.keys(datosExtra).forEach(key => {
                    const input = formulario.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = datosExtra[key] || '';
                    }
                });
                
                formularioOverlay.classList.remove('hidden');
            }
        }

        // Función para buscar alumnos
        function buscarAlumnos(termino) {
            const datosCombinados = combinarDatosAlumnos();
            
            if (!termino) {
                return datosCombinados;
            }
            
            return datosCombinados.filter(alumno => {
                const textoBusqueda = `${alumno.carnet} ${alumno.nombre} ${alumno.apellido} ${alumno.direccion || ''} ${alumno.contacto_emergencia || ''}`.toLowerCase();
                return textoBusqueda.includes(termino.toLowerCase());
            });
        }

        // Eventos
        buscador.addEventListener('input', (e) => {
            const resultados = buscarAlumnos(e.target.value);
            renderizarTabla(resultados);
        });

        cerrarFormulario.addEventListener('click', () => {
            formularioOverlay.classList.add('hidden');
        });

        cancelarFormulario.addEventListener('click', () => {
            formularioOverlay.classList.add('hidden');
        });

        // Enviar formulario al servidor (post clásico, se maneja en PHP arriba)
        formulario.addEventListener('submit', () => {
            // Dejamos que el navegador haga el submit normal
        });

        // Inicializar la tabla con todos los alumnos
        renderizarTabla(combinarDatosAlumnos());
    </script>
</body>
</html>