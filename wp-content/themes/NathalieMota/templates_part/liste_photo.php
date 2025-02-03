<!-- Filters -->
<div class="filters-and-sort">
    <!-- Category Filter -->
    <div class="filter-list">
        <?php
        $photo_categories = get_terms('categorie'); // Replace 'categorie' with your taxonomy name if different
        ?>
        <select name="category-list" id="category-filter-list">
            <option value="" selected>CATÉGORIES</option>
            <?php
            if (!is_wp_error($photo_categories) && !empty($photo_categories)) {
                foreach ($photo_categories as $category) {
                    echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
                }
            } else {
                echo '<option value="">No categories available</option>';
            }
            ?>
        </select>
    </div>

    <!-- Format Filter -->
    <div class="filter-list">
        <?php
        $photo_formats = get_terms('format'); // Replace 'format' with your taxonomy name if different
        ?>
        <select name="format-list" id="format-filter-list">
            <option value="" selected>FORMATS</option>
            <?php
            if (!is_wp_error($photo_formats) && !empty($photo_formats)) {
                foreach ($photo_formats as $format) {
                    echo '<option value="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</option>';
                }
            } else {
                echo '<option value="">No formats available</option>';
            }
            ?>
        </select>
    </div>

    <!-- Sort Filter -->
    <div class="filter-list">
        <select id="date-sort" name="date-sort">
            <option value="" selected>TRIER PAR</option>
            <option value="DESC">À partir des plus récentes</option>
            <option value="ASC">À partir des plus anciennes</option>
        </select>
    </div>
</div>

<!-- Photo List -->
<div id="photo-container">
    <input type="hidden" name="page" value="1"> <!-- Tracks current pagination -->

    <div class="thumbnail-container-accueil">
        <?php
        // Set up the query for initial photo display
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = [
            'post_type'      => 'photo',
            'posts_per_page' => 8,
            'paged'          => $paged,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) :
                $query->the_post();
                ?>
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
            <?php
            endwhile;
        else :
            echo '<p>Aucune photo trouvée.</p>';
        endif;

        // Reset post data
        wp_reset_postdata();
        ?>
    </div>

    <!-- Load More Button -->
    <div class="view-all-button">
        <button id="load-more-posts"
                data-ajaxurl="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"
                data-nonce="<?php echo wp_create_nonce('load_more_posts_nonce'); ?>">
            Charger plus
        </button>
    </div>
</div>
