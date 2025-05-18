<?php
include 'session_check.php'; requiereRol("supervisor");
$ordenes = []; $files = glob("uploads/*.json");
foreach ($files as $file) {
  $data = json_decode(file_get_contents($file), true);
  if ($data) $ordenes[] = $data;
}
usort($ordenes, fn($a, $b) => strtotime($b['fecha']) - strtotime($a['fecha']));
?><!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel Supervisor</title><link rel="stylesheet" href="style.css"></head>
<body><header><h1>Panel del Supervisor</h1>
<button onclick="toggleDarkMode()" style="float:right; margin-top:-40px;">🌓</button></header>
<nav><a href="orden_trabajo.html">➕ Nueva Orden</a><a href="panel_supervisor.php">📋 Ver Órdenes</a>
<a href="estadisticas.php">📊 Estadísticas</a><a href="exportar_csv.php">📥 Exportar CSV</a>
<a href="logout.php">🚪 Cerrar sesión</a></nav>
<main><h2>Órdenes Recibidas</h2><table>
<tr><th>Código</th><th>Cliente</th><th>Dirección</th><th>Fecha</th><th>Acciones</th></tr>
<?php foreach ($ordenes as $orden): ?><tr>
<td><?= $orden['codigo'] ?></td><td><?= $orden['nombre'] ?></td>
<td><?= $orden['direccion'] ?></td><td><?= $orden['fecha'] ?></td>
<td><a href="uploads/<?= $orden['codigo'] ?>.pdf" target="_blank">📄 PDF</a> |
<a href="editar_orden.php?codigo=<?= $orden['codigo'] ?>">✏️ Editar</a> |
<a href="eliminar_orden.php?codigo=<?= $orden['codigo'] ?>" onclick="return confirm('¿Eliminar?')">🗑</a></td>
</tr><?php endforeach; ?></table></main>
<script>
function toggleDarkMode() {
  document.body.classList.toggle('dark');
  localStorage.setItem('modoOscuro', document.body.classList.contains('dark'));
}
window.onload = () => {
  if (localStorage.getItem('modoOscuro') === 'true') document.body.classList.add('dark');
}
</script></body></html>
