<?php
include 'session_check.php';
requiereRol("operario");
?><!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel Operario</title><link rel="stylesheet" href="style.css"></head><body>
<header><h1>Panel Operario</h1>
<button onclick="toggleDarkMode()" style="float:right; margin-top: -40px;">🌓</button></header>
<nav><a href="orden_trabajo.html">📝 Nueva Orden</a>
<a href="logout.php">🚪 Cerrar sesión</a></nav>
<main><p>Hola <strong><?= $_SESSION['usuario'] ?></strong>, puedes crear órdenes nuevas aquí.</p></main>
<script>
function toggleDarkMode() {
  document.body.classList.toggle('dark');
  localStorage.setItem('modoOscuro', document.body.classList.contains('dark'));
}
window.onload = () => {
  if (localStorage.getItem('modoOscuro') === 'true') document.body.classList.add('dark');
}
</script></body></html>
