<?php
session_start();
if(!isset($_SESSION['administrador'])){
    header("Location: /ProyectoInasistencias/index.php");
}
$dataAdmin=$_SESSION['administrador'];

require_once "../../models/SeguimientosModel.php";
$estudiantes = (new SeguimientosModel())->getSeguimietosFinalizados();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado Finalizado - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
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
            margin: auto;
            width: 90%;
            max-width: 1200px;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalFadeIn 0.3s;
        }
        
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Estilos adicionales para los elementos del modal */
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
            background-color: #B91C1C;
            border-radius: 2px;
        }
        .info-card {
            background-color: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #B91C1C;
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
        .status-inactive {
            background-color: #F3F4F6;
            color: #6B7280;
        }
        
        /* Estilos para el modal de historial */
        .modal-backdrop {
            backdrop-filter: blur(4px);
        }
        .modal-content-historial {
            animation: modalFadeIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<!--Navbar-->
<nav class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-2 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <img src="../Publico/Imagenes/ItcaLogo.png" alt="Logo ITCA FEPADE" class="h-8">
            <p class="text-sm font-semibold text-gray-700">Registro de Inasistencias</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-700 font-medium" id="userName"><?php echo $dataAdmin['nom_usuario'] . ' ' . $dataAdmin['ape_usuario']; ?></span>
            <button id="backBtn"
                    class="flex items-center bg-gray-600 text-white py-1 px-3 rounded-md text-sm hover:bg-gray-700 transition">
                <i class="fas fa-arrow-left mr-1"></i>
                <span class="hidden sm:inline">Regresar</span>
            </button>
            <button id="logoutBtn"
                    class="flex items-center bg-red-600 text-white py-1 px-3 rounded-md text-sm hover:bg-red-700 transition">
                <i class="fas fa-sign-out-alt mr-1"></i>
                <span class="hidden sm:inline">Salir</span>
            </button>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="flex justify-center bg-gray-100 mt-8 px-4">
    <div class="bg-white rounded-xl shadow-lg p-6 max-w-6xl w-full">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Listado de Finalizados</h2>
                <p class="text-sm text-gray-500">Gestión y consulta de información estudiantil</p>
            </div>
        </div>
        <!-- Filtros -->
        <div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg mb-4">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-2 rounded-full mr-3">
                    <i class="fas fa-filter text-blue-600"></i>
                </div>  
                <h3 class="font-semibold text-gray-800">Filtros de Búsqueda</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="md:col-span-2">
                    <label for="searchInput" class="block text-sm text-gray-600 mb-1">
                        <i class="fas fa-search mr-1"></i>Buscar por Carnet, Nombre o Apellido
                    </label>
                    <input type="text" id="searchInput" placeholder="Escriba para buscar..."
                           class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
                </div>
                <div>
                    <label for="dateFilter" class="block text-sm text-gray-600 mb-1">
                        <i class="fas fa-calendar mr-1"></i>Filtrar por Fecha
                    </label>
                    <input type="date" id="dateFilter"
                           class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <button onclick="limpiarFiltros()" class="w-full inline-flex items-center justify-center bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-700 transition text-sm">
                        <i class="fas fa-eraser mr-2"></i>Limpiar Filtros
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabla -->
        <div class="border border-gray-200 rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10">
                <tr>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Carnet</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Apellido</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Fecha Final</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Último Seguimiento</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Motivo</th>
                    <th class="px-4 py-3 text-right text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Acción</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100 text-sm">
                    <?php foreach ($estudiantes as $idx => $estudiante) { ?>
                    <tr class="hover:bg-gray-50 <?php echo $idx % 2 === 0 ? 'bg-white' : 'bg-gray-50/50'; ?>">
                        <td class="px-4 py-2 align-top font-medium text-gray-800"><?php echo $estudiante['carnet'];?></td>
                        <td class="px-4 py-2 align-top"><?php echo $estudiante['nombre'];?></td>
                        <td class="px-4 py-2 align-top"><?php echo $estudiante['apellido'];?></td>
                        <td class="px-4 py-2 align-top"><?php echo $estudiante['fecha_estado'];?></td>
                        <td class="px-4 py-2 align-top"><?php echo $estudiante['ultima_fecha_seguimiento'];?></td>
                        <td class="px-4 py-2 align-top"><?php echo $estudiante['motivo'];?></td>
                        <td class="px-4 py-2 align-top text-right space-x-2 whitespace-nowrap">
                            <a href="detalles_alumno.php?carnet=<?php echo $estudiante['carnet'];?>" class="inline-flex items-center bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-xs">
                                <i class="fas fa-eye mr-1"></i> Ver
                            </a>
                            <a href="historial_seguimiento.php?idalumno=<?php echo $estudiante['idalumno'];?>" class="inline-flex items-center bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-xs">
                                <i class="fas fa-history mr-1"></i> Historial
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    // Navegación
    document.getElementById('backBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea regresar?')) {
            window.location.href = 'dashboard.php';
        }
    });
    document.getElementById('logoutBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea cerrar sesión?')) {
            window.location.href = '../Login/Logout.php';
        }
    });

    // Filtrado en tiempo real
    const searchInput = document.getElementById('searchInput');
    const dateFilter = document.getElementById('dateFilter');
    const tableBody = document.querySelector('tbody');
    const allRows = Array.from(tableBody.getElementsByTagName('tr'));

    function aplicarFiltros() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedDate = dateFilter.value;
        
        allRows.forEach(row => {
            const carnet = row.cells[0]?.textContent.toLowerCase() || '';
            const nombre = row.cells[1]?.textContent.toLowerCase() || '';
            const apellido = row.cells[2]?.textContent.toLowerCase() || '';
            const fechaFinal = row.cells[3]?.textContent.trim() || '';
            
            // Filtro de búsqueda
            const matchesSearch = !searchTerm || 
                                carnet.includes(searchTerm) || 
                                nombre.includes(searchTerm) || 
                                apellido.includes(searchTerm);
            
            // Filtro de fecha
            const matchesDate = !selectedDate || fechaFinal === selectedDate;
            
            row.style.display = (matchesSearch && matchesDate) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', aplicarFiltros);
    dateFilter.addEventListener('change', aplicarFiltros);

    // Limpiar filtros
    function limpiarFiltros() {
        searchInput.value = '';
        dateFilter.value = '';
        allRows.forEach(row => {
            row.style.display = '';
        });
    }
</script>
</body>
</html>
