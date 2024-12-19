<?php
/**
 * Template Name: Full Width
 * Template Post Type: page
 */

get_header(); ?>

<div class="page-container">
    <main class="full-width-content">
        <?php while (have_posts()) : the_post(); ?>
            <article class="page-content">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <div class="content-area">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </main>
</div>

<?php get_footer(); ?>