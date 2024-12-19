<?php get_header(); ?>

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
                    <a href="<?php echo home_url('/recept'); ?>">Recept</a>
                    <?php if (is_tax('recipe_category') || is_tax('recipe_tag')) : ?>
                        <span class="separator">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6" />
                            </svg>
                        </span>
                        <span class="current"><?php single_term_title(); ?></span>
                    <?php endif; ?>
                </nav>

                <!-- Header -->
                <header class="archive-header">
                    <?php
                    if (is_post_type_archive('recipe')) {
                        echo '<h1>Alla Recept</h1>';
                    } elseif (is_tax()) {
                        echo '<h1>' . single_term_title('', false) . '</h1>';
                    }
                    ?>
                </header>

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

            <!-- Fallback ifall inga recept hittas -->
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