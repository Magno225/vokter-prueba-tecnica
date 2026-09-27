<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$tituloPagina = 'Vortek - La Mejor Tecnología';
require_once __DIR__ . '/partials/header.php';

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/ProductoController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new ProductoController($db);
$productos = $controller->listarTodos();
?>

<style>
 .hero-carousel {
  position: relative;
  overflow: hidden;
  background: var(--bg-hero);
  height: 650px;
  flex-shrink: 0;
}

.hero-track {
  display: flex;
  width: 300%;
  height: 100%;
  transition: transform 0.6s ease;
}

.hero-slide {
  width: 33.3333%;
  flex-shrink: 0;
  height: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  align-items: stretch;
}

.hero-text {
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 60px 48px 40px;
}
.hero-text .eyebrow { color: var(--blue-light); font-style: italic; font-size: 1.7rem; margin-bottom: 12px; }
.hero-text h1 { font-size: 4.3rem; font-weight: 2000; line-height: 1.15; margin-bottom: 20px; }
.hero-text p { color: var(--text-gray); font-size: 1.25rem; max-width: 420px; margin-bottom: 28px; line-height: 1.5; }

.hero-image {
  height: 650px;
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

.hero-dots { display: flex; gap: 8px; padding: 0 48px 36px; background: var(--bg-hero); }
.hero-dots .dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: var(--text-gray); opacity: 0.4; cursor: pointer;
  transition: background 0.3s ease, opacity 0.3s ease;
}
.hero-dots .dot.active { background: var(--blue-light); opacity: 1; }
  .dot { width: 20px; height: 8px; border-radius: 4px; background: var(--text-gray); opacity: 0.4; }
  .dot.active { background: var(--blue-light); opacity: 1; }

  .trust-bar {
    background: #ffffff; display: flex; flex-wrap: wrap; justify-content: space-around;
    gap: 24px; padding: 32px 48px; border-bottom: 1px solid #eee;
  }
  .trust-item { display: flex; align-items: center; gap: 12px; color: #111; flex: 1 1 200px; }
  .trust-item h4 { font-size: 0.9rem; margin-bottom: 4px; color: #111; }
  .trust-item p { font-size: 0.75rem; color: #777; }
  .nav-icon2 { width: 40px; height: 40px; object-fit: contain; }

  .products { display: flex; flex-wrap: wrap; gap: 20px; padding: 40px 48px 60px; background: #ffffff; }
  .product-card {
    flex: 1 1 260px; max-width: 280px; background: var(--card-bg); border-radius: 12px;
    overflow: visible; position: relative; color: #fff; z-index: 1; cursor: pointer;
  }
  .product-card:hover { z-index: 30; }
  .product-image-placeholder {
    background: rgba(255,255,255,0.04); height: 160px; display: flex; align-items: center;
    justify-content: center; color: var(--text-gray); font-size: 0.85rem; position: relative;
    overflow: hidden; border-radius: 12px 12px 0 0;
    transition: transform 0.35s ease, box-shadow 0.35s ease; transform-origin: center bottom;
  }
  .product-image-placeholder:hover {
    transform: scale(1.5); overflow: visible; box-shadow: 0 20px 40px rgba(0,0,0,0.5);
  }
  .product-img {
    width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;
    border-radius: 12px 12px 0 0; transition: transform 0.3s ease, border-radius 0.35s ease;
  }
  .product-image-placeholder:hover .product-img {
    object-fit: contain; background: var(--card-bg); border-radius: 12px;
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

  @media (max-width: 900px) { .hero { grid-template-columns: 1fr; } }

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
  transition: trasform 0.3s ease , box-shadow 0.3s ease;
  text-decoration: none;
  display: block;

}

.category-banner--tecnologia{
 background-image: url('../Images/Fotos/Fondos/Tecnologia.jpg');
  background-size: cover;
  background-position: center;
}

.category-banner--ropa{
 background-image: url('../Images/Fotos/Fondos/RopaCalzado.jpg');
  background-size: cover;
  background-position: center;
}

.category-banner--hogar{
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

.category-banner:hover {
  transform: scale(1.03);
  box-shadow: 0 12px 30px rgba(0,0,0,0.3);
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

</style>

<section class="hero-carousel">
  <div class="hero-track">

    <div class="hero-slide">
      <div class="hero-text">
        <p class="eyebrow">Sé mejor, sé tu mismo.</p>
        <h1>La Mejor Tecnología.<br>Al Mejor Precio.</h1>
        <p>Conoce todo nuestro catálogo en accesorios, diseñados para el rendimiento y estilo.</p>
        <button class="btn-primary">Conoce más</button>
      </div>
      <div class="hero-image">
        <img src="../Images/Fotos/FondosPrincipales/HeroTecnologia.jpg" alt="Audífonos y tecnología Vokter" class="hero-img">
      </div>
    </div>

    <div class="hero-slide">
      <div class="hero-text">
        <p class="eyebrow">Sé mejor, sé tú misma.</p>
        <h1>Conjuntos Deportivos<br>Disponibles en Todas las Tallas.</h1>
        <p>Conoce todo nuestro catálogo en accesorios, diseñados para el rendimiento y estilo.</p>
    <button class="btn-primary">Conoce más</button>
      </div>
      <div class="hero-image">
        <img src="../Images/Fotos/FondosPrincipales/HeroRopa.jpg" alt="Conjuntos deportivos Vokter" class="hero-img">
      </div>
    </div>

    <div class="hero-slide">
      <div class="hero-text">
        <p class="eyebrow">Sé mejor, duerme mejor.</p>
        <h1>Sábanas <em>Star Home</em><br>con un 100% Algodón</h1>
        <p>Conoce todo nuestro catálogo en accesorios, diseñados para la comodidad y estilo.</p>
        <button class="btn-primary">Conoce más</button>
      </div>
      <div class="hero-image">
        <img src="../Images/Fotos/FondosPrincipales/HeroHogar.jpg" alt="Sábanas Star Home" class="hero-img">      </div>
    </div>

  </div>

  <button class="hero-arrow hero-arrow-prev" id="hero-prev" aria-label="Hero anterior">&#10094;</button>
  <button class="hero-arrow hero-arrow-next" id="hero-next" aria-label="Hero siguiente">&#10095;</button>
</section>

<div class="hero-dots" id="hero-dots">
  <span class="dot active" data-index="0"></span>
  <span class="dot" data-index="1"></span>
  <span class="dot" data-index="2"></span>
</div>

<section class="trust-bar">
  <div class="trust-item">
    <img src="../Images/icons/entrega-rapida.png" class="nav-icon2" alt="icono de camión">
    <div><h4>Envió Rapido</h4><p>Gratis en referencias seleccionadas</p></div>
  </div>
  <div class="trust-item">
    <img src="../Images/icons/seguridad-activada.png" class="nav-icon2" alt="icono de escudo">
    <div><h4>Compra Segura</h4><p>Garantía de 30 días en todas tus compras</p></div>
  </div>
  <div class="trust-item">
    <img src="../Images/icons/corazon.png" class="nav-icon2" alt="icono de mano con corazón">
    <div><h4>Devoluciones</h4><p>Conoce nuestros términos y condiciones</p></div>
  </div>
  <div class="trust-item">
    <img src="../Images/icons/apoyo.png" class="nav-icon2" alt="icono de Asistencia">
    <div><h4>Asistencia</h4><p>Comunícate con nosotros en cualquier momento.</p></div>
  </div>
</section>

<section class="category-banners">
  <a href="Tecnologia.php" class="category-banner category-banner--tecnologia">
  <h2>Catálogo de Tecnología</h2>
</a>
  <a  href="Tecnologia.php" class="category-banner category-banner--ropa">
    <h2>Catálogo Ropa y Calzado</h2>
  </a>
  <div class="category-banner category-banner--hogar">
    <h2>Productos del Hogar</h2>
  </div>
</section>

<div class="sort-section">
  <p class="sort-title">Ordenar por:</p>
  <div class="sort-options">
    <span class="sort-option" id="sort-precio-bajo">Precio más bajo</span>
    <span class="sort-option" id="sort-calificacion">Mejores calificados</span>
    <span class="sort-option" id="sort-reciente">Lo más reciente</span>
  </div>
</div>

<div class="products">
    <?php foreach ($productos as $producto): ?>
        <a href="producto.php?id=<?php echo $producto['id']; ?>" class="product-card-link" data-precio="<?php echo $producto['precio_base']; ?>" data-id="<?php echo $producto['id']; ?>">
            <div class="product-card">
                <div class="product-image-placeholder" data-images="<?php echo htmlspecialchars(implode('|', array_column($producto['imagenes'], 'url'))); ?>">
                    <span class="badge-new">NEW</span>
                    <span class="badge-rating">4.5</span>
                    <img src="<?php echo $producto['imagen_url'] ? htmlspecialchars($producto['imagen_url']) : '/projectVokter/Images/Fotos/TecnologiaProductos/placeholder.jpg'; ?>" 
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
  document.querySelectorAll('.product-image-placeholder').forEach(function(placeholder) {
    const rutas = placeholder.dataset.images.split('|').filter(function(r) { return r.length > 0; });
    const img = placeholder.querySelector('.product-img');
    if (rutas.length <= 1) return;
    let index = 0;
    let intervalo = null;
    placeholder.addEventListener('mouseenter', function() {
      intervalo = setInterval(function() {
        index = (index + 1) % rutas.length;
        img.src = rutas[index];
      }, 900);
    });
    placeholder.addEventListener('mouseleave', function() {
      clearInterval(intervalo);
      index = 0;
      img.src = rutas[0];
    });
  });

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

(function() {
  const track = document.querySelector('.hero-track');
  const slides = document.querySelectorAll('.hero-slide');
  const dots = document.querySelectorAll('#hero-dots .dot');
  const prevBtn = document.getElementById('hero-prev');
  const nextBtn = document.getElementById('hero-next');
  const total = slides.length;
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