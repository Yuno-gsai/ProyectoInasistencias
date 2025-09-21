<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Búsqueda de Estudiantes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'itca-red': '#8B1538',
                        'itca-gold': '#D4A574',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-gray-300 shadow-sm">
        <div class="flex items-center justify-between px-6 py-3">
            <!-- Logo ITCA -->
            <div class="flex items-center space-x-4">
                <!-- Logo ITCA FEPADE -->
                <img src="LogoITCA_2024_FC_Moodle copy copy copy copy.png" alt="ITCA FEPADE" class="h-12 w-auto">
                
                <button class="bg-gray-500 text-white px-6 py-2 text-sm font-medium rounded">
                    Inicio
                </button>
            </div>
            
            <!-- User Section -->
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center border-2 border-gray-400">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-gray-700 font-medium">German</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="p-6">
        <!-- Search Bar -->
        <div class="bg-itca-red p-4 mb-6 rounded">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <label class="text-white font-medium">Buscar por:</label>
                    <select class="px-3 py-1 text-gray-900 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-white">
                        <option>Seleccione una opcion</option>
                        <option>Carnet</option>
                        <option>Nombre</option>
                        <option>Apellido</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-2">
                    <label class="text-white font-medium">Dato:</label>
                    <input type="text" class="px-3 py-1 text-gray-900 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-white w-48">
                </div>
                
                <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-1 font-bold transition-colors duration-200">
                    Buscar
                </button>
            </div>
        </div>

        <!-- Results Table -->
        <div class="bg-white rounded shadow-lg overflow-hidden">
            <!-- Table Header -->
            <div class="bg-gray-400 grid grid-cols-7 gap-4 p-3 text-gray-900 font-bold text-sm">
                <div>Carnet</div>
                <div>nombre</div>
                <div>apellido</div>
                <div>fecha final</div>
                <div>ultima accion</div>
                <div>motivo</div>
                <div>accion</div>
            </div>
            
            <!-- Table Row -->
            <div class="grid grid-cols-7 gap-4 p-3 border-b border-gray-200 text-sm">
                <div class="text-gray-900">5521</div>
                <div class="text-gray-900">german jose</div>
                <div class="text-gray-900">perdomo moran</div>
                <div class="text-gray-900">16/09/25</div>
                <div class="text-gray-900">llamada al celular</div>
                <div class="text-gray-900">Retiro</div>
                <div class="flex space-x-2">
                    <button class="bg-itca-red text-white px-3 py-1 text-xs font-medium hover:bg-red-800 transition-colors duration-200">
                        Ver detalles
                    </button>
                    <button class="bg-itca-red text-white px-3 py-1 text-xs font-medium hover:bg-red-800 transition-colors duration-200">
                        Historial
                    </button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>