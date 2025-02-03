<!-- Button to open modal -->
<button id="myBtn-photo" data-reference="<?php echo esc_attr($reference_photo); ?>">Contact</button>

<!-- Unified Modal for Contact and Photo -->
<div id="myModal-photo" class="modal">
    <div class="modal-content">
        <!-- Image Header -->
        <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Contact header.png" alt="Modal Image">
        <!-- Contact Form -->
        <?php echo do_shortcode('[contact-form-7 id="4ebebfb" title="Contact form 1"]'); ?>
    </div>
</div>