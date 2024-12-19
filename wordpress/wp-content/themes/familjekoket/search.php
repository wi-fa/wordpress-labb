<?php get_header(); ?>

<!-- Söksida -->
<div class="page-container">
    <div class="content-with-sidebar">
        <main class="recipes-grid">
            <?php if (have_posts()) : ?>
                <!-- Breadcrumbs -->
                <nav class="breadcrumbs">
                    <a href="<?php echo home_url(); ?>">Hem</a>
                    <span class="separator">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </span>
                    <span class="current"><?php printf(__('Sökresultat för "%s"', 'familjekoket'), get_search_query()); ?></span>
                </nav>

                <!-- Header -->
                <header class="archive-header">
                    <h1><?php printf(__('Sökresultat för "%s"', 'familjekoket'), get_search_query()); ?></h1>
                </header>

                <!-- Recept-card/cards -->
                <div class="recipes-container">
                    <?php
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/content/recipe-card');
                    endwhile;
                    ?>
                </div>

                <?php the_posts_pagination(array(
                    'prev_text' => __('Föregående', 'familjekoket'),
                    'next_text' => __('Nästa', 'familjekoket'),
                )); ?>

            <!-- Fallback ifall inget hittas -->
            <?php else : ?>
                <p><?php _e('Inga recept hittades.', 'familjekoket'); ?></p>
            <?php endif; ?>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <?php get_template_part('template-parts/components/recipe-sidebar'); ?>
        </aside>
    </div>
</div>

<?php get_footer(); ?>