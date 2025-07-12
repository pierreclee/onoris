<?php get_header(); ?>


<main>
    <section class="latest-block">
        <div class="content-wrapper">
        <section class="latest-articles" id="latest-articles">
            <h2>Nos derniers articles</h2>
            <div class="posts">
                <?php
                $query = new WP_Query([
                'posts_per_page' => 3 // change le nombre si besoin
                ]);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post(); ?>

                    <article class="post">
                        <div class="post-thumbnail">
                            <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                            <?php else : ?>
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/default-thumbnail.jpg" alt="<?php the_title_attribute(); ?>">
                            </a>
                            <?php endif; ?>
                        </div>

                        <header class="entry-header">
                            <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="entry-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
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
                    </article>

                <?php
                endwhile;
                wp_reset_postdata();
                endif;
                ?>
            </div>
        </section>
        <aside class="sidebar">
            <section class="popular" id="popular">
                <h3>Les plus lus</h3>
                <?php
                $month = date('Y-m');
                $month_key = '_onoris_views_' . $month;
                $popular_query = new WP_Query([
                    'posts_per_page' => 3,
                    'meta_key' => $month_key,
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                    'ignore_sticky_posts' => true
                ]);
                if ($popular_query->have_posts()) :
                    echo '<ul class="popular-this-month">';
                    while ($popular_query->have_posts()) : $popular_query->the_post();
                        $views = get_post_meta(get_the_ID(), $month_key, true);
                        ?>
                        <li>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </li>
                    <?php endwhile;
                    echo '</ul>';
                    wp_reset_postdata();
                else :
                    echo '<ul><li>Aucun article populaire ce mois-ci.</li></ul>';
                endif;
                ?>
            </section>
            <section class="dossiers">
            <ul class="dossier-list">
                <li>
                <img src="assets/icon-dossier-special.svg" alt="">
                <div>
                    <strong>Dossier spécial</strong><br>
                    <span>Inflation mondiale</span>
                </div>
                </li>
                <li>
                <img src="assets/icon-dossier.svg" alt="">
                <div>
                    <strong>Dossier</strong><br>
                    <span>Israël-Palestine</span>
                </div>
                </li>
                <li>
                <img src="assets/icon-focus.svg" alt="">
                <div>
                    <strong>Focus</strong><br>
                    <span>Le capitalisme vert</span>
                </div>
                </li>
            </ul>
            </section>
        </aside>
        </div>
    </section>

    <section class="editor-picks" id="editor-picks">
        <h2>La rédaction</h2>
        <div>
        <?php
        $redac_query = new WP_Query([
            'category_name' => 'la-redaction', // slug de ta catégorie
            'posts_per_page' => 3
        ]);

        if ($redac_query->have_posts()) :
            while ($redac_query->have_posts()) : $redac_query->the_post(); ?>
                <article>
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>">
                    </div>
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/default-thumbnail.jpg" alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>
                    <h3>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <p>
                        <small>
                            <strong>
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    echo esc_html($categories[0]->name);
                                }
                                ?>
                            </strong>
                            | <?php the_time('j F Y'); ?>
                        </small>
                    </p>
                </article>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo "<p>Aucun article trouvé dans la rédaction.</p>";
        endif;
        ?>
        </div>
    </section>

    <section class="donation-call">
        <h2><?php echo get_theme_mod('onoris_home_donnation_title') ?></h2>
        <p><?php echo get_theme_mod('onoris_home_donnation_subtitle'); ?></p>
        <button><?php echo get_theme_mod('onoris_home_donnation_button'); ?></button>
    </section>

    <section class="section-block">
        <div class="content-row">
        <section class="biographies" id="biographies">
            <h2>Un jour, une biographie</h2>

            <div class="posts">
                <?php
                $bio_query = new WP_Query([
                    'category_name' => 'biographies',
                    'posts_per_page' => 3
                ]);

                if ($bio_query->have_posts()) :
                    while ($bio_query->have_posts()) : $bio_query->the_post(); ?>

                        <article class="post">
                        <div class="post-thumbnail">
                            <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                            <?php else : ?>
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/default-thumbnail.jpg" alt="<?php the_title_attribute(); ?>">
                            </a>
                            <?php endif; ?>
                        </div>

                        <header class="entry-header">
                            <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="entry-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
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
                    </article>

                <?php
                endwhile;
                wp_reset_postdata();
                endif;
                ?>
            </div>
        </section>

        <aside class="sidebar">
            <section class="poll">
            <h3>Sondage</h3>
            <h4>Pensez-vous que l’UE est prête à une défense commune ?</h4>
            <form>
                <label><input type="radio" name="ue-defense"> Oui</label><br>
                <label><input type="radio" name="ue-defense"> Non</label><br>
                <label><input type="radio" name="ue-defense"> Ne sait pas</label>
            </form>
            <button>Voir les résultats</button>
            </section>
            <section class="submit-article">
            <h3>Vous avez une plume ?</h3>
            <p>Publiez vos articles sur Onoris</p>
            <button>Nous contacter</button>
            </section>
        </aside>
        </div>
    </section>

    <section class="finance-feature" id="finance-feature">
        <div class="finance-banner">
        <div class="finance-overlay">
            <div class="finance-label">Dossier finance</div>
            <h2>Finance contemporaine : instruments, enjeux et dérives</h2>
            <div class="finance-button-container">
            <a href="#" class="btn-discover">Découvrir</a>
            </div>  
        </div>
        </div>
    </section>

    <section class="partners">
        <h2><?php echo get_theme_mod('onoris_home_partners_title') ?></h2>
        <div class="partner-list">
        <div>
            <span><?php echo get_theme_mod('onoris_home_partner1') ?></span>
            <span><?php echo get_theme_mod('onoris_home_partner2') ?></span>
        </div>
        <div>
            <span><?php echo get_theme_mod('onoris_home_partner3') ?></span>
            <span><?php echo get_theme_mod('onoris_home_partner4') ?></span>
        </div>
        <div>
            <span><?php echo get_theme_mod('onoris_home_partner5') ?></span>
            <span><?php echo get_theme_mod('onoris_home_partner6') ?></span>
        </div>
        </div>
    </section>
</main>
</main>


<?php get_footer(); ?>