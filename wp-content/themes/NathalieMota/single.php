<?php get_header(); ?>

<main id="main" class="content-area">
    <div class="zone-contenu mobile-first">
        <div class="left-container">
            <div class="left-contenu">
                <h2><?php the_title(); ?></h2>
                <?php
                $reference_photo = get_field('reference');
                if ($reference_photo) {
                    echo '<p>Référence : ' . esc_html($reference_photo) . '</p>';
                }

                $categories = get_the_terms(get_the_ID(), 'categorie');
                $current_category_slugs = [];
                if ($categories) {
                    foreach ($categories as $category) {
                        $current_category_slugs[] = $category->slug;
                    }
                    $category_names = array_map(function($cat) {
                        return esc_html($cat->name);
                    }, $categories);
                    echo '<p>Catégorie : ' . implode(', ', $category_names) . '</p>';
                }

                $formats = get_the_terms(get_the_ID(), 'format');
                if ($formats) {
                    $format_names = array_map(function($format) {
                        return esc_html($format->name);
                    }, $formats);
                    echo '<p>Format : ' . implode(', ', $format_names) . '</p>';
                }

                $type_de_photo = get_field('type');
                if ($type_de_photo) {
                    echo '<p>Type : ' . esc_html($type_de_photo) . '</p>';
                }

                $date_capture = get_the_date('Y');
                if ($date_capture) {
                    echo '<p>Année : ' . esc_html($date_capture) . '</p>';
                }
                ?>
            </div>
        </div>
        <div class="right-container">
            <?php if (has_post_thumbnail()) : ?>
                <a data-href="<?php echo esc_url(wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0]); ?>" class="photo">
                    <?php the_post_thumbnail(); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="zone-contact">
        <div class="left-contact">
            <p class="texte-contact">Cette photo vous intéresse ?</p>
            <div class="bouton-contact">
                <?php include 'templates_part/modal-photo.php'; ?>
            </div>
        </div>
        <div class="right-contact">
            <?php
            $current_post_id = get_the_ID();
            $all_photo_posts = get_posts(['post_type' => 'photo', 'posts_per_page' => -1, 'order' => 'ASC']);
            $current_index = array_search($current_post_id, wp_list_pluck($all_photo_posts, 'ID'));

            $prev_post = $all_photo_posts[$current_index - 1] ?? end($all_photo_posts);
            $next_post = $all_photo_posts[$current_index + 1] ?? reset($all_photo_posts);
            ?>
<div class="thumbnail-container">
    <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="arrow-link">
        <img class="arrow-img arrow-img-gauche" src="<?php echo esc_url(get_template_directory_uri() . '/img_logo/fleche-gauche.png'); ?>" alt="Précédent">
    </a>

    <!-- Display current post thumbnail -->
    <div class="current-thumbnail">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('thumbnail', ['class' => 'post-thumbnail']); ?>
        <?php endif; ?>
    </div>

    <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="arrow-link">
        <img class="arrow-img arrow-img-droite" src="<?php echo esc_url(get_template_directory_uri() . '/img_logo/fleche-droite.png'); ?>" alt="Suivant">
    </a>
</div>

        </div>
    </div>

    <div class="related-images">
        <h3>VOUS AIMEREZ AUSSI</h3>
        <div class="image-container">
            <?php
            // Pass $current_category_slugs to the photo_block.php
            include locate_template('templates_part/photo_block.php', false, false);
            ?>
        </div>
    </div>
</main>
<script src="<?php echo esc_url(get_template_directory_uri() . '/js/scripts.js'); ?>"></script>
<?php get_footer(); ?>
