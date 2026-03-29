<?php
namespace Models;

use Core\Database;
use PDO;

class Article
{
    private $db;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    public function findAll($limit = null, $offset = 0)
    {
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.image_url, a.id_categorie,
                   c.libelle AS category_name,
                   c.libelle AS categorie_libelle,
                   a.id_categorie AS category_id
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
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.image_url, a.id_categorie,
                   c.libelle AS category_name,
                   c.libelle AS categorie_libelle,
                   a.id_categorie AS category_id
            FROM article a
            LEFT JOIN categorie c ON a.id_categorie = c.id
            WHERE a.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $slug]);
        return $stmt->fetch();
    }
    
    public function create($data)
    {
        $sql = "INSERT INTO article (id, titre, contenu, date_pub, image_url, id_categorie)
                VALUES (:id, :titre, :contenu, :date_pub, :image_url, :id_categorie)";

        $payload = [
            ':id' => $data['id'] ?? uniqid('art_', true),
            ':titre' => $data['titre'] ?? ($data['title'] ?? ''),
            ':contenu' => $data['contenu'] ?? ($data['content'] ?? ''),
            ':date_pub' => $data['date_pub'] ?? date('Y-m-d'),
            ':image_url' => $data['image_url'] ?? ($data['featured_image'] ?? null),
            ':id_categorie' => (int) ($data['id_categorie'] ?? ($data['category_id'] ?? 0)),
        ];

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($payload);
    }
    
    public function update($id, $data)
    {
        $sql = "UPDATE article SET
                titre = :titre,
                contenu = :contenu,
                date_pub = :date_pub,
                image_url = :image_url,
                id_categorie = :id_categorie
                WHERE id = :id";

        $payload = [
            ':id' => $id,
            ':titre' => $data['titre'] ?? ($data['title'] ?? ''),
            ':contenu' => $data['contenu'] ?? ($data['content'] ?? ''),
            ':date_pub' => $data['date_pub'] ?? date('Y-m-d'),
            ':image_url' => $data['image_url'] ?? ($data['featured_image'] ?? null),
            ':id_categorie' => (int) ($data['id_categorie'] ?? ($data['category_id'] ?? 0)),
        ];

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($payload);
    }
    
    public function delete($id)
    {
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
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.image_url, a.id_categorie,
                   c.libelle AS category_name,
                   c.libelle AS categorie_libelle,
                   a.id_categorie AS category_id
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
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.image_url, a.id_categorie,
                       c.libelle AS category_name,
                       c.libelle AS categorie_libelle,
                       a.id_categorie AS category_id
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
        $sql = "SELECT a.id, a.titre, a.contenu, a.date_pub, a.image_url, a.id_categorie,
                       c.libelle AS category_name,
                       c.libelle AS categorie_libelle,
                       a.id_categorie AS category_id
                FROM article a
                LEFT JOIN categorie c ON a.id_categorie = c.id
                WHERE a.titre LIKE :query OR a.contenu LIKE :query
                ORDER BY a.date_pub DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':query' => '%' . $query . '%']);
        
        return $stmt->fetchAll();
    }
}