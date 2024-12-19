<?php
/**
 * Template Name: Sidomeny Höger
 * Template Post Type: page
 */

get_header(); ?>

<div class="page-container">
    <div class="content-with-sidebar">
        <main class="main-content">
            <article class="page-content">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <div class="content-area">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; endif; ?>
                </div>
            </article>
        </main>

        <aside class="sidebar">
            <nav class="side-navigation">
                <h2>Undersidor</h2>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'sidebar-menu',
                    'menu_class' => 'sidebar-menu',
                    'container' => false,
                ));
                ?>
            </nav>
        </aside>
    </div>
</div>

<?php get_footer(); ?>