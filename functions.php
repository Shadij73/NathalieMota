<?php
function custom_enqueue_assets() {
    // Preconnect to Google Fonts
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";

    // Enqueue Google Fonts
    wp_enqueue_style('custom-google-fonts', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', false);
}
add_action('wp_head', 'custom_enqueue_assets', 5); // Loads in <head> for better performance

// Enqueue theme scripts and styles
function theme_enqueue_scripts() {
    wp_enqueue_style('theme-style', get_stylesheet_uri());
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// Register navigation menu
function register_theme_menus() {
    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'nathaliemota'),
    ));
}
add_action('after_setup_theme', 'register_theme_menus');

// Add theme support
function theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'theme_setup');
?>
