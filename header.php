<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div class="main-container">
        <header class="custom-header">
            <div class="header-top">
                <div class="site-title">
                    <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
                </div>
                <nav class="nav-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                    ));
                    ?>
                </nav>
            </div>
            <div class="header-image-container">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/medias/photo-header.jpg" alt="Event" class="header-image">
                <div class="overlay"></div>
                <div class="header-text">Photographe Event</div>
            </div>
            </nav>
        </header>
    </div> <!-- Ferme la div main-container -->