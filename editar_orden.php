<?php
include 'session_check.php'; requiereRol("supervisor");
$codigo = $_GET['codigo'] ?? ''; $jsonPath = "uploads/$codigo.json";
$pdfPath = "uploads/$codigo.pdf"; $firmaPath = "uploads/firma_$codigo.png";
if (!file_exists($jsonPath)) die("Orden no encontrada.");
$orden = json_decode(file_get_contents($jsonPath), true); $mensaje = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $orden['nombre'] = $_POST['nombre']; $orden['direccion'] = $_POST['direccion'];
  $orden['descripcion'] = $_POST['descripcion']; $orden['fecha'] = $_POST['fecha'];
  file_put_contents($jsonPath, json_encode($orden, JSON_PRETTY_PRINT));
  require 'lib/fpdf.php';
  $pdf = new FPDF(); $pdf->AddPage(); $pdf->SetFont('Arial','B',14);
  $pdf->Cell(0,10,"Orden de Trabajo: $codigo",0,1);
  $pdf->SetFont('Arial','',12); $pdf->Cell(0,10,"Nombre: {$orden['nombre']}",0,1);
  $pdf->Cell(0,10,"Dirección: {$orden['direccion']}",0,1);
  $pdf->Cell(0,10,"Fecha: {$orden['fecha']}",0,1);
  $pdf->MultiCell(0,10,"Descripción: {$orden['descripcion']}",0,1);
  $pdf->Ln(10); $pdf->Cell(0,10,"Firma:",0,1);
  $pdf->Image($firmaPath, 10, $pdf->GetY(), 100); $pdf->Output('F', $pdfPath);
  $mensaje = "Orden actualizada correctamente.";
}
?><!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">
<title>Editar Orden <?= $codigo ?></title><link rel="stylesheet" href="style.css"></head>
<body><main><h2>Editar Orden: <?= $codigo ?></h2><a href="panel_supervisor.php">← Volver</a>
<?php if ($mensaje): ?><p style="color:green;"><?= $mensaje ?></p><?php endif; ?>
<form method="post">
  <label>Nombre:</label><input type="text" name="nombre" value="<?= $orden['nombre'] ?>" required>
  <label>Dirección:</label><input type="text" name="direccion" value="<?= $orden['direccion'] ?>" required>
  <label>Descripción:</label><textarea name="descripcion" required><?= $orden['descripcion'] ?></textarea>
  <label>Fecha:</label><input type="date" name="fecha" value="<?= $orden['fecha'] ?>" required>
  <button type="submit">Guardar Cambios</button>
</form></main></body></html>
