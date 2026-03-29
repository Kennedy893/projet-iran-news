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
        <h2>Nouvelle categorie</h2>
        <form action="<?= htmlspecialchars(app_url('admin/categories/store'), ENT_QUOTES, 'UTF-8') ?>" method="POST" class="form-grid two">
            <input type="text" name="libelle" placeholder="Libelle de categorie" required>
            <button type="submit" class="btn-primary">Ajouter</button>
        </form>
    </section>

    <section class="card">
        <h2>Liste des categories</h2>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Libelle</th>
                    <th>Articles</th>
                    <th>Actions CRUD</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($categories)): ?>
                    <tr><td colspan="4" class="text-muted">Aucune categorie disponible.</td></tr>
                <?php else: ?>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td><?= (int) ($cat['id'] ?? 0) ?></td>
                            <td>
                                <form action="<?= htmlspecialchars(app_url('admin/categories/update/' . (int) ($cat['id'] ?? 0)), ENT_QUOTES, 'UTF-8') ?>" method="POST" class="form-grid two">
                                    <input type="text" name="libelle" value="<?= htmlspecialchars((string) ($cat['libelle'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                                    <button type="submit" class="btn-primary">Modifier</button>
                                </form>
                            </td>
                            <td><?= (int) ($cat['article_count'] ?? 0) ?></td>
                            <td>
                                <form class="inline" action="<?= htmlspecialchars(app_url('admin/categories/delete/' . (int) ($cat['id'] ?? 0)), ENT_QUOTES, 'UTF-8') ?>" method="POST" onsubmit="return confirm('Supprimer cette categorie ?');">
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
