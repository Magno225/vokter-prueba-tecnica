<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/CheckoutController.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: Login.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();
$controller = new CheckoutController($db);

$resultado = $controller->confirmarPedido(
    $_SESSION['usuario_id'],
    trim($_POST['direccion']),
    trim($_POST['ciudad']),
    trim($_POST['departamento']),
    trim($_POST['codigo_postal'])
);

if (!$resultado['exito']) {
    die($resultado['mensaje']);
}

$_SESSION['ultima_factura'] = $resultado['factura_id'];
$_SESSION['ultimo_total'] = $resultado['total'];

header('Location: PedidoConfirmado.php');
exit;