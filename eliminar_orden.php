<?php
include 'session_check.php'; requiereRol("supervisor");
$codigo = $_GET['codigo'] ?? '';
@unlink("uploads/$codigo.json");
@unlink("uploads/$codigo.pdf");
@unlink("uploads/firma_$codigo.png");
header("Location: panel_supervisor.php");
