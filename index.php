<?php
/* Template Name: Gallery Page */
get_header();
?>

<div class="main-container">
    <div class="gallery-container">
        <div class="filters">
            <!-- Premier menu déroulant -->
            <div id="categories-dropdown" class="dropdown">
                <div class="dropdown-selected">Catégories</div>
                <ul class="dropdown-menu">
                    <li class="dropdown-item first-item" data-value=""></li>
                    <li class="dropdown-item" data-value="reception">Réception</li>
                    <li class="dropdown-item" data-value="television">Télévision</li>
                    <li class="dropdown-item" data-value="concert">Concert</li>
                    <li class="dropdown-item" data-value="mariage">Mariage</li>
                </ul>
            </div>
            <!-- Deuxième menu déroulant -->
            <div id="formats-dropdown" class="dropdown">
                <div class="dropdown-selected">Formats</div>
                <ul class="dropdown-menu">
                    <li class="dropdown-item first-item" data-value=""></li>
                    <li class="dropdown-item" data-value="photo">Photo</li>
                    <li class="dropdown-item" data-value="video">Vidéo</li>
                    <li class="dropdown-item" data-value="audio">Audio</li>
                    <li class="dropdown-item" data-value="document">Document</li>
                </ul>
            </div>
            <!-- Troisième menu déroulant -->
            <div id="sort-by-dropdown" class="dropdown">
                <div class="dropdown-selected">Trier Par</div>
                <ul class="dropdown-menu">
                    <li class="dropdown-item first-item" data-value=""></li>
                    <li class="dropdown-item" data-value="date">Date</li>
                    <li class="dropdown-item" data-value="popularity">Popularité</li>
                    <li class="dropdown-item" data-value="rating">Évaluation</li>
                    <li class="dropdown-item" data-value="alphabetical">Alphabétique</li>
                </ul>
            </div>
        </div>

        <div class="gallery-grid">
            <?php
            // La boucle pour afficher les images de la galerie
            $args = array(
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'post_status' => 'inherit',
                'posts_per_page' => 8,
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
            ?>
        </div>

        <div class="load-more">
            <button id="load-more-button">Charger plus</button>
        </div>
    </div>
</div> <!-- Ferme la div main-container -->

<?php get_footer(); ?>