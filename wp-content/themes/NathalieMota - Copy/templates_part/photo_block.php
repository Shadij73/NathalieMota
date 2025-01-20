<div class="image-container">
    <?php
    // Préparation des arguments pour récupérer les photos liées
    $args_related_photos = array(
        'post_type' => 'photo', // Type de publication : photo
        'posts_per_page' => 2, // Nombre de photos à afficher : 2
        'orderby' => 'rand', // Ordonner par ordre aléatoire
        'tax_query' => array( // Requête de taxonomie pour filtrer les photos par catégorie
            array(
                'taxonomy' => 'categorie', // Taxonomie : categorie
                'field' => 'slug', // On utilise le slug de la catégorie pour le filtrage
                'terms' => $current_category_slugs, // Les slugs des catégories courantes
            ),
        ),
    );

    // Création de la requête pour les photos liées
    $related_photos_query = new WP_Query($args_related_photos);

    // Boucle sur les photos liées trouvées
    while ($related_photos_query->have_posts()) :
        $related_photos_query->the_post();
    ?>
        <div class="related-image">
            <a href="<?php the_permalink(); ?>"> <!-- Lien vers la photo détaillée -->
                <?php if (has_post_thumbnail()) : ?> <!-- Vérifie si la photo a une image à la une -->
                    <div class="image-wrapper">
                        <?php the_post_thumbnail(); ?> <!-- Affiche l'image à la une -->
                        <!-- Overlay -->
                        <div class="thumbnail-overlay-single">
                            <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Icon_eye.png" alt="Icône de l'œil">
                            
                            <!-- Bouton pour afficher l'image en plein écran -->
                            <button class="fullscreen-icon" data-src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0]; ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Icon_fullscreen.png" alt="Icône plein écran" class="fullscreen-trigger">
                            </button>

                            <?php

                            // Récupère les références et catégories liées à la photo
                            $related_reference_photo = get_field('reference');
                            $related_categories = get_the_terms(get_the_ID(), 'categorie');
                            $related_category_names = array();

                            if ($related_categories) { // Si des catégories sont associées
                                foreach ($related_categories as $category) { // Boucle sur chaque catégorie
                                    $related_category_names[] = esc_html($category->name); // Ajoute le nom de la catégorie à la liste
                                }
                            }
                            ?>
                            <div class="photo-info">
                                <div class="photo-info-left">
                                    <p><?php echo esc_html($related_reference_photo); ?></p> <!-- Affiche la référence -->
                                </div>
                                <div class="photo-info-right">
                                    <p><?php echo implode(', ', $related_category_names); ?></p> <!-- Liste des catégories -->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </a>
        </div>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?> <!-- Réinitialise les données de la requête -->
</div>
