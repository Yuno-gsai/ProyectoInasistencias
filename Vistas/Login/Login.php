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
<body class="bg-gray-100 min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('/Vistas/Publico/Imagenes/LoginFondo.jpg');">
<div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md backdrop-blur-sm bg-white/90">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
        <img src="/Vistas/Publico/Imagenes/ItcaLogo.png" alt="Logo ITCA FEPADE" class="h-24">
    </div>

    <!-- Título -->
    <p class="text-center text-gray-600 mb-8">Sistema de Registro de Inasistencias</p>

    <!-- Selector de tipo de usuario -->
    <div class="flex mb-6 bg-gray-100 p-1 rounded-lg">
        <button id="docenteBtn" class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-300 bg-red-600 text-white">Docente</button>
        <button id="adminBtn" class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-300 text-gray-700">Administrador</button>
    </div>

    <!-- Formulario de Login -->
    <form id="loginForm" class="space-y-4">
        <!-- Campo para Docente/Administrador -->
        <div>
            <label class="block text-gray-700 font-medium mb-2" for="username">
                <span id="labelTipoUsuario">Docente</span>
            </label>
            <input type="text" id="username" placeholder="Ingrese su número de carnet"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition">
        </div>

        <!-- Campo para Contraseña -->
        <div>
            <label class="block text-gray-700 font-medium mb-2" for="password">Contraseña</label>
            <input type="password" id="password" placeholder="Ingrese su contraseña"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition">
        </div>

        <!-- Botón de Iniciar Sesión -->
        <button type="submit" class="w-full bg-red-700 text-white py-3 rounded-lg font-semibold hover:bg-red-800 transition-all duration-300 shadow-md hover:shadow-lg">
            Iniciar Sesión
        </button>
    </form>

    <!-- Enlace de ayuda -->
    <div class="mt-6 text-center">
        <a href="#" class="text-red-600 hover:text-red-800 text-sm font-medium">¿Olvidó su contraseña?</a>
    </div>
</div>

<script>
    // Lógica para cambiar entre Docente y Administrador
    const docenteBtn = document.getElementById('docenteBtn');
    const adminBtn = document.getElementById('adminBtn');
    const labelTipoUsuario = document.getElementById('labelTipoUsuario');
    const usernameInput = document.getElementById('username');

    // Función para cambiar a modo Docente
    function setDocenteMode() {
        docenteBtn.classList.add('bg-red-600', 'text-white');
        docenteBtn.classList.remove('bg-gray-200', 'text-gray-700');
        adminBtn.classList.add('bg-gray-200', 'text-gray-700');
        adminBtn.classList.remove('bg-red-600', 'text-white');
        labelTipoUsuario.textContent = 'Docente';
        usernameInput.placeholder = 'Ingrese su número de carnet';
    }

    // Función para cambiar a modo Administrador
    function setAdminMode() {
        adminBtn.classList.add('bg-red-600', 'text-white');
        adminBtn.classList.remove('bg-gray-200', 'text-gray-700');
        docenteBtn.classList.add('bg-gray-200', 'text-gray-700');
        docenteBtn.classList.remove('bg-red-600', 'text-white');
        labelTipoUsuario.textContent = 'Administrador';
        usernameInput.placeholder = 'Ingrese su nombre de usuario';
    }

    // Event listeners para los botones
    docenteBtn.addEventListener('click', setDocenteMode);
    adminBtn.addEventListener('click', setAdminMode);

    // Manejo del envío del formulario
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Aquí iría la lógica de autenticación con PHP
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const userType = docenteBtn.classList.contains('bg-red-600') ? 'docente' : 'admin';

        console.log('Tipo de usuario:', userType);
        console.log('Usuario:', username);
        console.log('Contraseña:', password);

        // En una implementación real, aquí se enviarían los datos al servidor PHP
        // usando fetch o mediante un formulario tradicional
        alert(`Iniciando sesión como ${userType} con usuario: ${username}`);
    });
</script>
</body>
</html>