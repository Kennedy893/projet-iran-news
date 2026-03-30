<?php
namespace Models;

use Core\Database;
use PDO;

class Article
{
    private $db;

    private const IMAGE_TYPE_PRIMARY = 1;
    private const IMAGE_TYPE_SECONDARY = 2;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    public function findAll($limit = null, $offset = 0)
    {
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.id_categorie,
                       c.libelle AS category_name,
                       c.libelle AS categorie_libelle,
                       a.id_categorie AS category_id,
                       (
                           SELECT i.chemin
                           FROM image i
                           WHERE i.id_article = a.id AND i.type_image = " . self::IMAGE_TYPE_PRIMARY . "
                           ORDER BY i.id ASC
                           LIMIT 1
                       ) AS image_url
                FROM article a
                LEFT JOIN categorie c ON a.id_categorie = c.id
                ORDER BY a.date_pub DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->db->prepare($sql);
        
        if ($limit) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function findBySlug($slug)
    {
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.id_categorie,
                       c.libelle AS category_name,
                       c.libelle AS categorie_libelle,
                       a.id_categorie AS category_id,
                       (
                           SELECT i.chemin
                           FROM image i
                           WHERE i.id_article = a.id AND i.type_image = " . self::IMAGE_TYPE_PRIMARY . "
                           ORDER BY i.id ASC
                           LIMIT 1
                       ) AS image_url
                FROM article a
                LEFT JOIN categorie c ON a.id_categorie = c.id
                WHERE a.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $slug]);
        return $stmt->fetch();
    }
    
    public function create($data)
    {
        $sql = "INSERT INTO article (titre, contenu, date_pub, id_categorie)
                VALUES (:titre, :contenu, :date_pub, :id_categorie)";

        $payload = [
            ':titre' => $data['titre'] ?? ($data['title'] ?? ''),
            ':contenu' => $data['contenu'] ?? ($data['content'] ?? ''),
            ':date_pub' => $data['date_pub'] ?? date('Y-m-d'),
            ':id_categorie' => (int) ($data['id_categorie'] ?? ($data['category_id'] ?? 0)),
        ];

        $stmt = $this->db->prepare($sql);
        if (!$stmt->execute($payload)) {
            return false;
        }

        return (int) $this->db->lastInsertId();
    }
    
    public function update($id, $data)
    {
        $sql = "UPDATE article SET
                titre = :titre,
                contenu = :contenu,
                date_pub = :date_pub,
                id_categorie = :id_categorie
                WHERE id = :id";

        $payload = [
            ':id' => $id,
            ':titre' => $data['titre'] ?? ($data['title'] ?? ''),
            ':contenu' => $data['contenu'] ?? ($data['content'] ?? ''),
            ':date_pub' => $data['date_pub'] ?? date('Y-m-d'),
            ':id_categorie' => (int) ($data['id_categorie'] ?? ($data['category_id'] ?? 0)),
        ];

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($payload);
    }
    
    public function delete($id)
    {
        $this->deleteAllImagesForArticle((int) $id);

        $sql = "DELETE FROM article WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    public function incrementViews($id)
    {
        // La table article ne contient pas la colonne views dans database.sql.
        return true;
    }
    
    public function getRelated($categoryId, $currentId, $limit = 3)
    {
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.id_categorie,
                       c.libelle AS category_name,
                       c.libelle AS categorie_libelle,
                       a.id_categorie AS category_id,
                       (
                           SELECT i.chemin
                           FROM image i
                           WHERE i.id_article = a.id AND i.type_image = " . self::IMAGE_TYPE_PRIMARY . "
                           ORDER BY i.id ASC
                           LIMIT 1
                       ) AS image_url
                FROM article a
                LEFT JOIN categorie c ON a.id_categorie = c.id
                WHERE a.id_categorie = :category_id
                AND a.id != :current_id
                ORDER BY a.date_pub DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':current_id', (string) $currentId);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function findByCategory($categoryId)
    {
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.id_categorie,
                       c.libelle AS category_name,
                       c.libelle AS categorie_libelle,
                       a.id_categorie AS category_id,
                       (
                           SELECT i.chemin
                           FROM image i
                           WHERE i.id_article = a.id AND i.type_image = " . self::IMAGE_TYPE_PRIMARY . "
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

    public function search($query)
    {
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.id_categorie,
                       c.libelle AS category_name,
                       c.libelle AS categorie_libelle,
                       a.id_categorie AS category_id,
                       (
                           SELECT i.chemin
                           FROM image i
                           WHERE i.id_article = a.id AND i.type_image = " . self::IMAGE_TYPE_PRIMARY . "
                           ORDER BY i.id ASC
                           LIMIT 1
                       ) AS image_url
                FROM article a
                LEFT JOIN categorie c ON a.id_categorie = c.id
                WHERE a.titre LIKE :query OR a.contenu LIKE :query
                ORDER BY a.date_pub DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':query' => '%' . $query . '%']);
        
        return $stmt->fetchAll();
    }

    public function getPrimaryImagePath($articleId)
    {
        $primary = $this->getPrimaryImage($articleId);
        return $primary['chemin'] ?? null;
    }

    public function getPrimaryImage($articleId)
    {
        $stmt = $this->db->prepare("SELECT id, chemin FROM image WHERE id_article = :id_article AND type_image = :type_image ORDER BY id ASC LIMIT 1");
        $stmt->execute([
            ':id_article' => (int) $articleId,
            ':type_image' => self::IMAGE_TYPE_PRIMARY,
        ]);

        return $stmt->fetch() ?: null;
    }

    public function getSecondaryImages($articleId)
    {
        $stmt = $this->db->prepare("SELECT id, chemin FROM image WHERE id_article = :id_article AND type_image = :type_image ORDER BY id ASC");
        $stmt->execute([
            ':id_article' => (int) $articleId,
            ':type_image' => self::IMAGE_TYPE_SECONDARY,
        ]);

        return $stmt->fetchAll();
    }

    public function setPrimaryImage($articleId, $path)
    {
        $existing = $this->getPrimaryImage($articleId);

        if ($existing !== null) {
            $stmt = $this->db->prepare("UPDATE image SET chemin = :chemin WHERE id_article = :id_article AND type_image = :type_image");
            return $stmt->execute([
                ':chemin' => $path,
                ':id_article' => (int) $articleId,
                ':type_image' => self::IMAGE_TYPE_PRIMARY,
            ]);
        }

        $stmt = $this->db->prepare("INSERT INTO image (chemin, type_image, id_article) VALUES (:chemin, :type_image, :id_article)");
        return $stmt->execute([
            ':chemin' => $path,
            ':type_image' => self::IMAGE_TYPE_PRIMARY,
            ':id_article' => (int) $articleId,
        ]);
    }

    public function addSecondaryImages($articleId, array $paths)
    {
        if (empty($paths)) {
            return true;
        }

        $stmt = $this->db->prepare("INSERT INTO image (chemin, type_image, id_article) VALUES (:chemin, :type_image, :id_article)");
        foreach ($paths as $path) {
            $ok = $stmt->execute([
                ':chemin' => $path,
                ':type_image' => self::IMAGE_TYPE_SECONDARY,
                ':id_article' => (int) $articleId,
            ]);

            if (!$ok) {
                return false;
            }
        }

        return true;
    }

    public function findImageById($imageId)
    {
        $stmt = $this->db->prepare("SELECT id, chemin, type_image, id_article FROM image WHERE id = :id");
        $stmt->execute([':id' => (int) $imageId]);
        return $stmt->fetch() ?: null;
    }

    public function deleteImageById($imageId)
    {
        $stmt = $this->db->prepare("DELETE FROM image WHERE id = :id");
        return $stmt->execute([':id' => (int) $imageId]);
    }

    private function deleteAllImagesForArticle($articleId)
    {
        $stmt = $this->db->prepare("SELECT chemin FROM image WHERE id_article = :id_article");
        $stmt->execute([':id_article' => (int) $articleId]);
        $images = $stmt->fetchAll();

        foreach ($images as $image) {
            $relativePath = ltrim((string) ($image['chemin'] ?? ''), '/');
            if ($relativePath === '') {
                continue;
            }

            $fullPath = __DIR__ . '/../../public/' . $relativePath;
            if (is_file($fullPath)) {
                @unlink($fullPath);
            }
        }

        $deleteStmt = $this->db->prepare("DELETE FROM image WHERE id_article = :id_article");
        $deleteStmt->execute([':id_article' => (int) $articleId]);
    }
}