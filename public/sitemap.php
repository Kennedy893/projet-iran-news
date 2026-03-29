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
    echo '<url>';
    echo '<loc>' . APP_URL . '/categorie/' . $cat['slug'] . '</loc>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>0.8</priority>';
    echo '</url>';
}

// Articles
foreach($articles as $article) {
    echo '<url>';
    echo '<loc>' . APP_URL . '/article/' . $article['slug'] . '</loc>';
    echo '<lastmod>' . date('Y-m-d', strtotime($article['updated_at'])) . '</lastmod>';
    echo '<changefreq>monthly</changefreq>';
    echo '<priority>0.6</priority>';
    echo '</url>';
}

echo '</urlset>';