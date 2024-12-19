    <div class="sidebar-inner">
        <?php if (is_active_sidebar('social-media-widget')) : ?>
            <?php dynamic_sidebar('social-media-widget'); ?>
        <?php endif; ?>

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
    </div>