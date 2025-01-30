<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Nathalie Mota</title>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Initialize JavaScript variable 'ajaxurl' -->
    <script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>

    <!-- Theme stylesheets -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/components.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/layout.css">
    <style>
        :root {
            --chemin-image-chevron: url('<?php echo get_template_directory_uri(); ?>/img_logo/chevron.png');
        }
    </style>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- WordPress head hook -->
    <?php wp_head(); ?>
</head>
<body>
    <header>
        <div class="header-logo">
            <?php
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            ?>
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Logo.png" alt="Site Logo">
            </a>
        </div>

        <!-- Mobile Menu Button -->
        <div class="mobile-menu-button" id="open-fullscreen-menu-button">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <nav class="header-menu">
            <div class="close-button-container">
                <div class="logo-container">
                    <a href="<?php echo home_url(); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Logo.png" alt="Site Logo">
                    </a>
                </div>
                <button id="close-fullscreen-menu-button" class="close-button">X</button>
            </div>

            <?php
            wp_nav_menu([
                'theme_location' => 'header-menu',
                'container'      => false
            ]);
            ?>

            <!-- Modal -->
            <?php include 'templates_part/modal.php'; ?>
        </nav>
    </header>
