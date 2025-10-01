
<?php
require_once "../../models/SeguimientosModel.php";

$seguimientosModel = new SeguimientosModel();

if(isset($_POST['accion']) && isset($_POST['detalle'])){
    $data = [
        'id_inasistencia' => 1,
        'accion' => $_POST['accion'],
        'respuesta' => $_POST['detalle']
    ];
    if($seguimientosModel->Create($data)){
        echo "<script>alert('Seguimiento creado exitosamente');</script>";
    }else{
        echo "<script>alert('Error al crear el seguimiento');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Sistema Académico</title>
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
    <header class="bg-white shadow-sm border-b">
        <div class="flex items-center justify-between px-6 py-3">
            <!-- Logo ITCA -->
            <div class="flex items-center space-x-4">
                <img src="/LogoITCA_2024_FC_Moodle.png" alt="ITCA FEPADE" class="h-10">
                <button class="bg-gray-400 text-white px-6 py-2 text-sm font-medium">
                    Inicio
                </button>
            </div>
            
            <!-- User Section -->
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Student Photo -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <!-- Student Photo -->
                    <div class="border-4 border-gray-400 mb-4">
                        <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&cs=tinysrgb&w=300&h=400" 
                             alt="Foto del estudiante" 
                             class="w-full h-64 object-cover grayscale">
                    </div>
                    
                    <!-- Carnet Info -->
                    <div class="text-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Carnet</h2>
                        <p class="text-lg font-medium text-gray-700">12345</p>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button class="w-full bg-itca-red text-white py-3 px-4 font-medium hover:bg-red-800 transition-colors">
                            Cancelar Segimiento
                        </button>
                        <button class="w-full bg-itca-red text-white py-3 px-4 font-medium hover:bg-red-800 transition-colors">
                            Historial de Segimiento
                        </button>
                    </div>
                </div>
            </div>

            <!-- Middle Column - Personal Data -->
            <div class="lg:col-span-1">
                <div class="bg-gray-200 p-6 rounded-lg">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">DATOS PERSONALES</h2>
                    
                    <div class="space-y-4">
                        <!-- Name and Surname -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Nombre</h3>
                                <p class="text-gray-800">German Jose</p>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Apellido</h3>
                                <p class="text-gray-800">Perdomo Moran</p>
                            </div>
                        </div>
                        
                        <!-- Student Status -->
                        <div class="mb-4">
                            <h3 class="font-bold text-gray-900 mb-1">Estado de alumno</h3>
                            <p class="text-gray-800">Activo</p>
                        </div>
                        
                        <!-- Year and Phone -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Año</h3>
                                <p class="text-gray-800">2025</p>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Telefono</h3>
                                <p class="text-gray-800">76267471</p>
                            </div>
                        </div>
                        
                        <!-- Personal Email -->
                        <div class="mb-4">
                            <h3 class="font-bold text-gray-900 mb-1">Correo personal</h3>
                            <p class="text-gray-800">estudiante@gmail.com</p>
                        </div>
                        
                        <!-- Institutional Email -->
                        <div class="mb-4">
                            <h3 class="font-bold text-gray-900 mb-1">Correo Intitucional</h3>
                            <p class="text-gray-800">estudiante@itca.edu.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Action Form -->
        <form method="post">
            <div class="lg:col-span-1">
                <div class="bg-gray-400 p-6 rounded-lg text-white">
                    <!-- Action Type -->
                    <div class="mb-6">
                        <h3 class="text-xl font-bold mb-3">Tipo De Accion</h3>
                        <select name="accion" id="accion" class="w-full p-3 border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-itca-red">
                            <option value="">Seleccionar</option>
                            <option value="llamada">llamada</option>
                            <option value="correo">Correo</option>
                            <option value="mensaje">Mensaje</option>
                        </select>
                    </div>
                    
                    <!-- Details -->
                    <div class="mb-6">
                        <h3 class="text-xl font-bold mb-3">Detalles</h3>
                        <textarea name="detalle" id="detalle" class="w-full h-32 p-3 border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-itca-red resize-none"></textarea>
                    </div>
                    
                    <!-- Save Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-itca-red text-white px-8 py-2 font-medium hover:bg-red-800 transition-colors">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </main>
</body>
</html>