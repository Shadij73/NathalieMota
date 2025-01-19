<!-- Filtres -->
<div class="filters-and-sort">
    <!-- Filtre par Catégorie -->
    <div class="filter-list" id="category-filter-list">
        <div class="filter-container">
            <p>Catégories</p>
            <!-- Icône du chevron pour l'interaction déroulante -->
            <img src="<?php echo get_template_directory_uri(); ?>/img_logo/chevron.png" class="chevron-icon"> 
        </div>
        <!-- Liste des options de catégories récupérées depuis WordPress -->
        <ul>
            <li data-value="ALL"></li> <!-- Option pour sélectionner toutes les catégories -->
            <?php
            // Boucle pour afficher toutes les catégories disponibles
            $photo_categories = get_terms('categorie');
            foreach ($photo_categories as $category) {
                echo '<li data-value="' . $category->slug . '">' . $category->name . '</li>';
            }
            ?>
        </ul>
    </div>

    <!-- Filtre par Format -->
    <div class="filter-list" id="format-filter-list">
        <div class="filter-container">
            <p>Formats</p>
            <!-- Icône du chevron pour l'interaction déroulante -->
            <img src="<?php echo get_template_directory_uri(); ?>/img_logo/chevron.png" class="chevron-icon"> 
        </div>
        <!-- Liste des options de formats récupérées depuis WordPress -->
        <ul>
            <li data-value="ALL"></li> <!-- Option pour sélectionner tous les formats -->
            <?php
            // Boucle pour afficher tous les formats disponibles
            $photo_formats = get_terms('format');
            foreach ($photo_formats as $format) {
                echo '<li data-value="' . $format->slug . '">' . $format->name . '</li>';
            }
            ?>
        </ul>
    </div>

    <!-- Filtre pour Trier par date -->
    <div class="filter-list" id="date-sort-list">
        <div class="filter-container">
            <p>TRIER PAR</p>
            <!-- Icône du chevron pour l'interaction déroulante -->
            <img src="<?php echo get_template_directory_uri(); ?>/img_logo/chevron.png" class="chevron-icon"> 
        </div>
        <!-- Options de tri -->
        <ul>
            <li data-value="ALL"></li> <!-- Option pour annuler le tri spécifique -->
            <li data-value="DESC">À partir des plus récentes</li> <!-- Tri par ordre décroissant -->
            <li data-value="ASC">À partir des plus anciennes</li> <!-- Tri par ordre croissant -->
        </ul>
    </div>
</div>

<!-- Liste Photo -->
<div class="custom-post-thumbnail">
    <!-- Stockage de la page actuelle pour la pagination -->
    <input type="hidden" name="page" value="1">

    <!-- Conteneur pour les vignettes des posts -->
    <div class="thumbnail-container-accueil">
        <?php
        // Préparation de la requête pour récupérer les posts de type 'photo'
        $args_custom_posts = array(
            'post_type' => 'photo', 
            'posts_per_page' => 8, // Limite du nombre de posts par page
            'paged' => $paged, // Pagination
            'orderby' => 'date', // Trier par date
            'order' => 'DESC', // Ordre décroissant
        );

        // Exécution de la requête
        $custom_posts_query = new WP_Query($args_custom_posts);

        // Boucle sur les résultats
        while ($custom_posts_query->have_posts()) :
            $custom_posts_query->the_post();
        ?>

            <div class="custom-post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <!-- Vérification si le post a une image mise en avant -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="thumbnail-wrapper">
                            <a href="<?php the_permalink(); ?>">
                            <!-- Affichage de l'image mise en avant -->
                            <?php the_post_thumbnail(); ?>

                            <!-- Overlay avec des informations supplémentaires et icône d'agrandissement -->
                            <div class="thumbnail-overlay">
                                <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Icon_eye.png" alt="Icône d'oeil">

                                <button class="fullscreen-icon" 
                                    data-src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0]; ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Icon_fullscreen.png" alt="Icône de plein écran" class="fullscreen-trigger">
                                </button>

                                <!-- Informations supplémentaires sur la photo -->
                                <?php
                                // Récupération de la référence et des catégories associées à la photo
                                $related_reference_photo = get_field('reference');
                                $related_categories = get_the_terms(get_the_ID(), 'categorie');
                                $related_category_names = array();

                                if ($related_categories) {
                                    foreach ($related_categories as $category) {
                                        $related_category_names[] = esc_html($category->name);
                                    }
                                }
                                ?>
                                <div class="photo-info">
                                    <div class="photo-info-left">
                                        <p><?php echo esc_html($related_reference_photo); ?></p>
                                    </div>
                                    <div class="photo-info-right">
                                        <p><?php echo implode(', ', $related_category_names); ?></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            </a>
        </div>

        <?php endwhile; ?>

        <!-- Réinitialisation de la requête globale de WordPress -->
        <?php wp_reset_postdata(); ?>
    </div>

    <!-- Bouton pour charger plus de posts -->
    <div class="view-all-button">
        <button id="load-more-posts"
                data-ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>"
                data-nonce="<?php echo wp_create_nonce('load_more_posts_nonce'); ?>">
            Charger plus
        </button>
    </div>
</div>
