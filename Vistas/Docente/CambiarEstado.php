<?php
session_start();
if(!isset($_SESSION['docente'])){
    header("Location: /ProyectoInasistencias/index.php");
    exit();
}
require_once "../../models/FaltasModel.php";

$dataDocente = $_SESSION['docente'];
$idInasistencia = isset($_GET['id']) ? $_GET['id'] : null;
$estado = isset($_GET['estado']) ? $_GET['estado'] : null;

if (!$idInasistencia || !$estado) {
    $_SESSION['toast'] = [
        'type' => 'error',
        'message' => 'Parámetros inválidos',
        'details' => 'No se proporcionó el ID o el estado de la inasistencia'
    ];
    header("Location: /ProyectoInasistenciasItca/Vistas/Docente/CrudInasistencia.php");
    exit();
}

try {
    $inasistencia = new Faltas();
    if($inasistencia->cambiarEstado($idInasistencia, $estado)){
        $accion = ($estado === 'Eliminada') ? 'eliminada' : 'actualizada';
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => "Inasistencia $accion correctamente"
        ];
    } else {
        throw new Exception('No se pudo completar la operación');
    }
} catch (Exception $e) {
    $_SESSION['toast'] = [
        'type' => 'error',
        'message' => 'Error al procesar la solicitud',
        'details' => $e->getMessage()
    ];
}

header("Location: /ProyectoInasistenciasItca/Vistas/Docente/CrudInasistencia.php");
exit();