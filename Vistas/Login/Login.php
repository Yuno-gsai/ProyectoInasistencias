<?php
session_start();

require_once __DIR__."/../../models/DocenteModel.php";
require_once __DIR__."/../../models/DetalleModel.php";
$docente = new Docente();
$detalle = new DetalleModel();

$dataciclos= $detalle->getAllCiclos();
$datayears = $detalle->getAllAnios();

if(isset($_POST['username']) && isset($_POST['password'])) {
    $tipoUsuario = $_POST['tipo_usuario'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($docente->CustongetAll($username, $password)){
        $dataDocente = $docente->CustongetAll($username, $password);

        if($tipoUsuario == 'docente' && $dataDocente['estado'] == 'Activo'){
            $_SESSION['docente'] = $dataDocente;
            header("Location: /ProyectoInasistenciasItca/Vistas/Docente/DashboardDocente.php");
            exit();
        }

        if($tipoUsuario == 'administrador' && $dataDocente['estado'] == 'Activo' && $dataDocente['esadministrador'] == 1){
            $_SESSION['administrador'] = $dataDocente;
            $_SESSION['administrador']['ciclo'] = $_POST['ciclo'] ?? '';
            $_SESSION['administrador']['anio'] = $_POST['anio'] ?? '';
            header("Location: /ProyectoInasistenciasItca/Vistas/Admin/dashboard.php");
            exit();
        }
        else{
            echo "<script>alert('Acceso denegado');</script>";
        }
    } else {
        echo "<script>alert('Credenciales incorrectas');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('Vistas/Publico/Imagenes/LoginFondo.jpg');">
<div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md backdrop-blur-sm bg-white/90">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
        <img src="Vistas/Publico/Imagenes/ItcaLogo.png" alt="Logo ITCA FEPADE" class="h-24">
    </div>

    <!-- Título -->
    <p class="text-center text-gray-600 mb-8">Sistema de Registro de Inasistencias</p>

    <!-- Selector de tipo de usuario -->
    <div class="flex mb-6 bg-gray-100 p-1 rounded-lg">
        <button id="docenteBtn" class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-300 bg-red-600 text-white">Docente</button>
        <button id="adminBtn" class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-300 text-gray-700">Administrador</button>
    </div>

    <!-- Formulario de Login -->
    <form method="post" class="space-y-4">
        <input type="hidden" name="tipo_usuario" id="tipo_usuario" value="docente">

        <!-- Campo usuario -->
        <div>
            <label class="block text-gray-700 font-medium mb-2" for="username">
                <span id="labelTipoUsuario">Docente</span>
            </label>
            <input type="text" name="username" id="username" placeholder="Ingrese su número de carnet"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition">
        </div>

        <!-- Campo contraseña -->
        <div>
            <label class="block text-gray-700 font-medium mb-2" for="password">Contraseña</label>
            <input type="password" name="password" id="password" placeholder="Ingrese su contraseña"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition">
        </div>

        <!-- Campos adicionales para ADMIN -->
        <div id="adminExtraFields" class="hidden space-y-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2" for="ciclo">Ciclo</label>
                <select name="ciclo" id="ciclo"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition">
                    <option value="">Seleccione un ciclo</option>
                    <?php foreach($dataciclos as $ciclo){ ?>
                    <option value="<?php echo $ciclo['ciclo']; ?>"><?php echo $ciclo['ciclo']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2" for="anio">Año</label>
                <select name="anio" id="anio"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition">

                        <?php foreach($datayears as $year){ ?>
                        <option value="<?php echo $year['year']; ?>"><?php echo $year['year']; ?></option>
                        <?php } ?>
                </select>
            </div>
        </div>

        <!-- Botón -->
        <button type="submit"
            class="w-full bg-red-700 text-white py-3 rounded-lg font-semibold hover:bg-red-800 transition-all duration-300 shadow-md hover:shadow-lg">
            Iniciar Sesión
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="#" class="text-red-600 hover:text-red-800 text-sm font-medium">¿Olvidó su contraseña?</a>
    </div>
</div>

<script>
    const docenteBtn = document.getElementById('docenteBtn');
    const adminBtn = document.getElementById('adminBtn');
    const labelTipoUsuario = document.getElementById('labelTipoUsuario');
    const usernameInput = document.getElementById('username');
    const tipoUsuarioInput = document.getElementById('tipo_usuario');
    const adminExtraFields = document.getElementById('adminExtraFields');

    // Función modo Docente
    function setDocenteMode() {
        docenteBtn.classList.add('bg-red-600', 'text-white');
        docenteBtn.classList.remove('bg-gray-200', 'text-gray-700');
        adminBtn.classList.add('bg-gray-200', 'text-gray-700');
        adminBtn.classList.remove('bg-red-600', 'text-white');
        labelTipoUsuario.textContent = 'Docente';
        usernameInput.placeholder = 'Ingrese su número de carnet';
        tipoUsuarioInput.value = 'docente';
        adminExtraFields.classList.add('hidden');
    }

    // Función modo Administrador
    function setAdminMode() {
        adminBtn.classList.add('bg-red-600', 'text-white');
        adminBtn.classList.remove('bg-gray-200', 'text-gray-700');
        docenteBtn.classList.add('bg-gray-200', 'text-gray-700');
        docenteBtn.classList.remove('bg-red-600', 'text-white');
        labelTipoUsuario.textContent = 'Administrador';
        usernameInput.placeholder = 'Ingrese su nombre de usuario';
        tipoUsuarioInput.value = 'administrador';
        adminExtraFields.classList.remove('hidden');
    }

    docenteBtn.addEventListener('click', setDocenteMode);
    adminBtn.addEventListener('click', setAdminMode);
</script>
</body>
</html>
