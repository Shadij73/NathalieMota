<footer>
    <!-- Navigation dans le pied de page -->
    <nav class="footer-menu">
        <?php
        // Affiche le menu assigné à l'emplacement "footer-menu" dans l'administration de WordPress
        wp_nav_menu([
            'theme_location' => 'footer-menu',
        ]);
        ?>
    </nav>
    <!-- Inclut le fichier lightbox.php depuis le dossier templates_part pour la fonctionnalité de lightbox -->
    <?php include ('templates_part/lightbox.php')?>

</footer>
<!-- Inclut tous les scripts nécessaires de WordPress et des plugins, juste avant la fermeture du body -->
<?php wp_footer(); ?>
</body>
</html>
