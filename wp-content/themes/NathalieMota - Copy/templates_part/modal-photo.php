<!-- Bouton pour ouvrir le modal de contact -->
<button id="myBtn-photo" data-reference="<?php echo esc_attr($reference_photo); ?>">Contact</button>

<!-- Modal de contact -->
<div id="myModal-photo" class="modal-photo">

    <!-- Contenu du modal -->
    <div class="modal-content-photo">
        <!-- Image dans l'entête du modal -->
        <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Contact header.png" alt="Image Modal">

        <!-- Formulaire de contact généré par le shortcode de Contact Form 7 -->
        <?php echo do_shortcode('[contact-form-7 id="2cc0601" title="Modal Contact 1"]'); ?>
    </div>

</div>
