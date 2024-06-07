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

<?php wp_footer(); ?>
</body>

</html>