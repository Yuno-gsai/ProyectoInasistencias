<?php
session_start();
session_destroy();
header("Location: /ProyectoInasistencias/index.php");
?>