<?php get_header(); ?>

<!-- Första sida -->
<div class="main-content">
    <div class="hero-wrapper">
        <div class="hero">
            <!-- Dynamisk hero bild ifrån ACF-fält skapade i admin -->
            <?php
            $hero_image = get_field('hero_image');
            if ($hero_image) : ?>
                <img src="<?php echo esc_url($hero_image); ?>" alt="Hero image" class="hero-img">
            <?php endif; ?>
            <div class="hero-text">
                <h1>Välkommen till</br> vårat härliga familjekök</h1>
                <a class="hero-btn" href="/recept/">Utforska recept</a>
            </div>
        </div>
    </div>

    <main class="site-main">
        <section class="feature-categories">
            <div class="container">
                <div class="category-blocks">
                    <!-- Huvudkategorier -->
                    <?php
                    $main_categories = ['Bakning', 'Frukost', 'Lunch', 'Middagar'];
                    foreach ($main_categories as $cat_name) :
                        $category = get_term_by('name', $cat_name, 'recipe_category');
                        if ($category) :
                            // Hämta första bilden från kategorin
                            $recipes = get_posts([
                                'post_type' => 'recipe',
                                'tax_query' => [['taxonomy' => 'recipe_category', 'field' => 'term_id', 'terms' => $category->term_id]],
                                'posts_per_page' => 1
                            ]);
                    ?>
                            <a href="<?php echo get_term_link($category); ?>" class="category-block">
                                <?php if (!empty($recipes) && has_post_thumbnail($recipes[0]->ID)) : ?>
                                    <div class="category-image">
                                        <?php echo get_the_post_thumbnail($recipes[0]->ID, 'large'); ?>
                                    </div>
                                <?php endif; ?>
                                <span class="category-name"><?php echo $category->name; ?></span>
                            </a>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
        </section>

        <!-- Senaste recepten -->
        <section class="latest-recipes">
            <div class="container">
                <header class="section-header">
                    <span class="section-label">Nyheter</span>
                    <h2>Senaste recepten</h2>
                </header>

                <div class="recipes-grid">
                    <?php
                    $recipes = new WP_Query([
                        'post_type' => 'recipe',
                        'posts_per_page' => 3,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ]);

                    if ($recipes->have_posts()) :
                        while ($recipes->have_posts()) : $recipes->the_post();
                    ?>
                            <!-- Recept-card -->
                            <article class="recipe-card">
                                <a href="<?php the_permalink(); ?>" class="card-inner">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="card-image">
                                            <?php the_post_thumbnail('large'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-content">
                                        <span class="author-date">
                                            <?php echo get_the_author(); ?> • <?php echo date_i18n('j M Y', strtotime(get_the_date())); ?>
                                        </span>
                                        <div class="title-and-icon">
                                            <h3><?php the_title(); ?></h3>
                                            <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g clip-path="url(#clip0_429_11179)">
                                                        <path d="M7 7H17M17 7V17M17 7L7 17" stroke="#292929" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_429_11179">
                                                            <rect width="24" height="24" fill="white"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </g>
                                            </svg>
                                        </div>
                                        <?php if ($description = get_field('description')) : ?>
                                            <p><?php echo wp_trim_words($description, 15); ?></p>
                                        <?php endif; ?>
                                        <?php
                                        $categories = get_the_terms(get_the_ID(), 'recipe_category');
                                        if ($categories) :
                                            foreach ($categories as $category) {
                                        ?>
                                                <span class="category-tag"><?php echo $category->name; ?></span>
                                        <?php
                                            }
                                        endif;
                                        ?>
                                    </div>
                                </a>
                            </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
                <div class="section-footer">
                    <a href="/recept" class="view-all">Se alla recept</a>
                </div>
            </div>
        </section>


    </main>
</div>

<?php get_footer(); ?>