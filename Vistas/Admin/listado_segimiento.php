<?php
session_start();
if(!isset($_SESSION['administrador'])){
    header("Location: /ProyectoInasistenciasItca/index.php");
}
$dataAdmin=$_SESSION['administrador'];

require_once "../../models/SeguimientosModel.php";
$estudiantes = (new SeguimientosModel())->getAllEstudiantes($dataAdmin['ciclo'], $dataAdmin['anio']);
var_dump($estudiantes);

date_default_timezone_set('America/El_Salvador');

if(isset($_POST['confirmarRetiro'])){
    $idAlumno = $_POST['studentId'];
    $motivo = $_POST['motivo'];
    $estado = $_POST['estado'];
    (new SeguimientosModel())->FinSeguimieto($estado, $motivo, $idAlumno, date('Y-m-d'));
}



if(isset($_POST['guardarSeguimiento'])){
    $data = [
        'id_inasistencia' => $_POST['faltaid'],
        'accion' => $_POST['tipo_accion'],
        'respuesta' => $_POST['detalle']
    ];
    (new SeguimientosModel())->Create($data);
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Seguimiento - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .modal-backdrop {
            backdrop-filter: blur(4px);
        }
        .modal-content {
            animation: modalFadeIn 0.3s ease-out;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .close-btn {
            position: absolute;
            top: 15px;
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
        .student-photo {
            background: linear-gradient(135deg, #E5E7EB 0%, #D1D5DB 100%);
        }
        .section-title {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 20px;
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
        .info-card {
            background-color: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
        .status-suspended {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        .status-transferred {
            background-color: #FEF3C7;
            color: #92400E;
        }
        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <?php include "menu.php" ?>

    <div class="container mx-auto p-6 max-w-7xl">
        <!-- Título -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Listado de Seguimiento</h1>
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
            <div class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-48">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Buscar por:</label>
                    <select id="searchType" class="w-full px-3 py-2 rounded border-none bg-white focus:outline-none focus:ring-2 focus:ring-white">
                        <option>Seleccione una opción</option>
                        <option>Carnet</option>
                        <option>Nombre</option>
                        <option>Apellido</option>
                    </select>
                </div>
                <div class="flex-1 min-w-48">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Dato:</label>
                    <input id="searchTerm" type="text" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Ingrese término de búsqueda">
                </div>
                <div>
                    <button onclick="buscarEstudiantes()" class="bg-red-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-red-700 transition-colors shadow-md">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                </div>
            </div>
        </div>

        <!-- Sección de resultados -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-1">Estudiantes en Seguimiento</h2>
            <p id="totalRegistros" class="text-gray-600 text-sm">Total de registros: 3</p>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">CARNET</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">NOMBRE</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">APELLIDO</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">FALTAS</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">SEGUIMIENTOS</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">ULTIMA FECHA DE SEGUIMIENTO</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-800">ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody id="tablaEstudiantes">
                        <?php foreach ($estudiantes as $estudiante) { ?>
                            <?php if ($estudiante['total_seguimientos'] > 0) { ?>
                        <tr class="bg-gray-50 hover:bg-gray-100 transition-colors">
                            <td class="px-4 py-3"><?php echo $estudiante['carnet'];?></td>
                            <td class="px-4 py-3 text-blue-600 font-medium"><?php echo $estudiante['nombre'];?></td>
                            <td class="px-4 py-3 text-blue-600 font-medium"><?php echo $estudiante['apellido'];?></td>
                            <td class="px-4 py-3 text-red-600 font-medium"><?php echo $estudiante['total_faltas'];?></td>
                            <td class="px-4 py-3 text-red-600 font-medium"><?php echo $estudiante['total_seguimientos'];?></td>
                            <td class="px-4 py-3 text-red-600 font-medium"><?php echo $estudiante['ultima_fecha_seguimiento'];?></td>
                            <td class="px-4 py-3">
                                <button onclick="openDetailsModal('<?php echo $estudiante['idalumno'];?>')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm transition-colors shadow-md">
                                    <i class="fas fa-eye mr-1"></i>Ver detalles
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                           
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de Detalles -->
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-6xl w-full modal-content relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeDetailsModal()" class="close-btn">&times;</button>
            
            <div class="p-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Foto y Carnet -->
                    <div class="lg:w-1/4 flex flex-col items-center">
                        <div class="student-photo border-4 border-gray-800 w-full h-64 rounded-lg flex items-center justify-center mb-6 shadow-lg">
                            <div class="text-7xl text-gray-600">👤</div>
                        </div>
                        <div class="text-center mb-6 w-full">
                            <h3 class="text-xl font-bold text-gray-700 mb-2">Carnet</h3>
                            <div class="info-card text-center">
                                <p id="studentCarnet" class="text-2xl font-bold text-gray-800">12345</p>
                            </div>
                        </div>
                        <div class="space-y-3 w-full">
                            <button onclick="openCancelModal()" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg font-medium transition-colors shadow-md">
                                <i class="fas fa-times-circle mr-2"></i>Cancelar Seguimiento
                            </button>
                            <button onclick="openHistoryModal(estudianteActual.idalumno)" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium transition-colors shadow-md">
                                <i class="fas fa-history mr-2"></i>Historial de Seguimiento
                            </button>
                        </div>
                    </div>

                    <!-- Datos Personales -->
                    <div class="lg:w-2/4">
                        <h2 class="text-2xl font-bold text-gray-800 section-title">DATOS PERSONALES</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="info-card">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Nombre</label>
                                <p id="studentName" class="text-lg text-gray-800">German Jose</p>
                            </div>
                            <div class="info-card">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Apellido</label>
                                <p id="studentLastName" class="text-lg text-gray-800">Perdomo Moran</p>
                            </div>
                            <div class="info-card">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Estado de alumno</label>
                                <span id="studentStatus" class="status-badge status-active">Activo</span>
                            </div>
                            <div class="info-card">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Año</label>
                                <p id="studentYear" class="text-lg text-gray-800">2025</p>
                            </div>
                            <div class="info-card">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Teléfono</label>
                                <p id="studentPhone" class="text-lg text-gray-800">76267471</p>
                            </div>
                            <div class="info-card">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Correo personal</label>
                                <p id="studentPersonalEmail" class="text-lg text-blue-600">estudiante@gmail.com</p>
                            </div>
                            <div class="info-card md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Correo Institucional</label>
                                <p id="studentEmail" class="text-lg text-blue-600">estudiante@itca.edu.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tipo De Accion -->
                    <div class="lg:w-1/4">
                        <div class="bg-gray-100 p-6 rounded-lg h-full">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 section-title">Tipo De Acción</h3>
                            <form method="post">
                            <div class="mb-6">
                                <select name="tipo_accion" id="tipo_accion">
                                    <option value="llamada">Llamada</option>
                                    <option value="correo">Correo</option>
                                    <option value="visita">Visita</option>
                                </select>
                            </div>
                            <input type="text" id="faltaid" name="faltaid">

                            <h3 class="text-xl font-bold text-gray-800 mb-4 section-title">Detalles</h3>
                            <div class="mb-6">
                                <textarea name="detalle" id="detalle" class="w-full h-40 p-3 rounded-lg border border-gray-300 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-red-500" readonly>Ya no viene porque es muy pobre y no le alcanza para pagar. Se llamó al alumno y no contestó.</textarea>
                            </div>
                            
                            <button type="submit" name="guardarSeguimiento" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium transition-colors shadow-md">
                                <i class="fas fa-save mr-2"></i>Guardar
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Cancelar Seguimiento -->
    <div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full modal-content relative">
            <button onclick="closeCancelModal()" class="close-btn">&times;</button>
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Cancelar Seguimiento</h2>
                
                <div class="space-y-6">
                    <form method="post">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">Estado Final</h3>
                        <select name="estado" class="w-full p-3 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-itca-red">
                            <option>Seleccione una opción</option>
                            <option>Retirado</option>
                            <option>Suspendido</option>
                            <option>Transferido</option>
                        </select>
                    </div>
                    <input type="hidden" id="studentId" name="studentId">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">Motivo de Retiro</h3>
                        <textarea name="motivo" class="w-full h-32 p-3 rounded-lg border border-gray-300 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-itca-red">Ya no viene porque es muy pobre y no le alcanza para pagar. Se llamó al alumno y no contestó.</textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-4 pt-4">
                        <button onclick="closeCancelModal()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" name="confirmarRetiro" onclick="closeCancelModal()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition-colors shadow-md">
                            <i class="fas fa-check mr-2"></i>Confirmar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
    <?php include "modal_historial.php" ?>

</body>
</html>
