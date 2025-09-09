<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Inasistencias - ITCA FEPADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .highlight { background-color: #fef3c7; font-weight: 600; }
        .table-container { overflow-x: auto; }
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
            <span class="text-sm text-gray-700 font-medium" id="userName">Docente</span>
            <img id="profileImage" src="../Publico/Imagenes/PerfilPrueba.jpg" alt="Foto docente"
                 class="rounded-full w-8 h-8 object-cover border border-gray-200">
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
                <h2 class="text-2xl font-bold text-gray-800">Gestionar Inasistencias</h2>
                <p class="text-sm text-gray-500">Revise, filtre y gestione las inasistencias registradas</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="FormRegistroInasistencia.php"
                   class="inline-flex items-center bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition text-sm">
                    <i class="fas fa-plus mr-2"></i>Nueva Inasistencia
                </a>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg mb-4">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-2 rounded-full mr-3">
                    <i class="fas fa-filter text-blue-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Filtros</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-start">
                <div class="relative md:col-span-2">
                    <label for="searchInput" class="block text-sm text-gray-600 mb-1">Buscar</label>
                    <input type="text" id="searchInput" placeholder="Nombre, carnet, carrera..."
                           class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
                    <i class="fas fa-search absolute left-3 top-[42px] md:top-[38px] transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Desde</label>
                    <input type="date" id="fromDate" class="w-full p-2 border border-gray-300 rounded" />
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Hasta</label>
                    <input type="date" id="toDate" class="w-full p-2 border border-gray-300 rounded" />
                </div>
            </div>
            <div class="mt-3 flex items-center justify-between">
                <button id="clearFilters" class="inline-flex items-center text-blue-700 hover:text-blue-800 text-sm">
                    <i class="fas fa-broom mr-2"></i>Limpiar filtros
                </button>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-container border border-gray-200 rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10">
                <tr>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Estudiante</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Carrera / Grupo</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Horas</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Materia</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Observaciones</th>
                    <th class="px-4 py-3 text-right text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
                </thead>
                <tbody id="tableBody" class="bg-white divide-y divide-gray-100 text-sm"></tbody>
            </table>
        </div>

        <!-- Mensaje vacío -->
        <div id="emptyState" class="hidden text-center text-gray-500 py-8">
            <i class="fas fa-inbox text-3xl mb-2"></i>
            <div>No hay inasistencias que coincidan con los filtros.</div>
        </div>

        <!-- Resumen -->
        <div class="mt-4 text-sm text-gray-600">
            <span id="summaryCount">0</span> registro(s) mostrado(s)
        </div>
    </div>
</main>

<script>
    // Datos estáticos de ejemplo (coherentes con FormRegistroInasistencia)
    const inasistencias = [
        {
            id: 1,
            carnet: "000224",
            apellidos: "PÉREZ LÓPEZ",
            nombres: "JOSÉ CARLOS",
            carrera: "TEC. EN DESARROLLO DE SOFTWARE",
            grupo: "SOFT42B",
            fecha: "2025-09-01",
            horas: 2,
            materia: "Programación I",
            observaciones: "Llegó tarde al laboratorio"
        },
        {
            id: 2,
            carnet: "000225",
            apellidos: "GARCÍA MARTÍNEZ",
            nombres: "MARÍA ELENA",
            carrera: "TEC. EN DESARROLLO DE SOFTWARE",
            grupo: "SOFT42A",
            fecha: "2025-09-02",
            horas: 1,
            materia: "Base de Datos",
            observaciones: "Ausencia justificada"
        },
        {
            id: 3,
            carnet: "000229",
            apellidos: "LÓPEZ RAMÍREZ",
            nombres: "CARMEN ELIZABETH",
            carrera: "TEC. EN DESARROLLO DE SOFTWARE",
            grupo: "SOFT42B",
            fecha: "2025-09-03",
            horas: 4,
            materia: "Desarrollo Web",
            observaciones: "Sin justificación"
        }
    ];

    function normalizeText(text) {
        return (text || '')
            .toString()
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s]/g, '')
            .replace(/\s+/g, ' ')
            .trim();
    }

    function renderTable(rows) {
        const tbody = document.getElementById('tableBody');
        const empty = document.getElementById('emptyState');
        if (!rows.length) {
            tbody.innerHTML = '';
            empty.classList.remove('hidden');
            document.getElementById('summaryCount').textContent = '0';
            return;
        }
        empty.classList.add('hidden');
        tbody.innerHTML = rows.map((r, idx) => `
            <tr class="hover:bg-gray-50 ${idx % 2 === 0 ? 'bg-white' : 'bg-gray-50/50'}">
                <td class="px-4 py-2 align-top text-gray-700">${r.id}</td>
                <td class="px-4 py-2 align-top">
                    <div class="font-medium text-gray-800">${r.nombres} ${r.apellidos}</div>
                    <div class="text-xs text-gray-500">${r.carnet}</div>
                </td>
                <td class="px-4 py-2 align-top">${r.carrera} <span class="text-gray-400">/</span> ${r.grupo}</td>
                <td class="px-4 py-2 align-top">${r.fecha}</td>
                <td class="px-4 py-2 align-top">${r.horas}</td>
                <td class="px-4 py-2 align-top">${r.materia}</td>
                <td class="px-4 py-2 align-top">${r.observaciones || ''}</td>
                <td class="px-4 py-2 align-top text-right space-x-2 whitespace-nowrap">
                    <a href="EditarInasistencia.php?id=${r.id}" class="inline-flex items-center bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-xs">
                        <i class="fas fa-pen mr-1"></i> Editar
                    </a>
                    <button data-id="${r.id}" class="btn-delete inline-flex items-center bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-xs">
                        <i class="fas fa-trash mr-1"></i> Eliminar
                    </button>
                </td>
            </tr>
        `).join('');
        document.getElementById('summaryCount').textContent = String(rows.length);
    }

    function applyFilters() {
        const text = normalizeText(document.getElementById('searchInput').value);
        const from = document.getElementById('fromDate').value;
        const to = document.getElementById('toDate').value;
        const rows = inasistencias.filter(r => {
            const textHay = normalizeText(`${r.nombres} ${r.apellidos} ${r.carnet} ${r.carrera} ${r.grupo} ${r.materia} ${r.observaciones}`).includes(text);
            const afterFrom = from ? (r.fecha >= from) : true;
            const beforeTo = to ? (r.fecha <= to) : true;
            return textHay && afterFrom && beforeTo;
        });
        renderTable(rows);
    }

    // Eventos
    document.getElementById('searchInput').addEventListener('input', applyFilters);
    document.getElementById('fromDate').addEventListener('change', applyFilters);
    document.getElementById('toDate').addEventListener('change', applyFilters);

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete');
        if (btn) {
            const id = parseInt(btn.dataset.id, 10);
            const item = inasistencias.find(x => x.id === id);
            if (confirm(`¿Eliminar inasistencia de ${item.nombres} ${item.apellidos} del ${item.fecha}?`)) {
                const idx = inasistencias.findIndex(x => x.id === id);
                if (idx >= 0) {
                    inasistencias.splice(idx, 1);
                    applyFilters();
                }
            }
        }
    });

    // Limpiar filtros
    document.getElementById('clearFilters').addEventListener('click', function() {
        document.getElementById('searchInput').value = '';
        document.getElementById('fromDate').value = '';
        document.getElementById('toDate').value = '';
        applyFilters();
    });

    // (Se eliminó exportación CSV según solicitud)

    // Navegación
    document.getElementById('backBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea regresar? Se perderán los cambios no guardados.')) {
            window.location.href = 'DashboardDocente.php';
        }
    });
    document.getElementById('logoutBtn').addEventListener('click', function() {
        if (confirm('¿Está seguro que desea cerrar sesión?')) {
            window.location.href = '../Login/Login.php';
        }
    });

    // Inicialización
    document.addEventListener('DOMContentLoaded', function() {
        // setear max para filtros de fecha a hoy
        const today = new Date();
        const tzOffset = new Date(today.getTime() - (today.getTimezoneOffset() * 60000));
        const todayStr = tzOffset.toISOString().split('T')[0];
        document.getElementById('fromDate').setAttribute('max', todayStr);
        document.getElementById('toDate').setAttribute('max', todayStr);
        applyFilters();
    });
</script>
</body>
</html>
