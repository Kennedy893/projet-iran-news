<?php
$articles = $articles ?? [];
$categories = $categories ?? [];
?>

<main id="main-content" class="container" role="main">
    
    <!-- Hero Section -->
    <section class="home-hero" aria-labelledby="site-title">
        <!-- H1 avec mot-clé principal -->
        <h1 id="site-title">Actualités sur le conflit en Iran : analyses et informations fiables</h1>
        
        <p>
            Suivez les dernières actualités sur l’Iran, avec des analyses détaillées, des informations vérifiées et un suivi du conflit en Iran en temps réel.
        </p>
    </section>

    <!-- Grille principale -->
    <div class="home-grid">

        <!-- Section Articles -->
        <section aria-labelledby="recent-articles-title">
            
            <!-- H2 avec mot-clé secondaire -->
            <h2 id="recent-articles-title">Dernières actualités sur l’Iran et le conflit</h2>

            <?php if (empty($articles)): ?>
                <div class="empty-state" style="padding:var(--spacing-2xl);text-align:center;background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--border-radius-md);">
                    <p style="color:var(--color-text-secondary);margin:0;">
                        Aucun article sur le conflit en Iran n’est disponible pour le moment.
                    </p>
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

                        $excerpt = mb_substr(trim(strip_tags((string) $content)), 0, 180);
                        if (mb_strlen(trim(strip_tags((string) $content))) > 180) {
                            $excerpt .= '...';
                        }

                        $articleUrl = article_url($articleId, $title);
                        $categoryUrl = isset($article['id_categorie']) ? category_url((int) $article['id_categorie'], $categoryName) : '#';
                        ?>
                        
                        <article class="article-card">
                            
                            <?php if (!empty($imageUrl)): ?>
                                <a 
                                    href="<?= $articleUrl ?>" 
                                    title="Lire l’article : <?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>"
                                    rel="noopener"
                                >
                                    <img
                                        src="<?= htmlspecialchars(image_url((string) $imageUrl), ENT_QUOTES, 'UTF-8') ?>"
                                        class="js-zoomable-image"
                                        alt="Image illustrant <?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?> - actualité sur le conflit en Iran"                          
                                        width="1200"
                                        height="675"
                                        loading="lazy">
                                </a>
                            <?php endif; ?>

                            <!-- H3 pour chaque article -->
                            <h3>
                                <a 
                                    href="<?= $articleUrl ?>" 
                                    title="Consulter l’analyse complète : <?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>"
                                    rel="noopener"
                                >
                                    <?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </h3>

                            <!-- Métadonnées -->
                            <div class="article-meta">
                                <span>
                                    <strong>Catégorie :</strong> 
                                    <a 
                                        href="<?= $categoryUrl ?>" 
                                        title="Voir les articles de la catégorie <?= htmlspecialchars((string) $categoryName, ENT_QUOTES, 'UTF-8') ?>"
                                        rel="noopener"
                                    >
                                        <?= htmlspecialchars((string) $categoryName, ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                </span>

                                <?php if (!empty($publishedAt)): ?>
                                    <time datetime="<?= htmlspecialchars((string) $publishedAt, ENT_QUOTES, 'UTF-8') ?>">
                                        Publié le <?= htmlspecialchars((string) date('d/m/Y', strtotime((string) $publishedAt)), ENT_QUOTES, 'UTF-8') ?>
                                    </time>
                                <?php endif; ?>
                            </div>

                            <!-- Extrait optimisé -->
                            <p class="article-excerpt">
                                <?= htmlspecialchars((string) $excerpt, ENT_QUOTES, 'UTF-8') ?>
                            </p>

                            <!-- Lien optimisé SEO -->
                            <a 
                                href="<?= $articleUrl ?>" 
                                class="read-more"
                                title="Lire l’article complet : <?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>"
                                rel="noopener"
                            >
                                Lire l’article complet sur <?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?>
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
                            <a href="<?= htmlspecialchars(category_url((int) $categoryId, $categoryLabel), ENT_QUOTES, 'UTF-8') ?>">
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
