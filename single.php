<?php get_header(); ?>

<main class="article-layout">
    <div class="article-container">
        <div class="article-content">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <h2 class="article-title"><?php the_title(); ?></h2>

            <p class="article-intro">
            <?php echo get_the_excerpt(); ?>
            </p>

            <div class="article-image-container">
                <?php if (has_post_thumbnail()) : ?>
                <img src="<?php echo get_the_post_thumbnail_url(null, 'large'); ?>" alt="<?php the_title_attribute(); ?>" class="article-image">
                <?php endif; ?>
            </div>

            <div class="article-meta">
            <strong>OJ</strong> Onoris Journal — <time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('j F Y \à H\hi'); ?></time>
            </div>

            <div class="article-body">
            <?php the_content(); ?>
            </div>

            
            <?php
            $custom_author = get_post_meta(get_the_ID(), '_onoris_custom_author', true);
            if ($custom_author) {
                echo '<p class="article-author">' . esc_html($custom_author) . '</p>';
            }
            ?>

        <?php endwhile; endif; ?>

        <?php
        $total_views = get_post_meta(get_the_ID(), '_onoris_total_views', true);
        echo '<span class="views-count">Nombre de vues : ' . intval($total_views) . '</span>';
        ?>

        </div>

        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>