<!-- Modal for Contact -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <!-- Modal Header with Image -->
        <div class="modal-header">
            <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Contact header.png" alt="Contact Header Image" class="modal-header-image">
        </div>
        <div class="modal-body">
            <!-- Contact Form 7 Shortcode -->
            <?php echo do_shortcode('[contact-form-7 id="4ebebfb" title="Contact form 1"]'); ?>
        </div>
    </div>
</div>