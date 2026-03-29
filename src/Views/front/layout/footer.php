<footer class="site-footer" style="margin-top:2rem;padding:1.25rem 1rem;border-top:1px solid #ddd;">
    <div class="container" style="display:flex;flex-wrap:wrap;justify-content:space-between;gap:1rem;">
        <p style="margin:0;">&copy; <?= date('Y') ?> Iran Info. Tous droits reserves.</p>
        <nav aria-label="Liens utiles" style="display:flex;gap:1rem;">
            <a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>">Accueil</a>
            <a href="<?= htmlspecialchars(app_url('search'), ENT_QUOTES, 'UTF-8') ?>">Recherche</a>
            <a href="<?= htmlspecialchars(app_url('sitemap.php'), ENT_QUOTES, 'UTF-8') ?>">Plan du site</a>
        </nav>
    </div>
</footer>

<script src="<?= htmlspecialchars(app_url('assets/js/main.js'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
</body>
</html>
