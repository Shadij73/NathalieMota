<!-- Lightbox -->
<div id="myLightbox" class="lightbox">
    <!-- Bouton de fermeture du Lightbox -->
    <button class="lightbox__close">
        <img src="<?php echo get_template_directory_uri(); ?>/img_logo/close-lightbox.png" alt="Croix">
    </button>

    <!-- Navigation dans le Lightbox (précédent/suivant) -->
    <div class="lightbox__navigation">
        <!-- Bouton pour aller à l'image précédente -->
        <button class="lightbox__prev">
            <p>Précédente</p>
        </button>

        <!-- Bouton pour aller à l'image suivante -->
        <button class="lightbox__next">
            <p>Suivante</p>
        </button>
    </div>

    <!-- Conteneur principal pour le contenu du Lightbox -->
    <div class="lightbox__container">
        <?php
        // Récupération des catégories liées au post courant
        $related_categories = get_the_terms(get_the_ID(), 'categorie');
        $related_category_names = array();
        if ($related_categories) {
            foreach ($related_categories as $category) {
                $related_category_names[] = esc_html($category->name);
            }
        } 
        ?>  
        <?php if (has_post_thumbnail()) : ?>
            <?php $thumbnail_id = get_post_thumbnail_id(); ?>
            <?php $thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'large')[0]; ?>
            <?php $reference_photo = get_field('reference', $thumbnail_id); ?>
            <!-- Lien contenant l'image en taille large, la référence et les catégories comme attributs data- pour utilisation dans le script -->
            <a data-href="<?php echo $thumbnail_src; ?>" data-reference="<?php echo $reference_photo; ?>" data-category="<?php echo implode(',', $related_category_names); ?>" class="photo-lightbox">
                <!-- Affichage de l'image à la taille post-thumbnail -->
                <?php the_post_thumbnail(); ?>
            </a>
        <?php endif; ?>
    </div>

    <!-- Informations supplémentaires sur la photo affichée dans le Lightbox -->
    <div class="photo-info-lightbox">
        <!-- Emplacement pour la référence de la photo -->
        <div class="photo-info-left-lightbox">
            <!-- référence -->
        </div>

        <!-- Emplacement pour la catégorie de la photo -->
        <div class="photo-info-right-lightbox">
            <!-- catégorie -->
        </div>
    </div>
</div>
