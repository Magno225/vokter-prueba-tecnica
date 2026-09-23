<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['ultima_factura'])) {
    header('Location: Principal.php');
    exit;
}

$facturaId = $_SESSION['ultima_factura'];
$total = $_SESSION['ultimo_total'];
unset($_SESSION['ultima_factura'], $_SESSION['ultimo_total']);

$tituloPagina = 'Vokter - Pedido Confirmado';
require_once __DIR__ . '/partials/header.php';
?>

<style>
  .confirm-box {
    max-width: 500px; margin: 80px auto; text-align: center; padding: 40px;
    background: #fff; border: 1px solid #eee; border-radius: 12px;
  }
  .confirm-box .icon { font-size: 3rem; margin-bottom: 16px; }
  .confirm-box h1 { font-size: 1.4rem; color: #111; margin-bottom: 10px; }
  .confirm-box p { color: #666; font-size: 0.9rem; margin-bottom: 20px; }
  .confirm-box a {
    display: inline-block; padding: 12px 28px; background: var(--blue-accent); color: #fff;
    text-decoration: none; border-radius: 8px; font-weight: 600;
  }
</style>

<div class="confirm-box">
  <div class="icon">✅</div>
  <h1>¡Pedido confirmado!</h1>
  <p>Tu pedido #<?php echo $facturaId; ?> por $<?php echo number_format($total, 0, ',', '.'); ?> COP fue registrado con éxito.</p>
  <a href="Principal.php">Volver al catálogo</a>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>