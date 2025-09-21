<?php
session_start();
$dataDocente = $_SESSION['docente'];
var_dump($dataDocente);
?>

<nav class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-2 flex justify-between items-center">
        <!-- Logo e Identidad -->
        <div class="flex items-center space-x-2">
            <img src="../Publico/Imagenes/ItcaLogo.png" alt="Logo ITCA FEPADE" class="h-8">
            <p class="text-sm font-semibold text-gray-700">Registro de Inasistencias</p>
        </div>
        <!-- Usuario y Botón -->
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-700 font-medium" id="userName"><?php echo $dataDocente['nom_usuario'] ?></span>
            <img id="profileImage"
                 src="../Publico/Imagenes/PerfilPrueba.jpg"
                 alt="Foto docente"
                 class="rounded-full w-8 h-8 object-cover border border-gray-200">
            <button id="logoutBtn"
                    class="flex items-center bg-red-600 text-white py-1 px-3 rounded-md text-sm hover:bg-red-700 transition">
                <i class="fas fa-sign-out-alt mr-1"></i>
                <span class="hidden sm:inline">Salir</span>
            </button>
        </div>
    </div>
</nav>