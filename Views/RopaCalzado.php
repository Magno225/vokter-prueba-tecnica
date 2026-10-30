<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/ProductoController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new ProductoController($db);

// Categoría 2 = Ropa y Calzado
$productos = $controller->listarPorCategoria(2);

$tituloPagina = 'Vokter - Catálogo Ropa y Calzado';

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

.sort-section {
  padding: 32px 48px 8px;
  background: #ffffff;
}
.sort-section .sort-title {
  font-size: 0.85rem; font-weight: 700; color: #666;
  text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;
}
.sort-options { display: flex; justify-content: space-between; width: 100%; }
.sort-option {
  font-size: 1.5rem; font-weight: 800; color: #444;
  cursor: pointer; transition: color 0.2s ease;
}
.sort-option:hover { color: var(--blue-accent); }

 .hero-carousel {
  position: relative;
  overflow: hidden;
  background: var(--bg-hero);
  height: 700px;
  flex-shrink: 0;
}

.hero-slide {
  width: 33.3333%;
  flex-shrink: 0;
  height: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  align-items: stretch;
}

.hero-image {
  height: 700px;
  overflow: hidden;
  align-self: center;
}
.hero-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.hero-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(0,0,0,0.4);
  color: #fff;
  border: none;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  font-size: 1rem;
  cursor: pointer;
  z-index: 5;
  display: flex;
  align-items: center;
  justify-content: center;
}
.hero-arrow:hover { background: rgba(0,0,0,0.65); }
.hero-arrow-prev { left: 16px; }
.hero-arrow-next { right: 16px; }

.hero-text {
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 60px 48px 40px;
}

.btn-primary{
  background: #0c53e9;
  color: #ffffff;
  width: 160px;
  height: 50px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  padding: 10px 20px;
  font-size: 16px; 
  font-weight: bold; 
}

.hero-track {
  display: flex;
  width: 300%;
  height: 100%;
  transition: transform 0.6s ease;
}

.hero-text .eyebrow { color: var(--blue-light); font-style: italic; font-size: 1.7rem; margin-bottom: 12px; }
.hero-text h1 { font-size: 4.3rem; font-weight: 2000; line-height: 1.15; margin-bottom: 20px; }
.hero-text h2 { font-size: 4.3rem; font-weight: 2000; line-height: 1.15; margin-bottom: 20px; color: var(--text-white); }
.hero-text p { color: var(--text-gray); font-size: 1.25rem; max-width: 420px; margin-bottom: 28px; line-height: 1.5; }

</style>

<section class="hero-carousel">
  <div class="hero-track">

    <div class="hero-slide">
      <div class="hero-text">
        <p class="eyebrow">Sé mejor, sé tu mismo.</p>
        <h1>Conjuntos Deportivos<br>Al Mejor Precio.</h1>
        <p>Conoce nuestros nuevos conjuntos deportivos disponibles para dama y caballero en todas las tallas.</p>              
        <a href="Tecnologia.php" class="btn-primary">Conoce más</a>
      </div>
      <div class="hero-image">
        <img src="../Images/Fotos/PromocionalesRopaCalzado/Sudaderas.jpg" alt="Sudaderas para dama y caballero" class="hero-img">
      </div>
    </div>

    <div class="hero-slide">
      <div class="hero-text">
        <p class="eyebrow">¿Te gusta? ¡Presumelo!</p>
        <h1>Zapatillas para Dama<br>Nuevo Modelo Disponible.</h1>
        <p>Conoce las nuevos diseños en calzado para dama, modelos pensados para el rendimiento y estilo.</p>
        <a href="RopaCalzado.php" class="btn-primary">Conoce más</a>
      </div>
      <div class="hero-image">
        <img src="../Images/Fotos/PromocionalesRopaCalzado/TenisMujer.jpg" alt="Imagen publicitaria de tenis para dama" class="hero-img">
      </div>
    </div>

    <div class="hero-slide">
      <div class="hero-text">
        <p class="eyebrow">Actua, ¡gana!.</p>
            <h1>Tu proxima aventura <br>¡Te espera!<br>Nuevas botas de Senderismo,<br>Para Hombre</h1>
            <p>Conoce nuestras nuevo modelo de botas para Senderismo, preparadas para lo que sea.</p>
        <a href="Hogar.php" class="btn-primary">Conoce más</a>
      </div>
      <div class="hero-image">
        <img src="../Images/Fotos/PromocionalesRopaCalzado/BotasHombreVerdes.jpg" alt="Botas de senderismo para hombre" class="hero-img">      </div>
    </div>

      <div class="hero-slide">
      <div class="hero-text">
        <p class="eyebrow">Ve por tus metas, ¡Ve por todo!</p>
        <h1>Conjunto Deportivo <em>Para Dama</em><br>con un 100% Algodón</h1>
        <p>Conoce todo nuestro catálogo en accesorios, diseñados para la comodidad y estilo.</p>
        <a href="Hogar.php" class="btn-primary">Conoce más</a>
      </div>
      <div class="hero-image">
        <img src="../Images/Fotos/PromocionalesRopaCalzado/SudaderaMujer.jpg" alt="Sudadera para dama" class="hero-img">      </div>
    </div>

  </div>

  <button class="hero-arrow hero-arrow-prev" id="hero-prev" aria-label="Hero anterior">&#10094;</button>
  <button class="hero-arrow hero-arrow-next" id="hero-next" aria-label="Hero siguiente">&#10095;</button>
</section>

<h1 class="page-heading">Catálogo Ropa y Calzado</h1>

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

<div class="sort-options">
  <span class="sort-option" id="sort-precio-bajo">Precio más bajo</span>
  <span class="sort-option" id="sort-calificacion">Mejores calificados</span>
  <span class="sort-option" id="sort-reciente">Lo más reciente</span>
</div>

<div class="products">
    <?php foreach ($productos as $producto): ?>
        <a href="producto.php?id=<?php echo $producto['id']; ?>" class="product-card-link" data-precio="<?php echo $producto['precio_base']; ?>" data-id="<?php echo $producto['id']; ?>">            <div class="product-card">
                <div class="product-image-placeholder">
                    <span class="badge-new">NEW</span>
                    <span class="badge-rating">4.5</span>
                    <img src="<?php echo $producto['imagen_url'] ? htmlspecialchars($producto['imagen_url']) : '/projectVokter/Images/Fotos/RopaCalzadoProductos/placeholder.jpg'; ?>" 
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

  const botonPrecioBajo = document.getElementById('sort-precio-bajo');
if (botonPrecioBajo) {
  botonPrecioBajo.addEventListener('click', function() {
    const contenedor = document.querySelector('.products');
    const tarjetas = Array.from(contenedor.querySelectorAll('.product-card-link'));

    tarjetas.sort(function(a, b) {
      return parseFloat(a.dataset.precio) - parseFloat(b.dataset.precio);
    });

    tarjetas.forEach(function(tarjeta) {
      contenedor.appendChild(tarjeta);
    });
  });
}

(function() {
  const track = document.querySelector('.hero-track');
  const slides = document.querySelectorAll('.hero-slide');
  const dots = document.querySelectorAll('#hero-dots .dot');
  const prevBtn = document.getElementById('hero-prev');
  const nextBtn = document.getElementById('hero-next');
  const total = slides.length;
  track.style.width = (total * 100) + '%';
  slides.forEach(function(s) { s.style.width = (100 / total) + '%'; });
  let current = 0;
  let intervalId;

  function irASlide(indice) {
    current = (indice + total) % total;
    track.style.transform = 'translateX(-' + (current * (100 / total)) + '%)';
    dots.forEach(function(dot, i) {
      dot.classList.toggle('active', i === current);
    });
  }

  function siguiente() { irASlide(current + 1); }
  function anterior() { irASlide(current - 1); }

  function iniciarAutoRotacion() {
    intervalId = setInterval(siguiente, 6000);
  }

  function reiniciarAutoRotacion() {
    clearInterval(intervalId);
    iniciarAutoRotacion();
  }

  nextBtn.addEventListener('click', function() {
    siguiente();
    reiniciarAutoRotacion();
  });

  prevBtn.addEventListener('click', function() {
    anterior();
    reiniciarAutoRotacion();
  });

  dots.forEach(function(dot) {
    dot.addEventListener('click', function() {
      irASlide(parseInt(dot.dataset.index, 10));
      reiniciarAutoRotacion();
    });
  });

  iniciarAutoRotacion();
})();
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>