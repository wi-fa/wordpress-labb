<?php
/**
 * Template Name: Bild Höger
 * Template Post Type: page
 */

get_header(); ?>

<div class="page-container">
    <div class="content-with-image">
        <main class="main-content">
            <article class="page-content">
                <?php if ($hero_title = get_field('hero_title')) : ?>
                    <h1 class="page-title"><?php echo $hero_title; ?></h1>
                <?php endif; ?>

                <?php if ($hero_description = get_field('hero_description')) : ?>
                    <div class="hero-description">
                        <p><?php echo $hero_description; ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($section_1_title = get_field('section_1_title')) : ?>
                    <div class="content-section">
                        <h2><?php echo $section_1_title; ?></h2>
                        <?php echo get_field('section_1_text'); ?>
                    </div>
                <?php endif; ?>
            </article>
        </main>

        <div class="featured-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>