<?php

// Register header and footer menus
function register_menus() {
    register_nav_menu('header-menu', __('Main Menu', 'text-domain'));
    register_nav_menu('footer-menu', __('Footer Menu', 'text-domain'));
}
add_action('after_setup_theme', 'register_menus');

// Enqueue custom styles
function enqueue_custom_styles() {
    $styles = [
        'style.css',
        'css/fonts.css',
        'css/header.css',
        'css/footer.css',
        'css/single.css',
        'css/index.css',
        'css/liste-photo.css',
        'css/lightbox.css',
    ];

    foreach ($styles as $style) {
        wp_enqueue_style(
            'custom-' . md5($style),
            get_template_directory_uri() . '/' . $style,
            [],
            '1.0',
            'all'
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

// Enqueue custom scripts with AJAX nonce
function enqueue_custom_scripts() {
    wp_enqueue_script(
        'custom-scripts',
        get_template_directory_uri() . '/js/scripts.js',
        ['jquery'],
        '1.0',
        true
    );

    wp_localize_script('custom-scripts', 'ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('ajax_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// Add theme support for featured images
add_theme_support('post-thumbnails');

// Enqueue Font Awesome
function enqueue_font_awesome() {
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css',
        [],
        '5.15.3'
    );
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

// Load more posts via AJAX
function load_more_posts() {
    check_ajax_referer('load_more_posts_nonce', 'security');

    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $offset = ($page - 1) * 8;

    $args = [
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'offset'         => $offset,
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            include locate_template('template-parts/photo-thumbnail.php');
        }
        wp_reset_postdata();
        echo ob_get_clean();
    } else {
        wp_die();
    }
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

// Load more photos via AJAX
function load_more_photos() {
    if (!isset($_POST['page']) || !isset($_POST['security'])) {
        wp_send_json_error('Invalid parameters');
        exit;
    }

    if (!wp_verify_nonce($_POST['security'], 'load_more_posts_nonce')) {
        wp_send_json_error('Invalid nonce');
        exit;
    }

    $page = intval($_POST['page']);
    $args = [
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $page,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <div class="custom-post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="thumbnail-wrapper">
                            <?php the_post_thumbnail(); ?>
                            <div class="thumbnail-overlay">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/img_logo/Icon_eye.png'); ?>" alt="Eye Icon">
                                <button class="fullscreen-icon" data-src="<?php echo esc_url(wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0]); ?>">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/img_logo/Icon_fullscreen.png'); ?>" alt="Fullscreen Icon">
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </a>
            </div>
        <?php }
        wp_reset_postdata();
        $html = ob_get_clean();
        wp_send_json_success($html);
    } else {
        wp_send_json_error('No more photos');
    }
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

// Load filtered posts via AJAX
function load_filtered_posts() {
    check_ajax_referer('ajax_nonce', 'nonce');

    $category = sanitize_text_field($_POST['categorie']);

    $args = [
        'post_type'      => 'photo',
        'posts_per_page' => -1,
        'tax_query'      => [
            [
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => $category,
            ],
        ],
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <div class="custom-post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="thumbnail-wrapper">
                            <?php the_post_thumbnail(); ?>
                            <div class="thumbnail-overlay">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/img_logo/Icon_eye.png'); ?>" alt="Eye Icon">
                                <button class="fullscreen-icon" data-src="<?php echo esc_url(wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0]); ?>">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/img_logo/Icon_fullscreen.png'); ?>" alt="Fullscreen Icon">
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </a>
            </div>
        <?php }
        wp_reset_postdata();
        $data = ob_get_clean();
        wp_send_json_success($data);
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_load_filtered_posts', 'load_filtered_posts');
add_action('wp_ajax_nopriv_load_filtered_posts', 'load_filtered_posts');
