</div> <!-- Ferme la div main-container -->

<footer>
    <div class="footer-content">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'footer-menu',
            'container' => 'nav',
            'container_class' => 'footer-nav',
            'menu_class' => 'footer-menu'
        ));
        ?>
    </div>
</footer>

<div id="lightbox" class="lightbox">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <a class="lightbox-prev" onclick="changeSlide(-1)">&#10094;</a>
    <a class="lightbox-next" onclick="changeSlide(1)">&#10095;</a>
    <div class="lightbox-content">
        <img id="lightbox-img" src="" alt="Image en plein écran">
        <div class="lightbox-info">
            <span id="lightbox-reference" class="lightbox-reference"></span>
            <span id="lightbox-category" class="lightbox-category"></span>
        </div>
    </div>
</div>

<?php include locate_template('templates_part/contact_modal.php'); ?>

<?php wp_footer(); ?>
</body>

</html>