<?php
/* Template Name: Info Photo */

// Inclut le fichier wp-load.php pour charger WordPress.
include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

// Appelle l'en-tête du thème WordPress.
get_header();
?>
</header>
</div>

<?php

// Vérifie si un identifiant de post est passé en paramètre dans l'URL.
if (isset($_GET['id'])) {
    // Récupère l'identifiant du post et assure qu'il est un entier.
    $post_id = intval($_GET['id']);
    // Récupère les informations du post correspondant à l'identifiant.
    $post = get_post($post_id);

    // Vérifie si le post existe.
    if ($post) {
        // Obtient l'URL de l'image mise en avant du post.
        $image_url = get_the_post_thumbnail_url($post_id, 'large');
        // Obtient le titre du post.
        $title = get_the_title($post_id);
        // Obtient la méta-donnée 'reference' du post.
        $reference = get_post_meta($post_id, 'reference', true);
        // Obtient les termes de taxonomie 'categorie' associés au post.
        $categories = wp_get_post_terms($post_id, 'categorie', array("fields" => "names"));
        // Obtient les termes de taxonomie 'format' associés au post.
        $formats = wp_get_post_terms($post_id, 'format', array("fields" => "names"));
        // Utilise la fonction get_field() d'ACF pour obtenir la valeur du champ personnalisé 'type'.
        $types = get_field('type', $post_id);
        // Utilise get_the_date() pour obtenir l'année de publication du post.
        $year = get_the_date('Y', $post_id);
?>
        <!-- Affichage des informations de la photo -->
        <div class="photo-info">
            <!-- Affiche l'image de la photo -->
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
            <!-- Affiche le titre de la photo -->
            <h1><?php echo esc_html($title); ?></h1>
            <!-- Affiche la référence de la photo -->
            <p><strong>Référence :</strong> <?php echo esc_html($reference); ?></p>
            <!-- Affiche les catégories de la photo -->
            <p><strong>Catégorie :</strong>
                <?php
                if (!is_wp_error($categories) && !empty($categories)) {
                    echo esc_html(implode(', ', $categories));
                } else {
                    echo 'Non défini';
                }
                ?>
            </p>
            <!-- Affiche les formats de la photo -->
            <p><strong>Format :</strong>
                <?php
                if (!is_wp_error($formats) && !empty($formats)) {
                    echo esc_html(implode(', ', $formats));
                } else {
                    echo 'Non défini';
                }
                ?>
            </p>
            <!-- Affiche le type de la photo -->
            <p><strong>Type :</strong>
                <?php
                if (!empty($types)) {
                    echo esc_html($types);
                } else {
                    echo 'Non défini';
                }
                ?>
            </p>
            <!-- Affiche l'année de la photo -->
            <p><strong>Année :</strong> <?php echo esc_html($year); ?></p>
        </div>
        <p>Cette photo vous intéresse?</p>
        <div id="overlay"></div>
        <button id="contactBtn" class="cta-button" data-reference="<?php echo esc_attr($reference); ?>">Contact</button>


<?php
    } else {
        // Affiche un message si le post n'existe pas.
        echo '<p>Photo non trouvée.</p>';
    }
} else {
    // Affiche un message si aucun identifiant de post n'est passé en paramètre.
    echo '<p>Aucun identifiant de photo fourni.</p>';
}

// Appelle le pied de page du thème WordPress.
get_footer();
?>