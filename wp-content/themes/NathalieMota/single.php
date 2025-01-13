<?php
get_header();
?>


<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        while ( have_posts() ) :
            the_post();
            // Display post content
            the_content();
            // If comments are open or there's at least one comment, load the comment template
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            // Post navigation
            the_post_navigation();
        endwhile;
        ?>
    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php
get_footer();
?>