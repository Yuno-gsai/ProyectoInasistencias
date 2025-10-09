<?php
session_start();
if(!isset($_SESSION['administrador'])){
    header("Location: /ProyectoInasistencias/index.php");
    exit();
}
$dataAdmin=$_SESSION['administrador'];

require_once "../../models/FaltasModel.php";

// Obtener el carnet del alumno
$carnet = isset($_GET['carnet']) ? $_GET['carnet'] : null;

if (!$carnet) {
    header("Location: listado_alumnos.php");
    exit();
}

$faltasModel = new Faltas();
$alumnos = $faltasModel->getAllAlumnos();
$alumno = null;

foreach ($alumnos as $a) {
    if ($a['carnet'] === $carnet) {
        $alumno = $a;
        break;
    }
}

if (!$alumno) {
    header("Location: listado_alumnos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Alumno - ITCA FEPADE</title>
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
        .status-inactive {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        .student-photo {
            background: linear-gradient(135deg, #E5E7EB 0%, #D1D5DB 100%);
            border: 3px solid #EF4444;
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
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Detalles del Alumno</h2>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Columna izquierda: Foto y carnet -->
            <div class="lg:w-1/3 flex flex-col items-center">
                <div class="student-photo p-4 mb-6 w-full max-w-xs rounded-lg shadow-lg flex items-center justify-center">
                    <img src="<?php echo !empty($alumno['foto']) ? $alumno['foto'] : '/ProyectoInasistencias/Vistas/Publico/Imagenes/12225881.png'; ?>" 
                         alt="Foto del estudiante" 
                         class="w-full h-64 object-cover rounded">
                </div>
                <div class="text-center mb-8 w-full">
                    <div class="text-xl font-semibold text-gray-600 mb-3">Carnet</div>
                    <div class="info-card text-center py-4">
                        <div class="text-3xl font-bold text-gray-800"><?php echo $alumno['carnet']; ?></div>
                    </div>
                </div>
            </div>

            <!-- Columna derecha: Datos personales -->
            <div class="lg:w-2/3">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Datos Personales</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Primera columna -->
                    <div class="space-y-6">
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Nombre</div>
                            <div class="text-lg text-gray-800 font-medium"><?php echo $alumno['nombre']; ?></div>
                        </div>
                        
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Estado de alumno</div>
                            <div>
                                <span class="status-badge <?php echo $alumno['estadoAlumno'] == 1 ? 'status-active' : 'status-inactive'; ?>">
                                    <?php echo $alumno['estadoAlumno'] == 1 ? 'Activo' : 'Inactivo'; ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Contacto de emergencia</div>
                            <div class="text-lg text-gray-800 font-medium"><?php echo $alumno['telefono_emergencia'] ?? 'N/A'; ?></div>
                        </div>
                    </div>

                    <!-- Segunda columna -->
                    <div class="space-y-6">
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Apellido</div>
                            <div class="text-lg text-gray-800 font-medium"><?php echo $alumno['apellido']; ?></div>
                        </div>
                        
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Beca</div>
                            <div>
                                <span class="status-badge <?php echo $alumno['beca'] == 1 ? 'status-active' : 'status-inactive'; ?>">
                                    <?php echo $alumno['beca'] == 1 ? 'Sí' : 'No'; ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Tipo de beca</div>
                            <div class="text-lg text-gray-800 font-medium"><?php echo $alumno['tipobeca'] ?? 'N/A'; ?></div>
                        </div>
                    </div>

                    <!-- Tercera columna -->
                    <div class="space-y-6">
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Correo</div>
                            <div class="text-lg text-blue-600 font-medium"><?php echo $alumno['email']; ?></div>
                        </div>
                        
                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Teléfono</div>
                            <div class="text-lg text-gray-800 font-medium"><?php echo $alumno['telefono']; ?></div>
                        </div>

                        <div class="info-card">
                            <div class="text-sm font-semibold text-gray-600 mb-1">Observaciones</div>
                            <div class="text-lg text-gray-800 font-medium"><?php echo $alumno['observaciones'] ?? 'N/A'; ?></div>
                        </div>
                    </div>
                </div>
                
                <!-- Información adicional -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="info-card">
                        <div class="text-sm font-semibold text-gray-600 mb-1">Ciclo actual</div>
                        <div class="text-lg text-gray-800 font-medium"><?php echo $alumno['ciclo']; ?></div>
                    </div>
                    <div class="info-card">
                        <div class="text-sm font-semibold text-gray-600 mb-1">Faltas acumuladas</div>
                        <div class="text-lg text-red-600 font-medium"><?php echo $alumno['total_faltas']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.getElementById('backBtn').addEventListener('click', function() {
        window.location.href = 'listado_alumnos.php';
    });
    
    document.getElementById('logoutBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea cerrar sesión?')) {
            window.location.href = '../Login/Logout.php';
        }
    });
</script>
</body>
</html>
