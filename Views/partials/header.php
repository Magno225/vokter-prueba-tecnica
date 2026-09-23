<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($tituloPagina)) { $tituloPagina = 'Vokter'; }

$totalCarrito = 0;
if (isset($_SESSION['usuario_id'])) {
    require_once __DIR__ . '/../../Config/database.php';
    require_once __DIR__ . '/../../Models/carritoServer.php';
    $database = new Database();
    $db = $database->getConnection();
    $carritoModel = new Carrito($db);
    $totalCarrito = $carritoModel->contarItems($_SESSION['usuario_id']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($tituloPagina); ?></title>
<style>
  :root {
    --bg-dark: #0a0e1a;
    --bg-hero: #0d1421;
    --blue-accent: #2563eb;
    --blue-light: #38bdf8;
    --text-white: #ffffff;
    --text-gray: #a3adc2;
    --card-bg: #0f1626;
    --badge-new: #2563eb;
    --badge-rating: #22c55e;
    --price-color: #ffffff;
    --border-subtle: rgba(255,255,255,0.08);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  html, body { height: 100%; }

  body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #ffffff;
    color: var(--text-white);
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  main { flex: 1; }

  /* ===================== HEADER / NAV ===================== */
  header {
    background: var(--bg-dark);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 48px;
    border-bottom: 1px solid var(--border-subtle);
  }

  .logo { font-size: 1.6rem; font-weight: 800; letter-spacing: -0.5px; }
  nav ul { list-style: none; display: flex; align-items: center; gap: 54px; }
  nav a { color: var(--text-white); text-decoration: none; font-size: 0.95rem; font-weight: 500; }
  nav a:hover { color: var(--blue-light); }

  .nav-icons { display: flex; align-items: center; gap: 22px; }
  .nav-icon { width: 24px; height: 24px; object-fit: contain; cursor: pointer; }
  .icon-placeholder {
    width: 22px; height: 22px; display: inline-block;
    border: 1px dashed var(--text-gray); border-radius: 4px;
  }

  .search-menu { position: relative; }
  .search-panel {
    display: none; position: absolute; top: calc(100% + 14px); right: 0;
    background: var(--bg-dark); border: 1px solid var(--border-subtle);
    border-radius: 12px; padding: 20px 24px 24px; width: 480px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.4); z-index: 10;
  }
  .search-panel.active { display: block; }
  .search-input {
    width: 100%; padding: 12px 18px; border-radius: 24px; border: none;
    background: #ffffff; color: #111; font-size: 0.9rem; margin-bottom: 20px;
  }
  .categories-divider { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
  .categories-divider span { flex: 1; height: 1px; background: var(--border-subtle); }
  .categories-divider p {
    font-size: 0.8rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 1px; white-space: nowrap;
  }
  .categories-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
  .category-column h4 { font-size: 0.95rem; font-weight: 700; margin-bottom: 10px; }
  .category-column ul { list-style: none; }
  .category-column li {
    font-size: 0.8rem; color: var(--text-gray); padding: 4px 0 4px 14px;
    position: relative; cursor: pointer;
  }
  .category-column li::before { content: "•"; position: absolute; left: 0; color: var(--text-gray); }
  .category-column li:hover { color: var(--blue-light); }

  .user-menu { position: relative; }
  .user-menu-trigger {
    display: flex; align-items: center; gap: 8px; background: none; border: none;
    color: var(--text-white); font-size: 0.9rem; cursor: pointer;
  }
  .user-name { font-weight: 500; }
  .user-dropdown {
    display: none; position: absolute; top: 100%; left: 0;
    background: var(--card-bg); border: 1px solid var(--border-subtle);
    border-radius: 8px; padding: 14px 16px; min-width: 200px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3); z-index: 10;
  }
  .user-menu:hover .user-dropdown { display: block; }
  .dropdown-title {
    font-size: 0.75rem; color: var(--text-gray); text-transform: uppercase;
    letter-spacing: 0.5px; margin-bottom: 8px;
  }
  .dropdown-list { list-style: none; display: flex; flex-direction: column; gap: 10px; }
  .dropdown-list a { color: var(--text-white); text-decoration: none; font-size: 0.9rem; }
  .dropdown-list a:hover { color: var(--blue-light); }

  /* Las páginas que usen este header agregan aquí su propio <style> extra si lo necesitan */
</style>
</head>
<body>

  <!-- ===================== HEADER ===================== -->
  <header>
    <div class="logo">Vokter</div>
    <nav>
      <ul>
        <li><a href="Principal.php">Inicio</a></li>
        <li><a href="Principal.php">Tienda</a></li>
        <li><a href="Novedades.php">Novedades</a></li>
        <li><a href="#">Lo más vendido</a></li>
        <li><a href="#">Lo mejor calificado</a></li>
        <li><a href="Promociones.php">Promociones</a></li>
        <li><a href="#">Contactos</a></li>
        <?php if (isset($_SESSION['usuario_id'])): ?>
        <li><a href="/projectVokter/Views/MisCompras.php">Mis compras</a></li>
        <?php endif; ?>
      </ul>
    </nav>

    <div class="nav-icons">
      <div class="search-menu">
        <img src="../Images/icons/lupa.png" class="nav-icon" alt="icono de Lupa." id="search-trigger">
        <div class="search-panel" id="search-panel">
          
          <input type="text" class="search-input" placeholder="Buscar productos...">
          <div class="categories-divider"><span></span><p>Categorías</p><span></span></div>
          <div class="categories-grid">
            <div class="category-column">
              <h4>Tecnología</h4>
              <ul>
                <li><a href="Buscar.php?q=Audifonos">Audífonos</a></li>
                <li><a href="Buscar.php?q=Consola">Consolas de videojuegos</a></li>
                <li><a href="Buscar.php?q=Moto">Accesorios de moto y automóvil</a></li>
                <li><a href="Buscar.php?q=Parlante">Bocinas</a></li>
                <li><a href="Buscar.php?q=Power Bank">Power banks</a></li>
              </ul>
            </div>
            <div class="category-column">
              <h4>Ropa</h4>
              <ul><li>Sudaderas</li><li>Camisetas</li><li>Pantalones</li><li>Calzado</li></ul>
            </div>
            <div class="category-column">
              <h4>Hogar</h4>
              <ul><li>Sábanas</li><li>Star Home</li></ul>
            </div>
          </div>
        </div>
      </div>

      <a href="/projectVokter/Views/Carrito.php" style="position: relative; display: inline-block;">        <img src="../Images/icons/carrito-de-compras.png" class="nav-icon" alt="icono de Carrito de Compras.">
        <?php if ($totalCarrito > 0): ?>
          <span style="
            position: absolute; top: -6px; right: -8px;
            background: #dc2626; color: #fff; font-size: 0.65rem; font-weight: 700;
            width: 18px; height: 18px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
          "><?php echo $totalCarrito; ?></span>
        <?php endif; ?>
      </a>

      <div class="user-menu">
        <button class="user-menu-trigger">
          <img src="../Images/icons/avatar.png " class="nav-icon" alt="icono de usuario/avatar diponible a la vista en el header de la pg.">
          <!--<span class="icon-placeholder"></span>-->
          <span class="user-name">Hola, Alejandro</span>
        </button>
        <div class="user-dropdown">
          <p class="dropdown-title">Categorías</p>
          <ul class="dropdown-list">
            <li><a href="#">Tecnología</a></li>
            <li><a href="#">Ropa y Calzado</a></li>
            <li><a href="#">Ideal para el hogar</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>