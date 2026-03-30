<?php
$articles = $articles ?? [];
$category = $category ?? null;
$categoryName = $category['libelle'] ?? 'Catégorie';
$categoryId = $category['id'] ?? '';
?>

<main id="main-content" class="container" role="main">
    <!-- Breadcrumb -->
    <nav aria-label="Fil d'Ariane" class="breadcrumb" style="margin-bottom:var(--spacing-xl);font-size:var(--font-size-sm);">
        <ol style="list-style:none;padding:0;margin:0;display:flex;gap:var(--spacing-xs);flex-wrap:wrap;">
            <li><a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>">Accueil</a></li>
            <li aria-hidden="true" style="color:var(--color-text-muted);">/</li>
            <li aria-current="page" style="color:var(--color-text-secondary);"><?= htmlspecialchars((string) $categoryName, ENT_QUOTES, 'UTF-8') ?></li>
        </ol>
    </nav>

    <!-- En-tête de catégorie -->
    <header class="category-header" style="background:linear-gradient(135deg,var(--color-primary-dark) 0%,var(--color-primary) 100%);color:white;padding:var(--spacing-2xl);text-align:center;border-radius:var(--border-radius-lg);margin-bottom:var(--spacing-2xl);">
        <h1 style="font-size:var(--font-size-3xl);margin-bottom:var(--spacing-sm);color:white;">
            <?= htmlspecialchars((string) $categoryName, ENT_QUOTES, 'UTF-8') ?>
        </h1>
        <p style="font-size:var(--font-size-lg);opacity:0.9;margin:0;">
            <?= count($articles) ?> article<?= count($articles) > 1 ? 's' : '' ?> dans cette catégorie
        </p>
    </header>

    <!-- Liste des articles -->
    <section aria-labelledby="articles-title">
        <h2 id="articles-title" class="sr-only">Articles de la catégorie <?= htmlspecialchars((string) $categoryName, ENT_QUOTES, 'UTF-8') ?></h2>

        <?php if (empty($articles)): ?>
            <div class="empty-state" style="padding:var(--spacing-3xl);text-align:center;background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--border-radius-md);">
                <p style="color:var(--color-text-secondary);font-size:var(--font-size-lg);margin:0;">
                    Aucun article disponible dans cette catégorie pour le moment.
                </p>
                <a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>" style="display:inline-block;margin-top:var(--spacing-lg);padding:var(--spacing-sm) var(--spacing-lg);background-color:var(--color-primary);color:white;border-radius:var(--border-radius-sm);text-decoration:none;font-weight:600;">
                    Retour à l'accueil
                </a>
            </div>
        <?php else: ?>
            <div class="articles-list">
                <?php foreach ($articles as $article): ?>
                    <?php
                    $articleId = $article['id'] ?? '';
                    $title = $article['titre'] ?? '';
                    $content = $article['contenu'] ?? '';
                    $publishedAt = $article['date_pub'] ?? null;
                    $imageUrl = $article['image_url'] ?? '';

                    $excerpt = mb_substr(trim(strip_tags((string) $content)), 0, 180);
                    if (mb_strlen(trim(strip_tags((string) $content))) > 180) {
                        $excerpt .= '...';
                    }
                    
                    $articleUrl = app_url('article/' . rawurlencode((string) $articleId));
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
</main>

<!-- Schema.org Markup pour SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "<?= htmlspecialchars((string) $categoryName, ENT_QUOTES, 'UTF-8') ?>",
  "description": "Articles de la catégorie <?= htmlspecialchars((string) $categoryName, ENT_QUOTES, 'UTF-8') ?>",
  "publisher": {
    "@type": "Organization",
    "name": "Iran Info"
  }
}
</script>