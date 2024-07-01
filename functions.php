<?php
function my_enqueue_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('contact-form-7');
    wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery', 'contact-form-7'), null, true);
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

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

function custom_theme_enqueue_styles()
{
    wp_enqueue_style('google-fonts-spacemono', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', false);
    wp_enqueue_style('google-fonts-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', false);
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_styles');
