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
$controller = new CarritoController($db);

$carrito = $controller->obtenerCarrito($_SESSION['usuario_id']);

$tituloPagina = 'Vokter - Mi Carrito';
require_once __DIR__ . '/partials/header.php';
?>

<style>
  .cart-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 32px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 48px 60px;
  }

  .cart-items { display: flex; flex-direction: column; gap: 16px; }

  .cart-item {
    display: flex;
    align-items: center;
    gap: 20px;
    background: #fff;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 16px;
  }

  .cart-item-image {
    width: 90px; height: 90px; border-radius: 8px; overflow: hidden;
    background: var(--bg-hero); flex-shrink: 0;
  }
  .cart-item-image img { width: 100%; height: 100%; object-fit: cover; }

  .cart-item-info { flex: 1; }
  .cart-item-info h3 { font-size: 0.95rem; color: #111; margin-bottom: 6px; }
  .cart-item-info p { font-size: 0.8rem; color: #666; margin-bottom: 4px; }
  .cart-item-price { font-weight: 700; color: #111; font-size: 1rem; }

  .qty-selector {
    display: flex; align-items: center; border: 1px solid #ccc; border-radius: 6px; overflow: hidden;
    width: fit-content; margin-top: 8px;
  }
  .qty-btn {
    width: 32px; height: 32px; border: none; background: #f5f5f5; cursor: pointer;
    font-size: 1.1rem; font-weight: 700; color: #333; text-decoration: none;
    display: flex; align-items: center; justify-content: center;
  }
  .qty-btn:hover { background: #e5e5e5; }
    .qty-value {
    width: 40px;
    text-align: center;
    font-weight: 600;
    font-size: 0.95rem;
    color: #111;
    display: flex;
    align-items: center;
    justify-content: center;
    }
  .cart-item-remove {
    font-size: 0.8rem; color: #dc2626; cursor: pointer; text-decoration: none; margin-top: 8px; display: inline-block;
  }

  .cart-empty { padding: 60px; text-align: center; color: #666; }
  .cart-empty a { color: var(--blue-accent); }

  .cart-summary {
    background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 24px;
    height: fit-content; position: sticky; top: 20px;
  }
  .cart-summary h2 { font-size: 1.1rem; margin-bottom: 16px; color: #111; }
  .cart-summary-row {
    display: flex; justify-content: space-between; font-size: 0.9rem; color: #444; margin-bottom: 10px;
  }
  .cart-summary-total {
    display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 700; color: #111;
    padding-top: 14px; margin-top: 14px; border-top: 1px solid #eee;
  }
  .btn-continuar {
    width: 100%; margin-top: 20px; padding: 14px; background: var(--blue-accent); color: #fff;
    border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.95rem;
  }

  @media (max-width: 900px) {
    .cart-layout { grid-template-columns: 1fr; }
  }
</style>

<div class="cart-layout">
  <div class="cart-items">
    <?php if (empty($carrito['items'])): ?>
      <p class="cart-empty">Tu carrito está vacío. <a href="Principal.php">Ver catálogo</a></p>
    <?php else: ?>
      <?php foreach ($carrito['items'] as $item): ?>
        <div class="cart-item">
          <div class="cart-item-image">
            <img src="<?php echo $item['imagen_url'] ? htmlspecialchars($item['imagen_url']) : '/projectVokter/Images/Fotos/placeholder.jpg'; ?>" alt="">
          </div>
          <div class="cart-item-info">
            <h3><?php echo htmlspecialchars($item['nombre']); ?></h3>
            <?php if ($item['color']): ?>
              <p>Color: <?php echo htmlspecialchars($item['color']); ?><?php echo $item['talla'] ? ' — Talla: ' . htmlspecialchars($item['talla']) : ''; ?></p>
            <?php endif; ?>
            <p class="cart-item-price">$<?php echo number_format($item['precio_unitario'], 0, ',', '.'); ?> COP</p>

            <div class="qty-selector">
              <a href="ActualizarCarrito.php?accion=restar&item_id=<?php echo $item['item_id']; ?>" class="qty-btn">−</a>
              <span class="qty-value"><?php echo $item['cantidad']; ?></span>
              <a href="ActualizarCarrito.php?accion=sumar&item_id=<?php echo $item['item_id']; ?>" class="qty-btn">+</a>
            </div>
            <a href="ActualizarCarrito.php?accion=eliminar&item_id=<?php echo $item['item_id']; ?>" class="cart-item-remove">Eliminar</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <div class="cart-summary">
    <h2>Resumen de compra</h2>
    <div class="cart-summary-row">
      <span>Productos (<?php echo count($carrito['items']); ?>)</span>
      <span>$<?php echo number_format($carrito['total'], 0, ',', '.'); ?> COP</span>
    </div>
    <div class="cart-summary-total">
      <span>Total</span>
      <span>$<?php echo number_format($carrito['total'], 0, ',', '.'); ?> COP</span>
    </div>
    <a href="Checkout.php" class="btn-continuar" style="display: block; text-align: center; text-decoration: none;">Continuar</a>  </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>