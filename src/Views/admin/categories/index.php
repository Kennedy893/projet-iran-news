<?php
$flash = $flash ?? null;
$categories = $categories ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des categories | Admin</title>
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/variables.min.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/style.min.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/responsive.min.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/admin-dashboard.min.css'), ENT_QUOTES, 'UTF-8') ?>">
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
                <a href="<?= htmlspecialchars(app_url('admin/dashboard'), ENT_QUOTES, 'UTF-8') ?>">Dashboard</a>
                <a href="<?= htmlspecialchars(app_url('admin/articles'), ENT_QUOTES, 'UTF-8') ?>">Articles</a>
                <a class="active" href="<?= htmlspecialchars(app_url('admin/categories'), ENT_QUOTES, 'UTF-8') ?>">Categories</a>
                <a href="<?= htmlspecialchars(app_url('admin/logout'), ENT_QUOTES, 'UTF-8') ?>">Se deconnecter</a>
            </nav>
        </div>
    </header>

<main class="admin-shell container" role="main">
    <section class="admin-page-intro card">
        <h1 class="admin-title">Gestion des categories</h1>
        <p class="admin-subtitle">Pilotez les categories de contenus.</p>
    </section>

    <?php if (!empty($flash)): ?>
        <div class="flash <?= htmlspecialchars((string) ($flash['type'] ?? 'success'), ENT_QUOTES, 'UTF-8') ?>">
            <?= htmlspecialchars((string) ($flash['message'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <section class="card list-card">
        <div class="section-toolbar section-toolbar-strong">
            <div>
                <h2>Liste des categories</h2>
                <p class="text-muted" style="margin:.2rem 0 0;">Chaque categorie est clairement separee pour une gestion plus rapide.</p>
            </div>
            <button type="button" class="btn btn-primary btn-add-prominent js-open-modal" data-target-modal="category-create-modal">+ Ajouter une categorie</button>
        </div>

        <?php if (empty($categories)): ?>
            <p class="text-muted">Aucune categorie disponible.</p>
        <?php else: ?>
            <div class="entity-list entity-list-categories">
                <?php foreach ($categories as $cat): ?>
                    <?php $catId = (int) ($cat['id'] ?? 0); ?>
                    <article class="entity-item category-item">
                        <div class="entity-head">
                            <h3 class="item-title"><?= htmlspecialchars((string) ($cat['libelle'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h3>
                            <div class="entity-meta">
                                <span class="tag"><?= (int) ($cat['article_count'] ?? 0) ?> article(s)</span>
                            </div>
                        </div>
                        <footer class="entity-actions">
                            <button
                                type="button"
                                class="btn js-open-category-modal"
                                data-id="<?= $catId ?>"
                                data-libelle="<?= htmlspecialchars((string) ($cat['libelle'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                                Modifier
                            </button>
                            <form class="inline" action="<?= htmlspecialchars(app_url('admin/categories/delete/' . $catId), ENT_QUOTES, 'UTF-8') ?>" method="POST" onsubmit="return confirm('Supprimer cette categorie ?');">
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </footer>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<div id="category-create-modal" class="modal-overlay" aria-hidden="true">
    <div class="modal-card modal-small" role="dialog" aria-modal="true" aria-labelledby="category-create-title">
        <div class="modal-header">
            <h3 id="category-create-title">Ajouter une categorie</h3>
            <button type="button" class="btn modal-close" data-close-modal>&times;</button>
        </div>
        <form action="<?= htmlspecialchars(app_url('admin/categories/store'), ENT_QUOTES, 'UTF-8') ?>" method="POST" class="form-grid" id="category-create-form">
            <input type="text" name="libelle" placeholder="Libelle de categorie" required>
            <div class="modal-actions">
                <button type="button" class="btn" data-close-modal>Annuler</button>
                <button type="submit" class="btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</div>

<div id="category-edit-modal" class="modal-overlay" aria-hidden="true">
    <div class="modal-card modal-small" role="dialog" aria-modal="true" aria-labelledby="category-edit-title">
        <div class="modal-header">
            <h3 id="category-edit-title">Modifier la categorie</h3>
            <button type="button" class="btn modal-close" data-close-modal>&times;</button>
        </div>
        <form id="category-edit-form" method="POST" class="form-grid">
            <input type="text" id="category-edit-libelle" name="libelle" required>
            <div class="modal-actions">
                <button type="button" class="btn" data-close-modal>Annuler</button>
                <button type="submit" class="btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script src="<?= htmlspecialchars(app_url('assets/js/admin-crud-modal.min.js'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
</body>
</html>
