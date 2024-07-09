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
/*
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
*/
// Fonction pour ajouter des polices google fonts.
function add_google_fonts()
{
    wp_enqueue_style('Space Mono', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap"', false);
    wp_enqueue_style('Poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap', false);
}
add_action('wp_enqueue_scripts', 'add_google_fonts');

function enqueue_custom_scripts()
{
    wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null, true);

    wp_localize_script('custom-scripts', 'my_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'site_url' => get_site_url()
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function register_custom_rest_endpoints()
{
    register_rest_route('custom/v1', '/photos/', array(
        'methods' => 'GET',
        'callback' => 'get_custom_photos',
        'permission_callback' => '__return_true',
    ));
    add_action('rest_api_init', 'register_custom_rest_endpoints');
    add_action('wp_ajax_load_photos', 'get_custom_photos');
    add_action('wp_ajax_nopriv_load_photos', 'get_custom_photos');
}

function get_custom_photos()
{
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $format = isset($_GET['format']) ? $_GET['format'] : '';
    $order = isset($_GET['order']) ? $_GET['order'] : '';
    $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'offset' => $offset,
        'post_status' => 'publish',
    );

    if ($category) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    if ($order == 'recentes') {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    } elseif ($order == 'anciennes') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    }

    $query = new WP_Query($args);
    $posts = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $posts[] = array(
                'id' => $post_id,
                'title' => get_the_title(),
                'image_url' => get_the_post_thumbnail_url($post_id, 'medium_large'),
                'image_full_url' => get_the_post_thumbnail_url($post_id, 'full'),
                'reference' => get_post_meta($post_id, 'reference', true),
                'categories' => wp_get_post_terms($post_id, 'categorie', array('fields' => 'names')),
            );
        }
    }

    wp_reset_postdata();
    wp_send_json($posts);
}

add_action('init', 'register_custom_rest_endpoints');


function load_more_photos()
{
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $posts_per_page = 8;

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
        'post_status' => 'publish'
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $post_id = get_the_ID();
            $image_url = get_the_post_thumbnail_url($post_id, 'full');
            $image_full_url = get_the_post_thumbnail_url($post_id, 'full');
            $title = get_the_title($post_id);
            $reference = get_post_meta($post_id, 'reference', true);
            $categories = wp_get_post_terms($post_id, 'categorie', array("fields" => "names"));
            $formats = wp_get_post_terms($post_id, 'format', array("fields" => "names"));
            $date = get_the_date('Y', $post_id);
            $category_slugs = wp_list_pluck(wp_get_post_terms($post_id, 'categorie'), 'slug');
            $format_slugs = wp_list_pluck(wp_get_post_terms($post_id, 'format'), 'slug');
?>

            <div class="related-photo-card" data-category="<?php echo esc_attr(implode(' ', $category_slugs)); ?>" data-format="<?php echo esc_attr(implode(' ', $format_slugs)); ?>" data-date="<?php echo esc_attr($date); ?>">
                <div class="related-photo-overlay">
                    <div class="related-photo-fullscreen">
                        <a href="#" class="open-lightbox" data-full-url="<?php echo esc_url($image_full_url); ?>" data-reference="<?php echo esc_html($reference); ?>" data-category="<?php echo esc_html(implode(', ', $categories)); ?>"><i class="fas fa-expand"></i></a>
                    </div>
                    <div class="related-photo-view">
                        <a href="<?php echo esc_url(home_url('/info-photo/?id=' . $post_id)); ?>"><i class="fas fa-eye"></i></a>
                    </div>
                    <div class="related-photo-info">
                        <span class="related-photo-reference"><?php echo esc_html($reference); ?></span>
                        <span class="related-photo-category"><?php echo esc_html(implode(', ', $categories)); ?></span>
                    </div>
                </div>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
            </div>
<?php
        endwhile;
    endif;
    wp_reset_postdata();
    die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');
