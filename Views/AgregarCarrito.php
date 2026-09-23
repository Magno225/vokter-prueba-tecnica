<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: Login.php');
    exit;
}

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/CarritoController.php';
require_once __DIR__ . '/../Controllers/ProductoController.php';

$database = new Database();
$db = $database->getConnection();

$varianteId = isset($_POST['variante_id']) ? (int) $_POST['variante_id'] : 0;
$cantidad = isset($_POST['cantidad']) ? (int) $_POST['cantidad'] : 1;
$productoId = isset($_POST['producto_id']) ? (int) $_POST['producto_id'] : 0;

$productoController = new ProductoController($db);
$producto = $productoController->obtenerDetalle($productoId);

if ($producto && $varianteId > 0) {
    $carritoController = new CarritoController($db);
    $carritoController->agregarProducto($_SESSION['usuario_id'], $varianteId, $cantidad, $producto['precio_base']);
}

header('Location: producto.php?id=' . $productoId . '&agregado=1');
exit;