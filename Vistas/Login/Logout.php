<?php
session_start();
session_destroy();
header("Location: /ProyectoInasistenciasItca/index.php");
?>