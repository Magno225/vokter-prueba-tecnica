<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/UsuarioController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new UsuarioController($db);

$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = $controller->registrar(
        trim($_POST['cedula']),
        trim($_POST['nombre']),
        trim($_POST['apellido']),
        trim($_POST['correo']),
        $_POST['password'],
        trim($_POST['telefono'])
    );
}

$tituloPagina = 'Vokter - Crear cuenta';
require_once __DIR__ . '/partials/header.php';
?>

<style>
  .auth-container { max-width: 420px; margin: 60px auto; padding: 32px; }
  .auth-container h1 { font-size: 1.5rem; margin-bottom: 24px; color: #111; }
  .auth-container input {
    width: 100%; padding: 10px 12px; margin-bottom: 14px;
    border: 1px solid #ccc; border-radius: 6px; font-size: 0.9rem;
  }
  .auth-container button {
    width: 100%; padding: 12px; background: var(--blue-accent); color: #fff;
    border: none; border-radius: 6px; font-weight: 600; cursor: pointer;
  }
  .auth-msg-error { color: #dc2626; margin-bottom: 14px; font-size: 0.85rem; }
  .auth-msg-ok { color: #16a34a; margin-bottom: 14px; font-size: 0.85rem; }
  .auth-container p { margin-top: 16px; font-size: 0.85rem; color: #444; }
  .auth-container a { color: var(--blue-accent); }
</style>

<div class="auth-container">
  <h1>Crear cuenta</h1>

  <?php if ($resultado): ?>
    <p class="<?php echo $resultado['exito'] ? 'auth-msg-ok' : 'auth-msg-error'; ?>">
      <?php echo htmlspecialchars($resultado['mensaje']); ?>
    </p>
  <?php endif; ?>

  <form method="POST">
    <input type="text" name="cedula" placeholder="Cédula" required>
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="apellido" placeholder="Apellido" required>
    <input type="email" name="correo" placeholder="Correo electrónico" required>
    <input type="tel" name="telefono" placeholder="Teléfono">
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Crear cuenta</button>
  </form>

  <p>¿Ya tienes cuenta? <a href="Login.php">Inicia sesión</a></p>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>