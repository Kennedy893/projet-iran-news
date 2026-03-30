<?php
http_response_code(404);
?>

<main id="main-content" class="container" role="main">
    <div class="error-404" style="display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:60vh;text-align:center;padding:var(--spacing-2xl);">
        <!-- Code d'erreur -->
        <div style="font-size:8rem;font-weight:700;line-height:1;color:var(--color-primary);margin-bottom:var(--spacing-md);">
            404
        </div>

        <!-- Message -->
        <h1 style="font-size:var(--font-size-3xl);margin-bottom:var(--spacing-md);color:var(--color-text-primary);">
            Page non trouvée
        </h1>
        
        <p style="font-size:var(--font-size-lg);color:var(--color-text-secondary);max-width:600px;margin-bottom:var(--spacing-xl);">
            Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
        </p>

        <!-- Actions -->
        <div style="display:flex;gap:var(--spacing-md);flex-wrap:wrap;justify-content:center;">
            <a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>" 
               style="display:inline-block;padding:var(--spacing-md) var(--spacing-xl);background-color:var(--color-primary);color:white;border-radius:var(--border-radius-sm);text-decoration:none;font-weight:600;transition:background-color var(--transition-fast);">
                Retour à l'accueil
            </a>
            <a href="<?= htmlspecialchars(app_url('search'), ENT_QUOTES, 'UTF-8') ?>" 
               style="display:inline-block;padding:var(--spacing-md) var(--spacing-xl);background-color:var(--color-surface);color:var(--color-primary);border:2px solid var(--color-primary);border-radius:var(--border-radius-sm);text-decoration:none;font-weight:600;transition:all var(--transition-fast);">
                Rechercher
            </a>
        </div>

        <!-- Articles populaires (optionnel) -->
        <?php if (isset($popularArticles) && !empty($popularArticles)): ?>
            <section style="margin-top:var(--spacing-3xl);width:100%;max-width:900px;">
                <h2 style="font-size:var(--font-size-xl);margin-bottom:var(--spacing-xl);color:var(--color-text-primary);">
                    Articles populaires
                </h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:var(--spacing-lg);">
                    <?php foreach ($popularArticles as $article): ?>
                        <?php
                        $articleId = $article['id'] ?? '';
                        $title = $article['titre'] ?? '';
                        $imageUrl = $article['image_url'] ?? '';
                        $articleUrl = app_url('article/' . rawurlencode((string) $articleId));
                        ?>
                        <article class="article-card">
                            <?php if (!empty($imageUrl)): ?>
                                <a href="<?= htmlspecialchars((string) $articleUrl, ENT_QUOTES, 'UTF-8') ?>">
                                    <img 
                                        src="<?= htmlspecialchars(image_url((string) $imageUrl), ENT_QUOTES, 'UTF-8') ?>"
                                        data-zoom-src="<?= htmlspecialchars(image_url((string) $imageUrl), ENT_QUOTES, 'UTF-8') ?>"
                                        class="js-zoomable-image"
                                        alt="<?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>"
                                        loading="lazy">
                                </a>
                            <?php endif; ?>
                            <h3>
                                <a href="<?= htmlspecialchars((string) $articleUrl, ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </h3>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</main>