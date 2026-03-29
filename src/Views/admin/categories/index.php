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
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/admin-dashboard.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body>
<main class="admin-shell" role="main">
    <header class="admin-topbar">
        <div>
            <h1 class="admin-title">Gestion des categories</h1>
            <p class="admin-subtitle">Pilotez les categories de contenus.</p>
        </div>
        <nav class="admin-nav" aria-label="Navigation admin">
            <a href="<?= htmlspecialchars(app_url('admin/dashboard'), ENT_QUOTES, 'UTF-8') ?>">Dashboard</a>
            <a href="<?= htmlspecialchars(app_url('admin/articles'), ENT_QUOTES, 'UTF-8') ?>">Articles</a>
            <a class="active" href="<?= htmlspecialchars(app_url('admin/categories'), ENT_QUOTES, 'UTF-8') ?>">Categories</a>
            <a href="<?= htmlspecialchars(app_url('admin/logout'), ENT_QUOTES, 'UTF-8') ?>">Se deconnecter</a>
        </nav>
    </header>

    <?php if (!empty($flash)): ?>
        <div class="flash <?= htmlspecialchars((string) ($flash['type'] ?? 'success'), ENT_QUOTES, 'UTF-8') ?>">
            <?= htmlspecialchars((string) ($flash['message'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <section class="card" style="margin-bottom:1rem;">
        <div class="section-toolbar">
            <div>
                <h2>Nouvelle categorie</h2>
                <p class="text-muted" style="margin:.2rem 0 0;">Creer une categorie depuis une popup.</p>
            </div>
            <button type="button" class="btn btn-primary js-open-modal" data-target-modal="category-create-modal">Ajouter</button>
        </div>
    </section>

    <section class="card">
        <h2>Liste des categories</h2>
        <div class="table-wrap">
            <table class="table-clean">
                <thead>
                <tr>
                    <th>Libelle</th>
                    <th>Articles</th>
                    <th>Actions CRUD</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($categories)): ?>
                    <tr><td colspan="3" class="text-muted">Aucune categorie disponible.</td></tr>
                <?php else: ?>
                    <?php foreach ($categories as $cat): ?>
                        <?php $catId = (int) ($cat['id'] ?? 0); ?>
                        <tr>
                            <td>
                                <div class="item-title"><?= htmlspecialchars((string) ($cat['libelle'] ?? ''), ENT_QUOTES, 'UTF-8') ?></div>
                            </td>
                            <td><span class="tag"><?= (int) ($cat['article_count'] ?? 0) ?> article(s)</span></td>
                            <td class="actions-cell">
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
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
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

<script src="<?= htmlspecialchars(app_url('assets/js/admin-crud-modal.js'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
</body>
</html>
