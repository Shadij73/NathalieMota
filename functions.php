<?php
function mon_theme_enqueue_styles() {
    wp_enqueue_style('mon-theme-style', get_stylesheet_uri());
    wp_enqueue_script('mon-theme-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_styles');

function mon_theme_register_menus() {
    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'mon-theme')
    ));
}
add_action('init', 'mon_theme_register_menus');
?>
