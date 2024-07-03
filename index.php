<?php
/* Template Name: Gallery Page */
get_header(); ?>

<div class="header-image-container">
    <?php
    // Liste des IDs des images de la galerie
    $image_ids = array(66, 29, 28, 27, 26, 25, 24, 23, 22, 21, 20, 19, 18, 17, 16, 15);

    // Sélectionner une image aléatoire parmi ces IDs
    $random_image_id = $image_ids[array_rand($image_ids)];

    // Récupérer l'URL de l'image
    $image_src = wp_get_attachment_image_src($random_image_id, 'full')[0];
    ?>
    <img src="<?php echo $image_src; ?>" alt="Event" class="header-image">
    <div class="overlay"></div>
    <div class="header-text">Photographe Event</div>
</div>
</header>

<?php include get_template_directory() . '/templates_part/galleriephoto.php';

get_footer();
?>