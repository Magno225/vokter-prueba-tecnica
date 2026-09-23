<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/ProductoController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new ProductoController($db);

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$producto = $controller->obtenerDetalle($id);

if (!$producto) {
    die('Producto no encontrado.');
}

$imagenes = $producto['imagenes'];
$variantes = $producto['variantes'];
$tituloPagina = 'Vokter - ' . $producto['nombre'];

//cuando los colores cambian.

$coloresUnicos = [];

foreach($variantes as $v){
    if(!in_array($v['color'],$coloresUnicos)){
      $coloresUnicos[] = $v['color']; 
    }
}

//Ordenalas segun su oreden de aparicion.

$tallasUnicas = [];
foreach ($variantes as $v) {
    if ($v['talla'] && !in_array($v['talla'], $tallasUnicas)) {
        $tallasUnicas[] = $v['talla'];
    }
}

// Mapa "color|talla" => ['stock' => X, 'variante_id' => Y]
$mapaVariantes = [];
foreach ($variantes as $v) {
    $clave = $v['color'] . '|' . $v['talla'];
    $mapaVariantes[$clave] = ['stock' => (int) $v['stock'], 'variante_id' => $v['id']];
}

// Mapa color => imagen (buscamos, para cada color, la primera imagen cuya variante tenga ese color)

$mapaImagenPorColor = [];
foreach ($variantes as $v) {
    if (isset($mapaImagenPorColor[$v['color']])) continue;
    foreach ($imagenes as $img) {
        if ($img['variante_id'] == $v['id']) {
            $mapaImagenPorColor[$v['color']] = $img['url'];
            break;
        }
    }
}

// Mapa color => código hex
$mapaColorHex = [];
foreach ($variantes as $v) {
    if (!isset($mapaColorHex[$v['color']])) {
        $mapaColorHex[$v['color']] = $v['color_hex'] ?? '#cccccc';
    }
}

$tituloPagina = 'Vokter - ' . $producto['nombre'];

require_once __DIR__ . '/partials/header.php';
?>

<style>
  /* ===================== PRODUCT DETAIL ===================== */
  .product-detail { max-width: 1200px; margin: 0 auto; padding: 30px 48px 60px; color: #111; }

  .breadcrumb { font-size: 0.85rem; color: #666; margin-bottom: 24px; }
  .breadcrumb a { color: var(--blue-accent); text-decoration: none; }
  .breadcrumb span { margin: 0 6px; }

  .detail-grid { display: grid; grid-template-columns: 480px 1fr 340px; gap: 32px; }

  .detail-gallery { display: flex; gap: 16px; }
  .thumbnail-list { display: flex; flex-direction: column; gap: 10px; }
  .thumbnail {
    width: 70px; height: 70px; border: 1px solid #ddd; border-radius: 6px;
    cursor: pointer; overflow: hidden;
  }
  .thumbnail img { width: 100%; height: 100%; object-fit: cover; }
  .thumbnail.active { border-color: var(--blue-accent); }

  .main-image {
    background: var(--bg-hero); border-radius: 12px; min-height: 420px;
    display: flex; align-items: center; justify-content: center;
    color: var(--text-gray); overflow: hidden; flex: 1;
  }
  .main-image img { width: 100%; height: 100%; object-fit: contain; }

  .detail-info h1 { font-size: 1.5rem; font-weight: 700; margin: 12px 0 10px; }

  .price-block { margin-bottom: 20px; }
  .price-current { font-size: 2rem; font-weight: 700; }

  .product-details h3 { font-size: 0.95rem; margin-bottom: 10px; }
  .product-details p { color: #444; font-size: 0.88rem; line-height: 1.7; }

  .purchase-card { border: 1px solid #eee; border-radius: 10px; padding: 20px; }
  .shipping-highlight { color: #16a34a; font-weight: 600; margin-bottom: 6px; }
  .shipping-link { font-size: 0.85rem; color: var(--blue-accent); margin-bottom: 18px; cursor: pointer; }
  .stock-label { font-size: 0.85rem; margin-bottom: 8px; }
  .quantity-select {
    width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; margin-bottom: 18px;
  }

  .btn-primary {
    background: var(--blue-accent); color: #fff; border: none; padding: 14px 28px;
    border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer;
  }
  .btn-secondary {
    background: #eaf1ff; color: var(--blue-accent); border: none; padding: 14px 28px;
    border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer;
  }
  .btn-full { width: 100%; margin-bottom: 12px; }

  .purchase-footer {
    margin-top: 18px; padding-top: 16px; border-top: 1px solid #eee;
    font-size: 0.82rem; color: #555; display: flex; flex-direction: column; gap: 8px;
  }

  @media (max-width: 900px) {
    .detail-grid { grid-template-columns: 1fr; }
    .detail-gallery { flex-direction: column; }
  }

  .color-dot {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    display: inline-block;
    cursor: pointer;
    border: 2px solid transparent;
  }

  .color-dot.active {
    border-color: var(--blue-accent);
  }
.talla-selector { margin-bottom: 24px; }
.talla-options { display: flex; gap: 8px; flex-wrap: wrap; }
.talla-btn {
  padding: 8px 16px; border: 1px solid #ccc; border-radius: 6px;
  background: #fff; cursor: pointer; font-size: 0.85rem;
}
.talla-btn.active { border-color: var(--blue-accent); background: #eaf1ff; color: var(--blue-accent); }
.stock-variante-info { font-size: 0.85rem; color: #16a34a; margin-bottom: 20px; }

.price-old {
  font-size: 0.85rem;
  color: #9ca3af;
  text-decoration: line-through;
  display: block;
  margin-bottom: 6px;
  font-weight: 500;
}
.discount-badge {
  color: #16a34a;
  font-weight: 600;
  font-size: 0.85rem;
  margin-bottom: 6px;
}

.category-banners {
  display: flex;
  gap: 20px;
  padding: 40px 48px 0;
  background: #ffffff;
}

.category-banners {
  display: flex;
  gap: 20px;
  padding: 40px 48px;
  background: #ffffff;
  max-width: 1200px;
  margin: 0 auto;
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

.explore-heading {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 48px;
  font-size: 1rem;
  font-weight: 700;
  color: #444;
}
</style>

<!-- ===================== PRODUCT DETAIL PAGE ===================== -->
<main class="product-detail">

  <nav class="breadcrumb">
    <a href="Principal.php">Inicio</a> <span>/</span>
    <span><?php echo htmlspecialchars($producto['nombre']); ?></span>
  </nav>

  <div class="detail-grid">

    <div class="detail-gallery">
      <div class="thumbnail-list">
        <?php foreach ($imagenes as $index => $img):
          $colorDeEstaImagen = '';
              foreach ($variantes as $v) {
                if ($v['id'] == $img['variante_id']) {
                  $colorDeEstaImagen = $v['color'];
                  break;
                }
              }
          ?>
          <div class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>" data-src="<?php echo htmlspecialchars($img['url']); ?>"
          data-color="<?php echo htmlspecialchars($colorDeEstaImagen); ?>"
          >
            <img src="<?php echo htmlspecialchars($img['url']); ?>" alt="Miniatura <?php echo $index + 1; ?>">
          </div>
        <?php endforeach; ?>
      </div>
      <div class="main-image">
        <?php if (!empty($imagenes)): ?>
          <img id="main-product-image" src="<?php echo htmlspecialchars($imagenes[0]['url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
        <?php else: ?>
          <h3 style="color: red;">¡Sin imagen disponible!</h3>
        <?php endif; ?>
      </div>
    </div>

  <div class="detail-info">
      <span class="badge-new">Nuevo</span>
      <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>

    <div class="price-block">
    <?php if ($producto['en_promocion']): 
      $precioDescuento = $producto['precio_base'] * (1 - $producto['descuento_porcentaje'] / 100);
    ?>
      <span class="price-old">$<?php echo number_format($producto['precio_base'], 0, ',', '.'); ?> COP</span>
      <p class="discount-badge">¡Este producto tiene un <?php echo (int) $producto['descuento_porcentaje']; ?>% de descuento!</p>
      <span class="price-current">$<?php echo number_format($precioDescuento, 0, ',', '.'); ?> COP</span>
    <?php else: ?>
      <span class="price-current">$<?php echo number_format($producto['precio_base'], 0, ',', '.'); ?> COP</span>
    <?php endif; ?>
  </div> 

      <?php if (!empty($variantes)): ?>
    <div class="color-selector">
      <p class="selector-label">Color: <strong id="color-seleccionado"><?php echo htmlspecialchars($coloresUnicos[0]); ?></strong></p>
      <div class="color-options">
        <?php foreach ($coloresUnicos as $index => $color): ?>
          <span class="color-dot <?php echo $index === 0 ? 'active' : ''; ?>" 
              data-color="<?php echo htmlspecialchars($color); ?>"
              data-image="<?php echo isset($mapaImagenPorColor[$color]) ? htmlspecialchars($mapaImagenPorColor[$color]) : ''; ?>"
              style="background: <?php echo htmlspecialchars($mapaColorHex[$color]); ?>;"
              title="<?php echo htmlspecialchars($color); ?>">
          </span>
        <?php endforeach; ?>
      </div>
    </div>

    <?php if (!empty($tallasUnicas)): ?>
      <div class="talla-selector">
        <p class="selector-label">Talla:</p>
        <div class="talla-options">
          <?php foreach ($tallasUnicas as $index => $talla): ?>
            <button type="button" class="talla-btn <?php echo $index === 0 ? 'active' : ''; ?>" data-talla="<?php echo htmlspecialchars($talla); ?>">
              <?php echo htmlspecialchars($talla); ?>
            </button>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <p class="stock-variante-info" id="stock-variante-info"></p>
  <?php endif; ?>

  <script>
    const mapaVariantes = <?php echo json_encode($mapaVariantes); ?>;
  </script>



      <div class="product-details">
        <h3>Descripción</h3>
        <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
      </div>
  </div>

      <div class="detail-purchase">
        <div class="purchase-card">
          <p class="shipping-highlight">🚚 Llega gratis mañana</p>
          <p class="shipping-link">Más detalles y formas de entrega</p>

          <p class="stock-label">Stock disponible: <span id="stock-disponible-numero"><?php echo $producto['stock_total']; ?></span> unidades</p>
          <select class="quantity-select" id="cantidad-select">
            <option value="1">1 unidad</option>
          </select>

          <button class="btn-primary btn-full">Comprar ahora</button>
          <form method="POST" action="AgregarCarrito.php" id="form-agregar-carrito">
            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
            <input type="hidden" name="variante_id" id="input-variante-id" value="">
            <input type="hidden" name="cantidad" id="input-cantidad" value="1">
            <button type="submit" class="btn-secondary btn-full">Agregar al carrito</button>
            <?php if (isset($_GET['agregado']) && $_GET['agregado'] == '1'): ?>
              <p style="color: #16a34a; font-weight: 600; font-size: 0.85rem; margin-bottom: 10px;">
                ✓ Producto agregado al carrito
              </p>
            <?php endif; ?>
          </form>

          <div class="purchase-footer">
            <p>✔ Devolución gratis dentro de 30 días</p>
            <p>🛡 Compra protegida</p>
            <p>🔧 12 meses de garantía con fábricantes</p>
          </div>
        </div>
      </div>

    </div>
</main>

<?php if (isset($_GET['agregado']) && $_GET['agregado'] == '1'): ?>
  <h3 class="explore-heading">¿Quieres seguir explorando?</h3>
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
<?php endif; ?>

<script>

  let colorActual = document.querySelector('.color-dot.active') ? document.querySelector('.color-dot.active').dataset.color : null;
  let tallaActual = document.querySelector('.talla-btn.active') ? document.querySelector('.talla-btn.active').dataset.talla : null;

  function obtenerVarianteIdActual() {
    if (!colorActual) return null;
    const clave = tallaActual ? (colorActual + '|' + tallaActual) : (colorActual + '|');
    return mapaVariantes[clave] ? mapaVariantes[clave].variante_id : null;
  }

  const formAgregar = document.getElementById('form-agregar-carrito');
  if (formAgregar) {
    formAgregar.addEventListener('submit', function(event) {
      const varianteId = obtenerVarianteIdActual();
      if (!varianteId) {
        event.preventDefault();
        alert('Selecciona un color/talla válido.');
        return;
      }
      document.getElementById('input-variante-id').value = varianteId;
      document.getElementById('input-cantidad').value = document.getElementById('cantidad-select').value;
    });
  }

  function actualizarStockInfo() {
    if (!colorActual || !tallaActual) return;
    const clave = colorActual + '|' + tallaActual;
    const info = document.getElementById('stock-variante-info');

    if (mapaVariantes[clave] && mapaVariantes[clave].stock > 0) {
      info.textContent = mapaVariantes[clave].stock + ' unidades disponibles';
      info.style.color = '#16a34a';
    } else {
      info.textContent = 'Esta combinación no está disponible';
      info.style.color = '#dc2626';
    }
  }

  function actualizarSelectCantidad() {
    const select = document.getElementById('cantidad-select');
    if (!select) return;

    let stockDisponible = <?php echo $producto['stock_total']; ?>; // valor por defecto si no hay variantes

    if (colorActual && tallaActual) {
      const clave = colorActual + '|' + tallaActual;
      stockDisponible = mapaVariantes[clave] ? mapaVariantes[clave].stock : 0;
    } else if (colorActual && !tallaActual) {
      // Producto solo con color (sin talla), como las sábanas
      const clave = colorActual + '|';
      stockDisponible = mapaVariantes[clave] ? mapaVariantes[clave].stock : 0;
    }

    const maximo = Math.min(stockDisponible, 10);
    select.innerHTML = '';

    if (maximo <= 0) {
      select.innerHTML = '<option value="0">Sin stock</option>';
      select.disabled = true;
      return;
    }

    select.disabled = false;
    for (let i = 1; i <= maximo; i++) {
      const option = document.createElement('option');
      option.value = i;
      option.textContent = i + (i > 1 ? ' unidades' : ' unidad');
      select.appendChild(option);
    }
  }

  document.querySelectorAll('.thumbnail').forEach(function(thumb) {
    thumb.addEventListener('click', function() {
      const nuevaRuta = thumb.dataset.src;
      document.getElementById('main-product-image').src = nuevaRuta;

      document.querySelectorAll('.thumbnail').forEach(function(t) {
        t.classList.remove('active');
      });
      thumb.classList.add('active');

      // Si esta miniatura tiene un color asociado, sincronizamos el selector de color
      if (thumb.dataset.color) {
        colorActual = thumb.dataset.color;
        document.getElementById('color-seleccionado').textContent = colorActual;

        document.querySelectorAll('.color-dot').forEach(function(dot) {
          dot.classList.toggle('active', dot.dataset.color === colorActual);
        });

        actualizarStockInfo();
      }
    });
  });

  document.querySelectorAll('.color-dot').forEach(function(dot) {
    dot.addEventListener('click', function() {
      colorActual = dot.dataset.color;
      document.getElementById('color-seleccionado').textContent = colorActual;

      if (dot.dataset.image) {
        document.getElementById('main-product-image').src = dot.dataset.image;
      }

      document.querySelectorAll('.color-dot').forEach(function(d) { d.classList.remove('active'); });
      dot.classList.add('active');

      actualizarStockInfo();
    });
  });

  document.querySelectorAll('.talla-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
      tallaActual = btn.dataset.talla;

      document.querySelectorAll('.talla-btn').forEach(function(b) { b.classList.remove('active'); });
      btn.classList.add('active');

      actualizarStockInfo();
    });
  });

  actualizarStockInfo();
  actualizarSelectCantidad();
  </script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>