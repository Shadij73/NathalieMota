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
        wp_enqueue_style('custom-' . md5($style), get_template_directory_uri() . '/' . $style, [], '1.0', 'all');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

// Enqueue custom scripts with AJAX nonce
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/js/scripts.js', ['jquery'], '1.0', true);
    wp_localize_script('custom-scripts', 'ajax_data', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('load_more_posts_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// Add theme support for featured images
add_theme_support('post-thumbnails');

// Enqueue Font Awesome
function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

// Load more posts via AJAX
function load_more_posts() {
    check_ajax_referer('load_more_posts_nonce', 'security');
    $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
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

// Load filtered posts via AJAX
function load_filtered_posts() {
    check_ajax_referer('load_more_posts_nonce', 'security');

    $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : 'DESC';

    $args = [
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $page,
        'orderby'        => 'date',
        'order'          => $sort,
    ];

    if (!empty($category) && $category !== 'ALL') {
        $args['tax_query'][] = [
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category,
        ];
    }

    if (!empty($format) && $format !== 'ALL') {
        $args['tax_query'][] = [
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        ];
    }

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
        echo 'No results found.';
    }
    die();
}
add_action('wp_ajax_load_filtered_posts', 'load_filtered_posts');
add_action('wp_ajax_nopriv_load_filtered_posts', 'load_filtered_posts');
