<?php
namespace Controllers;

use Models\Article;
use Models\Category;

class AdminController
{
    private $articleModel;
    private $categoryModel;

    public function __construct()
    {
        $this->articleModel = new Article();
        $this->categoryModel = new Category();
    }

    public function dashboard()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('admin/login');
            return;
        }

        $admin = $_SESSION['admin_user'];
        $articles = $this->articleModel->findAll();
        $categories = $this->categoryModel->findAllWithCount();

        $stats = [
            'articles_total' => count($articles),
            'categories_total' => count($categories),
            'articles_today' => 0,
        ];

        $today = date('Y-m-d');
        foreach ($articles as $article) {
            if (($article['date_pub'] ?? null) === $today) {
                $stats['articles_today']++;
            }
        }

        $recentArticles = array_slice($articles, 0, 5);
        $topCategories = array_slice($categories, 0, 5);

        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }

    public function listArticles()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('admin/login');
            return;
        }

        $articles = $this->articleModel->findAll();
        $categories = $this->categoryModel->findAll();

        $flash = $_SESSION['admin_flash'] ?? null;
        unset($_SESSION['admin_flash']);

        require_once __DIR__ . '/../Views/admin/articles/index.php';
    }

    public function storeArticle()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('admin/login');
            return;
        }

        $data = [
            'titre' => trim($_POST['titre'] ?? ''),
            'contenu' => trim($_POST['contenu'] ?? ''),
            'date_pub' => $_POST['date_pub'] ?? date('Y-m-d'),
            'image_url' => trim($_POST['image_url'] ?? ''),
            'id_categorie' => (int) ($_POST['id_categorie'] ?? 0),
        ];

        if ($data['titre'] === '' || $data['contenu'] === '' || $data['id_categorie'] <= 0) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => 'Veuillez remplir tous les champs obligatoires pour l\'article.'];
            $this->redirect('admin/articles');
            return;
        }

        $ok = $this->articleModel->create($data);
        $_SESSION['admin_flash'] = [
            'type' => $ok ? 'success' : 'error',
            'message' => $ok ? 'Article cree avec succes.' : 'Impossible de creer l\'article.',
        ];

        $this->redirect('admin/articles');
    }

    public function updateArticle($params)
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('admin/login');
            return;
        }

        $id = (int) ($params['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => 'Identifiant article invalide.'];
            $this->redirect('admin/articles');
            return;
        }

        $data = [
            'titre' => trim($_POST['titre'] ?? ''),
            'contenu' => trim($_POST['contenu'] ?? ''),
            'date_pub' => $_POST['date_pub'] ?? date('Y-m-d'),
            'image_url' => trim($_POST['image_url'] ?? ''),
            'id_categorie' => (int) ($_POST['id_categorie'] ?? 0),
        ];

        if ($data['titre'] === '' || $data['contenu'] === '' || $data['id_categorie'] <= 0) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => 'Champs invalides pour la mise a jour de l\'article.'];
            $this->redirect('admin/articles');
            return;
        }

        $ok = $this->articleModel->update($id, $data);
        $_SESSION['admin_flash'] = [
            'type' => $ok ? 'success' : 'error',
            'message' => $ok ? 'Article mis a jour.' : 'Echec de la mise a jour de l\'article.',
        ];

        $this->redirect('admin/articles');
    }

    public function deleteArticle($params)
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('admin/login');
            return;
        }

        $id = (int) ($params['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => 'Identifiant article invalide.'];
            $this->redirect('admin/articles');
            return;
        }

        $ok = $this->articleModel->delete($id);
        $_SESSION['admin_flash'] = [
            'type' => $ok ? 'success' : 'error',
            'message' => $ok ? 'Article supprime.' : 'Echec de la suppression de l\'article.',
        ];

        $this->redirect('admin/articles');
    }

    public function listCategories()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('admin/login');
            return;
        }

        $categories = $this->categoryModel->findAllWithCount();

        $flash = $_SESSION['admin_flash'] ?? null;
        unset($_SESSION['admin_flash']);

        require_once __DIR__ . '/../Views/admin/categories/index.php';
    }

    public function storeCategory()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('admin/login');
            return;
        }

        $libelle = trim($_POST['libelle'] ?? '');
        if ($libelle === '') {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => 'Le libelle de categorie est obligatoire.'];
            $this->redirect('admin/categories');
            return;
        }

        $ok = $this->categoryModel->create($libelle);
        $_SESSION['admin_flash'] = [
            'type' => $ok ? 'success' : 'error',
            'message' => $ok ? 'Categorie creee.' : 'Echec de creation de la categorie.',
        ];

        $this->redirect('admin/categories');
    }

    public function updateCategory($params)
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('admin/login');
            return;
        }

        $id = (int) ($params['id'] ?? 0);
        $libelle = trim($_POST['libelle'] ?? '');

        if ($id <= 0 || $libelle === '') {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => 'Donnees invalides pour la categorie.'];
            $this->redirect('admin/categories');
            return;
        }

        $ok = $this->categoryModel->update($id, $libelle);
        $_SESSION['admin_flash'] = [
            'type' => $ok ? 'success' : 'error',
            'message' => $ok ? 'Categorie mise a jour.' : 'Echec de la mise a jour de la categorie.',
        ];

        $this->redirect('admin/categories');
    }

    public function deleteCategory($params)
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('admin/login');
            return;
        }

        $id = (int) ($params['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => 'Identifiant categorie invalide.'];
            $this->redirect('admin/categories');
            return;
        }

        $ok = $this->categoryModel->delete($id);
        $_SESSION['admin_flash'] = [
            'type' => $ok ? 'success' : 'error',
            'message' => $ok ? 'Categorie supprimee.' : 'Impossible de supprimer cette categorie (articles lies).',
        ];

        $this->redirect('admin/categories');
    }

    private function isAuthenticated()
    {
        return !empty($_SESSION['admin_user']['id']);
    }

    private function redirect($path)
    {
        header('Location: ' . app_url($path));
        exit;
    }
}
