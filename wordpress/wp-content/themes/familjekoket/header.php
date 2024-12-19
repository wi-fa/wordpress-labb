<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <!-- Navbar med logo, hamburger ikon och blog länk -->
    <nav class="navbar">
        <div class="first-row">
            <?php get_template_part('template-parts/components/logo'); ?>
            <?php get_template_part('template-parts/navigation/hamburger'); ?>
            <a class="blog-link" href="/recept">Blog</a>
        </div>
    </nav>

    <!-- Fullscreen meny med navigation och senaste recept i desktopmode -->
    <div class="fullscreen-menu">
        <div class="menu-content">
            <div class="menu-left">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'primary-menu',
                    'container' => 'nav'
                ));
                ?>
            </div>
            <div class="menu-right">
                <div class="latest-recipes">
                    <h3>Senaste Recepten</h3>
                    <?php
                    $latest_recipes = new WP_Query(array(
                        'post_type' => 'recipe',
                        'posts_per_page' => 2,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));

                    if ($latest_recipes->have_posts()) :
                        while ($latest_recipes->have_posts()) : $latest_recipes->the_post();
                    ?>
                            <div class="recipe-preview">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="recipe-image">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="recipe-info">
                                    <h4>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                            <?php
                                            $categories = get_the_terms(get_the_ID(), 'recipe_category');
                                            if ($categories && !is_wp_error($categories)) :
                                            ?>
                                                <span class="recipe-category"><?php echo $categories[0]->name; ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <!-- Fullscreen-meny-footer -->
        <footer class="footerContainerz">
            <div class="footerMain">
                <div class="subscribe">
                    <h3>Prenumerera<br>på vårat nyhetsbrev</h3>
                    <p>Senaste nytt, meddelanden och de<br>senaste uppdateringarna direkt i din inkorg.</p>
                    <button class="subscribe-button">
                        <span>→</span>
                    </button>
                </div>

                <div class="footerContent">
                    <!-- Kategorier -->
                    <div class="listContainer">
                        <span>Recept</span>
                        <ul>
                            <?php
                            $recipe_categories = get_terms([
                                'taxonomy' => 'recipe_category',
                                'name' => ['Bakning', 'Frukost', 'Lunch', 'Middagar'],
                                'hide_empty' => false
                            ]);
                            foreach ($recipe_categories as $category) {
                                echo '<li><a href="' . site_url('/recept/kategori/') . $category->slug . '">' . esc_html($category->name) . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>

                    <!-- Specialkost -->
                    <div class="listContainer">
                        <span>Specialkost</span>
                        <ul>
                            <?php
                            $diet_tags = get_terms([
                                'taxonomy' => 'recipe_tag',
                                'name' => ['Barnvänligt', 'Glutenfritt'],
                                'hide_empty' => false
                            ]);
                            foreach ($diet_tags as $tag) {
                                echo '<li><a href="' . site_url('/recept/tag/') . $tag->slug . '">' . esc_html($tag->name) . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="listContainer">
                        <span>Support</span>
                        <ul>
                            <?php
                            $pages = get_pages([
                                'post_type' => 'page',
                                'post_status' => 'publish',
                                'sort_column' => 'menu_order'
                            ]);

                            foreach ($pages as $page) {
                                if (in_array($page->post_name, ['integritet', 'kontakt', 'om-oss'])) {
                                    echo '<li><a href="' . get_permalink($page->ID) . '">' . $page->post_title . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="listContainer">
                        <span>Social</span>
                        <ul>
                            <li><a href="https://instagram.com">Instagram</a></li>
                            <li><a href="https://facebook.com">Facebook</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="footerFoot">
                <p>Familjeköket.</p>
                <p>All rights reserved</p>
            </div>
        </footer>
        <?php wp_footer(); ?>
    </div>