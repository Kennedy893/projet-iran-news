<?php
$articles = $articles ?? [];
$categories = $categories ?? [];
?>

<main class="container" role="main">
    <section class="home-hero">
        <h1>Iran Info</h1>
        <p>Actualites et analyses sur le conflit en Iran.</p>
        <p style="margin-top:.75rem;">
            <a href="<?= htmlspecialchars(app_url('admin/login'), ENT_QUOTES, 'UTF-8') ?>" style="display:inline-block;padding:.5rem .85rem;border:1px solid #ccc;border-radius:6px;text-decoration:none;color:inherit;">
                Acceder a l'administration
            </a>
        </p>
    </section>

    <div class="home-grid" style="display:grid;grid-template-columns:2fr 1fr;gap:2rem;align-items:start;">
        <section aria-labelledby="recent-articles-title">
            <h2 id="recent-articles-title">Derniers articles</h2>

            <?php if (empty($articles)): ?>
                <p>Aucun article disponible pour le moment.</p>
            <?php else: ?>
                <div class="articles-list" style="display:grid;gap:1.25rem;">
                    <?php foreach ($articles as $article): ?>
                        <?php
                        $articleId = $article['id'] ?? '';
                        $title = $article['titre'] ?? '';
                        $content = $article['contenu'] ?? '';
                        $categoryName = $article['categorie_libelle'] ?? ($article['category_name'] ?? 'General');
                        $publishedAt = $article['date_pub'] ?? null;
                        $imageUrl = $article['image_url'] ?? '';

                        $excerpt = mb_substr(trim(strip_tags((string) $content)), 0, 180);
                        if (mb_strlen(trim(strip_tags((string) $content))) > 180) {
                            $excerpt .= '...';
                        }
                        ?>
                        <article class="article-card" style="border:1px solid #ddd;padding:1rem;border-radius:8px;">
                            <?php if (!empty($imageUrl)): ?>
                                <a href="<?= htmlspecialchars(app_url('article/' . rawurlencode((string) $articleId)), ENT_QUOTES, 'UTF-8') ?>">
                                    <img
                                        src="<?= htmlspecialchars((string) $imageUrl, ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>"
                                        style="width:100%;height:auto;border-radius:6px;">
                                </a>
                            <?php endif; ?>

                            <h3 style="margin:.75rem 0 .5rem;">
                                <a href="<?= htmlspecialchars(app_url('article/' . rawurlencode((string) $articleId)), ENT_QUOTES, 'UTF-8') ?>" style="text-decoration:none;color:inherit;">
                                    <?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </h3>

                            <p style="margin:0 0 .5rem;color:#555;">
                                <strong>Categorie:</strong> <?= htmlspecialchars((string) $categoryName, ENT_QUOTES, 'UTF-8') ?>
                                <?php if (!empty($publishedAt)): ?>
                                    | <time datetime="<?= htmlspecialchars((string) $publishedAt, ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars((string) date('d/m/Y', strtotime((string) $publishedAt)), ENT_QUOTES, 'UTF-8') ?>
                                    </time>
                                <?php endif; ?>
                            </p>

                            <p style="margin:0 0 .75rem;">
                                <?= htmlspecialchars((string) $excerpt, ENT_QUOTES, 'UTF-8') ?>
                            </p>

                            <a href="<?= htmlspecialchars(app_url('article/' . rawurlencode((string) $articleId)), ENT_QUOTES, 'UTF-8') ?>">Lire l'article</a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <aside aria-labelledby="categories-title">
            <h2 id="categories-title">Categories</h2>

            <?php if (empty($categories)): ?>
                <p>Aucune categorie disponible.</p>
            <?php else: ?>
                <ul style="list-style:none;padding:0;margin:0;display:grid;gap:.5rem;">
                    <?php foreach ($categories as $category): ?>
                        <?php
                        $categoryId = $category['id'] ?? '';
                        $categoryLabel = $category['libelle'] ?? ($category['name'] ?? 'Sans nom');
                        $count = isset($category['article_count']) ? (int) $category['article_count'] : null;
                        ?>
                        <li>
                            <a href="<?= htmlspecialchars(app_url('categorie/' . rawurlencode((string) $categoryId)), ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars((string) $categoryLabel, ENT_QUOTES, 'UTF-8') ?>
                            </a>
                            <?php if ($count !== null): ?>
                                <span style="color:#666;">(<?= $count ?>)</span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </aside>
    </div>
</main>
