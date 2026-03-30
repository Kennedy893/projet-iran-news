<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard admin | Iran Info</title>
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/variables.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/responsive.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/admin-dashboard.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body>
    <header class="site-header admin-site-header" role="banner">
        <div class="container">
            <a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>" class="site-logo" aria-label="Iran Info - Retour a l'accueil">
                <span aria-hidden="true">📰</span>
                <span>Iran Info Admin</span>
            </a>
            <nav class="main-nav admin-main-nav" aria-label="Navigation principale admin">
                <a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>">Accueil</a>
                <a href="<?= htmlspecialchars(app_url('search'), ENT_QUOTES, 'UTF-8') ?>">Recherche</a>
                <a class="active" href="<?= htmlspecialchars(app_url('admin/dashboard'), ENT_QUOTES, 'UTF-8') ?>">Dashboard</a>
                <a href="<?= htmlspecialchars(app_url('admin/articles'), ENT_QUOTES, 'UTF-8') ?>">Articles</a>
                <a href="<?= htmlspecialchars(app_url('admin/categories'), ENT_QUOTES, 'UTF-8') ?>">Categories</a>
                <a href="<?= htmlspecialchars(app_url('admin/logout'), ENT_QUOTES, 'UTF-8') ?>">Se deconnecter</a>
            </nav>
        </div>
    </header>

<main class="admin-shell container" role="main">
    <section class="admin-page-intro card">
        <h1 class="admin-title">Dashboard Backoffice</h1>
        <p class="admin-subtitle">Bienvenue, <?= htmlspecialchars((string) ($admin['nom'] ?? 'admin'), ENT_QUOTES, 'UTF-8') ?>. Vue globale de l'activite editoriale.</p>
    </section>

    <section class="grid-stats" aria-label="Statistiques principales">
        <article class="stat-card">
            <div class="stat-label">Articles publies</div>
            <div class="stat-value"><?= (int) ($stats['articles_total'] ?? 0) ?></div>
        </article>
        <article class="stat-card">
            <div class="stat-label">Categories actives</div>
            <div class="stat-value"><?= (int) ($stats['categories_total'] ?? 0) ?></div>
        </article>
        <article class="stat-card">
            <div class="stat-label">Articles aujourd'hui</div>
            <div class="stat-value"><?= (int) ($stats['articles_today'] ?? 0) ?></div>
        </article>
    </section>

    <section class="layout-two">
        <article class="card">
            <h2>Derniers articles</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Categorie</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($recentArticles)): ?>
                        <tr><td colspan="3" class="text-muted">Aucun article disponible.</td></tr>
                    <?php else: ?>
                        <?php foreach ($recentArticles as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) ($item['titre'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars((string) ($item['category_name'] ?? 'N/A'), ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars((string) ($item['date_pub'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <p><a class="btn btn-primary" href="<?= htmlspecialchars(app_url('admin/articles'), ENT_QUOTES, 'UTF-8') ?>">Acceder a la gestion des articles</a></p>
        </article>

        <article class="card">
            <h2>Categories les plus utilisees</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Categorie</th>
                        <th>Articles</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($topCategories)): ?>
                        <tr><td colspan="2" class="text-muted">Aucune categorie disponible.</td></tr>
                    <?php else: ?>
                        <?php foreach ($topCategories as $cat): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) ($cat['libelle'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= (int) ($cat['article_count'] ?? 0) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <p><a class="btn btn-primary" href="<?= htmlspecialchars(app_url('admin/categories'), ENT_QUOTES, 'UTF-8') ?>">Acceder a la gestion des categories</a></p>
        </article>
    </section>
</main>
</body>
</html>
