<?php
/* Template Name: Gallery Page */
get_header(); ?>

<div class="header-image-container">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/medias/photo-header.jpg" alt="Event" class="header-image">
    <div class="overlay"></div>
    <div class="header-text">Photographe Event</div>
</div>
</nav>
</header>
</div> <!-- Ferme la div main-container -->


<?php include get_template_directory() . '/templates_part/galleriephoto.php';

get_footer();
?>