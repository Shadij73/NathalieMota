<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title> <!-- Dynamic Title -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="logo">
        <a href="<?php echo home_url(); ?>">
            <img class="logostyle" src="<?php echo get_template_directory_uri(); ?>/assets/logo.png" alt="Logo">
        </a>
    </div>
    <nav>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'main-menu',
            'container'      => 'div',
            'container_class' => 'menu-main-menu-container',
            'menu_class'     => 'menu',
        ));
        ?>
    </nav>
</header>
