<?php
include 'session_check.php'; requiereRol("supervisor");
$ordenes = []; $files = glob("uploads/*.json");
foreach ($files as $file) {
  $data = json_decode(file_get_contents($file), true);
  if ($data) $ordenes[] = $data;
}
$total = count($ordenes); $mesActual = date("Y-m"); $totalMes = 0;
foreach ($ordenes as $orden) {
  if (strpos($orden['codigo'], "OT-$mesActual") === 0) $totalMes++;
}
usort($ordenes, fn($a, $b) => strtotime($b['fecha']) - strtotime($a['fecha']));
$ordenesRecientes = array_slice($ordenes, 0, 5);
?><!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Estadísticas</title><link rel="stylesheet" href="style.css"></head><body>
<header><h1>Estadísticas</h1><button onclick="toggleDarkMode()" style="float:right;">🌓</button></header>
<nav><a href="panel_supervisor.php">← Volver</a></nav>
<main><div class="stats"><p>📄 Total órdenes: <strong><?= $total ?></strong></p>
<p>📅 Este mes (<?= $mesActual ?>): <strong><?= $totalMes ?></strong></p></div>
<h3>Últimas 5 órdenes</h3><table><tr><th>Código</th><th>Cliente</th><th>Dirección</th><th>Fecha</th><th>PDF</th></tr>
<?php foreach ($ordenesRecientes as $orden): ?><tr>
<td><?= $orden['codigo'] ?></td><td><?= $orden['nombre'] ?></td>
<td><?= $orden['direccion'] ?></td><td><?= $orden['fecha'] ?></td>
<td><a href="uploads/<?= $orden['codigo'] ?>.pdf" target="_blank">📄</a></td></tr>
<?php endforeach; ?></table></main>
<script>
function toggleDarkMode() {
  document.body.classList.toggle('dark');
  localStorage.setItem('modoOscuro', document.body.classList.contains('dark'));
}
window.onload = () => {
  if (localStorage.getItem('modoOscuro') === 'true') document.body.classList.add('dark');
}
</script></body></html>
