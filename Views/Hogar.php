<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/ProductoController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new ProductoController($db);

// Categoría 3 = Hogar
$productos = $controller->listarPorCategoria(3);

$tituloPagina = 'Vokter - Catálogo de Hogar';
require_once __DIR__ . '/partials/header.php';
?>

<style>
  .category-banners {
    display: flex;
    gap: 20px;
    padding: 40px 48px 0;
    background: #ffffff;
  }

  .category-banner {
    flex: 1;
    background: var(--bg-hero);
    border-radius: 12px;
    padding: 24px;
    min-height: 230px;
    color: var(--text-white);
    position: relative;
    overflow: hidden;
    cursor: pointer;
    text-decoration: none;
    display: block;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .category-banner:hover {
    transform: scale(1.03);
    box-shadow: 0 12px 30px rgba(0,0,0,0.3);
  }

  .category-banner--tecnologia {
    background-image: url('../Images/Fotos/Fondos/Tecnologia.jpg');
    background-size: cover;
    background-position: center;
  }

  .category-banner--ropa {
    background-image: url('../Images/Fotos/Fondos/RopaCalzado.jpg');
    background-size: cover;
    background-position: center;
  }

  .category-banner--hogar {
    background-image: url('../Images/Fotos/Fondos/Hogar.jpg');
    background-size: cover;
    background-position: center;
  }

  .category-banner h2 {
    position: absolute;
    bottom: 24px;
    left: 24px;
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1.15;
    max-width: 80%;
    text-shadow: 0 2px 8px rgba(0,0,0,0.7);
  }

  .page-heading {
    padding: 40px 48px 0;
    font-size: 1.8rem;
    font-weight: 800;
    color: #111;
  }

  .products {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 40px 48px 60px;
    background: #ffffff;
  }

  .product-card {
    flex: 1 1 260px;
    max-width: 280px;
    background: var(--card-bg);
    border-radius: 12px;
    overflow: visible;
    position: relative;
    color: #fff;
    z-index: 1;
    cursor: pointer;
  }

  .product-card:hover { z-index: 30; }

  .product-image-placeholder {
    background: rgba(255,255,255,0.04);
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-gray);
    font-size: 0.85rem;
    position: relative;
    overflow: hidden;
    border-radius: 12px 12px 0 0;
    transition: transform 0.35s ease, box-shadow 0.35s ease;
    transform-origin: center bottom;
  }

  .product-image-placeholder:hover {
    transform: scale(1.5);
    overflow: visible;
    box-shadow: 0 20px 40px rgba(0,0,0,0.5);
  }

  .product-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 12px 12px 0 0;
    transition: transform 0.3s ease, border-radius 0.35s ease;
  }

  .product-image-placeholder:hover .product-img {
    object-fit: contain;
    background: var(--card-bg);
    border-radius: 12px;
  }

  .badge-new, .badge-rating { z-index: 2; }
  .badge-new {
    position: absolute; top: 10px; left: 10px; background: var(--badge-new); color: #fff;
    font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 4px;
  }
  .badge-rating {
    position: absolute; top: 10px; right: 10px; background: var(--badge-rating); color: #fff;
    font-size: 0.75rem; font-weight: 700; width: 30px; height: 30px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
  }

  .product-info { padding: 14px 16px 18px; }
  .product-info h3 { font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; line-height: 1.3; }
  .product-info .price { font-size: 0.9rem; font-weight: 600; color: var(--price-color); }
  .sort-section {
  padding: 32px 48px 8px;
  background: #ffffff;
}

.sort-section .sort-title {
  font-size: 0.85rem;
  font-weight: 700;
  color: #666;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 12px;
}

.sort-options {
  display: flex;
  justify-content: space-between;
  width: 100%;
}

.sort-option {
  font-size: 1.5rem;
  font-weight: 800;
  color: #444;
  cursor: pointer;
  transition: color 0.2s ease;
}

.sort-option:hover {
  color: var(--blue-accent);
}
</style>

<h1 class="page-heading">Catálogo de Hogar</h1>

<section class="category-banners">
  <a href="Tecnologia.php" class="category-banner category-banner--tecnologia">
    <h2>Catálogo de Tecnología</h2>
  </a>
  <a href="RopaCalzado.php" class="category-banner category-banner--ropa">
    <h2>Catálogo Ropa y Calzado</h2>
  </a>
  <a href="Hogar.php" class="category-banner category-banner--hogar">
    <h2>Productos del Hogar</h2>
  </a>
</section>

<div class="sort-section">
  <p class="sort-title">Ordenar por:</p>
  <div class="sort-options">
    <span class="sort-option">Precio más bajo</span>
    <span class="sort-option">Mejores calificados</span>
    <span class="sort-option">Lo más reciente</span>
  </div>
</div>

<div class="products">
    <?php foreach ($productos as $producto): ?>
        <a href="producto.php?id=<?php echo $producto['id']; ?>" class="product-card-link" data-id="<?php echo $producto['id']; ?>">>
            <div class="product-card">
                <div class="product-image-placeholder">
                    <span class="badge-new">NEW</span>
                    <span class="badge-rating">4.5</span>
                    <img src="<?php echo $producto['imagen_url'] ? htmlspecialchars($producto['imagen_url']) : '/projectVokter/Images/Fotos/HogarProductos/placeholder.jpg'; ?>" 
                         alt="Foto <?php echo htmlspecialchars($producto['nombre']); ?>" 
                         class="product-img">
                </div>
                <div class="product-info">
                    <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                    <p class="price">$<?php echo number_format($producto['precio_base'], 0, ',', '.'); ?> COP</p>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<script>
  document.getElementById('sort-precio-bajo').addEventListener('click', function() {
    const contenedor = document.querySelector('.products');
    const tarjetas = Array.from(contenedor.querySelectorAll('.product-card-link'));

    tarjetas.sort(function(a, b) {
      return parseFloat(a.dataset.precio) - parseFloat(b.dataset.precio);
    });

    tarjetas.forEach(function(tarjeta) {
      contenedor.appendChild(tarjeta);
    });
  });

  const botonReciente = document.getElementById('sort-reciente');
  if (botonReciente) {
    botonReciente.addEventListener('click', function() {
      const contenedor = document.querySelector('.products');
      const tarjetas = Array.from(contenedor.querySelectorAll('.product-card-link'));

      tarjetas.sort(function(a, b) {
        return parseInt(b.dataset.id) - parseInt(a.dataset.id);
      });

      tarjetas.forEach(function(tarjeta) {
        contenedor.appendChild(tarjeta);
      });
    });
  }
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>