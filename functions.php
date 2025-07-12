<?php



// =========================
// Enqueue styles and scripts
// =========================



function onoris_enqueue_assets() {
      // Fichier de base obligatoire pour WordPress
wp_enqueue_style('onoris-style', get_stylesheet_uri());

// Ton vrai CSS (assets/css/main.css)
wp_enqueue_style(
    'onoris-main-style',
    get_template_directory_uri() . '/assets/css/main.css',
    [],
    filemtime(get_template_directory() . '/assets/css/main.css') // version = cache bust
);

  // Ton JS (optionnel)
wp_enqueue_script(
    'onoris-script',
    get_template_directory_uri() . '/assets/js/scripts.js',
    [],
    filemtime(get_template_directory() . '/assets/js/scripts.js'),
    true // charge en footer
);
}
add_action('wp_enqueue_scripts', 'onoris_enqueue_assets');



// =========================
// Support et fonctionnalités du thème
// =========================



// Support image à la une
add_theme_support('post-thumbnails');

// Menus
register_nav_menus([
    'main-menu' => 'Menu principal',
    'secondary-menu' => 'Menu Thémtique',
    'footer-useful' => 'Footer - Liens utiles',
    'footer-about' => 'Footer - À propos',
    'footer-follow' => 'Footer - Nous suivre'
]);

// Charger les polices Google
// Remplace les liens par ceux que tu veux utiliser

wp_enqueue_style(
  'onoris-google-fonts',
  'https://fonts.googleapis.com/css2?family=Jaldi&family=Frank+Ruhl+Libre&display=swap',
  [],
  null
);



// =========================
// Custom post type pour les articles
// =========================



// Custom post type pour les biographies
function register_biographies_cpt() {
    register_post_type('biographie', [
        'labels' => [
        'name' => 'Biographies',
        'singular_name' => 'Biographie',
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-id',
        'supports' => ['title', 'editor', 'thumbnail'],
    ]);
}
add_action('init', 'register_biographies_cpt');



// =========================
// Custom author pour les articles
// =========================



// Ajouter une metabox "Auteur"
function onoris_add_custom_author_metabox() {
    add_meta_box(
        'onoris_custom_author',                // ID unique
        'Auteur de l\'article',                 // Titre de la metabox
        'onoris_custom_author_callback',       // Fonction de rendu
        'post',                                // Post type
        'side',                                // Position (normal, side)
        'default'                              // Priorité
    );
}
add_action('add_meta_boxes', 'onoris_add_custom_author_metabox');

// Fonction de rendu de la metabox
function onoris_custom_author_callback($post) {
    wp_nonce_field('onoris_save_custom_author', 'onoris_custom_author_nonce');
    $author = get_post_meta($post->ID, '_onoris_custom_author', true);
    echo '<input type="text" name="onoris_custom_author" value="' . esc_attr($author) . '" style="width:100%;" />';
}

// Sauvegarde de l'auteur personnalisé
function onoris_save_custom_author($post_id) {
    if (!isset($_POST['onoris_custom_author_nonce']) ||
        !wp_verify_nonce($_POST['onoris_custom_author_nonce'], 'onoris_save_custom_author')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['onoris_custom_author'])) {
        update_post_meta($post_id, '_onoris_custom_author', sanitize_text_field($_POST['onoris_custom_author']));
    }
}
add_action('save_post', 'onoris_save_custom_author');





// =========================
// Customizer pour la page d'accueil
// =========================

function onoris_customize_register($wp_customize) {


    $wp_customize->add_panel('onoris_home_panel', [
        'title'       => "Personnalisation de la page d'accueil",
        'description' => "Modifiez les contenus de la page d'accueil",
        'priority'    => 10,
    ]);

    // Section pour la section d'informations générales
    // Ajoute une section pour la section d'informations générales dans le panel de personnalisation
    $wp_customize->add_section('onoris_home_general', [
        'title'    => 'Informations générales',
        'panel'    => 'onoris_home_panel', // 👈 rattache au panel
        'priority' => 1,
    ]);


    $wp_customize->add_setting('onoris_home_slogan', [
        'default' => 'Le média par les étudiants, pour les étudiants',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('onoris_home_slogan', [
        'label'    => 'Slogan principal',
        'section'  => 'onoris_home_general',
        'type'     => 'text'
    ]);



    // Section pour la section de donnation
    // Ajoute une section pour la section de donnation dans le panel de personnalisation
    $wp_customize->add_section('onoris_donnation_section', [
        'title'    => 'Section Donnation',
        'panel'    => 'onoris_home_panel', // 👈 rattache au panel
        'priority' => 1,
    ]);


    $wp_customize->add_setting('onoris_home_donnation_title', [
        'default' => 'Le média par les étudiants, pour les étudiants',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('onoris_home_donnation_title', [
        'label'    => 'Titre Section Donnation',
        'section'  => 'onoris_donnation_section',
        'type'     => 'text'
    ]);

    $wp_customize->add_setting('onoris_home_donnation_subtitle', [
        'default' => 'Soutenez Onoris dès 1 € et faites vivre un journal libre et indépendant',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('onoris_home_donnation_subtitle', [
        'label'    => 'Sous-titre Section Donnation',
        'section'  => 'onoris_donnation_section',
        'type'     => 'text'
    ]);

    $wp_customize->add_setting('onoris_home_donnation_button', [
        'default' => 'Faire un don',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('onoris_home_donnation_button', [
        'label'    => 'Bouton Section Donnation',
        'section'  => 'onoris_donnation_section',
        'type'     => 'text'
    ]);



    // Section pour la section de partenaires
    // Ajoute une section pour la section de partenaires dans le panel de personnalisation
    $wp_customize->add_section('onoris_partners_section', [
        'title'    => 'Section Partenaires',
        'panel'    => 'onoris_home_panel', // 👈 rattache au panel
        'priority' => 1,
    ]);


    $wp_customize->add_setting('onoris_home_partners_title', [
        'default' => 'TOUS NOS PARTENAIRES',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('onoris_home_partners_title', [
        'label'    => 'Titre de la section Partenaires',
        'section'  => 'onoris_partners_section',
        'type'     => 'text'
    ]);
    $wp_customize->add_setting('onoris_home_partner1', [
        'default' => 'Partenaire 1',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('onoris_home_partner1', [
        'label'    => 'Nom du partenaire 1',
        'section'  => 'onoris_partners_section',
        'type'     => 'text'
    ]);
    $wp_customize->add_setting('onoris_home_partner2', [
        'default' => 'Partenaire 2',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('onoris_home_partner2', [
        'label'    => 'Nom du partenaire 2',
        'section'  => 'onoris_partners_section',
        'type'     => 'text'
    ]);
    $wp_customize->add_setting('onoris_home_partner3', [
        'default' => 'Partenaire 3',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('onoris_home_partner3', [
        'label'    => 'Nom du partenaire 3',
        'section'  => 'onoris_partners_section',
        'type'     => 'text'
    ]);
    $wp_customize->add_setting('onoris_home_partner4', [
        'default' => 'Partenaire 4',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('onoris_home_partner4', [
        'label'    => 'Nom du partenaire 4',
        'section'  => 'onoris_partners_section',
        'type'     => 'text'
    ]);
    $wp_customize->add_setting('onoris_home_partner5', [
        'default' => 'Partenaire 5',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('onoris_home_partner5', [
        'label'    => 'Nom du partenaire 5',
        'section'  => 'onoris_partners_section',
        'type'     => 'text'
    ]);
    $wp_customize->add_setting('onoris_home_partner6', [
        'default' => 'Partenaire 6',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('onoris_home_partner6', [
        'label'    => 'Nom du partenaire 6',
        'section'  => 'onoris_partners_section',
        'type'     => 'text'
    ]);
}
add_action('customize_register', 'onoris_customize_register');



// =========================
// Analytics
// =========================



// Page d'analytics dans le menu admin
function onoris_add_analytics_page() {
    add_menu_page(
        'Analytics Onoris',
        'Analytics',
        'manage_options',
        'onoris-analytics',
        'onoris_render_analytics_page',
        'dashicons-chart-bar',
        4
    );
}
add_action('admin_menu', 'onoris_add_analytics_page');

// Chargement Chart.js pour la page d'analytics
function onoris_admin_enqueue($hook) {
    if ($hook != 'toplevel_page_onoris-analytics') return;
    wp_enqueue_script(
        'chartjs',
        'https://cdn.jsdelivr.net/npm/chart.js',
        [],
        null,
        true
    );
}
add_action('admin_enqueue_scripts', 'onoris_admin_enqueue');

// Suivi des vues de la page d'accueil
function onoris_track_homepage_views() {
    if (is_front_page()) {
        $home_id = get_option('page_on_front'); // ID de la page d’accueil
        // Total global
        $views = get_post_meta($home_id, '_onoris_home_views_total', true);
        $views = $views ? $views + 1 : 1;
        update_post_meta($home_id, '_onoris_home_views_total', $views);
        // Par mois
        $month = date('m/Y');
        $month_key = '_onoris_home_views_' . $month;
        $mviews = get_post_meta($home_id, $month_key, true);
        $mviews = $mviews ? $mviews + 1 : 1;
        update_post_meta($home_id, $month_key, $mviews);
        // Par jour
        $day = date('d/m/Y');
        $days_array = get_post_meta($home_id, '_onoris_home_views_days', true);
        if (!is_array($days_array)) $days_array = [];
        $days_array[$day] = isset($days_array[$day]) ? $days_array[$day] + 1 : 1;
        update_post_meta($home_id, '_onoris_home_views_days', $days_array);
    }
}
add_action('wp', 'onoris_track_homepage_views');




function onoris_render_analytics_page() {
    
    // Affichage des vues de la page d'accueil
    $home_id = get_option('page_on_front');

        // Vues globales
        $total = get_post_meta($home_id, '_onoris_home_views_total', true);

        // Vues du mois
        $month = date('m/Y');
        $month_key = '_onoris_home_views_' . $month;
        $month_total = get_post_meta($home_id, $month_key, true);

        // Vues du jour
        $day = date('d/m/Y');
        $days_array = get_post_meta($home_id, '_onoris_home_views_days', true);
        $today_total = (is_array($days_array) && isset($days_array[$day])) ? $days_array[$day] : 0;
    

    // Total global (toutes les vues de tous les articles)
    global $wpdb;
    $total_views = $wpdb->get_var(
        "SELECT SUM(CAST(meta_value AS UNSIGNED)) 
        FROM {$wpdb->postmeta} 
        WHERE meta_key = '_onoris_total_views'"
    );

    // Total des vues aujourd'hui (toutes les vues de tous les articles)
    $today = date('d/m/Y');
    $total_today = 0;
    $posts = get_posts([
        'post_type' => 'post',
        'posts_per_page' => -1,
        'fields' => 'ids'
    ]);
    foreach ($posts as $pid) {
        $days_array = get_post_meta($pid, '_onoris_views_days', true);
        if (is_array($days_array) && isset($days_array[$today])) {
            $total_today += (int)$days_array[$today];
        }
    }

    // Total du mois sélectionné (toutes les vues sur tous les articles ce mois)
    $month = isset($_GET['analytics_month']) ? $_GET['analytics_month'] : date('m/Y');
    $month_key = '_onoris_views_' . $month;
    $month_views = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT SUM(CAST(meta_value AS UNSIGNED))
            FROM {$wpdb->postmeta} 
            WHERE meta_key = %s",
            $month_key
        )
    );

    echo '<div class="analytics-global-stats" style="margin:30px 0;">';
    echo '<h2>Vue d’ensemble</h2>';
    echo "<p><strong>Accueil&nbsp;: $total vues au total, $month_total ce mois-ci, $today_total aujourd'hui</strong></p>";
    echo '<p><strong>Vues aujourd\'hui (' . $today . ') :</strong> ' . number_format($total_today) . '</p>';
    echo '<p><strong>Vues sur ' . $month . ' :</strong> ' . number_format($month_views) . '</p>';
    echo '<p><strong>Vues totales :</strong> ' . number_format($total_views) . '</p>';
    echo '</div>';


    // Top 5 des articles les plus lus (tous temps)
    $top_global = new WP_Query([
    'posts_per_page' => 5,
    'meta_key' => '_onoris_total_views',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    'ignore_sticky_posts' => true
    ]);
    echo '<h3>Top 5 des articles les plus lus (tous temps)</h3>';
    if ($top_global->have_posts()) {
        echo '<ol>';
        while ($top_global->have_posts()) : $top_global->the_post();
            $v = get_post_meta(get_the_ID(), '_onoris_total_views', true);
            echo '<li><a href="'.get_edit_post_link().'">' . get_the_title() . '</a> (' . intval($v) . ' vues)</li>';
        endwhile;
        echo '</ol>';
        wp_reset_postdata();
    } else {
        echo '<p>Aucun article trouvé.</p>';
    }

    // Top 5 des articles les plus lus ce mois
    $top_month = new WP_Query([
        'posts_per_page' => 5,
        'meta_key' => $month_key,
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'ignore_sticky_posts' => true
    ]);
    echo '<h3>Top 5 du mois ' . $month . '</h3>';
    if ($top_month->have_posts()) {
        echo '<ol>';
        while ($top_month->have_posts()) : $top_month->the_post();
            $v = get_post_meta(get_the_ID(), $month_key, true);
            echo '<li><a href="'.get_edit_post_link().'">' . get_the_title() . '</a> (' . intval($v) . ' vues)</li>';
        endwhile;
        echo '</ol>';
        wp_reset_postdata();
    } else {
        echo '<p>Aucun article ce mois.</p>';
    }



    // Répartition des vues par catégorie
    $categories = get_categories([
        'hide_empty' => false
    ]);

    echo '<h3>Répartition des vues par catégorie</h3>';
    echo '<table class="widefat fixed striped"><thead><tr><th>Catégorie</th><th>Vues totales</th><th>Vues sur '.$month.'</th></tr></thead><tbody>';

    foreach ($categories as $cat) {
        // 1. Récupérer tous les articles de la catégorie
        $posts_in_cat = get_posts([
            'category' => $cat->term_id,
            'posts_per_page' => -1,
            'fields' => 'ids'
        ]);
        $total = 0;
        $month_total = 0;
        foreach ($posts_in_cat as $pid) {
            $total += (int) get_post_meta($pid, '_onoris_total_views', true);
            $month_total += (int) get_post_meta($pid, $month_key, true);
        }
        echo '<tr>
            <td>' . esc_html($cat->name) . '</td>
            <td>' . number_format($total) . '</td>
            <td>' . number_format($month_total) . '</td>
        </tr>';
    }
    echo '</tbody></table>';



    // Sélection du mois et de l'article pour le graphe
    $month = date('m/Y');
    $month_key = '_onoris_views_' . $month;

    // Récupère la sélection (GET)
    $selected_post_id = isset($_GET['analytics_post_id']) ? intval($_GET['analytics_post_id']) : 0;

    // Génère la liste des articles les plus lus ce mois
    $popular = new WP_Query([
        'posts_per_page' => 20,
        'meta_key' => $month_key,
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'ignore_sticky_posts' => true,
        'fields' => 'ids'
    ]);

    echo '<div class="wrap"><h1>Analytics – Suivi d\'un article</h1>';

    // Cherche tous les mois où il existe des vues (stockées sous la clé _onoris_views_YYYY-MM)
    global $wpdb;
    $prefix = $wpdb->prefix . 'postmeta';
    $results = $wpdb->get_col(
        "SELECT DISTINCT REPLACE(meta_key, '_onoris_views_', '') 
        FROM $prefix 
        WHERE meta_key LIKE '_onoris_views_%' 
        ORDER BY meta_key DESC"
    );
    $available_months = array_filter($results, function($v) { return preg_match('/^\d{4}-\d{2}$/', $v); });

    // Valeur sélectionnée
    $selected_month = isset($_GET['analytics_month']) ? $_GET['analytics_month'] : date('m/Y');
    // Formulaire de sélection
    echo '<form method="get" action="">';
    echo '<input type="hidden" name="page" value="onoris-analytics">';

    // Choix du mois
    echo '<label for="analytics_month">Mois : </label>';
    echo '<select name="analytics_month" id="analytics_month" onchange="this.form.submit()">';
    foreach ($available_months as $m) {
        $selected = ($m === $selected_month) ? 'selected' : '';
        echo '<option value="'.$m.'" '.$selected.'>'.$m.'</option>';
    }
    echo '</select>';

    // Liste des articles
    echo '<label for="analytics_post_id"> Article : </label>';
    echo '<select name="analytics_post_id" id="analytics_post_id" onchange="this.form.submit()">';
    echo '<option value="">— Sélectionner —</option>';

    // Recherche les articles populaires pour le mois choisi
    $month_key = '_onoris_views_' . $selected_month;
    $popular = new WP_Query([
        'posts_per_page' => 20,
        'meta_key' => $month_key,
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'ignore_sticky_posts' => true,
        'fields' => 'ids'
    ]);

    foreach ($popular->posts as $pid) {
        $title = get_the_title($pid);
        $selected = ($pid == $selected_post_id) ? 'selected' : '';
        echo "<option value=\"$pid\" $selected>$title</option>";
    }
    echo '</select>';
    echo '</form>';

    // Si un article est sélectionné, afficher le graphe
    // Récupérer les données du mois sélectionné
if ($selected_post_id) {
    $days_array = get_post_meta($selected_post_id, '_onoris_views_days', true);
    if (!is_array($days_array)) $days_array = [];

        // Labels/données pour le mois sélectionné
        $year = substr($selected_month, 0, 4);
        $month_num = substr($selected_month, 5, 2);
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, intval($month_num), intval($year));

        $labels = [];
        $data = [];
        for ($i = 1; $i <= $days_in_month; $i++) {
            $day_str = $selected_month . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $labels[] = $day_str;
            $data[] = isset($days_array[$day_str]) ? (int)$days_array[$day_str] : 0;
        }
        echo '<h2>Évolution du trafic pour « ' . get_the_title($selected_post_id) . ' » (' . $selected_month . ')</h2>';
        echo '<canvas id="viewsChart" width="600" height="250"></canvas>';
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('viewsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [{
                        label: 'Vues par jour',
                        data: <?php echo json_encode($data); ?>,
                        borderColor: '#3480af',
                        backgroundColor: 'rgba(52,128,175,0.15)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                    legend: { display: false }
                    },
                    scales: {
                        x: { display: true, title: { display: true, text: 'Jour' }},
                        y: { display: true, title: { display: true, text: 'Vues' }}
                    }
                }
            });
        });
        </script>
        <?php
    }

    echo '</div>';
    wp_reset_postdata();
}



// Récupération des vues pour le graphe
function onoris_track_post_views() {
    if (!is_single()) return;

    $post_id = get_the_ID();

    // Compteur global
    $views = get_post_meta($post_id, '_onoris_total_views', true);
    $views = $views ? $views + 1 : 1;
    update_post_meta($post_id, '_onoris_total_views', $views);

    // Compteur par mois
    $month = date('m/Y');
    $month_key = '_onoris_views_' . $month;
    $mviews = get_post_meta($post_id, $month_key, true);
    $mviews = $mviews ? $mviews + 1 : 1;
    update_post_meta($post_id, $month_key, $mviews);

    // Compteur par jour (pour le graphe)
    $day = date('d/m');
    $days_array = get_post_meta($post_id, '_onoris_views_days', true);
    if (!is_array($days_array)) $days_array = [];
    $days_array[$day] = isset($days_array[$day]) ? $days_array[$day] + 1 : 1;
    update_post_meta($post_id, '_onoris_views_days', $days_array);
}
add_action('wp', 'onoris_track_post_views');


// Log des vues dans un fichier
function onoris_get_view_count($context = 'global', $id = null) {
    $file = WP_CONTENT_DIR . '/uploads/onoris_counters.json';
    if (!file_exists($file)) return 0;
    $json = file_get_contents($file);
    $data = json_decode($json, true);
    if ($id) {
        return isset($data[$context][$id]) ? (int)$data[$context][$id] : 0;
    }
    return isset($data[$context]) ? (int)$data[$context] : 0;
}

function onoris_increment_view_count($context = 'global', $id = null) {
    $file = WP_CONTENT_DIR . '/uploads/onoris_counters.json';
    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
        if (!is_array($data)) $data = [];
    } else {
        $data = [];
    }
    if ($id) {
        if (!isset($data[$context][$id])) $data[$context][$id] = 0;
        $data[$context][$id]++;
    } else {
        if (!isset($data[$context])) $data[$context] = 0;
        $data[$context]++;
    }
    file_put_contents($file, json_encode($data), LOCK_EX);
}

add_action('wp', function() {
    if (is_single()) {
        onoris_increment_view_count('post', get_the_ID());
    }
    if (is_front_page()) {
        onoris_increment_view_count('home');
    }
});