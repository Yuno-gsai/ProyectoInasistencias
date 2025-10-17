<?php
session_start();
if(!isset($_SESSION['administrador'])){
    header("Location: /ProyectoInasistenciasItca/index.php");
}
$dataAdmin=$_SESSION['administrador'];

require_once "../../models/FaltasModel.php";
$alumnos = (new Faltas())->getAllAlumnos($dataAdmin['ciclo'], $dataAdmin['anio']);

$estudiantes = json_encode($alumnos);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Alumnos - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Modal styles mejorados */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 12px;
            max-width: 95vw;
            max-height: 95vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            transform: scale(0.9);
            transition: transform 0.3s ease;
            width: 1200px;
        }
        
        .modal.show .modal-content {
            transform: scale(1);
        }
        
        /* Estilos para elementos específicos del modal */
        .info-card {
            background: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-left: 4px solid #DC2626;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .status-active {
            background-color: #DCFCE7;
            color: #166534;
        }
        
        .status-inactive {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 12px;
            margin-bottom: 24px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: #DC2626;
            border-radius: 2px;
        }
        
        .student-photo {
            background: linear-gradient(135deg, #E5E7EB 0%, #D1D5DB 100%);
            border: 3px solid #DC2626;
        }
        
        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            font-size: 28px;
            font-weight: bold;
            color: #6B7280;
            cursor: pointer;
            z-index: 10;
            transition: all 0.2s;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .close-btn:hover {
            color: #374151;
            background-color: rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <?php include "menu.php" ?>

    <!-- Contenido principal -->
    <div class="container mx-auto px-6 py-8 max-w-7xl">
        <!-- Título principal -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Listado de Alumnos</h1>
            <p class="text-gray-600">Gestión y consulta de información estudiantil</p>
        </div>

        <!-- Barra de búsqueda -->
        <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-lg mb-6">
            <div class="flex items-center mb-4">
                <div class="bg-red-100 p-2 rounded-full mr-3">
                    <i class="fas fa-filter text-red-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Filtros de búsqueda</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Buscar por:</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent" id="searchType">
                        <option value="">Seleccione una opción</option>
                        <option value="carnet">Carnet</option>
                        <option value="nombre">Nombre</option>
                        <option value="apellido">Apellido</option>
                        <option value="email">Email</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Dato:</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent" id="searchInput" placeholder="Ingrese término de búsqueda">
                </div>
                <div>
                    <button class="w-full bg-red-600 text-white px-6 py-2 rounded-lg font-medium transition-all duration-200 shadow-md hover:bg-red-700" onclick="buscarEstudiantes()">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabla de estudiantes -->
        <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Estudiantes Registrados</h2>
                <p class="text-sm text-gray-600 mt-1">Total de registros: 2</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-100 to-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Carnet</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Apellido</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Teléfono</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Faltas</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Ciclo</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Año</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTable">
                        <tr class="bg-white hover:bg-gray-50 border-b border-gray-200 transition-colors duration-150">
                        <?php foreach ($alumnos as $alumno) { ?>    
                        <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo $alumno['carnet']; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-800 capitalize"><?php echo $alumno['nombre']; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-800 capitalize"><?php echo $alumno['apellido']; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-800"><?php echo $alumno['telefono']; ?></td>
                            <td class="px-6 py-4 text-sm text-blue-600"><?php echo $alumno['email']; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <?php echo $alumno['total_faltas']; ?> faltas
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800"><?php echo $alumno['ciclo']; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-800"><?php echo $alumno['year']; ?></td>
                            <td class="px-6 py-4">
                                <button class="bg-red-600 text-white px-4 py-2 text-sm rounded-lg hover:bg-red-700 transition-all duration-200 shadow-md hover:shadow-lg font-medium" 
                                        onclick="verDetalles('<?php echo $alumno['carnet']; ?>',<?php echo $alumno['idalumno']; ?>)">
                                    <i class="fas fa-eye mr-1"></i>Ver detalles
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include 'modal_detalles_alumno.php'; ?>
</body>
</html>