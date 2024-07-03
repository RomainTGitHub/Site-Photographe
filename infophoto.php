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

    // Slug du type de post personnalisé (à vérifier dans CPT UI)
    $custom_post_type_slug = 'photo'; // Remplacez 'photo' par le slug correct si différent

    // Récupère les IDs des posts du type personnalisé
    $args = array(
        'post_type' => $custom_post_type_slug, // Utilise le slug correct
        'posts_per_page' => -1,
        'fields' => 'ids',
        'post_status' => 'publish'
    );
    $query = new WP_Query($args);
    $posts = $query->posts;
    $total_posts = count($posts);

    // Trouve l'index de l'ID actuel dans la liste
    $current_index = array_search($post_id, $posts);

    if ($current_index === false) {
        echo '<p>ID de photo invalide.</p>';
    } else {
        // Calcule les IDs des photos précédente et suivante
        $prev_index = ($current_index - 1 + $total_posts) % $total_posts;
        $next_index = ($current_index + 1) % $total_posts;

        $prev_id = $posts[$prev_index];
        $next_id = $posts[$next_index];

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
            $categories = wp_get_post_terms($post_id, 'categorie', array("fields" => "all"));
            $category_slugs = !is_wp_error($categories) ? wp_list_pluck($categories, 'slug') : array();
            $category_names = !is_wp_error($categories) ? wp_list_pluck($categories, 'name') : array();
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
                    if (!empty($category_names)) {
                        echo esc_html(implode(', ', $category_names));
                    } else {
                        echo 'Non défini';
                    }
                    ?>
                </p>
                <!-- Affiche les formats de la photo -->
                <p><strong>Format :</strong>
                    <?php
                    if (!empty($formats)) {
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

            <!-- Flèches directionnelles -->
            <div class="navigation-buttons">
                <a href="?id=<?php echo $prev_id; ?>" class="nav-arrow"><i class="fas fa-arrow-left"></i></a>
                <a href="?id=<?php echo $next_id; ?>" class="nav-arrow"><i class="fas fa-arrow-right"></i></a>
            </div>

            <!-- Ajout de deux photos aléatoires de la même catégorie -->
            <h2>VOUS AIMEREZ AUSSI</h2>
            <div class="related-photos-container">
                <?php
                if (!empty($category_slugs)) {
                    // Récupère deux posts aléatoires de la même catégorie
                    $related_args = array(
                        'post_type' => $custom_post_type_slug,
                        'posts_per_page' => 2,
                        'post__not_in' => array($post_id),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'categorie',
                                'field' => 'slug',
                                'terms' => $category_slugs,
                            ),
                        ),
                        'orderby' => 'rand'
                    );

                    $related_query = new WP_Query($related_args);

                    if ($related_query->have_posts()) {
                        echo '<div class="related-photos">';
                        while ($related_query->have_posts()) {
                            $related_query->the_post();
                            $related_image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                            $related_title = get_the_title();
                            $related_reference = get_post_meta(get_the_ID(), 'reference', true);
                            $related_categories = wp_get_post_terms(get_the_ID(), 'categorie', array("fields" => "names"));
                ?>
                            <div class="related-photo-card">
                                <div class="related-photo-overlay">
                                    <div class="related-photo-fullscreen">
                                        <a href="#" data-full-url="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" onclick="openLightbox(<?php echo $index; ?>)"><i class="fas fa-expand"></i></a>
                                    </div>
                                    <div class="related-photo-view">
                                        <a href="?id=<?php echo get_the_ID(); ?>"><i class="fas fa-eye"></i></a>
                                    </div>
                                    <div class="related-photo-info">
                                        <span class="related-photo-reference"><?php echo esc_html($related_reference); ?></span>
                                        <span class="related-photo-category"><?php echo esc_html(implode(', ', $related_categories)); ?></span>
                                    </div>
                                </div>
                                <img src="<?php echo esc_url($related_image_url); ?>" alt="<?php echo esc_attr($related_title); ?>">
                            </div>
                <?php
                        }
                        echo '</div>';
                        wp_reset_postdata();
                    } else {
                        echo '<p>Aucune photo connexe trouvée.</p>';
                    }
                } else {
                    echo '<p>Pas de catégories trouvées pour cette photo.</p>';
                }
                ?>
            </div>

<?php
        } else {
            // Affiche un message si le post n'existe pas.
            echo '<p>Photo non trouvée.</p>';
        }
    }
} else {
    // Affiche un message si aucun identifiant de post n'est passé en paramètre.
    echo '<p>Aucun identifiant de photo fourni.</p>';
}

// Appelle le pied de page du thème WordPress.
get_footer();
?>