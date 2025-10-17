<?php
session_start();
if(!isset($_SESSION['administrador'])){
    header("Location: /ProyectoInasistenciasItca/index.php");
}
$dataAdmin=$_SESSION['administrador'];
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        .menu-item {
            transition: all 0.3s ease;
        }
        .menu-item:hover {
            transform: translateX(5px);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar Admin -->
    <?php include 'menu.php'; ?>

    <!-- Main Content -->
    <main class="flex justify-center bg-gray-100 mt-8 px-4">
        <div class="bg-white rounded-xl shadow-lg p-6 max-w-2xl w-full">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Panel del Administrador</h2>

            <!-- Menu de opciones -->
            <div class="space-y-4">
                <!-- Opción: Listado de alumnos -->
                <a href="listado_alumnos.php">
                    <div class="menu-item bg-red-50 border-l-4 border-red-600 p-4 rounded-lg cursor-pointer hover:bg-red-100">
                        <div class="flex items-center">
                            <div class="bg-red-100 p-3 rounded-full mr-4">
                                <i class="fas fa-user-graduate text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Listado de alumnos</h3>
                                <p class="text-sm text-gray-600">Gestionar información de estudiantes</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Opción: Listado de seguimiento -->
                <a href="listado_segimiento.php">
                    <div class="menu-item bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg cursor-pointer hover:bg-blue-100">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-list-check text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Listado de seguimiento</h3>
                                <p class="text-sm text-gray-600">Monitorear progreso académico</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Opción: Listado seguimiento finalizado -->
                <a href="listado_finalizado.php">
                    <div class="menu-item bg-green-50 border-l-4 border-green-600 p-4 rounded-lg cursor-pointer hover:bg-green-100">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Listado seguimiento finalizado</h3>
                                <p class="text-sm text-gray-600">Revisar seguimientos finalizados</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </main>
</body>
</html>