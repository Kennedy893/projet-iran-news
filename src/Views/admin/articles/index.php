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
        <h2>Nouvel article</h2>
        <form action="<?= htmlspecialchars(app_url('admin/articles/store'), ENT_QUOTES, 'UTF-8') ?>" method="POST" class="form-grid">
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
            <button type="submit" class="btn-primary">Ajouter l'article</button>
        </form>
    </section>

    <section class="card">
        <h2>Liste des articles</h2>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Categorie</th>
                    <th>Date</th>
                    <th>Actions CRUD</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($articles)): ?>
                    <tr><td colspan="5" class="text-muted">Aucun article pour le moment.</td></tr>
                <?php else: ?>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?= (int) ($article['id'] ?? 0) ?></td>
                            <td>
                                <form action="<?= htmlspecialchars(app_url('admin/articles/update/' . (int) ($article['id'] ?? 0)), ENT_QUOTES, 'UTF-8') ?>" method="POST" class="form-grid">
                                    <input type="text" name="titre" value="<?= htmlspecialchars((string) ($article['titre'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                                    <textarea name="contenu" required><?= htmlspecialchars((string) ($article['contenu'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                                    <div class="form-grid two">
                                        <input type="date" name="date_pub" value="<?= htmlspecialchars((string) ($article['date_pub'] ?? date('Y-m-d')), ENT_QUOTES, 'UTF-8') ?>" required>
                                        <select name="id_categorie" required>
                                            <?php foreach ($categories as $cat): ?>
                                                <?php $selected = ((int) ($cat['id'] ?? 0) === (int) ($article['id_categorie'] ?? 0)); ?>
                                                <option value="<?= (int) ($cat['id'] ?? 0) ?>" <?= $selected ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars((string) ($cat['libelle'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <input type="url" name="image_url" value="<?= htmlspecialchars((string) ($article['image_url'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" placeholder="URL image">
                                    <div>
                                        <button type="submit" class="btn-primary">Modifier</button>
                                    </div>
                                </form>
                            </td>
                            <td><?= htmlspecialchars((string) ($article['category_name'] ?? 'N/A'), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string) ($article['date_pub'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <form class="inline" action="<?= htmlspecialchars(app_url('admin/articles/delete/' . (int) ($article['id'] ?? 0)), ENT_QUOTES, 'UTF-8') ?>" method="POST" onsubmit="return confirm('Supprimer cet article ?');">
                                    <button type="submit" class="btn">Supprimer</button>
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
</body>
</html>
