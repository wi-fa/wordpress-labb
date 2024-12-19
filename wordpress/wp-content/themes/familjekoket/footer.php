<footer class="footerContainer">
    <img src="http://localhost:8000/wp-content/uploads/2024/12/logologo.png" alt="">
    <div class="footerMain">
        <div class="subscribe">
            <h3>Prenumerera<br>på vårat nyhetsbrev</h3>
            <p>Senaste nytt, meddelanden och de<br>senaste uppdateringarna direkt i din inkorg.</p>
            <button class="subscribe-button">
                <span>→</span>
            </button>
        </div>

        <div class="footerContent">
            <!-- Första listan (kategorier) -->
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

            <!-- 2a listan (specialkost) -->
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

            <!-- 3e listan (support) -->
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

            <!-- 4e listan (sociala-medier) -->
            <div class="listContainer">
                <span>Social</span>
                <ul>
                    <li><a href="https://instagram.com">Instagram</a></li>
                    <li><a href="https://facebook.com">Facebook</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer foot xD -->
    <div class="footerFoot">
        <p>Familjeköket.</p>
        <p>All rights reserved</p>
    </div>
</footer>
<?php wp_footer(); ?>