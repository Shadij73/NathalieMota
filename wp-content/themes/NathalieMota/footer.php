<?php get_template_part('templates_part/contact-modal'); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/scripts.js"></script>

<footer>
    <nav class="footer-menu">
        <ul>
            <li><a href="<?php echo esc_url(get_permalink(get_page_by_title('Mentions légales'))); ?>">MENTIONS LÉGALES</a></li>
            <li><a href="<?php echo esc_url(get_permalink(get_page_by_title('Vie privée'))); ?>">VIE PRIVÉE</a></li>
            <li><a href="#">TOUS DROITS RÉSERVÉS</a></li>
        </ul>
    </nav>
    <p>&copy; <?php echo date('Y'); ?> Tous droits réservés.</p>
</footer>


<?php wp_footer(); ?>
</body>
</html>

<button id="open-modal">Contact</button>
<?php get_template_part('templates_part/contact-modal'); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/scripts.js"></script>
