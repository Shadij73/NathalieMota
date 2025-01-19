<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Nathalie Mota</title>

    <!-- Initialisation de la variable JavaScript 'ajaxurl' -->
    <script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>

    <!-- Liens vers les feuilles de style du thème -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/fonts.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/header.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/footer.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/single.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/index.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/liste-photo.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/lightbox.css">
    <style>:root {--chemin-image-chevron: url('<?php echo get_template_directory_uri(); ?>/img_logo/chevron.png');}</style>

    <!-- Inclusion de jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Hook WordPress pour inclure des éléments dans l'en-tête -->
    <?php wp_head(); ?>


</head>
<body>

    <header>
        <div class="header-logo">
            <!-- Récupération et affichage du logo personnalisé du thème -->
            <?php
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            ?>
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Logo.png" alt="Site Logo">
            </a>
        </div>

        <!-- MENU BURGER -->
        <div class="mobile-menu-button" id="open-fullscreen-menu-button">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        

        <nav class="header-menu">
            <div class="close-button-container">
            <div class="logo-container">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    ?>
                    <a href="<?php echo home_url(); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Logo.png" alt="Site Logo">
                    </a>
                </div>
                <button id="close-fullscreen-menu-button" class="close-button">X</button>
                <!-- Bouton pour fermer le menu mobile -->
            </div>
            
            <?php
            wp_nav_menu([
                'theme_location' => 'header-menu',
                'container'      => false
            ]);
            ?>
            <!-- Modal -->
            <?php include ( 'templates_part/modal.php')?>
        </nav>
    </header>
