<div class="sidebar-inner">
    <!-- Söksektion -->
    <div class="sidebar-section search-section">
        <h2>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.4-4.4" />
            </svg>
            Sök Recept
        </h2>
        <form role="search" method="get" class="recipe-search" action="<?php echo home_url('/'); ?>">
            <input type="hidden" name="post_type" value="recipe">
            <input type="search" name="s" placeholder="Vad letar du efter?">
            <button type="submit">Sök</button>
        </form>
    </div>

    <!-- Populära Recept -->
    <div class="sidebar-section trending-section">
        <h2>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M8.96173 18.9109L9.42605 18.3219L8.96173 18.9109ZM12 5.50063L11.4596 6.02073C11.463 6.02421 11.4664 6.02765 11.4698 6.03106L12 5.50063ZM15.0383 18.9109L15.5026 19.4999L15.0383 18.9109ZM13.4698 8.03034C13.7627 8.32318 14.2376 8.32309 14.5304 8.03014C14.8233 7.7372 14.8232 7.26232 14.5302 6.96948L13.4698 8.03034ZM9.42605 18.3219C7.91039 17.1271 6.25307 15.9603 4.93829 14.4798C3.64922 13.0282 2.75 11.3345 2.75 9.1371H1.25C1.25 11.8026 2.3605 13.8361 3.81672 15.4758C5.24723 17.0866 7.07077 18.3752 8.49742 19.4999L9.42605 18.3219ZM2.75 9.1371C2.75 6.98623 3.96537 5.18252 5.62436 4.42419C7.23607 3.68748 9.40166 3.88258 11.4596 6.02073L12.5404 4.98053C10.0985 2.44352 7.26409 2.02539 5.00076 3.05996C2.78471 4.07292 1.25 6.42503 1.25 9.1371H2.75ZM8.49742 19.4999C9.00965 19.9037 9.55954 20.3343 10.1168 20.6599C10.6739 20.9854 11.3096 21.25 12 21.25V19.75C11.6904 19.75 11.3261 19.6293 10.8736 19.3648C10.4213 19.1005 9.95208 18.7366 9.42605 18.3219L8.49742 19.4999ZM15.5026 19.4999C16.9292 18.3752 18.7528 17.0866 20.1833 15.4758C21.6395 13.8361 22.75 11.8026 22.75 9.1371H21.25C21.25 11.3345 20.3508 13.0282 19.0617 14.4798C17.7469 15.9603 16.0896 17.1271 14.574 18.3219L15.5026 19.4999ZM22.75 9.1371C22.75 6.42503 21.2153 4.07292 18.9992 3.05996C16.7359 2.02539 13.9015 2.44352 11.4596 4.98053L12.5404 6.02073C14.5983 3.88258 16.7639 3.68748 18.3756 4.42419C20.0346 5.18252 21.25 6.98623 21.25 9.1371H22.75ZM14.574 18.3219C14.0479 18.7366 13.5787 19.1005 13.1264 19.3648C12.6739 19.6293 12.3096 19.75 12 19.75V21.25C12.6904 21.25 13.3261 20.9854 13.8832 20.6599C14.4405 20.3343 14.9903 19.9037 15.5026 19.4999L14.574 18.3219ZM11.4698 6.03106L13.4698 8.03034L14.5302 6.96948L12.5302 4.97021L11.4698 6.03106Z" fill="#000000"></path>
                </g>
            </svg>
            Populära Recept
        </h2>
        <?php
        $trending_recipes = new WP_Query([
            'post_type' => 'recipe',
            'posts_per_page' => 3,
            'orderby' => 'date'
        ]);

        if ($trending_recipes->have_posts()) :
            while ($trending_recipes->have_posts()) : $trending_recipes->the_post(); ?>
                <div class="trending-recipe">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="recipe-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('thumbnail'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="recipe-info">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php if (get_field('cooking_time')) : ?>
                            <div class="recipe-meta">
                                <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M12 13h4v1h-5V7h1zM9 2h6V1H9zm13.65 3.916l-2.176 2.177A9.8 9.8 0 1 1 17.6 4.965l2.049-2.049zM12 4.2a8.8 8.8 0 1 0 8.8 8.8A8.81 8.81 0 0 0 12 4.2zm9.236 1.716L19.65 4.33l-1.086 1.086 1.586 1.586z"></path>
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                    </g>
                                </svg>
                                <span><?php echo esc_html(get_field('cooking_time')); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
        <?php endwhile;
            wp_reset_postdata();
        endif; ?>
    </div>

    <!-- Nyhetsbrev -->
    <div class="sidebar-section newsletter-section">
        <div class="newsletter-content">
            <h2>Få nya recept varje vecka</h2>
            <p>Prenumerera på vårt nyhetsbrev för de senaste recepten!</p>
            <form class="newsletter-form">
                <div class="input-group">
                    <svg class="newsletter-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    <input type="email" placeholder="Din e-postadress">
                </div>
                <button type="submit">
                    Prenumerera
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffdb01" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Kategorier -->
    <div class="sidebar-section categories-section">
        <div class="categories-grid">
            <?php
            $terms = get_terms([
                'taxonomy' => 'recipe_category',
                'hide_empty' => true
            ]);

            if ($terms && !is_wp_error($terms)) :
                foreach ($terms as $term) : ?>
                    <a href="<?php echo esc_url(get_term_link($term)); ?>" class="category-item">
                        <span class="category-name"><?php echo esc_html($term->name); ?></span>
                        <span class="count"><?php echo $term->count; ?></span>
                    </a>
            <?php endforeach;
            endif; ?>
        </div>
    </div>
</div>