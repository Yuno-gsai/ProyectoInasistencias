<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Sistema de Gestión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-gray-400 px-6 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo y navegación izquierda -->
            <div class="flex items-center space-x-4">
                <!-- Logo ITCA -->
                <div class="flex items-center">
                    <img src="LogoITCA_2024_FC_Moodle.png" alt="ITCA FEPADE" class="h-10 w-auto">
                </div>
                
                <!-- Botón Inicio -->
                <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 text-sm font-medium transition-colors">
                    Inicio
                </button>
            </div>
            
            <!-- Usuario derecha -->
            <div class="flex items-center space-x-3">
                <!-- Avatar -->
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <!-- Nombre usuario -->
                <span class="text-gray-800 text-sm font-medium">German</span>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            
            <!-- Card 1: Listado de alumnos -->
            <div class="bg-gray-300 rounded-lg p-8 flex flex-col items-center text-center cursor-pointer hover:bg-gray-400 hover:shadow-lg transition-all duration-300 group">
                <div class="mb-6 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-20 h-20 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        <path d="M16 8c0 .55.45 1 1 1s1-.45 1-1-.45-1-1-1-1 .45-1 1z"/>
                        <path d="M7 9c-.55 0-1 .45-1 1s.45 1 1 1 1-.45 1-1-.45-1-1-1z"/>
                        <path d="M8 10h8v2H8z"/>
                        <path d="M6 14h12v1H6z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-800">Listado de alumnos</h3>
            </div>
            
            <!-- Card 2: Listado de seguimiento -->
            <div class="bg-gray-300 rounded-lg p-8 flex flex-col items-center text-center cursor-pointer hover:bg-gray-400 hover:shadow-lg transition-all duration-300 group">
                <div class="mb-6 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-20 h-20 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        <path d="M21.99 4H22l-1.41 1.41L18.17 3 21.99 4zm-2.7 2.7L16.87 9.1 15.46 7.69l2.42-2.42L19.3 6.7z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-800">Listado de seguimiento</h3>
            </div>
            
            <!-- Card 3: Listado seguimiento cancelado -->
            <div class="bg-gray-300 rounded-lg p-8 flex flex-col items-center text-center cursor-pointer hover:bg-gray-400 hover:shadow-lg transition-all duration-300 group">
                <div class="mb-6 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-20 h-20 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-3 14H8v-2h8v2zm0-4H8v-2h8v2zm0-4H8V7h8v2z"/>
                        <path d="m18.3 8.1-1.4-1.4L12 11.6 7.1 6.7 5.7 8.1 10.6 13 5.7 17.9l1.4 1.4L12 14.4l4.9 4.9 1.4-1.4L13.4 13l4.9-4.9z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-800 leading-tight">listado seguimiento<br>cancelado</h3>
            </div>
            
        </div>
    </main>
</body>
</html>