<?php
session_start();
function requiereRol($rolEsperado) {
  if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== $rolEsperado) {
    header("Location: login.php");
    exit;
  }
}
?>