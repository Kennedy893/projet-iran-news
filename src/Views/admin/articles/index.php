<?php
$flash = $flash ?? null;
$articles = $articles ?? [];
$categories = $categories ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des articles | Admin</title>
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/admin-dashboard.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body>
<main class="admin-shell" role="main">
    <header class="admin-topbar">
        <div>
            <h1 class="admin-title">Gestion des articles</h1>
            <p class="admin-subtitle">Creer, modifier et supprimer les articles.</p>
        </div>
        <nav class="admin-nav" aria-label="Navigation admin">
            <a href="<?= htmlspecialchars(app_url('admin/dashboard'), ENT_QUOTES, 'UTF-8') ?>">Dashboard</a>
            <a class="active" href="<?= htmlspecialchars(app_url('admin/articles'), ENT_QUOTES, 'UTF-8') ?>">Articles</a>
            <a href="<?= htmlspecialchars(app_url('admin/categories'), ENT_QUOTES, 'UTF-8') ?>">Categories</a>
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
                <h2>Nouvel article</h2>
                <p class="text-muted" style="margin:.2rem 0 0;">Ajoutez un article via une fenetre dediee.</p>
            </div>
            <button type="button" class="btn btn-primary js-open-modal" data-target-modal="article-create-modal">Ajouter</button>
        </div>
    </section>

    <section class="card">
        <h2>Liste des articles</h2>
        <div class="table-wrap">
            <table class="table-clean">
                <thead>
                <tr>
                    <th>Titre</th>
                    <th>Categorie</th>
                    <th>Date</th>
                    <th>Actions CRUD</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($articles)): ?>
                    <tr><td colspan="4" class="text-muted">Aucun article pour le moment.</td></tr>
                <?php else: ?>
                    <?php foreach ($articles as $article): ?>
                        <?php
                        $articleId = (int) ($article['id'] ?? 0);
                        $title = (string) ($article['titre'] ?? '');
                        $content = trim((string) ($article['contenu'] ?? ''));
                        $excerpt = mb_substr($content, 0, 130) . (mb_strlen($content) > 130 ? '...' : '');
                        ?>
                        <tr>
                            <td>
                                <div class="item-title"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></div>
                                <div class="item-subtext"><?= htmlspecialchars($excerpt, ENT_QUOTES, 'UTF-8') ?></div>
                            </td>
                            <td><span class="tag"><?= htmlspecialchars((string) ($article['category_name'] ?? 'N/A'), ENT_QUOTES, 'UTF-8') ?></span></td>
                            <td><?= htmlspecialchars((string) ($article['date_pub'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="actions-cell">
                                <button
                                    type="button"
                                    class="btn js-open-article-modal"
                                    data-id="<?= $articleId ?>"
                                    data-titre="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
                                    data-contenu="<?= htmlspecialchars((string) ($article['contenu'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                    data-date="<?= htmlspecialchars((string) ($article['date_pub'] ?? date('Y-m-d')), ENT_QUOTES, 'UTF-8') ?>"
                                    data-image="<?= htmlspecialchars((string) ($article['image_url'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                    data-categorie="<?= (int) ($article['id_categorie'] ?? 0) ?>">
                                    Modifier
                                </button>
                                <form class="inline" action="<?= htmlspecialchars(app_url('admin/articles/delete/' . $articleId), ENT_QUOTES, 'UTF-8') ?>" method="POST" onsubmit="return confirm('Supprimer cet article ?');">
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

<div id="article-create-modal" class="modal-overlay" aria-hidden="true">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="article-create-title">
        <div class="modal-header">
            <h3 id="article-create-title">Ajouter un article</h3>
            <button type="button" class="btn modal-close" data-close-modal>&times;</button>
        </div>
        <form action="<?= htmlspecialchars(app_url('admin/articles/store'), ENT_QUOTES, 'UTF-8') ?>" method="POST" class="form-grid" id="article-create-form">
            <input type="text" name="titre" placeholder="Titre" required>
            <textarea name="contenu" placeholder="Contenu" required></textarea>
            <div class="form-grid two">
                <input type="date" name="date_pub" value="<?= htmlspecialchars(date('Y-m-d'), ENT_QUOTES, 'UTF-8') ?>" required>
                <select name="id_categorie" required>
                    <option value="">Choisir une categorie</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= (int) ($cat['id'] ?? 0) ?>"><?= htmlspecialchars((string) ($cat['libelle'] ?? ''), ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="url" name="image_url" placeholder="URL image (optionnel)">
            <div class="modal-actions">
                <button type="button" class="btn" data-close-modal>Annuler</button>
                <button type="submit" class="btn-primary">Ajouter l'article</button>
            </div>
        </form>
    </div>
</div>

<div id="article-edit-modal" class="modal-overlay" aria-hidden="true">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="article-edit-title">
        <div class="modal-header">
            <h3 id="article-edit-title">Modifier l'article</h3>
            <button type="button" class="btn modal-close" data-close-modal>&times;</button>
        </div>
        <form id="article-edit-form" method="POST" class="form-grid">
            <input type="text" id="article-edit-titre" name="titre" required>
            <textarea id="article-edit-contenu" name="contenu" required></textarea>
            <div class="form-grid two">
                <input type="date" id="article-edit-date" name="date_pub" required>
                <select id="article-edit-categorie" name="id_categorie" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= (int) ($cat['id'] ?? 0) ?>"><?= htmlspecialchars((string) ($cat['libelle'] ?? ''), ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="url" id="article-edit-image" name="image_url" placeholder="URL image">
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
