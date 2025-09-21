<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Perfil de Estudiante</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen">
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
    <main class="container mx-auto px-6 py-8">
        <div class="flex gap-8">
            <!-- Panel izquierdo - Foto y datos básicos -->
            <div class="flex-shrink-0">
                <!-- Foto del estudiante -->
                <div class="bg-white border-4 border-black p-2 mb-4 w-80 h-96">
                    <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&cs=tinysrgb&w=300&h=400&fit=crop" 
                         alt="Foto del estudiante" 
                         class="w-full h-full object-cover">
                </div>
                
                <!-- Carnet -->
                <div class="text-center mb-4">
                    <h3 class="text-xl font-bold text-black">Carnet</h3>
                    <p class="text-lg text-black">12345</p>
                </div>
                
                <!-- Botón Iniciar Segimiento -->
                <button class="w-full bg-red-800 hover:bg-red-900 text-white py-3 px-6 font-medium transition-colors">
                    Iniciar Segimiento
                </button>
            </div>
            
            <!-- Panel derecho - Datos personales -->
            <div class="flex-1 bg-gray-300 p-8">
                <h2 class="text-2xl font-bold text-black mb-8">DATOS PERSONALES</h2>
                
                <div class="grid grid-cols-2 gap-x-16 gap-y-6">
                    <!-- Fila 1 -->
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Nombre</h3>
                        <p class="text-black">German Jose</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Apellido</h3>
                        <p class="text-black">Perdomo Moran</p>
                    </div>
                    
                    <!-- Fila 2 -->
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Correo personal</h3>
                        <p class="text-black">estudiante@gmail.com</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Correo Intitucional</h3>
                        <p class="text-black">estudiante@itca.edu.com</p>
                    </div>
                    
                    <!-- Fila 3 -->
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Estado de alumno</h3>
                        <p class="text-black">Activo</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Telefono</h3>
                        <p class="text-black">76267471</p>
                    </div>
                    
                    <!-- Fila 4 -->
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Año</h3>
                        <p class="text-black">2025</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Beca</h3>
                        <p class="text-black">si</p>
                    </div>
                    
                    <!-- Fila 5 -->
                    <div class="col-span-2">
                        <h3 class="text-lg font-semibold text-black mb-1">Tipo de beca</h3>
                        <p class="text-black">Semilla</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>