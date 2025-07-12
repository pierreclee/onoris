<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Jaldi&family=Frank+Ruhl+Libre&display=swap" rel="stylesheet">

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header>
  <div class="header-top">
    <button class="burger" aria-label="Menu">☰</button>

    <div class="mobile-menu">
      <button class="close-menu" aria-label="Fermer le menu">✕</button>
      <?php
        wp_nav_menu([
          'theme_location' => 'main-menu',
          'container' => false,
        ]);
      ?>
    </div>

    <div class="mobile-backdrop" id="mobile-backdrop"></div>
    <a class="logo-link" <?php echo esc_url(home_url('/')); ?>">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_noir.png" alt="Logo Onoris">
    </a>

    <nav class="menu desktop-menu">
      <?php
        wp_nav_menu([
          'theme_location' => 'main-menu',
          'container' => false,
          'menu_class' => '',
          'items_wrap' => '%3$s' // empêche WP d’ajouter <ul>
        ]);
      ?>
    </nav>

    <button class="connexion">Connexion</button>
  </div>

  <h1 class="logo"><?php bloginfo('name'); ?></h1>

  <div class="header-bottom">
    <?php
      wp_nav_menu([
        'theme_location' => 'secondary-menu',
        'container' => false,
        'menu_class' => '',
        'items_wrap' => '%3$s'
      ]);
    ?>
  </div>
</header>