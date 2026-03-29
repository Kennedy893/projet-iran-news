<?php
namespace Models;

use Core\Database;
use PDO;

class Category
{
    private $db;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM categorie ORDER BY libelle ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function findAllWithCount()
    {
        $sql = "SELECT c.id, c.libelle, c.libelle AS name, COUNT(a.id) AS article_count
                FROM categorie c
                LEFT JOIN article a ON a.id_categorie = c.id
                GROUP BY c.id, c.libelle
                ORDER BY c.libelle ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function findBySlug($slug)
    {
        if (ctype_digit((string) $slug)) {
            $stmt = $this->db->prepare("SELECT id, libelle, libelle AS name FROM categorie WHERE id = :id");
            $stmt->execute([':id' => (int) $slug]);
            return $stmt->fetch();
        }

        $label = trim(str_replace('-', ' ', urldecode((string) $slug)));
        $stmt = $this->db->prepare("SELECT id, libelle, libelle AS name FROM categorie WHERE LOWER(libelle) = LOWER(:libelle)");
        $stmt->execute([':libelle' => $label]);
        return $stmt->fetch();
    }

    public function create($libelle)
    {
        $stmt = $this->db->prepare("INSERT INTO categorie (libelle) VALUES (:libelle)");
        return $stmt->execute([':libelle' => $libelle]);
    }

    public function update($id, $libelle)
    {
        $stmt = $this->db->prepare("UPDATE categorie SET libelle = :libelle WHERE id = :id");
        return $stmt->execute([
            ':id' => (int) $id,
            ':libelle' => $libelle,
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categorie WHERE id = :id");
        return $stmt->execute([':id' => (int) $id]);
    }
}