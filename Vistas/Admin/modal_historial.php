<?php
if(!isset($_SESSION['administrador'])){
    header("Location: /ProyectoInasistenciasItca/index.php");
}
$dataAdmin=$_SESSION['administrador'];

require_once "../../models/SeguimientosModel.php";

// Obtener todos los estudiantes con sus seguimientos
$dataALumnos = new SeguimientosModel();
$dataALumnos = json_encode($dataALumnos->getAllEstudiantes($dataAdmin['ciclo'], $dataAdmin['anio']));
?>

<!-- Modal de Historial de Seguimientos -->
<div id="historyModal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full modal-content relative max-h-[90vh] overflow-y-auto">
        <button onclick="closeHistoryModal()" class="absolute top-4 right-4 text-gray-500 text-3xl font-bold hover:text-gray-800">&times;</button>
        <div class="p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center section-title">Historial de Seguimiento</h2>

            <div id="historialContent" >
                <!-- Cada seguimiento será una “tarjeta” estilo timeline -->
            </div>

            <div class="flex justify-end mt-8">
                <button onclick="closeHistoryModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors shadow-md">
                    <i class="fas fa-times mr-2"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Datos de estudiantes desde PHP
    const estudiantes = <?php echo $dataALumnos; ?>;

    // Variable para almacenar el estudiante actual
    let estudianteActual = null;

    // Abrir modal de detalles del estudiante
    function openDetailsModal(idalumno) {
        estudianteActual = estudiantes.find(est => est.idalumno == idalumno);
        if (estudianteActual) {
            document.getElementById('studentCarnet').textContent = estudianteActual.carnet;
            document.getElementById('studentName').textContent = estudianteActual.nombre;
            document.getElementById('studentLastName').textContent = estudianteActual.apellido;
            document.getElementById('studentPhone').textContent = estudianteActual.telefono;
            document.getElementById('studentEmail').textContent = estudianteActual.email;
            document.getElementById('studentId').value = estudianteActual.idalumno;
            document.getElementById('faltaid').value = estudianteActual.faltas[0].id_inasistencia;

            // Estado
            const statusElement = document.getElementById('studentStatus');
            statusElement.textContent = estudianteActual.estadoAlumno == 1 ? "Activo" : "Inactivo";
            statusElement.className = 'status-badge';
            if (estudianteActual.estadoAlumno == 1) statusElement.classList.add('status-active');
            else if (estudianteActual.estadoAlumno == 0) statusElement.classList.add('status-suspended');
            else if (estudianteActual.estadoAlumno == 2) statusElement.classList.add('status-transferred');
        }

        document.getElementById('detailsModal').classList.remove('hidden');
        document.getElementById('detailsModal').classList.add('flex');
    }

    function closeDetailsModal() {
        document.getElementById('detailsModal').classList.add('hidden');
        document.getElementById('detailsModal').classList.remove('flex');
    }

    function openHistoryModal(idalumno) {
        // If idalumno is provided, find the student
        if (idalumno) {
            estudianteActual = estudiantes.find(est => est.idalumno == idalumno);
        }
        
        if (!estudianteActual) return;

        const historialContent = document.getElementById('historialContent');
        historialContent.innerHTML = '';

        if (Array.isArray(estudianteActual.seguimientos) && estudianteActual.seguimientos.length > 0) {
            estudianteActual.seguimientos.forEach(s => {
                let borderColor = 'border-red-600';
                if (s.accion?.toLowerCase().includes('llamada')) borderColor = 'border-blue-500';
                else if (s.accion?.toLowerCase().includes('correo') || s.accion?.toLowerCase().includes('email')) borderColor = 'border-green-500';
                else if (s.accion?.toLowerCase().includes('visita')) borderColor = 'border-yellow-500';

                const itemElement = document.createElement('div');
                itemElement.className = `relative bg-gray-50 p-4 rounded-lg shadow-md ${borderColor} border-l-4`;
                itemElement.innerHTML = `
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-500 font-medium">${s.fecha}</span>
                        <span class="text-sm font-semibold ${borderColor.replace('border', 'text')}">${s.accion}</span>
                    </div>
                    <p class="text-gray-700">${s.respuesta}</p>
                `;
                historialContent.appendChild(itemElement);
            });
        } else {
            historialContent.innerHTML = "<p class='text-gray-500 text-center'>No hay seguimientos registrados.</p>";
        }

        document.getElementById('historyModal').classList.remove('hidden');
        document.getElementById('historyModal').classList.add('flex');
    }

    function closeHistoryModal() {
        document.getElementById('historyModal').classList.add('hidden');
        document.getElementById('historyModal').classList.remove('flex');
    }


    // Cerrar modales con Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDetailsModal();
            closeHistoryModal();
        }
    });

    function openCancelModal() {
            document.getElementById('cancelModal').classList.remove('hidden');
            document.getElementById('cancelModal').classList.add('flex');
        }

    function closeCancelModal() {
        document.getElementById('cancelModal').classList.add('hidden');
        document.getElementById('cancelModal').classList.remove('flex');
    }
</script>
