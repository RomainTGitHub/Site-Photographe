<?php
// Fonction pour ajouter les scripts personnalisés et nécessaires, y compris jQuery et le script de formulaire de contact 7.
function my_enqueue_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('contact-form-7');
    wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery', 'contact-form-7'), null, true);
}
// Attache la fonction my_enqueue_scripts à l'action wp_enqueue_scripts.
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

// Fonction pour ajouter les styles et scripts Bootstrap.
function enqueue_bootstrap()
{
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script('jquery'); // Assurez-vous que jQuery est chargé
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);
}
// Attache la fonction enqueue_bootstrap à l'action wp_enqueue_scripts.
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

// Fonction pour enregistrer et charger les styles et scripts personnalisés.
function custom_enqueue_styles_scripts()
{
    // Enregistrer et charger le fichier CSS
    wp_enqueue_style('custom-dropdown-style', get_template_directory_uri() . '/styles.css');

    // Enregistrer et charger le fichier JavaScript
    wp_enqueue_script('custom-dropdown-script', get_template_directory_uri() . '/scripts.js', array('jquery'), null, true);
}
// Attache la fonction custom_enqueue_styles_scripts à l'action wp_enqueue_scripts.
add_action('wp_enqueue_scripts', 'custom_enqueue_styles_scripts');

// Fonction pour ajouter les styles personnalisés du thème.
function my_custom_theme_enqueue_styles()
{
    wp_enqueue_style('custom-style', get_stylesheet_uri());
}
// Attache la fonction my_custom_theme_enqueue_styles à l'action wp_enqueue_scripts.
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_styles');

// Fonction pour enregistrer et inclure les scripts personnalisés du thème.
function my_custom_theme_scripts()
{
    // Enregistrer le script
    wp_register_script('my-custom-script', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);

    // Inclure le script
    wp_enqueue_script('my-custom-script');
}
// Attache la fonction my_custom_theme_scripts à l'action wp_enqueue_scripts.
add_action('wp_enqueue_scripts', 'my_custom_theme_scripts');

// Fonction pour enregistrer les menus de navigation.
function register_my_menus()
{
    register_nav_menus(
        array(
            'primary' => __('Primary Menu'),
            'footer-menu' => __('Footer Menu'),
        )
    );
}
// Attache la fonction register_my_menus à l'action init.
add_action('init', 'register_my_menus');

// Fonction pour enregistrer les menus de pied de page.
function register_footer_menus()
{
    register_nav_menus(
        array(
            'footer-menu' => __('Footer Menu'),
        )
    );
}
// Attache la fonction register_footer_menus à l'action init.
add_action('init', 'register_footer_menus');

// Fonction pour ajouter une zone de widget pour le pied de page.
function footer_widget_area()
{
    register_sidebar(
        array(
            'name'          => __('Footer Widget Area', 'theme_text_domain'),
            'id'            => 'footer-widget-area',
            'description'   => __('Widgets added here will appear in your footer.', 'theme_text_domain'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
// Attache la fonction footer_widget_area à l'action widgets_init.
add_action('widgets_init', 'footer_widget_area');

// Fonction pour ajouter un type de message personnalisé.
function create_custom_post_type()
{
    register_post_type(
        'custom_type',
        array(
            'labels'      => array(
                'name'          => __('Custom Types'),
                'singular_name' => __('Custom Type'),
            ),
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array('slug' => 'custom-type'),
            'supports'    => array('title', 'editor', 'thumbnail'),
        )
    );
}
// Attache la fonction create_custom_post_type à l'action init.
add_action('init', 'create_custom_post_type');

// Fonction pour ajouter des polices google fonts.
function add_google_fonts()
{
    wp_enqueue_style('Space Mono', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap"', false);
    wp_enqueue_style('Poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap', false);
}
add_action('wp_enqueue_scripts', 'add_google_fonts');
