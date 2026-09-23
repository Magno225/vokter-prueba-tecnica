<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/CarritoController.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: Login.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();
$carritoController = new CarritoController($db);

$carrito = $carritoController->obtenerCarrito($_SESSION['usuario_id']);

if (empty($carrito['items'])) {
    header('Location: Carrito.php');
    exit;
}

$tituloPagina = 'Vokter - Finalizar Compra';
require_once __DIR__ . '/partials/header.php';
?>

<style>
  .checkout-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 32px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 48px 60px;
  }

  .checkout-section {
    background: #fff; border: 1px solid #eee; border-radius: 12px;
    padding: 24px; margin-bottom: 20px;
  }
  .checkout-section h2 { font-size: 1.05rem; margin-bottom: 16px; color: #111; }

  .checkout-section input, .checkout-section select {
    width: 100%; padding: 10px 12px; margin-bottom: 14px;
    border: 1px solid #ccc; border-radius: 6px; font-size: 0.9rem;
  }

  .payment-options { display: flex; flex-direction: column; gap: 10px; color: #4d4444;}
  .payment-option {
    display: flex; align-items: center; gap: 10px;
    border: 1px solid #ccc; border-radius: 8px; padding: 12px;
    cursor: pointer; font-size: 0.9rem;
  }
  .payment-option input { width: auto; margin: 0; }

  .checkout-summary {
    background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 24px;
    height: fit-content; position: sticky; top: 20px;
  }
  .checkout-summary h2 { font-size: 1.1rem; margin-bottom: 16px; color: #111; }
  .summary-item {
    display: flex; justify-content: space-between; font-size: 0.85rem; color: #444; margin-bottom: 8px;
  }
  .summary-total {
    display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 700; color: #111;
    padding-top: 14px; margin-top: 14px; border-top: 1px solid #eee;
  }
  .btn-confirmar {
    width: 100%; margin-top: 20px; padding: 14px; background: var(--blue-accent); color: #fff;
    border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.95rem;
  }

  @media (max-width: 900px) { .checkout-layout { grid-template-columns: 1fr; } }
</style>

<form method="POST" action="ConfirmarPedido.php">
  <div class="checkout-layout">
    <div>
      <div class="checkout-section">
        <h2>Dirección de envío</h2>
        <input type="text" name="direccion" placeholder="Calle, número, detalles" required>
        <input type="text" name="ciudad" placeholder="Ciudad" required>
        <input type="text" name="departamento" placeholder="Departamento" required>
        <input type="text" name="codigo_postal" placeholder="Código postal" required>
      </div>

      <div class="checkout-section">
        <h2>Método de pago</h2>
        <div class="payment-options">
            <label class="payment-option">
                <input type="radio" name="metodo_pago" value="Tarjeta" checked>
                Tarjeta de crédito/débito
            </label>
            <label class="payment-option">
                <input type="radio" name="metodo_pago" value="PSE">
                PSE
            </label>
            <label class="payment-option">
                <input type="radio" name="metodo_pago" value="Contraentrega">
                Pago contraentrega
            </label>
            </div>
      </div>
    </div>

    <div class="checkout-summary">
      <h2>Resumen del pedido</h2>
      <?php foreach ($carrito['items'] as $item): ?>
        <div class="summary-item">
          <span><?php echo htmlspecialchars($item['nombre']); ?> x<?php echo $item['cantidad']; ?></span>
          <span>$<?php echo number_format($item['precio_unitario'] * $item['cantidad'], 0, ',', '.'); ?></span>
        </div>
      <?php endforeach; ?>
      <div class="summary-total">
        <span>Total</span>
        <span>$<?php echo number_format($carrito['total'], 0, ',', '.'); ?> COP</span>
      </div>
      <button type="submit" class="btn-confirmar">Confirmar pedido</button>
    </div>
  </div>
</form>

<?php require_once __DIR__ . '/partials/footer.php'; ?>