<?php
$articles = $articles ?? [];
$categories = $categories ?? [];
?>

<main id="main-content" class="container" role="main">
    <!-- Hero Section -->
    <section class="home-hero" aria-labelledby="site-title">
        <h1 id="site-title">Iran Info</h1>
        <p>Actualités et analyses sur le conflit en Iran. Information objective, vérifiée et contextualisée.</p>
    </section>

    <!-- Grille principale -->
    <div class="home-grid">
        <!-- Section Articles -->
        <section aria-labelledby="recent-articles-title">
            <h2 id="recent-articles-title">Derniers articles</h2>

            <?php if (empty($articles)): ?>
                <div class="empty-state" style="padding:var(--spacing-2xl);text-align:center;background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--border-radius-md);">
                    <p style="color:var(--color-text-secondary);margin:0;">Aucun article disponible pour le moment.</p>
                </div>
            <?php else: ?>
                <div class="articles-list">
                    <?php foreach ($articles as $article): ?>
                        <?php
                        $articleId = $article['id'] ?? '';
                        $title = $article['titre'] ?? '';
                        $content = $article['contenu'] ?? '';
                        $categoryName = $article['categorie_libelle'] ?? ($article['category_name'] ?? 'Général');
                        $publishedAt = $article['date_pub'] ?? null;
                        $imageUrl = $article['image_url'] ?? '';
                        $imageSrc = (strpos((string) $imageUrl, 'http://') === 0 || strpos((string) $imageUrl, 'https://') === 0)
                            ? (string) $imageUrl
                            : app_url(ltrim((string) $imageUrl, '/'));

                        $excerpt = mb_substr(trim(strip_tags((string) $content)), 0, 180);
                        if (mb_strlen(trim(strip_tags((string) $content))) > 180) {
                            $excerpt .= '...';
                        }
                        
                        $articleUrl = app_url('article/' . rawurlencode((string) $articleId));
                        $categoryUrl = isset($article['id_categorie']) ? app_url('categorie/' . rawurlencode((string) $article['id_categorie'])) : '#';
                        ?>
                        
                        <article class="article-card">
                            <?php if (!empty($imageUrl)): ?>
                                <a href="<?= $articleUrl ?>" aria-label="Lire l'article: <?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>">
                                    <img
                                        src="<?= htmlspecialchars(image_url((string) $imageUrl), ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>"
                                        loading="lazy">
                                </a>
                            <?php endif; ?>

                            <h3>
                                <a href="<?= $articleUrl ?>">
                                    <?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </h3>

                            <div class="article-meta">
                                <span>
                                    <strong>Catégorie:</strong> 
                                    <a href="<?= $categoryUrl ?>">
                                        <?= htmlspecialchars((string) $categoryName, ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                </span>
                                <?php if (!empty($publishedAt)): ?>
                                    <time datetime="<?= htmlspecialchars((string) $publishedAt, ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars((string) date('d/m/Y', strtotime((string) $publishedAt)), ENT_QUOTES, 'UTF-8') ?>
                                    </time>
                                <?php endif; ?>
                            </div>

                            <p class="article-excerpt">
                                <?= htmlspecialchars((string) $excerpt, ENT_QUOTES, 'UTF-8') ?>
                            </p>

                            <a href="<?= $articleUrl ?>" class="read-more">
                                Lire l'article 
                                <span aria-hidden="true">→</span>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- Sidebar Catégories -->
        <aside aria-labelledby="categories-title">
            <h2 id="categories-title">Catégories</h2>

            <?php if (empty($categories)): ?>
                <p style="color:var(--color-text-secondary);">Aucune catégorie disponible.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($categories as $category): ?>
                        <?php
                        $categoryId = $category['id'] ?? '';
                        $categoryLabel = $category['libelle'] ?? ($category['name'] ?? 'Sans nom');
                        $count = isset($category['article_count']) ? (int) $category['article_count'] : null;
                        ?>
                        <li>
                            <a href="<?= htmlspecialchars(app_url('categorie/' . rawurlencode((string) $categoryId)), ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars((string) $categoryLabel, ENT_QUOTES, 'UTF-8') ?>
                                <?php if ($count !== null): ?>
                                    <span>(<?= $count ?>)</span>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </aside>
    </div>
</main>
