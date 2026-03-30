<?php
$query = $_GET['q'] ?? '';
$results = $results ?? [];
$totalResults = count($results);
?>

<main id="main-content" class="container" role="main">
    <!-- En-tête de recherche -->
    <header class="search-header" style="margin-bottom:var(--spacing-2xl);">
        <h1 style="font-size:var(--font-size-3xl);margin-bottom:var(--spacing-lg);">Recherche</h1>
        
        <!-- Formulaire de recherche -->
        <form action="<?= htmlspecialchars(app_url('search'), ENT_QUOTES, 'UTF-8') ?>" method="get" role="search" style="max-width:600px;">
            <div style="display:flex;gap:var(--spacing-sm);">
                <label for="search-input" class="sr-only">Rechercher des articles</label>
                <input
                    type="search"
                    id="search-input"
                    name="q"
                    value="<?= htmlspecialchars((string) $query, ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Rechercher des articles..."
                    required
                    style="flex:1;padding:var(--spacing-md);border:2px solid var(--color-border);border-radius:var(--border-radius-sm);font-size:var(--font-size-base);font-family:var(--font-sans);">
                <button 
                    type="submit"
                    style="padding:var(--spacing-md) var(--spacing-xl);background-color:var(--color-primary);color:white;border:none;border-radius:var(--border-radius-sm);font-size:var(--font-size-base);font-weight:600;cursor:pointer;transition:background-color var(--transition-fast);">
                    Rechercher
                </button>
            </div>
        </form>

        <?php if (!empty($query)): ?>
            <p style="margin-top:var(--spacing-lg);color:var(--color-text-secondary);">
                <strong><?= $totalResults ?></strong> résultat<?= $totalResults > 1 ? 's' : '' ?> pour 
                <strong>"<?= htmlspecialchars((string) $query, ENT_QUOTES, 'UTF-8') ?>"</strong>
            </p>
        <?php endif; ?>
    </header>

    <!-- Résultats de recherche -->
    <?php if (empty($query)): ?>
        <div class="search-info" style="padding:var(--spacing-2xl);text-align:center;background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--border-radius-md);">
            <h2 style="font-size:var(--font-size-xl);margin-bottom:var(--spacing-md);color:var(--color-text-secondary);">
                Recherchez parmi nos articles
            </h2>
            <p style="color:var(--color-text-tertiary);margin:0;">
                Utilisez le formulaire ci-dessus pour rechercher des articles par mot-clé.
            </p>
        </div>
    <?php elseif (empty($results)): ?>
        <div class="no-results" style="padding:var(--spacing-3xl);text-align:center;background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--border-radius-md);">
            <h2 style="font-size:var(--font-size-2xl);margin-bottom:var(--spacing-md);color:var(--color-text-secondary);">
                Aucun résultat trouvé
            </h2>
            <p style="color:var(--color-text-tertiary);margin-bottom:var(--spacing-lg);">
                Aucun article ne correspond à votre recherche pour "<?= htmlspecialchars((string) $query, ENT_QUOTES, 'UTF-8') ?>".
            </p>
            <p style="color:var(--color-text-tertiary);">
                Suggestions :
            </p>
            <ul style="list-style:none;padding:0;margin:var(--spacing-md) 0 var(--spacing-xl);color:var(--color-text-tertiary);">
                <li>Vérifiez l'orthographe des mots-clés</li>
                <li>Essayez des mots-clés plus généraux</li>
                <li>Essayez des mots-clés différents</li>
            </ul>
            <a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>" style="display:inline-block;padding:var(--spacing-sm) var(--spacing-lg);background-color:var(--color-primary);color:white;border-radius:var(--border-radius-sm);text-decoration:none;font-weight:600;">
                Retour à l'accueil
            </a>
        </div>
    <?php else: ?>
        <section aria-labelledby="results-title">
            <h2 id="results-title" class="sr-only">Résultats de recherche</h2>
            <div class="articles-list">
                <?php foreach ($results as $article): ?>
                    <?php
                    $articleId = $article['id'] ?? '';
                    $title = $article['titre'] ?? '';
                    $content = $article['contenu'] ?? '';
                    $categoryName = $article['categorie_libelle'] ?? ($article['category_name'] ?? 'Général');
                    $publishedAt = $article['date_pub'] ?? null;
                    $imageUrl = $article['image_url'] ?? '';

                    $excerpt = mb_substr(trim(strip_tags((string) $content)), 0, 180);
                    if (mb_strlen(trim(strip_tags((string) $content))) > 180) {
                        $excerpt .= '...';
                    }
                    
                    // Highlight search term in excerpt
                    if (!empty($query)) {
                        $excerpt = preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark style="background-color:var(--color-accent-light);padding:2px 4px;border-radius:2px;">$1</mark>', $excerpt);
                    }
                    
                    $articleUrl = app_url('article/' . rawurlencode((string) $articleId));
                    ?>
                    
                    <article class="article-card">
                        <?php if (!empty($imageUrl)): ?>
                            <a href="<?= $articleUrl ?>">
                                <img
                                    src="<?= htmlspecialchars((string) $imageUrl, ENT_QUOTES, 'UTF-8') ?>"
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
                                <strong>Catégorie:</strong> <?= htmlspecialchars((string) $categoryName, ENT_QUOTES, 'UTF-8') ?>
                            </span>
                            <?php if (!empty($publishedAt)): ?>
                                <time datetime="<?= htmlspecialchars((string) $publishedAt, ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars((string) date('d/m/Y', strtotime((string) $publishedAt)), ENT_QUOTES, 'UTF-8') ?>
                                </time>
                            <?php endif; ?>
                        </div>

                        <p class="article-excerpt">
                            <?= $excerpt ?>
                        </p>

                        <a href="<?= $articleUrl ?>" class="read-more">
                            Lire l'article 
                            <span aria-hidden="true">→</span>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</main>