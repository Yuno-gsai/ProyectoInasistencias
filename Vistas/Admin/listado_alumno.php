<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Listado de Estudiantes</title>
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
        <!-- Barra de búsqueda -->
        <div class="bg-red-800 px-6 py-4 mb-6 rounded-t-lg">
            <div class="flex items-center space-x-6">
                <!-- Buscar por -->
                <div class="flex items-center space-x-3">
                    <label class="text-white font-medium">Buscar por:</label>
                    <select class="px-3 py-1 border border-gray-300 rounded text-gray-800 bg-white">
                        <option>Seleccione una opcion</option>
                        <option>Carnet</option>
                        <option>Nombre</option>
                        <option>Apellido</option>
                        <option>Email</option>
                    </select>
                </div>
                
                <!-- Dato -->
                <div class="flex items-center space-x-3">
                    <label class="text-white font-medium">Dato:</label>
                    <input type="text" class="px-3 py-1 border border-gray-300 rounded text-gray-800 bg-white w-48">
                </div>
                
                <!-- Botón Buscar -->
                <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-1 rounded font-medium transition-colors">
                    Buscar
                </button>
            </div>
        </div>

        <!-- Tabla de estudiantes -->
        <div class="bg-gray-400 rounded-b-lg overflow-hidden shadow-lg">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-500">
                        <th class="px-4 py-3 text-left text-black font-semibold">Carnet</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">nombre</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">apellido</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">telefono</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">email</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">Faltas</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">ciclo</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">año</th>
                        <th class="px-4 py-3 text-left text-black font-semibold">accion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-500">
                        <td class="px-4 py-3 text-black">5521</td>
                        <td class="px-4 py-3 text-black">german jose</td>
                        <td class="px-4 py-3 text-black">perdomo moran</td>
                        <td class="px-4 py-3 text-black">77777777</td>
                        <td class="px-4 py-3 text-black">estudiante.24@itca.edu.sv</td>
                        <td class="px-4 py-3 text-black">2</td>
                        <td class="px-4 py-3 text-black">2</td>
                        <td class="px-4 py-3 text-black">2024</td>
                        <td class="px-4 py-3">
                            <button class="bg-red-700 hover:bg-red-800 text-white px-3 py-1 text-xs rounded transition-colors">
                                Ver detalles
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-500">
                        <td class="px-4 py-3 text-black">5521</td>
                        <td class="px-4 py-3 text-black">german jose</td>
                        <td class="px-4 py-3 text-black">perdomo moran</td>
                        <td class="px-4 py-3 text-black">77777777</td>
                        <td class="px-4 py-3 text-black">estudiante.24@itca.edu.sv</td>
                        <td class="px-4 py-3 text-black">2</td>
                        <td class="px-4 py-3 text-black">2</td>
                        <td class="px-4 py-3 text-black">2024</td>
                        <td class="px-4 py-3">
                            <button class="bg-red-700 hover:bg-red-800 text-white px-3 py-1 text-xs rounded transition-colors">
                                Ver detalles
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>