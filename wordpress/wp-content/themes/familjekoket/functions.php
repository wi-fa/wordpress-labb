<?php
if (!defined('FAMILJEKOKET_VERSION')) {
    define('FAMILJEKOKET_VERSION', '1.0.0');
}

// Tema setup (stöd för olika saker)
function familjekoket_setup()
{
    // Rss
    add_theme_support('automatic-feed-links');

    // Titel-hantering
    add_theme_support('title-tag');

    // Feature bild
    add_theme_support('post-thumbnails');

    // Logotyp
    add_theme_support('custom-logo');

    // Meny placeringar
    register_nav_menus(array(
        'primary' => __('Huvudmeny', 'familjekoket'),
        'footer' => __('Sidfotsmeny', 'familjekoket'),
        'sidebar-menu' => __('Sidomeny', 'familjekoket'),
    ));

    // Header inställningar
    add_theme_support('custom-header', array(
        'default-image'      => '',
        'default-text-color' => '000',
        'width'              => 1920,
        'height'             => 1080,
        'flex-width'         => true,
        'flex-height'        => true,
    ));
}
add_action('after_setup_theme', 'familjekoket_setup');

// Döljer adminbaren vid preview av sida
add_filter('show_admin_bar', '__return_false');

// Registrerar font från google
function familjekoket_enqueue_fonts()
{
    wp_enqueue_style(
        'google-fonts-roboto-flex',
        'https://fonts.googleapis.com/css2?family=Roboto+Flex:wght@100;400;700&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'familjekoket_enqueue_fonts');

// Temats style och scrjpts
function familjekoket_scripts()
{
    // Styling
    wp_enqueue_style(
        'familjekoket-style',
        get_template_directory_uri() . '/dist/css/style.css',
        array(),
        filemtime(get_template_directory() . '/dist/css/style.css')
    );

    // Javascript
    wp_enqueue_script(
        'familjekoket-main',
        get_template_directory_uri() . '/dist/js/main.js',
        array('jquery'),
        filemtime(get_template_directory() . '/dist/js/main.js'),
        true
    );

    // AJAX för dynamiska sidladdningar i frontend, för filtrering av recept osv, vet inte om detta är rätt tänk dock. Hittade på nätet.
    wp_localize_script('familjekoket-main', 'familjekoketData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('familjekoket-nonce')
    ));
}
add_action('wp_enqueue_scripts', 'familjekoket_scripts');

// Sidmallar
function register_page_templates($templates)
{
    $templates['page-templates/full-width.php'] = __('Full Width', 'familjekoket');
    $templates['page-templates/sidebar-right.php'] = __('Sidomeny Höger', 'familjekoket');
    $templates['page-templates/sidebar-left.php'] = __('Sidomeny Vänster', 'familjekoket');
    $templates['page-templates/image-right.php'] = __('Bild Höger', 'familjekoket');
    return $templates;
}
add_filter('theme_page_templates', 'register_page_templates');

// Hantering av kontaktformulär (ej klart)
function handle_contact_form() {
    if (isset($_POST['action']) && $_POST['action'] == 'submit_contact_form') {
        if (!wp_verify_nonce($_POST['contact_form_nonce'], 'submit_contact_form')) {
            wp_die('Säkerhetsverifiering misslyckades, försök igen.');
        }

        // Rensar och validerar datan från formuläret
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);

        // Mail config
        $to = 'admin@wifa.se';
        $subject = 'Ny kontaktförfrågan från ' . $name;
        $body = "Namn: $name\nE-post: $email\nMeddelande: $message";
        $headers = array('Content-Type: text/plain; charset=UTF-8');

        $sent = wp_mail($to, $subject, $body, $headers);

        // Redirects beroende på resultatet av submit
        if ($sent) {
            wp_safe_redirect(add_query_arg('message', 'success', wp_get_referer()));
        } else {
            wp_safe_redirect(add_query_arg('message', 'error', wp_get_referer()));
        }
        exit;
    }
}
add_action('admin_post_submit_contact_form', 'handle_contact_form');
add_action('admin_post_nopriv_submit_contact_form', 'handle_contact_form');

// Meddelande efter att formuläret submittats
function display_contact_form_message() {
    if (isset($_GET['message'])) {
        if ($_GET['message'] == 'success') {
            echo '<div class="contact-form-message success">Tack för ditt meddelande! Vi återkommer så snart som möjligt.</div>';
        } elseif ($_GET['message'] == 'error') {
            echo '<div class="contact-form-message error">Det uppstod ett fel när meddelandet skulle skickas.</br> Vänligen försök igen senare.</div>';
        }
    }
}

// Skapar post typen recept
function create_recipe_post_type()
{
    register_post_type('recipe', array(
        'labels' => array(
            'name' => 'Recept',
            'singular_name' => 'Recept',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'recept',
            'with_front' => false
        ),
        'taxonomies' => array('recipe_category', 'recipe_tag'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'author'),
        'menu_icon' => 'dashicons-carrot',
        'show_in_rest' => true,
    ));

    // Lägger till kategorier
    register_taxonomy('recipe_category', 'recipe', array(
        'labels' => array(
            'name' => 'Kategorier',
            'singular_name' => 'Kategori',
        ),
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true, // Lägg till denna
        'show_in_rest' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true, // Lägg till denna
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'recept/kategori',
            'with_front' => false,
            'hierarchical' => true // Lägg till denna
        )
    ));

    // Lägger till tags
    register_taxonomy('recipe_tag', 'recipe', array(
        'labels' => array(
            'name' => 'Taggar',
            'singular_name' => 'Tagg',
        ),
        'hierarchical' => false,
        'public' => true,
        'show_in_rest' => true,
        'rewrite' => array(
            'slug' => 'recept/tag',
            'with_front' => false
        )
    ));
}
add_action('init', 'create_recipe_post_type');

// Uppdaterar permalinks när temat aktiverats pga problem av slugs och url
function familjekoket_rewrite_flush()
{
    create_recipe_post_type();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'familjekoket_rewrite_flush');

// Rewrite regeler för url (hade massa problem med detta, kändes onödigt krångligt)
add_action('init', function () {
    // Regel för kategorier
    add_rewrite_rule(
        'recept/kategori/([^/]+)/?$',
        'index.php?recipe_category=$matches[1]',
        'top'
    );
    // Regel för taggar
    add_rewrite_rule(
        'recept/tag/([^/]+)/?$',
        'index.php?recipe_tag=$matches[1]',
        'top'
    );
});

// Registrera widgetzonen
function register_social_media_widget_area() {
    register_sidebar(array(
        'name'          => 'Sociala medier',
        'id'            => 'social-media-widget',
        'description'   => 'Visa dina sociala medier-ikoner och information här',
        'before_widget' => '<div class="social-media-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="widget-header"><img src="" alt="" class="profile-image"><div class="header-content">',
        'after_title'   => '</div></div>'
    ));
}
add_action('widgets_init', 'register_social_media_widget_area');

// Skapa widgetklassen
class Social_Media_Widget extends WP_Widget {
    // Struct för widget
    public function __construct() {
        parent::__construct(
            'social_media_widget',
            'Sociala Medier',
            array('description' => 'Visa dina sociala medier-ikoner och information')
        );
    }

    public function widget($args, $instance) {
        $profile_image = $instance['profile_image'];
        $title = $instance['title'];
        $description = $instance['description'];
        $facebook_link = $instance['facebook_link'];
        $instagram_link = $instance['instagram_link'];

        echo $args['before_widget'];
        ?>

            <div class="widget-header">
                <?php if ($profile_image) : ?>
                <img src="<?php echo esc_url($profile_image); ?>" alt="<?php echo esc_attr($title); ?>" class="profile-image">
                <?php endif; ?>
                <div class="header-content">
                    <?php if ($title) : ?>
                    <h3><?php echo esc_html($title); ?></h3>
                    <?php endif; ?>
                    <?php if ($description) : ?>
                    <p><?php echo esc_html($description); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="social-media-links">
                <?php if ($facebook_link) : ?>
                <a href="<?php echo esc_url($facebook_link); ?>" target="_blank">
                    <svg width="32" height="32" fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                    </svg>
                </a>
                <?php endif; ?>

                <?php if ($instagram_link) : ?>
                <a href="<?php echo esc_url($instagram_link); ?>" target="_blank">
                    <svg width="32" height="32" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 5H9.5C7.29086 5 5.5 6.79086 5.5 9V15C5.5 17.2091 7.29086 19 9.5 19H15.5C17.7091 19 19.5 17.2091 19.5 15V9C19.5 6.79086 17.7091 5 15.5 5Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5 15C10.8431 15 9.5 13.6569 9.5 12C9.5 10.3431 10.8431 9 12.5 9C14.1569 9 15.5 10.3431 15.5 12C15.5 12.7956 15.1839 13.5587 14.6213 14.1213C14.0587 14.6839 13.2956 15 12.5 15Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <rect x="15.5" y="9" width="2" height="2" rx="1" transform="rotate(-90 15.5 9)" fill="#000000" />
                        <rect x="16" y="8.5" width="1" height="1" rx="0.5" transform="rotate(-90 16 8.5)" stroke="#000000" stroke-linecap="round" />
                    </svg>
                </a>
                <?php endif; ?>
            </div>

        <?php
        echo $args['after_widget'];
    }

    // Widget form i admin
    public function form($instance) {
        $profile_image = !empty($instance['profile_image']) ? $instance['profile_image'] : '';
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $facebook_link = !empty($instance['facebook_link']) ? $instance['facebook_link'] : '';
        $instagram_link = !empty($instance['instagram_link']) ? $instance['instagram_link'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('profile_image'); ?>">Profilbild URL:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('profile_image'); ?>" name="<?php echo $this->get_field_name('profile_image'); ?>" type="text" value="<?php echo esc_attr($profile_image); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Titel:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>">Beskrivning:</label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_textarea($description); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('facebook_link'); ?>">Facebook-länk:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('facebook_link'); ?>" name="<?php echo $this->get_field_name('facebook_link'); ?>" type="text" value="<?php echo esc_attr($facebook_link); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('instagram_link'); ?>">Instagram-länk:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('instagram_link'); ?>" name="<?php echo $this->get_field_name('instagram_link'); ?>" type="text" value="<?php echo esc_attr($instagram_link); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['profile_image'] = (!empty($new_instance['profile_image'])) ? esc_url_raw($new_instance['profile_image']) : '';
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? sanitize_textarea_field($new_instance['description']) : '';
        $instance['facebook_link'] = (!empty($new_instance['facebook_link'])) ? esc_url_raw($new_instance['facebook_link']) : '';
        $instance['instagram_link'] = (!empty($new_instance['instagram_link'])) ? esc_url_raw($new_instance['instagram_link']) : '';
        return $instance;
    }
}

function register_social_media_widget() {
    register_widget('Social_Media_Widget');
}
add_action('widgets_init', 'register_social_media_widget');