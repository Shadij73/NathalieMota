<?php get_template_part('templates_part/contact-modal'); ?>

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
