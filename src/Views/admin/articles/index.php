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
                <a class="active" href="<?= htmlspecialchars(app_url('admin/articles'), ENT_QUOTES, 'UTF-8') ?>">Articles</a>
                <a href="<?= htmlspecialchars(app_url('admin/categories'), ENT_QUOTES, 'UTF-8') ?>">Categories</a>
                <a href="<?= htmlspecialchars(app_url('admin/logout'), ENT_QUOTES, 'UTF-8') ?>">Se deconnecter</a>
            </nav>
        </div>
    </header>

<main class="admin-shell container" role="main">
    <section class="admin-page-intro card">
        <h1 class="admin-title">Gestion des articles</h1>
        <p class="admin-subtitle">Creer, modifier et supprimer les articles.</p>
    </section>

    <?php if (!empty($flash)): ?>
        <div class="flash <?= htmlspecialchars((string) ($flash['type'] ?? 'success'), ENT_QUOTES, 'UTF-8') ?>">
            <?= htmlspecialchars((string) ($flash['message'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <section class="card list-card">
        <div class="section-toolbar section-toolbar-strong">
            <div>
                <h2>Liste des articles</h2>
                <p class="text-muted" style="margin:.2rem 0 0;">Chaque article est affiche sur une carte distincte pour faciliter la lecture et l'edition.</p>
            </div>
            <button type="button" class="btn btn-primary btn-add-prominent js-open-modal" data-target-modal="article-create-modal">+ Ajouter un article</button>
        </div>

        <?php if (empty($articles)): ?>
            <p class="text-muted">Aucun article pour le moment.</p>
        <?php else: ?>
            <div class="entity-list">
                <?php foreach ($articles as $article): ?>
                    <?php
                    $articleId = (int) ($article['id'] ?? 0);
                    $title = (string) ($article['titre'] ?? '');
                    $content = trim((string) ($article['contenu'] ?? ''));
                    $excerpt = mb_substr($content, 0, 170) . (mb_strlen($content) > 170 ? '...' : '');
                    $primaryImagePath = (string) (($article['primary_image']['chemin'] ?? '') ?: '');
                    $primaryImageUrlForEdit = $primaryImagePath !== '' ? image_url($primaryImagePath) : '';
                    $secondaryImageUrlsForEdit = [];
                    foreach (($article['secondary_images'] ?? []) as $secondaryImage) {
                        $secondaryPath = (string) ($secondaryImage['chemin'] ?? '');
                        if ($secondaryPath !== '') {
                            $secondaryImageUrlsForEdit[] = image_url($secondaryPath);
                        }
                    }
                    ?>
                    <article class="entity-item article-item">
                        <header class="entity-head">
                            <div>
                                <h3 class="item-title"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h3>
                                <p class="item-subtext"><?= htmlspecialchars($excerpt, ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                            <div class="entity-meta">
                                <span class="tag"><?= htmlspecialchars((string) ($article['category_name'] ?? 'N/A'), ENT_QUOTES, 'UTF-8') ?></span>
                                <time class="meta-date"><?= htmlspecialchars((string) ($article['date_pub'] ?? ''), ENT_QUOTES, 'UTF-8') ?></time>
                            </div>
                        </header>

                        <div class="article-gallery" aria-label="Galerie des images de l'article">
                            <?php if (!empty($article['primary_image'])): ?>
                                <?php
                                $primary = $article['primary_image'];
                                $primaryPath = (string) ($primary['chemin'] ?? '');
                                $primaryUrl = image_url($primaryPath);
                                ?>
                                <div class="image-item image-item-primary">
                                    <button type="button" class="image-thumb-btn js-open-lightbox" data-image-src="<?= htmlspecialchars($primaryUrl, ENT_QUOTES, 'UTF-8') ?>">
                                        <img src="<?= htmlspecialchars($primaryUrl, ENT_QUOTES, 'UTF-8') ?>" alt="Image primaire" class="image-thumb" width="320" height="180">
                                    </button>
                                    <div class="image-meta">
                                        <span class="tag">Primaire</span>
                                        <form class="inline" action="<?= htmlspecialchars(app_url('admin/articles/images/delete/' . (int) ($primary['id'] ?? 0)), ENT_QUOTES, 'UTF-8') ?>" method="POST" onsubmit="return confirm('Attention: cette action supprimera definitivement l\'image primaire. Continuer ?');">
                                            <button type="submit" class="btn btn-danger btn-xs">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($article['secondary_images'])): ?>
                                <?php foreach ($article['secondary_images'] as $secondary): ?>
                                    <?php
                                    $secondaryPath = (string) ($secondary['chemin'] ?? '');
                                    $secondaryUrl = image_url($secondaryPath);
                                    ?>
                                    <div class="image-item">
                                        <button type="button" class="image-thumb-btn js-open-lightbox" data-image-src="<?= htmlspecialchars($secondaryUrl, ENT_QUOTES, 'UTF-8') ?>">
                                            <img src="<?= htmlspecialchars($secondaryUrl, ENT_QUOTES, 'UTF-8') ?>" alt="Image secondaire" class="image-thumb" width="320" height="180">
                                        </button>
                                        <div class="image-meta">
                                            <span class="tag">Secondaire</span>
                                            <form class="inline" action="<?= htmlspecialchars(app_url('admin/articles/images/delete/' . (int) ($secondary['id'] ?? 0)), ENT_QUOTES, 'UTF-8') ?>" method="POST" onsubmit="return confirm('Attention: cette action supprimera definitivement l\'image secondaire. Continuer ?');">
                                                <button type="submit" class="btn btn-danger btn-xs">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if (empty($article['primary_image']) && empty($article['secondary_images'])): ?>
                                <p class="text-muted" style="margin:.35rem 0 0;">Aucune image pour cet article.</p>
                            <?php endif; ?>
                        </div>

                        <footer class="entity-actions">
                            <button
                                type="button"
                                class="btn js-open-article-modal"
                                data-id="<?= $articleId ?>"
                                data-titre="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
                                data-contenu="<?= htmlspecialchars((string) ($article['contenu'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                data-date="<?= htmlspecialchars((string) ($article['date_pub'] ?? date('Y-m-d')), ENT_QUOTES, 'UTF-8') ?>"
                                data-categorie="<?= (int) ($article['id_categorie'] ?? 0) ?>"
                                data-primary-image="<?= htmlspecialchars($primaryImageUrlForEdit, ENT_QUOTES, 'UTF-8') ?>"
                                data-secondary-images="<?= htmlspecialchars(json_encode($secondaryImageUrlsForEdit, JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8') ?>">
                                Modifier
                            </button>
                            <form class="inline" action="<?= htmlspecialchars(app_url('admin/articles/delete/' . $articleId), ENT_QUOTES, 'UTF-8') ?>" method="POST" onsubmit="return confirm('Supprimer cet article ?');">
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </footer>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<div id="article-create-modal" class="modal-overlay" aria-hidden="true">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="article-create-title">
        <div class="modal-header">
            <h3 id="article-create-title">Ajouter un article</h3>
            <button type="button" class="btn modal-close" data-close-modal>&times;</button>
        </div>
        <form action="<?= htmlspecialchars(app_url('admin/articles/store'), ENT_QUOTES, 'UTF-8') ?>" method="POST" enctype="multipart/form-data" class="form-grid" id="article-create-form">
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
            <label>Image primaire (obligatoire)</label>
            <input type="file" name="image_primaire" accept="image/*" required>
            <label>Images secondaires (optionnelles, multiples)</label>
            <input type="file" name="images_secondaires[]" accept="image/*" multiple>
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
        <form id="article-edit-form" method="POST" enctype="multipart/form-data" class="form-grid">
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
            <div class="existing-images-preview" aria-live="polite">
                <div>
                    <strong>Image primaire actuelle</strong>
                    <div id="article-edit-primary-preview" class="existing-image-slot text-muted">Aucune image primaire</div>
                </div>
                <div>
                    <strong>Images secondaires actuelles</strong>
                    <div id="article-edit-secondary-preview" class="existing-secondary-grid text-muted">Aucune image secondaire</div>
                </div>
            </div>
            <label>Remplacer l'image primaire (optionnel)</label>
            <input type="file" id="article-edit-primary" name="image_primaire" accept="image/*">
            <label>Ajouter des images secondaires (optionnel, multiples)</label>
            <input type="file" id="article-edit-secondary" name="images_secondaires[]" accept="image/*" multiple>
            <div class="modal-actions">
                <button type="button" class="btn" data-close-modal>Annuler</button>
                <button type="submit" class="btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<div id="image-lightbox-modal" class="modal-overlay" aria-hidden="true">
    <div class="modal-card modal-image" role="dialog" aria-modal="true" aria-labelledby="image-lightbox-title">
        <div class="modal-header">
            <h3 id="image-lightbox-title">Apercu image</h3>
            <button type="button" class="btn modal-close" data-close-modal>&times;</button>
        </div>
        <div class="lightbox-content">
            <img id="lightbox-image" src="" alt="Agrandissement image" class="lightbox-image" width="1200" height="675">
        </div>
    </div>
</div>

<script src="<?= htmlspecialchars(app_url('assets/js/admin-crud-modal.min.js'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
</body>
</html>
