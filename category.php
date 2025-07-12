<?php get_header(); ?>

<main class="category-layout">
    <div class="category-header">
        <h1 class="category-title">Catégorie : <?php single_cat_title(); ?></h1>
        <p class="category-description"><?php echo category_description(); ?></p>
    </div>

    <div class="category-posts">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="post horizontal-post">
            <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium'); ?>
                <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/default-thumbnail.jpg" alt="<?php the_title_attribute(); ?>">
                <?php endif; ?>
            </a>
            </div>
            <div class="post-content">
            <header class="entry-header">
                <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <div class="entry-excerpt">
                <?php the_excerpt(); ?>
                </div>
                <div class="entry-meta">
                <span class="cat-links">
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) {
                        echo esc_html($categories[0]->name);
                    }
                    ?>
                </span> — 
                <time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('j F Y'); ?></time>
                </div>
            </header>
            </div>
        </article>
        <?php endwhile; else : ?>
        <p>Aucun article trouvé dans cette catégorie.</p>
        <?php endif; ?>
    </div>

    <div class="pagination">
        <?php the_posts_pagination(); ?>
    </div>
</main>

<?php get_footer(); ?>