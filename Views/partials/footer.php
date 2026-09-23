  <!-- ===================== FOOTER ===================== -->
  <footer class="site-footer">
    <div class="footer-top">
      <div class="footer-brand">
        <div class="footer-logo"><span class="logo">VOKTER</span></div>
        <p class="footer-description">
          Ecosistema premium de rendimiento y tecnología urbana. Sneakers, gadgets y gear esencial.
        </p>
      </div>
      <div class="footer-column">
        <h4>◻ Tienda</h4>
        <ul>
          <li><a href="#">Todos los productos</a></li>
          <li><a href="#">Footwear</a></li>
          <li><a href="#">Tech & Gadgets</a></li>
          <li><a href="#">Gear & Essentials</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h4>◻ Ayuda</h4>
        <ul>
          <li><a href="#">Contacto</a></li>
          <li><a href="#">Envíos</a></li>
          <li><a href="#">Devoluciones</a></li>
          <li><a href="#">FAQ</a></li>
        </ul>
      </div>
      <div class="footer-column footer-social-column">
        <h4>◻ Redes</h4>
        <div class="social-icons">
          <a href="https://www.instagram.com/vokter" target="_blank" class="social-icon">
            <img src="../Images/icons/instagram.png" class="nav-icon" alt="icono de instagram.">
          </a>
          <a href="https://www.tiktok.com/@vokter" target="_blank" class="social-icon">
            <img src="../Images/icons/tik-tok.png" class="nav-icon" alt="icono de tik-tok.">
          </a>
        </div>
        <h4>◻ Newsletter</h4>
        <p class="newsletter-text">Suscríbete para recibir drops exclusivos.</p>
        <div class="newsletter-form">
          <input type="email" placeholder="tu@email.com" class="newsletter-input">
          <button class="btn-subscribe">SUSCRIBIR</button>
        </div>
      </div>
    </div>

    <div class="footer-divider"><span></span><span class="divider-dot"></span><span></span></div>

    <div class="footer-bottom">
      <p>© 2026 VOKTER. Todos los derechos reservados.</p>
      <p>John Alejandro Celis - Ingeniero de Software de la UMB.</p>
      <div class="footer-legal">
        <a href="#">Privacidad</a>
        <a href="#">Términos</a>
      </div>
    </div>
  </footer>

  <style>
    /* ===================== FOOTER (estilos) ===================== */
    .site-footer { background: var(--bg-hero); color: var(--text-white); padding: 50px 48px 30px; }
    .footer-top { display: grid; grid-template-columns: 1.3fr 1fr 1fr 1.3fr; gap: 32px; margin-bottom: 40px; }
    .footer-logo .logo { color: var(--blue-light); font-size: 1.3rem; font-weight: 800; letter-spacing: 2px; }
    .footer-description { color: var(--text-gray); font-size: 0.85rem; line-height: 1.6; margin-top: 14px; max-width: 280px; }
    .footer-column h4 {
      color: var(--blue-light); font-size: 0.75rem; font-weight: 700;
      letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 16px;
    }
    .footer-column ul { list-style: none; display: flex; flex-direction: column; gap: 12px; }
    .footer-column a { color: var(--text-gray); text-decoration: none; font-size: 0.85rem; }
    .footer-column a:hover { color: var(--blue-light); }
    .social-icons { display: flex; gap: 12px; margin-bottom: 30px; }
    .social-icon {
      width: 38px; height: 38px; border: 1px solid var(--border-subtle);
      border-radius: 8px; display: flex; align-items: center; justify-content: center;
    }
    .newsletter-text { color: var(--text-gray); font-size: 0.85rem; margin-bottom: 14px; }
    .newsletter-form { display: flex; gap: 8px; }
    .newsletter-input {
      flex: 1; padding: 10px 14px; border-radius: 6px; border: 1px solid var(--border-subtle);
      background: rgba(255,255,255,0.03); color: var(--text-white); font-size: 0.85rem;
    }
    .newsletter-input::placeholder { color: var(--text-gray); }
    .btn-subscribe {
      background: var(--blue-accent); color: #fff; border: none; padding: 10px 18px;
      border-radius: 6px; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.5px;
      cursor: pointer; white-space: nowrap;
    }
    .footer-divider { display: flex; align-items: center; gap: 10px; margin-bottom: 24px; }
    .footer-divider span:not(.divider-dot) { flex: 1; height: 1px; background: var(--border-subtle); }
    .divider-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--blue-light); flex: none; }
    .footer-bottom { display: flex; justify-content: space-between; align-items: center; font-size: 0.78rem; color: var(--text-gray); }
    .footer-legal { display: flex; gap: 24px; }
    .footer-legal a { color: var(--text-gray); text-decoration: none; }
    .footer-legal a:hover { color: var(--blue-light); }

    @media (max-width: 900px) {
      nav ul { display: none; }
      .footer-top { grid-template-columns: 1fr 1fr; }
      .footer-bottom { flex-direction: column; gap: 12px; text-align: center; }
    }
  </style>

  <script>
    const searchTrigger = document.getElementById('search-trigger');
    const searchPanel = document.getElementById('search-panel');

    searchTrigger.addEventListener('click', function(event) {
      searchPanel.classList.toggle('active');
      event.stopPropagation();
    });

    document.addEventListener('click', function(event) {
      if (!searchPanel.contains(event.target) && event.target !== searchTrigger) {
        searchPanel.classList.remove('active');
      }
    });
  </script>

</body>
</html>