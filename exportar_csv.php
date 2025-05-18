<?php
include 'session_check.php'; requiereRol("supervisor");
$ordenes = []; $files = glob("uploads/*.json");
foreach ($files as $file) {
  $data = json_decode(file_get_contents($file), true);
  if ($data) $ordenes[] = $data;
}
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=ordenes_exportadas.csv');
$output = fopen('php://output', 'w');
fputcsv($output, ['Código', 'Nombre', 'Dirección', 'Fecha', 'Descripción']);
foreach ($ordenes as $orden) {
  fputcsv($output, [$orden['codigo'], $orden['nombre'], $orden['direccion'], $orden['fecha'], $orden['descripcion']]);
}
fclose($output);
