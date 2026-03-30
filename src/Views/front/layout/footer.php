
    <footer class="site-footer" role="contentinfo">
        <div class="container">
            <div class="footer-content">
                <p>&copy; <?= date('Y') ?> Iran Info. Tous droits réservés.</p>
                <p class="footer-tagline">Information objective sur le conflit en Iran</p>
            </div>
            <nav class="footer-nav" aria-label="Liens utiles">
                <a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>">Accueil</a>
                <a href="<?= htmlspecialchars(app_url('search'), ENT_QUOTES, 'UTF-8') ?>">Recherche</a>
                <a href="<?= htmlspecialchars(app_url('sitemap.php'), ENT_QUOTES, 'UTF-8') ?>">Plan du site</a>
                <a href="<?= htmlspecialchars(app_url('mentions-legales'), ENT_QUOTES, 'UTF-8') ?>">Mentions légales</a>
            </nav>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="<?= htmlspecialchars(app_url('assets/js/main.js'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
</body>
</html>
