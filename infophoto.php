<?php
/* Template Name: Info Photo */

include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
get_header();
?>
</header>
</div>

<?php

if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);
    $post = get_post($post_id);

    if ($post) {
        // Obtenez les informations nécessaires sur le post
        $image_url = get_the_post_thumbnail_url($post_id, 'large');
        $title = get_the_title($post_id);
        $reference = get_post_meta($post_id, 'reference', true);
        $categories = wp_get_post_terms($post_id, 'categorie', array("fields" => "names"));
        $formats = wp_get_post_terms($post_id, 'format', array("fields" => "names"));
        $types = get_field('type', $post_id);  // Utilisation de get_field() pour ACF
        $year = get_post_meta($post_id, 'year', true);
?>
        <div class="photo-info">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
            <h1><?php echo esc_html($title); ?></h1>
            <p><strong>Référence :</strong> <?php echo esc_html($reference); ?></p>
            <p><strong>Catégorie :</strong>
                <?php
                if (!is_wp_error($categories) && !empty($categories)) {
                    echo esc_html(implode(', ', $categories));
                } else {
                    echo 'Non défini';
                }
                ?>
            </p>
            <p><strong>Format :</strong>
                <?php
                if (!is_wp_error($formats) && !empty($formats)) {
                    echo esc_html(implode(', ', $formats));
                } else {
                    echo 'Non défini';
                }
                ?>
            </p>
            <p><strong>Type :</strong>
                <?php
                if (!empty($types)) {
                    echo esc_html($types);
                } else {
                    echo 'Non défini';
                }
                ?>
            </p>
            <p><strong>Année :</strong> <?php echo esc_html($year); ?></p>
        </div>
<?php
    } else {
        echo '<p>Image non trouvée.</p>';
    }
} else {
    echo '<p>ID d\'image non spécifié.</p>';
}

get_footer();
?>