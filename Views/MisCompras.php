<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['usuario_id'])) {
    header('Location: Login.php');
    exit;
}

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/PedidoController.php';

$database = new Database();
$db = $database->getConnection();
$pedidoController = new PedidoController($db);
$pedidos = $pedidoController->listarPedidos($_SESSION['usuario_id']);

$tituloPagina = 'Mis compras';
require_once __DIR__ . '/partials/header.php';
?>

<main style="max-width: 900px; margin: 40px auto; padding: 0 20px;">
    <h1>Mis compras</h1>

    <?php if (empty($pedidos)): ?>
        <p>Aún no has realizado ninguna compra. <a href="Principal.php">Ir al catálogo</a></p>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background: #0d1421; color: white;">
                    <th style="padding: 12px; text-align: left;">Pedido #</th>
                    <th style="padding: 12px; text-align: left;">Fecha</th>
                    <th style="padding: 12px; text-align: left;">Estado</th>
                    <th style="padding: 12px; text-align: right;">Total</th>
                    <th style="padding: 12px; text-align: center;">Factura</th>
                </tr>
            </thead>
           <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 12px; color: #0d1421;">#<?php echo str_pad($pedido['id'], 6, '0', STR_PAD_LEFT); ?></td>
                        <td style="padding: 12px; color: #0d1421;"><?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])); ?></td>
                        <td style="padding: 12px; color: #0d1421;"><?php echo htmlspecialchars($pedido['estado']); ?></td>
                        <td style="padding: 12px; color: #0d1421; text-align: right;">$<?php echo number_format($pedido['total'], 0, ',', '.'); ?></td>
                        <td style="padding: 12px; text-align: center;">
                            <a href="DescargarFactura.php?id=<?php echo $pedido['id']; ?>" style="color: #2563eb; font-weight: 600;">Descargar factura</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>