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

// Obtener datos del alumno directamente
$query = "SELECT a.idalumno, a.carnet, a.nombre, a.apellido, a.email, a.telefono
          FROM alumno a
          WHERE a.idalumno = ?";
$stmt = $seguimientosModel->getConnection()->prepare($query);
$stmt->execute([$idalumno]);
$alumno = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$alumno) {
    header("Location: listado_segimiento.php");
    exit();
}

// Obtener seguimientos del alumno
$querySeguimientos = "SELECT s.id_seguimiento, s.fecha, s.accion, s.respuesta 
                      FROM seguimiento s 
                      INNER JOIN inasistencia i ON s.id_inasistencia = i.id_inasistencia
                      WHERE i.idalumno = ?
                      ORDER BY s.fecha DESC";
$stmtSeg = $seguimientosModel->getConnection()->prepare($querySeguimientos);
$stmtSeg->execute([$idalumno]);
$seguimientos = $stmtSeg->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Seguimiento - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
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
    <div class="bg-white rounded-xl shadow-lg p-6 max-w-4xl w-full">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Historial de Seguimiento</h2>
            <p class="text-sm text-gray-500">Alumno: <?php echo $alumno['nombre'] . ' ' . $alumno['apellido']; ?> - Carnet: <?php echo $alumno['carnet']; ?></p>
        </div>

        <div class="space-y-4">
            <?php if (!empty($seguimientos) && is_array($seguimientos)): ?>
                <?php foreach ($seguimientos as $seg): ?>
                    <?php
                    $borderColor = 'border-red-500';
                    $textColor = 'text-red-600';
                    $accion = $seg['accion'] ?? '';
                    
                    if (stripos($accion, 'llamada') !== false) {
                        $borderColor = 'border-blue-500';
                        $textColor = 'text-blue-600';
                    } elseif (stripos($accion, 'correo') !== false || stripos($accion, 'email') !== false) {
                        $borderColor = 'border-green-500';
                        $textColor = 'text-green-600';
                    } elseif (stripos($accion, 'visita') !== false) {
                        $borderColor = 'border-yellow-500';
                        $textColor = 'text-yellow-600';
                    }
                    ?>
                    <div class="relative bg-gray-50 p-4 rounded-lg shadow-md <?php echo $borderColor; ?> border-l-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-500 font-medium">
                                <i class="fas fa-calendar mr-1"></i>
                                <?php echo $seg['fecha'] ?? 'N/A'; ?>
                            </span>
                            <span class="text-sm font-semibold <?php echo $textColor; ?>">
                                <?php echo $seg['accion'] ?? 'N/A'; ?>
                            </span>
                        </div>
                        <p class="text-gray-700"><?php echo $seg['respuesta'] ?? 'Sin descripción'; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-500">No hay seguimientos registrados para este alumno.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
    document.getElementById('backBtn').addEventListener('click', function() {
        window.history.back();
    });
    
    document.getElementById('logoutBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea cerrar sesión?')) {
            window.location.href = '../Login/Logout.php';
        }
    });
</script>
</body>
</html>
