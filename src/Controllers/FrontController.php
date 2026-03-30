<?php
namespace Controllers;

use Core\Database;
use Helpers\MetaManager;
use PDO;

class FrontController
{
    private $db;
    private $metaManager;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->metaManager = new MetaManager();
    }
    
    public function home()
    {
        // Récupérer les articles récents
        $articles = $this->getRecentArticles(10);
        
        // Récupérer les catégories avec comptage
        $categories = $this->getCategoriesWithCount();
        
        // Configuration SEO
        $this->metaManager->setHomeMeta();
        $meta = $this->metaManager->getMeta();
        
        // Charger la vue
        require_once __DIR__ . '/../Views/front/layout/header.php';
        require_once __DIR__ . '/../Views/front/home.php';
        require_once __DIR__ . '/../Views/front/layout/footer.php';
    }
    
    public function showArticle($params)
    {
        $id = $params['id'] ?? ($params['slug'] ?? null);
        
        if (!$id) {
            $this->notFound();
            return;
        }
        
        $article = $this->findArticleById($id);
        
        if (!$article) {
            $this->notFound();
            return;
        }
        
        // Récupérer les articles similaires
        $related = $this->getRelatedArticles($article['id_categorie'], $article['id']);
        $secondaryImages = $this->getSecondaryImages((int) $article['id']);
        
        // Configuration SEO
        $this->metaManager->setArticleMeta($article);
        $meta = $this->metaManager->getMeta();
        
        // Charger la vue
        require_once __DIR__ . '/../Views/front/layout/header.php';
        require_once __DIR__ . '/../Views/front/article.php';
        require_once __DIR__ . '/../Views/front/layout/footer.php';
    }
    
    public function showCategory($params)
    {
        $identifier = $params['id'] ?? ($params['slug'] ?? null);
        
        if (!$identifier) {
            $this->notFound();
            return;
        }
        
        $category = $this->findCategory($identifier);
        
        if (!$category) {
            $this->notFound();
            return;
        }
        
        $articles = $this->findArticlesByCategory((int) $category['id']);
        
        // Configuration SEO
        $this->metaManager->setCategoryMeta($category);
        $meta = $this->metaManager->getMeta();
        
        require_once __DIR__ . '/../Views/front/layout/header.php';
        require_once __DIR__ . '/../Views/front/category.php';
        require_once __DIR__ . '/../Views/front/layout/footer.php';
    }
    
    public function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        $this->metaManager->set404Meta();
        $meta = $this->metaManager->getMeta();
        
        require_once __DIR__ . '/../Views/front/layout/header.php';
        require_once __DIR__ . '/../Views/front/404.php';
        require_once __DIR__ . '/../Views/front/layout/footer.php';
    }
    
    public function search()
    {
        $query = $_GET['q'] ?? '';
        
        if (strlen($query) < 3) {
            $results = [];
        } else {
            $results = $this->searchArticles($query);
        }
        
        $this->metaManager->setSearchMeta($query);
        $meta = $this->metaManager->getMeta();
        
        require_once __DIR__ . '/../Views/front/layout/header.php';
        require_once __DIR__ . '/../Views/front/search.php';
        require_once __DIR__ . '/../Views/front/layout/footer.php';
    }

    private function getRecentArticles($limit = 10)
    {
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.id_categorie,
                       c.libelle AS categorie_libelle,
                       c.libelle AS category_name,
                       a.id_categorie AS category_id,
                       (
                           SELECT i.chemin
                           FROM image i
                           WHERE i.id_article = a.id AND i.type_image = 1
                           ORDER BY i.id ASC
                           LIMIT 1
                       ) AS image_url
                FROM article a
                LEFT JOIN categorie c ON a.id_categorie = c.id
                ORDER BY a.date_pub DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function getCategoriesWithCount()
    {
        $sql = "SELECT c.id, c.libelle, c.libelle AS name, COUNT(a.id) AS article_count
                FROM categorie c
                LEFT JOIN article a ON a.id_categorie = c.id
                GROUP BY c.id, c.libelle
                ORDER BY c.libelle ASC";

        return $this->db->query($sql)->fetchAll();
    }

    private function findArticleById($id)
    {
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.id_categorie,
                       c.libelle AS categorie_libelle,
                       c.libelle AS category_name,
                       a.id_categorie AS category_id,
                       (
                           SELECT i.chemin
                           FROM image i
                           WHERE i.id_article = a.id AND i.type_image = 1
                           ORDER BY i.id ASC
                           LIMIT 1
                       ) AS image_url
                FROM article a
                LEFT JOIN categorie c ON a.id_categorie = c.id
                WHERE a.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    private function getRelatedArticles($categoryId, $currentId, $limit = 3)
    {
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.id_categorie,
                       c.libelle AS categorie_libelle,
                       c.libelle AS category_name,
                       a.id_categorie AS category_id,
                       (
                           SELECT i.chemin
                           FROM image i
                           WHERE i.id_article = a.id AND i.type_image = 1
                           ORDER BY i.id ASC
                           LIMIT 1
                       ) AS image_url
                FROM article a
                LEFT JOIN categorie c ON a.id_categorie = c.id
                WHERE a.id_categorie = :category_id
                AND a.id <> :current_id
                ORDER BY a.date_pub DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_id', (int) $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':current_id', (string) $currentId);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function getSecondaryImages($articleId)
    {
        $stmt = $this->db->prepare("SELECT id, chemin FROM image WHERE id_article = :id_article AND type_image = 2 ORDER BY id ASC");
        $stmt->execute([':id_article' => (int) $articleId]);
        return $stmt->fetchAll();
    }

    private function findCategory($identifier)
    {
        if (ctype_digit((string) $identifier)) {
            $stmt = $this->db->prepare("SELECT id, libelle, libelle AS name FROM categorie WHERE id = :id");
            $stmt->execute([':id' => (int) $identifier]);
            return $stmt->fetch();
        }

        $label = trim(str_replace('-', ' ', urldecode((string) $identifier)));
        $stmt = $this->db->prepare("SELECT id, libelle, libelle AS name FROM categorie WHERE LOWER(libelle) = LOWER(:libelle)");
        $stmt->execute([':libelle' => $label]);
        return $stmt->fetch();
    }

    private function findArticlesByCategory($categoryId)
    {
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.id_categorie,
                       c.libelle AS categorie_libelle,
                       c.libelle AS category_name,
                       a.id_categorie AS category_id,
                       (
                           SELECT i.chemin
                           FROM image i
                           WHERE i.id_article = a.id AND i.type_image = 1
                           ORDER BY i.id ASC
                           LIMIT 1
                       ) AS image_url
                FROM article a
                LEFT JOIN categorie c ON a.id_categorie = c.id
                WHERE a.id_categorie = :category_id
                ORDER BY a.date_pub DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':category_id' => (int) $categoryId]);
        return $stmt->fetchAll();
    }

    private function searchArticles($query)
    {
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.id_categorie,
                       c.libelle AS categorie_libelle,
                       c.libelle AS category_name,
                       a.id_categorie AS category_id,
                       (
                           SELECT i.chemin
                           FROM image i
                           WHERE i.id_article = a.id AND i.type_image = 1
                           ORDER BY i.id ASC
                           LIMIT 1
                       ) AS image_url
                FROM article a
                LEFT JOIN categorie c ON a.id_categorie = c.id
                WHERE a.titre LIKE :query_title OR a.contenu LIKE :query_content
                ORDER BY a.date_pub DESC";

        $stmt = $this->db->prepare($sql);
        $like = '%' . $query . '%';
        $stmt->execute([
            ':query_title' => $like,
            ':query_content' => $like,
        ]);
        return $stmt->fetchAll();
    }
}