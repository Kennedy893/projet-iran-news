<?php
// Debug: Vérifie si la requête SQL retourne les bonnes images par article

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Core/Database.php';

use Core\Database;

$db = Database::getInstance();

// Requête identique à FrontController::getRecentArticles()
$sql = "SELECT a.id, a.titre, a.date_pub,
               (
                   SELECT i.chemin
                   FROM image i
                   WHERE i.id_article = a.id AND i.type_image = 1
                   ORDER BY i.id ASC
                   LIMIT 1
               ) AS image_url
        FROM article a
        ORDER BY a.date_pub DESC";

$stmt = $db->prepare($sql);
$stmt->execute();
$articles = $stmt->fetchAll();

echo "<h2>Articles et leurs images (depuis requête SQL)</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Titre</th><th>Image URL (BD)</th><th>Fichier existe?</th></tr>";

foreach ($articles as $article) {
    $id = $article['id'];
    $titre = $article['titre'];
    $imageUrl = $article['image_url'];
    
    $filePath = __DIR__ . '/' . ltrim($imageUrl, '/');
    $exists = file_exists($filePath) ? '✓ OUI' : '✗ NON';
    
    echo "<tr>";
    echo "<td>$id</td>";
    echo "<td>$titre</td>";
    echo "<td>" . htmlspecialchars($imageUrl) . "</td>";
    echo "<td>$exists</td>";
    echo "</tr>";
}

echo "</table>";
echo "<p style='margin-top: 20px; font-size: 12px;'>Si plusieurs articles ont la même image URL, c'est le bug.</p>";
?>
