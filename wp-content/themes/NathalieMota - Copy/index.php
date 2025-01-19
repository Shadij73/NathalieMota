<?php get_header(); ?>

<div class="hero">

    <?php
        // Configuration des arguments pour récupérer une photo aléatoire
        $args_related_photos = array(
            'post_type' => 'photo', 
            'posts_per_page' => 1,
            'orderby' => 'rand', 
        );
        // Création de la requête personnalisée pour récupérer la photo
        $related_photos_query = new WP_Query($args_related_photos);

        // Boucle sur la requête pour afficher la photo
        while ($related_photos_query->have_posts()) :
            $related_photos_query->the_post();// Prépare les données de la publication en cours
            $post_permalink = get_permalink();// Récupère le lien permanent de la publication
    ?>
    <a href="<?php echo esc_url($post_permalink); ?>">

            <div class="hero-image" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');">
                <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Titre header.png" alt="Titre Accueil">
            </div>

    </a>

        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>
        <!-- Réinitialise les données de la requête pour éviter des conflits avec d'autres boucles -->
</div>

<!-- Conteneur pour les photos listées -->
<div id="photo-container">
    <?php include ( 'templates_part/liste_photo.php')?>
</div>

<?php get_footer(); ?>
<?php include_once "header.php"; ?>

<?php include_once "functions.php"; ?>

<?php register_header_menu(); ?>

<?php register_footer_menu(); ?>

<?php enqueue_custom_styles(); ?>

<?php enqueue_custom_scripts(); ?>

<?php enqueue_font_awesome(); ?>

<?php load_more_posts(); ?>

<?php load_filtered_posts(); ?>
