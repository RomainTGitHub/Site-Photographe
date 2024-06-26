<?php

function enqueue_bootstrap()
{
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script('jquery'); // Assurez-vous que jQuery est chargé
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

function custom_enqueue_styles_scripts()
{
    // Enregistrer et charger le fichier CSS
    wp_enqueue_style('custom-dropdown-style', get_template_directory_uri() . '/styles.css');

    // Enregistrer et charger le fichier JavaScript
    wp_enqueue_script('custom-dropdown-script', get_template_directory_uri() . '/scripts.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'custom_enqueue_styles_scripts');


function my_custom_theme_enqueue_styles()
{
    wp_enqueue_style('custom-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_styles');

function my_custom_theme_scripts()
{
    // Enregistrer le script
    wp_register_script('my-custom-script', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);

    // Inclure le script
    wp_enqueue_script('my-custom-script');
}
add_action('wp_enqueue_scripts', 'my_custom_theme_scripts');


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
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'date';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';

    $args = array(
        'post_type' => 'photo', // Remplacez par votre CPT
        'paged' => $paged,
        'orderby' => $type,
        'order' => $order,
        'posts_per_page' => 10,
    );

    if ($category) {
        $args['tax_query'][] = array(
            'taxonomy' => 'category', // Remplacez par votre taxonomie
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if ($format) {
        $args['meta_query'][] = array(
            'key' => 'format', // Remplacez par votre clé de méta
            'value' => $format,
            'compare' => '='
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // Assurez-vous de remplacer cette partie par votre template de rendu de photo
            get_template_part('template-parts/content', 'photo');
        }
    } else {
        echo '';
    }
    wp_die();
}

add_action('wp_ajax_load_more_images', 'load_more_images');
add_action('wp_ajax_nopriv_load_more_images', 'load_more_images');

// Modifiez la requête principale pour prendre en compte les filtres
function filter_gallery_query($query)
{
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('photo')) {
        $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
        $format = isset($_GET['format']) ? sanitize_text_field($_GET['format']) : '';
        $type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'date';
        $order = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : 'DESC';

        $query->set('orderby', $type);
        $query->set('order', $order);

        if ($category) {
            $query->set('tax_query', array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category,
                ),
            ));
        }

        if ($format) {
            $query->set('meta_query', array(
                array(
                    'key' => 'format',
                    'value' => $format,
                    'compare' => '=',
                ),
            ));
        }
    }
}
add_action('pre_get_posts', 'filter_gallery_query');


function custom_theme_enqueue_styles()
{
    wp_enqueue_style('google-fonts-spacemono', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', false);
    wp_enqueue_style('google-fonts-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', false);
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_styles');
