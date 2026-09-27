<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: Login.php');
    exit;
}

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/UsuarioController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new UsuarioController($db);

$usuarioId = $_SESSION['usuario_id'];
$mensajeDatos = null;
$mensajePassword = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['actualizar_datos'])) {
        $mensajeDatos = $controller->actualizarPerfil(
            $usuarioId,
            trim($_POST['nombre']),
            trim($_POST['apellido']),
            trim($_POST['correo']),
            trim($_POST['telefono'])
        );

        if ($mensajeDatos['exito']) {
            $_SESSION['usuario_nombre'] = trim($_POST['nombre']);
        }
    }

    if (isset($_POST['cambiar_password'])) {
        $mensajePassword = $controller->cambiarPassword(
            $usuarioId,
            $_POST['password_actual'],
            $_POST['password_nueva']
        );
    }
}

$usuario = $controller->obtenerDatos($usuarioId);

$tituloPagina = 'Vokter - Mi perfil';
require_once __DIR__ . '/partials/header.php';
?>

<style>
  .perfil-container { max-width: 560px; margin: 60px auto; padding: 32px; color: #111; }
  .perfil-container h1 { font-size: 1.5rem; margin-bottom: 8px; }
  .perfil-container h2 { font-size: 1.1rem; margin: 32px 0 16px; }
  .perfil-container input {
    width: 100%; padding: 10px 12px; margin-bottom: 14px;
    border: 1px solid #ccc; border-radius: 6px; font-size: 0.9rem;
  }
  .perfil-container label { font-size: 0.8rem; color: #555; display: block; margin-bottom: 4px; }
  .perfil-container button {
    padding: 12px 20px; background: var(--blue-accent); color: #fff;
    border: none; border-radius: 6px; font-weight: 600; cursor: pointer;
  }
  .perfil-msg-exito { color: #16a34a; margin-bottom: 14px; font-size: 0.85rem; }
  .perfil-msg-error { color: #dc2626; margin-bottom: 14px; font-size: 0.85rem; }
  .perfil-container a { color: var(--blue-accent); }
  .perfil-divider { border: none; border-top: 1px solid #ddd; margin: 32px 0; }
</style>

<div class="perfil-container">
  <h1>Mi perfil</h1>
  <p><a href="MisCompras.php">Ver mis compras &rarr;</a></p>

  <h2>Datos personales</h2>

  <?php if ($mensajeDatos): ?>
    <p class="<?php echo $mensajeDatos['exito'] ? 'perfil-msg-exito' : 'perfil-msg-error'; ?>">
      <?php echo htmlspecialchars($mensajeDatos['mensaje']); ?>
    </p>
  <?php endif; ?>

  <form method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>

    <label for="correo">Correo</label>
    <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>

    <label for="telefono">Teléfono</label>
    <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>">

    <button type="submit" name="actualizar_datos">Guardar cambios</button>
  </form>

  <hr class="perfil-divider">

  <h2>Cambiar contraseña</h2>

  <?php if ($mensajePassword): ?>
    <p class="<?php echo $mensajePassword['exito'] ? 'perfil-msg-exito' : 'perfil-msg-error'; ?>">
      <?php echo htmlspecialchars($mensajePassword['mensaje']); ?>
    </p>
  <?php endif; ?>

  <form method="POST">
    <label for="password_actual">Contraseña actual</label>
    <input type="password" id="password_actual" name="password_actual" required>

    <label for="password_nueva">Contraseña nueva</label>
    <input type="password" id="password_nueva" name="password_nueva" required minlength="6">

    <button type="submit" name="cambiar_password">Cambiar contraseña</button>
  </form>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>