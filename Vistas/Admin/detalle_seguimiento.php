<?php
session_start();
if(!isset($_SESSION['administrador'])){
    header("Location: /ProyectoInasistencias/index.php");
    exit();
}
$dataAdmin=$_SESSION['administrador'];

require_once "../../models/SeguimientosModel.php";

// Obtener el ID del alumno
$idalumno = isset($_GET['idalumno']) ? intval($_GET['idalumno']) : null;

if (!$idalumno) {
    header("Location: listado_segimiento.php");
    exit();
}

$seguimientosModel = new SeguimientosModel();
$estudiantes = $seguimientosModel->getAllEstudiantes();
$alumno = null;

foreach ($estudiantes as $est) {
    if ($est['idalumno'] == $idalumno) {
        $alumno = $est;
        break;
    }
}

if (!$alumno) {
    header("Location: listado_segimiento.php");
    exit();
}

// Procesar formulario de seguimiento
if(isset($_POST['guardarSeguimiento'])){
    $data = [
        'id_inasistencia' => $_POST['faltaid'],
        'accion' => $_POST['tipo_accion'],
        'respuesta' => $_POST['detalle']
    ];
    $seguimientosModel->Create($data);
    $_SESSION['mensaje'] = 'Seguimiento guardado correctamente';
    header("Location: detalle_seguimiento.php?idalumno=" . $idalumno);
    exit();
}

// Procesar formulario de cancelación
if(isset($_POST['confirmarRetiro'])){
    $motivo = $_POST['motivo'];
    $estado = $_POST['estado'];
    $seguimientosModel->FinSeguimieto($estado, $motivo, $idalumno, date('Y-m-d'));
    $_SESSION['mensaje'] = 'Seguimiento finalizado correctamente';
    header("Location: listado_finalizado.php");
    exit();
}

// Obtener faltas del alumno
$faltas = [];
if (isset($alumno['faltas'])) {
    if (is_string($alumno['faltas'])) {
        $faltas = json_decode($alumno['faltas'], true);
    } elseif (is_array($alumno['faltas'])) {
        $faltas = $alumno['faltas'];
    }
}
if (!is_array($faltas)) {
    $faltas = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Seguimiento - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .info-card {
            background: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-left: 4px solid #EF4444;
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
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<!--Navbar-->
<nav class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-2 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <img src="../Publico/Imagenes/ItcaLogo.png" alt="Logo ITCA FEPADE" class="h-8">
            <p class="text-sm font-semibold text-gray-700">Registro de Inasistencias</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-700 font-medium"><?php echo $dataAdmin['nom_usuario'] . ' ' . $dataAdmin['ape_usuario']; ?></span>
            <button id="backBtn"
                    class="flex items-center bg-gray-600 text-white py-1 px-3 rounded-md text-sm hover:bg-gray-700 transition">
                <i class="fas fa-arrow-left mr-1"></i>
                <span class="hidden sm:inline">Regresar</span>
            </button>
            <button id="logoutBtn"
                    class="flex items-center bg-red-600 text-white py-1 px-3 rounded-md text-sm hover:bg-red-700 transition">
                <i class="fas fa-sign-out-alt mr-1"></i>
                <span class="hidden sm:inline">Salir</span>
            </button>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="flex justify-center bg-gray-100 mt-8 px-4">
    <div class="bg-white rounded-xl shadow-lg p-6 max-w-6xl w-full">
        <?php if(isset($_SESSION['mensaje'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                <p><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></p>
            </div>
        <?php endif; ?>

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Gestión de Seguimiento</h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información del Estudiante -->
            <div class="lg:col-span-2">
                <div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg mb-6">
                    <h3 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-user mr-2 text-blue-600"></i>Datos del Estudiante
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Carnet</div>
                            <div class="text-lg text-gray-800 font-medium"><?php echo $alumno['carnet']; ?></div>
                        </div>
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Nombre</div>
                            <div class="text-lg text-gray-800 font-medium"><?php echo $alumno['nombre'] . ' ' . $alumno['apellido']; ?></div>
                        </div>
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Teléfono</div>
                            <div class="text-lg text-gray-800 font-medium"><?php echo $alumno['telefono']; ?></div>
                        </div>
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Email</div>
                            <div class="text-lg text-blue-600 font-medium"><?php echo $alumno['email']; ?></div>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Seguimiento -->
                <div class="bg-green-50 border-l-4 border-green-600 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-4">
                        <i class="fas fa-clipboard-check mr-2 text-green-600"></i>Registrar Seguimiento
                    </h3>
                    <form method="post">
                        <input type="hidden" name="faltaid" value="<?php echo (!empty($faltas) && isset($faltas[0]['id_inasistencia'])) ? $faltas[0]['id_inasistencia'] : ''; ?>">
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Acción</label>
                            <select name="tipo_accion" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="Llamada">Llamada</option>
                                <option value="Correo">Correo</option>
                                <option value="Visita">Visita</option>
                                <option value="Reunión">Reunión</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Detalles</label>
                            <textarea name="detalle" required rows="4" 
                                      class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"
                                      placeholder="Describa el seguimiento realizado..."></textarea>
                        </div>

                        <button type="submit" name="guardarSeguimiento" 
                                class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition">
                            <i class="fas fa-save mr-2"></i>Guardar Seguimiento
                        </button>
                    </form>
                </div>
            </div>

            <!-- Panel de Acciones -->
            <div class="space-y-4">
                <a href="historial_seguimiento.php?idalumno=<?php echo $idalumno; ?>" 
                   class="block bg-blue-600 text-white p-4 rounded-lg hover:bg-blue-700 transition text-center">
                    <i class="fas fa-history text-2xl mb-2"></i>
                    <div class="font-semibold">Ver Historial</div>
                    <div class="text-sm opacity-90">Seguimientos anteriores</div>
                </a>

                <button onclick="document.getElementById('modalCancelar').classList.remove('hidden')" 
                        class="w-full bg-red-600 text-white p-4 rounded-lg hover:bg-red-700 transition text-center">
                    <i class="fas fa-times-circle text-2xl mb-2"></i>
                    <div class="font-semibold">Finalizar Seguimiento</div>
                    <div class="text-sm opacity-90">Cerrar caso</div>
                </button>
            </div>
        </div>
    </div>
</main>

<!-- Modal de Cancelar Seguimiento -->
<div id="modalCancelar" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Finalizar Seguimiento</h2>
        
        <form method="post">
            <input type="hidden" name="studentId" value="<?php echo $idalumno; ?>">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado Final</label>
                <select name="estado" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">Seleccione una opción</option>
                    <option value="Retirado">Retirado</option>
                    <option value="Suspendido">Suspendido</option>
                    <option value="Transferido">Transferido</option>
                    <option value="Resuelto">Resuelto</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Motivo</label>
                <textarea name="motivo" required rows="4"
                          class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500 resize-none"
                          placeholder="Describa el motivo de finalización..."></textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <button type="button" onclick="document.getElementById('modalCancelar').classList.add('hidden')"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </button>
                <button type="submit" name="confirmarRetiro"
                        class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('backBtn').addEventListener('click', function() {
        window.location.href = 'listado_segimiento.php';
    });
    
    document.getElementById('logoutBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea cerrar sesión?')) {
            window.location.href = '../Login/Logout.php';
        }
    });
</script>
</body>
</html>
