    <!-- Section newsletter -->
    <section class="newsletter">
      <div>
        <h2>Abonnez-vous à <br /> notre newsletter gratuite</h2>
        <input type="email" placeholder="Votre e-mail">
        <button>S’abonner</button>
      </div>
      <img src="<?php echo get_template_directory_uri(); ?>/assets/image_f2dd471c.png" alt="Newsletter illustration">
    </section>

    <!-- Footer principal -->
    <footer>
      <div class="footer-top">
        <div class="footer-logo">
          <a class="logo-link" <?php echo esc_url(home_url('/')); ?>>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_blanc.png" alt="Logo">
          </a>
          <h4>Onoris Journal</h4>
          <p><?php echo get_theme_mod('onoris_home_slogan'); ?></p>
          <img src="<?php echo get_template_directory_uri(); ?>/assets/Social.svg" alt="Social media">
        </div>

        <div class="footer-column">
            <h4>Nos liens utiles</h4>
            <?php
                wp_nav_menu([
                'theme_location' => 'footer-useful',
                'container' => false,
                'menu_class' => '', // tu peux ajouter une classe CSS ici si besoin
                ]);
            ?>
        </div>

        <div class="footer-column">
            <h4>À propos</h4>
            <?php
                wp_nav_menu([
                'theme_location' => 'footer-about',
                'container' => false,
                'menu_class' => '', // tu peux ajouter une classe CSS ici si besoin
                ]);
            ?>
        </div>

        <div class="footer-column">
            <h4>Nous suivre</h4>
            <?php
                wp_nav_menu([
                'theme_location' => 'footer-follow',
                'container' => false,
                "menu_class" => '', // tu peux ajouter une classe CSS ici si besoin
                ]);
            ?>
        </div>
      </div>
    </footer>

    <!-- Footer bas -->
    <div class="footer-bottom">
      <img src="<?php echo get_template_directory_uri(); ?>/components/Logo OJ blanc.png" alt="Logo">
      <ul>
        <li><a href="#">Mentions légales</a></li>
        <li><a href="#">Charte de modération</a></li>
        <li><a href="#">CGV / GCU</a></li>
        <li><a href="#">Confidentialité</a></li>
        <li><a href="#">Copyright</a></li>
        <li><a href="#">Politique de Cookies</a></li>
        <li><a href="#">Plan du site</a></li>
      </ul>
    </div>

    <?php wp_footer(); ?>
  </body>
</html>