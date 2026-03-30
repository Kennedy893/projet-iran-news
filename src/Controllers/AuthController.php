<?php
namespace Controllers;

use Models\User;

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showLogin()
    {
        $forceLogin = isset($_GET['force']) && (string) $_GET['force'] === '1';

        if ($forceLogin) {
            unset($_SESSION['admin_user']);
        }

        if ($this->isAuthenticated()) {
            $this->redirect('admin/dashboard');
            return;
        }

        if (empty($_SESSION['csrf_token']) || time() > (int) ($_SESSION['csrf_expires'] ?? 0)) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['csrf_expires'] = time() + CSRF_TOKEN_LIFETIME;
        }

        $error = $_SESSION['auth_error'] ?? null;
        $oldLogin = $_SESSION['auth_old_login'] ?? '';

        unset($_SESSION['auth_error'], $_SESSION['auth_old_login']);

        require_once __DIR__ . '/../Views/admin/login/login.php';
    }

    public function login()
    {
        $login = trim($_POST['login'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $csrf = (string) ($_POST['csrf_token'] ?? '');

        if (!$this->isValidCsrf($csrf)) {
            $_SESSION['auth_error'] = 'Session invalide. Merci de reessayer.';
            $_SESSION['auth_old_login'] = $login;
            $this->redirect('admin/login');
            return;
        }

        if ($login === '' || $password === '') {
            $_SESSION['auth_error'] = 'Veuillez renseigner vos identifiants.';
            $_SESSION['auth_old_login'] = $login;
            $this->redirect('admin/login');
            return;
        }

        $user = $this->userModel->verifyCredentials($login, $password);
        if (!$user) {
            $_SESSION['auth_error'] = 'Identifiants invalides.';
            $_SESSION['auth_old_login'] = $login;
            $this->redirect('admin/login');
            return;
        }

        session_regenerate_id(true);
        $_SESSION['admin_user'] = [
            'id' => $user['id'],
            'nom' => $user['nom'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        $this->redirect('admin/dashboard');
    }

    public function logout()
    {
        unset($_SESSION['admin_user']);
        $this->redirect('admin/login');
    }

    public function dashboard()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('admin/login');
            return;
        }

        $admin = $_SESSION['admin_user'];
        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }

    private function isAuthenticated()
    {
        return !empty($_SESSION['admin_user']['id']);
    }

    private function isValidCsrf($token)
    {
        $sessionToken = (string) ($_SESSION['csrf_token'] ?? '');
        $expiresAt = (int) ($_SESSION['csrf_expires'] ?? 0);

        if ($sessionToken === '' || $expiresAt < time()) {
            return false;
        }

        return hash_equals($sessionToken, $token);
    }

    private function redirect($path)
    {
        header('Location: ' . app_url($path));
        exit;
    }
}
