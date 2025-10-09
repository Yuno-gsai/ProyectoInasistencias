<?php
session_start();
if(!isset($_SESSION['administrador'])){
    header("Location: /ProyectoInasistencias/index.php");
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
<!--NavbarAdmin-->
<nav class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-2 flex justify-between items-center">
        <!-- Logo e Identidad -->
        <div class="flex items-center space-x-2">
            <img src="../Publico/Imagenes/ItcaLogo.png" alt="Logo ITCA FEPADE" class="h-8">
            <p class="text-sm font-semibold text-gray-700">Registro de Inasistencias</p>
        </div>
        <!-- Usuario y Botón -->
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-700 font-medium" id="userName"><?php echo $dataAdmin['nom_usuario'] . ' ' . $dataAdmin['ape_usuario']; ?></span>

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
    <div class="bg-white rounded-xl shadow-lg p-6 max-w-2xl w-full">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Panel del Administrador</h2>

        <!-- Menu de opciones -->
        <div class="space-y-4">
            <!-- Opción: Listado de alumnos -->
            <a href="listado_alumnos.php" class="block">
                <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-lg cursor-pointer hover:bg-red-100" tabindex="0" role="button" aria-label="Listado de alumnos">
                    <div class="flex items-center">
                        <div class="bg-red-100 p-3 rounded-full mr-4">
                            <i class="fas fa-users text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Listado de alumnos</h3>
                            <p class="text-sm text-gray-600">Gestionar información de estudiantes</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Opción: Listado de seguimiento -->
            <a href="listado_segimiento.php" class="block">
                <div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg cursor-pointer hover:bg-blue-100" tabindex="0" role="button" aria-label="Listado de seguimiento">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <i class="fas fa-clipboard-check text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Listado de seguimiento</h3>
                            <p class="text-sm text-gray-600">Monitorear progreso académico</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Opción: Listado seguimiento finalizado -->
            <a href="listado_finalizado.php" class="block">
                <div class="bg-green-50 border-l-4 border-green-600 p-4 rounded-lg cursor-pointer hover:bg-green-100" tabindex="0" role="button" aria-label="Listado seguimiento finalizado">
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


<script>
    // Botón salir -> Confirmar y redirigir al login
    document.getElementById('logoutBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea cerrar sesión?')) {
            window.location.href = '../Login/Logout.php';
        }
    });
</script>
</body>
</html>