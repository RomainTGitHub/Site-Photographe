<?php

function my_custom_theme_enqueue_styles()
{
    wp_enqueue_style('custom-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_styles');

function register_my_menus()
{
    register_nav_menus(
        array(
            'primary' => __('Primary Menu'),
            'footer-menu' => __('Footer Menu'),
        )
    );
}
add_action('init', 'register_my_menus');

function register_footer_menus()
{
    register_nav_menus(
        array(
            'footer-menu' => __('Footer Menu'),
        )
    );
}
add_action('init', 'register_footer_menus');



function enqueue_gallery_scripts()
{
    wp_enqueue_script('gallery-js', get_stylesheet_directory_uri() . '/gallery.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_gallery_scripts');


function load_more_images()
{
    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'post_status' => 'inherit',
        'posts_per_page' => 8,
        'paged' => $paged,
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="gallery-item">
                <?php echo wp_get_attachment_image(get_the_ID(), 'large'); ?>
            </div>
<?php endwhile;
        wp_reset_postdata();
    endif;
    wp_die();
}
add_action('wp_ajax_load_more_images', 'load_more_images');
add_action('wp_ajax_nopriv_load_more_images', 'load_more_images');

function custom_theme_enqueue_styles()
{
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', false);
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_styles');
