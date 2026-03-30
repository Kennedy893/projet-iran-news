<?php
$article = $article ?? null;
$relatedArticles = $relatedArticles ?? [];

if (!$article) {
    header('HTTP/1.0 404 Not Found');
    include __DIR__ . '/404.php';
    exit;
}

$title = $article['titre'] ?? 'Article';
$content = $article['contenu'] ?? '';
$categoryName = $article['categorie_libelle'] ?? 'Général';
$categoryId = $article['id_categorie'] ?? '';
$publishedAt = $article['date_pub'] ?? null;
$imageUrl = $article['image_url'] ?? '';
$articleId = $article['id'] ?? '';
?>

<main id="main-content" class="container" role="main">
    <!-- Breadcrumb -->
    <nav aria-label="Fil d'Ariane" class="breadcrumb" style="margin-bottom:var(--spacing-lg);font-size:var(--font-size-sm);">
        <ol style="list-style:none;padding:0;margin:0;display:flex;gap:var(--spacing-xs);flex-wrap:wrap;">
            <li><a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>">Accueil</a></li>
            <li aria-hidden="true" style="color:var(--color-text-muted);">/</li>
            <li><a href="<?= htmlspecialchars(app_url('categorie/' . rawurlencode((string) $categoryId)), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $categoryName, ENT_QUOTES, 'UTF-8') ?></a></li>
            <li aria-hidden="true" style="color:var(--color-text-muted);">/</li>
            <li aria-current="page" style="color:var(--color-text-secondary);"><?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?></li>
        </ol>
    </nav>

    <!-- Article principal -->
    <article class="article-single" style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--border-radius-md);padding:var(--spacing-2xl);margin-bottom:var(--spacing-2xl);">
        <!-- En-tête de l'article -->
        <header class="article-header" style="margin-bottom:var(--spacing-xl);border-bottom:2px solid var(--color-border);padding-bottom:var(--spacing-lg);">
            <h1 style="font-family:var(--font-serif);font-size:var(--font-size-3xl);line-height:1.2;margin-bottom:var(--spacing-md);">
                <?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>
            </h1>

            <div class="article-meta" style="display:flex;gap:var(--spacing-md);flex-wrap:wrap;font-size:var(--font-size-sm);color:var(--color-text-tertiary);">
                <span>
                    <strong style="color:var(--color-text-secondary);">Catégorie:</strong>
                    <a href="<?= htmlspecialchars(app_url('categorie/' . rawurlencode((string) $categoryId)), ENT_QUOTES, 'UTF-8') ?>" style="color:var(--color-primary);">
                        <?= htmlspecialchars((string) $categoryName, ENT_QUOTES, 'UTF-8') ?>
                    </a>
                </span>
                <?php if (!empty($publishedAt)): ?>
                    <span>
                        <strong style="color:var(--color-text-secondary);">Publié le:</strong>
                        <time datetime="<?= htmlspecialchars((string) $publishedAt, ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars((string) date('d F Y', strtotime((string) $publishedAt)), ENT_QUOTES, 'UTF-8') ?>
                        </time>
                    </span>
                <?php endif; ?>
            </div>
        </header>

        <!-- Image principale -->
        <?php if (!empty($imageUrl)): ?>
            <figure class="article-image" style="margin:0 0 var(--spacing-xl) 0;">
                <img
                    src="<?= htmlspecialchars((string) $imageUrl, ENT_QUOTES, 'UTF-8') ?>"
                    alt="<?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>"
                    style="width:100%;height:auto;max-height:500px;object-fit:cover;border-radius:var(--border-radius-md);">
            </figure>
        <?php endif; ?>

        <!-- Contenu de l'article -->
        <div class="article-content" style="font-family:var(--font-serif);font-size:var(--font-size-md);line-height:1.8;color:var(--color-text-primary);">
            <?= nl2br(htmlspecialchars((string) $content, ENT_QUOTES, 'UTF-8')) ?>
        </div>

        <!-- Partage social -->
        <footer class="article-footer" style="margin-top:var(--spacing-2xl);padding-top:var(--spacing-xl);border-top:1px solid var(--color-border);">
            <h2 style="font-size:var(--font-size-lg);margin-bottom:var(--spacing-md);">Partager cet article</h2>
            <div class="social-share" style="display:flex;gap:var(--spacing-md);flex-wrap:wrap;">
                <a href="https://twitter.com/intent/tweet?url=<?= urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&text=<?= urlencode($title) ?>" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="share-button"
                   style="display:inline-flex;align-items:center;gap:var(--spacing-xs);padding:var(--spacing-sm) var(--spacing-md);background-color:var(--color-primary);color:white;border-radius:var(--border-radius-sm);text-decoration:none;font-weight:600;transition:all var(--transition-fast);">
                    Twitter
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="share-button"
                   style="display:inline-flex;align-items:center;gap:var(--spacing-xs);padding:var(--spacing-sm) var(--spacing-md);background-color:var(--color-primary);color:white;border-radius:var(--border-radius-sm);text-decoration:none;font-weight:600;transition:all var(--transition-fast);">
                    Facebook
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&title=<?= urlencode($title) ?>" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="share-button"
                   style="display:inline-flex;align-items:center;gap:var(--spacing-xs);padding:var(--spacing-sm) var(--spacing-md);background-color:var(--color-primary);color:white;border-radius:var(--border-radius-sm);text-decoration:none;font-weight:600;transition:all var(--transition-fast);">
                    LinkedIn
                </a>
            </div>
        </footer>
    </article>

    <!-- Articles liés -->
    <?php if (!empty($relatedArticles)): ?>
        <section class="related-articles" style="margin-top:var(--spacing-2xl);">
            <h2 style="font-size:var(--font-size-2xl);margin-bottom:var(--spacing-xl);">Articles liés</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:var(--spacing-lg);">
                <?php foreach ($relatedArticles as $related): ?>
                    <?php
                    $relatedId = $related['id'] ?? '';
                    $relatedTitle = $related['titre'] ?? '';
                    $relatedImage = $related['image_url'] ?? '';
                    $relatedUrl = app_url('article/' . rawurlencode((string) $relatedId));
                    ?>
                    <article class="article-card">
                        <?php if (!empty($relatedImage)): ?>
                            <a href="<?= htmlspecialchars((string) $relatedUrl, ENT_QUOTES, 'UTF-8') ?>">
                                <img src="<?= htmlspecialchars((string) $relatedImage, ENT_QUOTES, 'UTF-8') ?>"
                                     alt="<?= htmlspecialchars((string) $relatedTitle, ENT_QUOTES, 'UTF-8') ?>"
                                     loading="lazy">
                            </a>
                        <?php endif; ?>
                        <h3>
                            <a href="<?= htmlspecialchars((string) $relatedUrl, ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars((string) $relatedTitle, ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </h3>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</main>

<!-- Schema.org Markup pour SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "<?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>",
  "image": "<?= htmlspecialchars((string) $imageUrl, ENT_QUOTES, 'UTF-8') ?>",
  "datePublished": "<?= htmlspecialchars((string) $publishedAt, ENT_QUOTES, 'UTF-8') ?>",
  "author": {
    "@type": "Organization",
    "name": "Iran Info"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Iran Info"
  },
  "description": "<?= htmlspecialchars(mb_substr(strip_tags((string) $content), 0, 160), ENT_QUOTES, 'UTF-8') ?>"
}
</script>