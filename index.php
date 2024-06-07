<?php
/* Template Name: Gallery Page */
get_header();
?>

<div class="main-container">
    <div class="gallery-container">
        <div class="filters">
            <select id="categories">
                <option value="">Catégories</option>
                <!-- Ajoutez des options de catégories ici -->
            </select>
            <select id="formats">
                <option value="">Formats</option>
                <!-- Ajoutez des options de formats ici -->
            </select>
            <select id="sort-by">
                <option value="">Trier Par</option>
                <!-- Ajoutez des options de tri ici -->
            </select>
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