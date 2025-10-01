<?php
require_once "../../models/SeguimientosModel.php";

$seguimientosModel = new SeguimientosModel();
$seguimientos = $seguimientosModel->getAllEstudiantes();

?>



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
                    <img src="LogoITCA_2024_FC_Moodle copy copy copy.png" alt="ITCA FEPADE" class="h-10 w-auto">
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
        <div class="bg-red-800 p-4 mb-6 flex items-center gap-4">
            <div class="flex items-center gap-2">
                <label class="text-white font-medium">Buscar por:</label>
                <select class="px-3 py-1 border border-gray-300 text-black">
                    <option>Seleccione una opcion</option>
                    <option>Carnet</option>
                    <option>Nombre</option>
                    <option>Apellido</option>
                    <option>Email</option>
                </select>
            </div>
            
            <div class="flex items-center gap-2">
                <label class="text-white font-medium">Dato:</label>
                <input type="text" class="px-3 py-1 border border-gray-300 text-black w-48">
            </div>
            
            <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-1 font-medium transition-colors">
                Buscar
            </button>
        </div>

        <!-- Tabla de estudiantes -->
        <div class="bg-gray-400 p-6">
            <table class="w-full">
                <!-- Encabezados -->
                <thead>
                    <tr class="text-black font-bold text-left">
                        <th class="pb-4 pr-4">Carnet</th>
                        <th class="pb-4 pr-4">nombre</th>
                        <th class="pb-4 pr-4">apellido</th>
                        <th class="pb-4 pr-4">fecha Ultimo seguimiento</th>
                        <th class="pb-4 pr-4">Faltas</th>
                        <th class="pb-4 pr-4">Seguimientos</th>
                    </tr>
                </thead>
                
                <!-- Filas de datos -->
                <tbody>
                    <?php foreach ($seguimientos as $seguimiento): ?>
                    <tr class="text-black">
                        <td class="py-2 pr-4"><?php echo $seguimiento['carnet']; ?></td>
                        <td class="py-2 pr-4"><?php echo $seguimiento['nombre']; ?></td>
                        <td class="py-2 pr-4"><?php echo $seguimiento['apellido']; ?></td>
                        <td class="py-2 pr-4"><?php echo $seguimiento['ultima_fecha_seguimiento']; ?></td>
                        <td class="py-2 pr-4"><?php echo $seguimiento['total_faltas']; ?></td>
                        <td class="py-2 pr-4"><?php echo $seguimiento['total_seguimientos']; ?></td>
                        <td class="py-2 flex gap-2">
                            <button class="bg-red-800 hover:bg-red-900 text-white px-3 py-1 text-sm transition-colors">
                                Ver detalles
                            </button>
                            <button class="bg-red-800 hover:bg-red-900 text-white px-3 py-1 text-sm transition-colors">
                                Historial
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>