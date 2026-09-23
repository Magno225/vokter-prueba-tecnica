<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: Login.php');
    exit;
}

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/CarritoController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new CarritoController($db);

$accion = $_GET['accion'] ?? '';
$itemId = isset($_GET['item_id']) ? (int) $_GET['item_id'] : 0;
$cantidadActual = isset($_GET['cantidad']) ? (int) $_GET['cantidad'] : null;

// Necesitamos la cantidad actual del item para sumar/restar correctamente
require_once __DIR__ . '/../Models/carritoServer.php';
$carritoModel = new Carrito($db);
$carrito = $controller->obtenerCarrito($_SESSION['usuario_id']);

$cantidadReal = 1;
foreach ($carrito['items'] as $item) {
    if ($item['item_id'] == $itemId) {
        $cantidadReal = $item['cantidad'];
        break;
    }
}

if ($accion === 'sumar') {
    $controller->incrementar($itemId, $cantidadReal);
} elseif ($accion === 'restar') {
    $controller->decrementar($itemId, $cantidadReal);
} elseif ($accion === 'eliminar') {
    $controller->eliminar($itemId);
}

header('Location: Carrito.php');
exit;