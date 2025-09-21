<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Estado Final</title>
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
                <img src="LogoITCA_2024_FC_Moodle copy copy copy.png" alt="ITCA FEPADE" class="h-12 w-auto">
                
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
    <main class="min-h-screen flex items-center justify-center p-6">
        <div class="bg-gray-400 p-8 rounded-lg shadow-lg w-full max-w-md">
            <!-- Estado Final -->
            <div class="mb-6">
                <h3 class="text-xl font-bold mb-3 text-gray-900">Estado Final</h3>
                <div class="relative">
                    <select class="w-full p-3 border border-gray-300 text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-itca-red appearance-none">
                        <option>Seleccione una opcion</option>
                        <option>Activo</option>
                        <option>Retirado</option>
                        <option>Graduado</option>
                        <option>Suspendido</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Motivo de Retiro -->
            <div class="mb-6">
                <h3 class="text-xl font-bold mb-3 text-gray-900">Motivo de Retiro</h3>
                <textarea class="w-full h-40 p-3 border border-gray-300 text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-itca-red resize-none">ya no viene porque es muy pobre y no le alcansa para pagar

se llamo al alumno y no contesto.</textarea>
            </div>

            <!-- Botón Guardar -->
            <div class="flex justify-end">
                <button class="bg-itca-red text-white px-8 py-2 font-bold hover:bg-red-800 transition-colors duration-200">
                    Guardar
                </button>
            </div>
        </div>
    </main>
</body>
</html>