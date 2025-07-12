<?php get_header(); ?>

<main class="fallback-layout">
    <div class="fallback-container">

        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article class="fallback-post">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="fallback-meta">
                Publié le <time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('j F Y'); ?></time>
                dans <?php the_category(', '); ?>
            </div>
            <div class="fallback-excerpt">
                <?php the_excerpt(); ?>
            </div>
            </article>
        <?php endwhile; ?>

        <div class="pagination">
            <?php the_posts_pagination(); ?>
        </div>

        <?php else : ?>
        <p>Aucun contenu à afficher pour le moment.</p>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>