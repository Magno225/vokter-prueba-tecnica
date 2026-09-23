<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['usuario_id'])) {
    header('Location: Login.php');
    exit;
}

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/PedidoController.php';
require_once __DIR__ . '/../Libs/fpdf/fpdf.php';

$facturaId = $_GET['id'] ?? null;
if (!$facturaId) {
    die('Factura no especificada.');
}

$database = new Database();
$db = $database->getConnection();
$pedidoController = new PedidoController($db);
$datos = $pedidoController->obtenerFacturaParaPDF($facturaId, $_SESSION['usuario_id']);

if ($datos === null) {
    die('No tienes permiso para ver esta factura.');
}

$factura = $datos['factura'];
$detalle = $datos['detalle'];

$pdf = new FPDF();
$pdf->AddPage();

// Encabezado
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 12, 'VOKTER', 0, 1);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 6, 'Factura de compra', 0, 1);
$pdf->Ln(4);

// Datos del pedido
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, 'Pedido #' . str_pad($factura['id'], 6, '0', STR_PAD_LEFT), 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, 'Fecha: ' . date('d/m/Y H:i', strtotime($factura['fecha_pedido'])), 0, 1);
$pdf->Cell(0, 6, 'Estado: ' . $factura['estado'], 0, 1);
$pdf->Ln(4);

// Cliente
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, 'Cliente', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, $factura['nombre'] . ' ' . $factura['apellido'], 0, 1);
$pdf->Cell(0, 6, $factura['correo'], 0, 1);
$pdf->Cell(0, 6, $factura['direccion'] . ', ' . $factura['ciudad'] . ', ' . $factura['departamento'], 0, 1);
$pdf->Ln(6);

// Tabla de productos
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(13, 20, 33);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(80, 8, 'Producto', 1, 0, 'L', true);
$pdf->Cell(30, 8, 'Variante', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Cant.', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Precio', 1, 0, 'R', true);
$pdf->Cell(30, 8, 'Subtotal', 1, 1, 'R', true);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);
foreach ($detalle as $item) {
    $variante = trim(($item['color'] ?? '') . ' ' . ($item['talla'] ?? ''));
    $pdf->Cell(80, 8, $item['nombre'], 1);
    $pdf->Cell(30, 8, $variante ?: '-', 1, 0, 'C');
    $pdf->Cell(20, 8, $item['cantidad'], 1, 0, 'C');
    $pdf->Cell(30, 8, '$' . number_format($item['precio_unitario'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(30, 8, '$' . number_format($item['subtotal_linea'], 0, ',', '.'), 1, 1, 'R');
}

$pdf->Ln(4);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(160, 7, 'Subtotal', 0, 0, 'R');
$pdf->Cell(30, 7, '$' . number_format($factura['subtotal'], 0, ',', '.'), 0, 1, 'R');
$pdf->Cell(160, 7, 'Envío', 0, 0, 'R');
$pdf->Cell(30, 7, '$' . number_format($factura['costo_envio'], 0, ',', '.'), 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(160, 9, 'Total', 0, 0, 'R');
$pdf->Cell(30, 9, '$' . number_format($factura['total'], 0, ',', '.'), 0, 1, 'R');

$pdf->Output('D', 'Factura_Vokter_' . $factura['id'] . '.pdf');
exit;