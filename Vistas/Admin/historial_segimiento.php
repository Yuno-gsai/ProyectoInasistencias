<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Detalles del Seguimiento</title>
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
                <img src="LogoITCA_2024_FC_Moodle copy copy.png" alt="ITCA FEPADE" class="h-12 w-auto">
                
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
    <main class="max-w-7xl mx-auto p-6">
        <!-- Title -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">DETALLES DEL SEGIMIENTO</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Seguimiento Table -->
            <div class="lg:col-span-2">
                <div class="bg-gray-300 rounded-lg overflow-hidden">
                    <!-- Table Header -->
                    <div class="bg-gray-500 text-white">
                        <div class="grid grid-cols-3 gap-0">
                            <div class="px-4 py-3 font-bold text-center border-r border-gray-400">Tipo de accion</div>
                            <div class="px-4 py-3 font-bold text-center border-r border-gray-400">fecha</div>
                            <div class="px-4 py-3 font-bold text-center">hora</div>
                        </div>
                    </div>
                    
                    <!-- Table Rows -->
                    <div class="bg-gray-300">
                        <!-- Row 1 -->
                        <div class="grid grid-cols-3 gap-0 border-b border-gray-400">
                            <div class="px-4 py-3 text-gray-900 border-r border-gray-400">llamada por celular</div>
                            <div class="px-4 py-3 text-gray-900 text-center border-r border-gray-400">27/09/2025</div>
                            <div class="px-4 py-3 text-gray-900 text-center">5:25</div>
                        </div>
                        
                        <!-- Row 2 -->
                        <div class="grid grid-cols-3 gap-0">
                            <div class="px-4 py-3 text-gray-900 border-r border-gray-400">correo</div>
                            <div class="px-4 py-3 text-gray-900 text-center border-r border-gray-400">28/09/2025</div>
                            <div class="px-4 py-3 text-gray-900 text-center">5:25</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Action Form -->
            <div class="lg:col-span-1">
                <div class="bg-gray-400 p-6 rounded-lg text-white">
                    <!-- Tipo De Accion -->
                    <div class="mb-6">
                        <h3 class="text-xl font-bold mb-3">Tipo De Accion</h3>
                        <input type="text" 
                               value="llamada a su celular"
                               class="w-full p-3 border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-itca-red">
                    </div>
                    
                    <!-- Motivo de Retiro -->
                    <div class="mb-6">
                        <h3 class="text-xl font-bold mb-3">Motivo de Retiro</h3>
                        <textarea class="w-full h-40 p-3 border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-itca-red resize-none">ya no viene porque es muy pobre y no le alcansa para pagar

se llamo al alumno y no contesto.</textarea>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>