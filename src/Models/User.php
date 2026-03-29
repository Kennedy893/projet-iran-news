<?php
namespace Models;

use Core\Database;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findByLogin($login)
    {
        $sql = "SELECT id, nom, mdp, email, role
                FROM utilisateur
                WHERE nom = :login_nom OR email = :login_email
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':login_nom' => $login,
            ':login_email' => $login,
        ]);
        return $stmt->fetch();
    }

    public function verifyCredentials($login, $plainPassword)
    {
        $user = $this->findByLogin($login);
        if (!$user) {
            return null;
        }

        $storedPassword = (string) ($user['mdp'] ?? '');
        $isValid = false;

        // Compatibilite: accepte hash moderne et mot de passe legacy en clair.
        if ($storedPassword !== '' && password_verify($plainPassword, $storedPassword)) {
            $isValid = true;
        } elseif ($storedPassword !== '' && hash_equals($storedPassword, $plainPassword)) {
            $isValid = true;
        }

        if (!$isValid) {
            return null;
        }

        unset($user['mdp']);
        return $user;
    }
}
