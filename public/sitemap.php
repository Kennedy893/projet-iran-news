<?php
header('Content-Type: application/xml; charset=utf-8');

require_once '../config/config.php';
require_once '../src/Core/Database.php';
require_once '../src/Models/Article.php';
require_once '../src/Models/Category.php';

use Models\Article;
use Models\Category;

$articleModel = new Article();
$categoryModel = new Category();

$articles = $articleModel->findAll(100); // Récupérer les 100 articles les plus récents
$categories = $categoryModel->findAll();

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Page d'accueil
echo '<url>';
echo '<loc>' . APP_URL . '/</loc>';
echo '<lastmod>' . date('Y-m-d') . '</lastmod>';
echo '<changefreq>daily</changefreq>';
echo '<priority>1.0</priority>';
echo '</url>';

// Catégories
foreach($categories as $cat) {
    $categoryId = (int) ($cat['id'] ?? 0);
    $categoryName = (string) ($cat['libelle'] ?? ($cat['name'] ?? 'categorie'));
    if ($categoryId <= 0) {
        continue;
    }

    echo '<url>';
    echo '<loc>' . htmlspecialchars(category_url($categoryId, $categoryName), ENT_QUOTES, 'UTF-8') . '</loc>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>0.8</priority>';
    echo '</url>';
}

// Articles
foreach($articles as $article) {
    $articleId = (int) ($article['id'] ?? 0);
    $articleTitle = (string) ($article['titre'] ?? ($article['title'] ?? 'article'));
    if ($articleId <= 0) {
        continue;
    }

    $lastmodSource = $article['date_pub'] ?? date('Y-m-d');

    echo '<url>';
    echo '<loc>' . htmlspecialchars(article_url($articleId, $articleTitle), ENT_QUOTES, 'UTF-8') . '</loc>';
    echo '<lastmod>' . date('Y-m-d', strtotime((string) $lastmodSource)) . '</lastmod>';
    echo '<changefreq>monthly</changefreq>';
    echo '<priority>0.6</priority>';
    echo '</url>';
}

echo '</urlset>';