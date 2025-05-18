<?php
require 'lib/fpdf.php';
$data = json_decode(file_get_contents("php://input"), true);
$nombre = $data['nombre'];
$direccion = $data['direccion'];
$descripcion = $data['descripcion'];
$fecha = $data['fecha'];
$firmaBase64 = $data['firma'];
$timestamp = time();
$codigoOrden = "OT-" . date("Y-m") . "-" . $timestamp;
$firmaPath = "uploads/firma_" . $codigoOrden . ".png";
file_put_contents($firmaPath, base64_decode(explode(',', $firmaBase64)[1]));
$pdfPath = "uploads/$codigoOrden.pdf";
$pdf = new FPDF(); $pdf->AddPage(); $pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,"Orden de Trabajo: $codigoOrden",0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,"Nombre: $nombre",0,1);
$pdf->Cell(0,10,"Dirección: $direccion",0,1);
$pdf->Cell(0,10,"Fecha: $fecha",0,1);
$pdf->MultiCell(0,10,"Descripción: $descripcion",0,1);
$pdf->Ln(10); $pdf->Cell(0,10,"Firma:",0,1);
$pdf->Image($firmaPath, 10, $pdf->GetY(), 100); $pdf->Output('F', $pdfPath);
$orden = [
  "codigo" => $codigoOrden, "nombre" => $nombre,
  "direccion" => $direccion, "descripcion" => $descripcion,
  "fecha" => $fecha, "firma" => $firmaPath
];
file_put_contents("uploads/$codigoOrden.json", json_encode($orden, JSON_PRETTY_PRINT));
$to = "cliente@correo.com"; $subject = "Orden: $codigoOrden";
$headers = "From: sistema@tudominio.com
";
$headers .= "Content-Type: text/plain; charset=UTF-8
";
$message = "Adjuntamos su orden: $codigoOrden.

Verifique su contenido.";
mail($to, $subject, $message, $headers);
echo json_encode(["status" => "ok", "codigo" => $codigoOrden]);
