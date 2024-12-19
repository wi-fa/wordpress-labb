<?php get_header(); ?>

<!-- Författarsida -->
<div class="page-container">
    <div class="content-with-sidebar">
        <main class="recipes-grid">
            <?php
            // Hämtar all data från författaren från url-slug
            $author = get_user_by('slug', get_query_var('author_name'));
            $author_id = $author->ID;

            // Paginering och query för recepten
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'author' => $author_id,
                'post_type' => 'recipe',
                'paged' => $paged,
                'posts_per_page' => 10
            );

            $author_recipes = new WP_Query($args);

            if ($author_recipes->have_posts()) : ?>
                <!-- Breadcrumbs -->
                <nav class="breadcrumbs">
                    <a href="<?php echo home_url(); ?>">Hem</a>
                    <span class="separator">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </span>
                    <a href="<?php echo home_url('/recept'); ?>">Recept</a>
                    <span class="separator">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </span>
                    <span class="current"><?php echo get_the_author_meta('display_name', $author_id); ?></span>
                </nav>

                <!-- Header med avatar och namn -->
                <header class="archive-header">
                    <div class="author-info">
                        <div class="author-avatar">
                            <?php echo get_avatar($author_id, 100); ?>
                        </div>
                        <div class="author-details">
                            <h1><?php echo get_the_author_meta('display_name', $author_id); ?></h1>
                            <?php if (get_the_author_meta('description', $author_id)) : ?>
                                <p class="author-bio"><?php echo nl2br(get_the_author_meta('description', $author_id)); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </header>

                <div class="recipes-container">
                    <?php while ($author_recipes->have_posts()) : $author_recipes->the_post();
                        get_template_part('template-parts/content/recipe-card');
                    endwhile; ?>
                </div>

                <!-- Paginering för recept grid -->
                <?php
                $big = 999999999;
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $author_recipes->max_num_pages
                ));
                ?>

            <!-- Fallback ifall inga recept finns -->
            <?php else : ?>
                <p><?php _e('Inga recept hittades från denna författare.', 'familjekoket'); ?></p>
            <?php
            endif;
            wp_reset_postdata();
            ?>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <?php get_template_part('template-parts/components/recipe-sidebar'); ?>
        </aside>
    </div>
</div>

<?php get_footer(); ?>