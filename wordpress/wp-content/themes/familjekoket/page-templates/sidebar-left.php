<?php
/**
 * Template Name: Sidomeny Vänster
 * Template Post Type: page
 */

get_header(); ?>

<div class="page-container">
    <div class="content-with-left-sidebar">
        <aside class="sidebar">
            <?php get_template_part('template-parts/components/contact-sidebar'); ?>
        </aside>

        <main class="main-content">
            <div class="contact-page-content">
                <div class="page-header">
                    <h1><?php the_title(); ?></h1>
                    <p>Har du frågor, förslag eller bara vill säga hej? Fyll i formuläret nedan så återkommer vi så snart som möjligt.</p>
                </div>

                <?php display_contact_form_message(); ?>

                <form class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="submit_contact_form">
                    <?php wp_nonce_field('submit_contact_form', 'contact_form_nonce'); ?>

                    <div class="form-group">
                        <input type="text" id="name" name="name" required placeholder=" ">
                        <label for="name">Namn</label>
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" required placeholder=" ">
                        <label for="email">E-post</label>
                    </div>
                    <div class="form-group">
                        <textarea id="message" name="message" required placeholder=" "></textarea>
                        <label for="message">Meddelande</label>
                    </div>
                    <button type="submit" class="submit-btn">
                        Skicka meddelande
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </form>
            </div>
        </main>
    </div>
</div>

<?php get_footer(); ?>