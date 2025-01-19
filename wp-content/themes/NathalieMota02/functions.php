<?php

// Enregistrement du menu principal dans l'entête
function register_header_menu() {
    register_nav_menu( 'header-menu', __( 'Menu principal', 'text-domain' ) );
}
add_action( 'after_setup_theme', 'register_header_menu' );

// Enregistrement du menu dans le pied de page
function register_footer_menu() {
    register_nav_menu( 'footer-menu', __( 'Footer Menu', 'text-domain' ) );
}
add_action( 'after_setup_theme', 'register_footer_menu' );


/* STYLE  */
// Chargement des feuilles de style personnalisées
function enqueue_custom_styles() {
    wp_enqueue_style('custom-theme-css', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('custom-theme-css', get_template_directory_uri() . '/css/fonts.css', array(), '1.0', 'all');
    wp_enqueue_style('custom-theme-css', get_template_directory_uri() . '/css/header.css', array(), '1.0', 'all');
    wp_enqueue_style('custom-theme-css', get_template_directory_uri() . '/css/footer.css', array(), '1.0', 'all');
    wp_enqueue_style('custom-theme-css', get_template_directory_uri() . '/css/single.css', array(), '1.0', 'all');
    wp_enqueue_style('custom-theme-css', get_template_directory_uri() . '/css/index.css', array(), '1.0', 'all');
    wp_enqueue_style('custom-theme-css', get_template_directory_uri() . '/css/liste-photo.css', array(), '1.0', 'all');
    wp_enqueue_style('custom-theme-css', get_template_directory_uri() . '/css/lightbox.css', array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

/* SCRIPT */
// Chargement des scripts personnalisés
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

/* IMG MIS EN AVANT */
add_theme_support( 'post-thumbnails' );

/* FONTAWESOME */
// Chargement de Font Awesome
function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

/* CHARGER PLUS */
// Fonction pour charger plus de posts via AJAX
function load_more_posts() {
    check_ajax_referer('load_more_posts_nonce', 'security');

    $page = $_POST['page'];

    $offset = ($page - 1) * 8;

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
        'offset' => $offset
    );

    $custom_posts_query = new WP_Query($args);

    if ($custom_posts_query->have_posts()) {
        ob_start(); 
        while ($custom_posts_query->have_posts()) {
            $custom_posts_query->the_post();
            
            ?>
            <div class="custom-post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="thumbnail-wrapper">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail(); ?>
                                <!-- Overlay -->
                                <div class="thumbnail-overlay">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Icon_eye.png" alt="Eye Icon">
                                    <button class="fullscreen-icon" 
                                        data-src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0]; ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Icon_fullscreen.png" alt="fullscreen-icon" class="fullscreen-trigger">
                                    </button>
                                    <?php
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
            <?php
        }
        wp_reset_postdata();
        $response = ob_get_clean(); 
        echo $response; 
    } else {
        wp_die();
    }
    die(); 
}

add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

// FILTRES
// Fonction pour charger des posts filtrés via AJAX
function load_filtered_posts() {
    check_ajax_referer('load_more_posts_nonce', 'security');

    // Récupération des paramètres de filtre
    $page = $_POST['page'];
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $format = isset($_POST['format']) ? $_POST['format'] : '';
    $sort = isset($_POST['sort']) ? $_POST['sort'] : 'DESC';

    // Configuration des arguments de la requête selon les filtres
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $page,
        'orderby' => 'date',
        'order' => $sort
    );

    // Catégorie
    if ($category !== 'ALL' && !empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category
        );
    }

    // Format
    if ($format !== 'ALL' && !empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format
        );
    }

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="custom-post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="thumbnail-wrapper">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail(); ?>
                                <!-- Overlay -->
                                <div class="thumbnail-overlay">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Icon_eye.png" alt="Eye Icon">
                                    <button class="fullscreen-icon" 
                                        data-src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0]; ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img_logo/Icon_fullscreen.png" alt="fullscreen-icon" class="fullscreen-trigger">
                                    </button>
                                    <?php
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
            <?php
        }
        wp_reset_postdata();
        $response = ob_get_clean();
        echo $response;
    } else {
        echo 'Aucun résultat trouvé.';
    }
    die();
}

add_action('wp_ajax_load_filtered_posts', 'load_filtered_posts');
add_action('wp_ajax_nopriv_load_filtered_posts', 'load_filtered_posts');

