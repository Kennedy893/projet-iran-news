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

        foreach ($articles as &$article) {
            $articleId = (int) ($article['id'] ?? 0);
            $article['primary_image'] = $this->articleModel->getPrimaryImage($articleId);
            $article['secondary_images'] = $this->articleModel->getSecondaryImages($articleId);
        }
        unset($article);

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
            'id_categorie' => (int) ($_POST['id_categorie'] ?? 0),
        ];

        if ($data['titre'] === '' || $data['contenu'] === '' || $data['id_categorie'] <= 0) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => 'Veuillez remplir tous les champs obligatoires pour l\'article.'];
            $this->redirect('admin/articles');
            return;
        }

        $primaryImage = $this->uploadSingleImage($_FILES['image_primaire'] ?? null);
        if (!empty($primaryImage['error'])) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => $primaryImage['error']];
            $this->redirect('admin/articles');
            return;
        }

        if (empty($primaryImage['path'])) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => 'L\'image primaire est obligatoire.'];
            $this->redirect('admin/articles');
            return;
        }

        $secondaryImages = $this->uploadMultipleImages($_FILES['images_secondaires'] ?? null);
        if (!empty($secondaryImages['error'])) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => $secondaryImages['error']];
            $this->redirect('admin/articles');
            return;
        }

        $articleId = $this->articleModel->create($data);
        $ok = false;

        if ($articleId !== false) {
            $okPrimary = $this->articleModel->setPrimaryImage($articleId, $primaryImage['path']);
            $okSecondary = $this->articleModel->addSecondaryImages($articleId, $secondaryImages['paths']);
            $ok = $okPrimary && $okSecondary;
        }

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
            'id_categorie' => (int) ($_POST['id_categorie'] ?? 0),
        ];

        if ($data['titre'] === '' || $data['contenu'] === '' || $data['id_categorie'] <= 0) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => 'Champs invalides pour la mise a jour de l\'article.'];
            $this->redirect('admin/articles');
            return;
        }

        $primaryImage = $this->uploadSingleImage($_FILES['image_primaire'] ?? null);
        if (!empty($primaryImage['error'])) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => $primaryImage['error']];
            $this->redirect('admin/articles');
            return;
        }

        $secondaryImages = $this->uploadMultipleImages($_FILES['images_secondaires'] ?? null);
        if (!empty($secondaryImages['error'])) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => $secondaryImages['error']];
            $this->redirect('admin/articles');
            return;
        }

        $ok = $this->articleModel->update($id, $data);
        if ($ok && !empty($primaryImage['path'])) {
            $oldPrimary = $this->articleModel->getPrimaryImagePath($id);
            $ok = $this->articleModel->setPrimaryImage($id, $primaryImage['path']);
            if ($ok && !empty($oldPrimary)) {
                $this->removeStoredFile($oldPrimary);
            }
        }

        if ($ok && !empty($secondaryImages['paths'])) {
            $ok = $this->articleModel->addSecondaryImages($id, $secondaryImages['paths']);
        }

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

    public function deleteArticleImage($params)
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('admin/login');
            return;
        }

        $imageId = (int) ($params['id'] ?? 0);
        if ($imageId <= 0) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => 'Identifiant image invalide.'];
            $this->redirect('admin/articles');
            return;
        }

        $image = $this->articleModel->findImageById($imageId);
        if (!$image) {
            $_SESSION['admin_flash'] = ['type' => 'error', 'message' => 'Image introuvable.'];
            $this->redirect('admin/articles');
            return;
        }

        $ok = $this->articleModel->deleteImageById($imageId);
        if ($ok) {
            $this->removeStoredFile($image['chemin'] ?? '');
        }

        $_SESSION['admin_flash'] = [
            'type' => $ok ? 'success' : 'error',
            'message' => $ok ? 'Image supprimee avec succes.' : 'Echec de la suppression de l\'image.',
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

    private function uploadSingleImage($file)
    {
        if (!$file || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return ['path' => null, 'error' => null];
        }

        if ((int) $file['error'] !== UPLOAD_ERR_OK) {
            return ['path' => null, 'error' => 'Erreur lors de l\'upload de l\'image primaire.'];
        }

        $savedPath = $this->saveUploadedImage($file);
        if ($savedPath === null) {
            return ['path' => null, 'error' => 'Format d\'image non autorise ou fichier invalide.'];
        }

        return ['path' => $savedPath, 'error' => null];
    }

    private function uploadMultipleImages($files)
    {
        if (!$files || !isset($files['name']) || !is_array($files['name'])) {
            return ['paths' => [], 'error' => null];
        }

        $paths = [];
        $count = count($files['name']);
        for ($i = 0; $i < $count; $i++) {
            if ((int) ($files['error'][$i] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            if ((int) ($files['error'][$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                return ['paths' => [], 'error' => 'Erreur lors de l\'upload d\'une image secondaire.'];
            }

            $file = [
                'name' => $files['name'][$i] ?? '',
                'type' => $files['type'][$i] ?? '',
                'tmp_name' => $files['tmp_name'][$i] ?? '',
                'error' => $files['error'][$i] ?? UPLOAD_ERR_NO_FILE,
                'size' => $files['size'][$i] ?? 0,
            ];

            $savedPath = $this->saveUploadedImage($file);
            if ($savedPath === null) {
                return ['paths' => [], 'error' => 'Format d\'image secondaire non autorise.'];
            }

            $paths[] = $savedPath;
        }

        return ['paths' => $paths, 'error' => null];
    }

    private function saveUploadedImage($file)
    {
        $tmpName = (string) ($file['tmp_name'] ?? '');
        if ($tmpName === '' || !is_uploaded_file($tmpName)) {
            return null;
        }

        $extension = strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION));
        if (!in_array($extension, ALLOWED_EXTENSIONS, true)) {
            return null;
        }

        $uploadDir = rtrim(UPLOAD_DIR, '/\\') . DIRECTORY_SEPARATOR . 'articles' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0777, true);
        }

        $filename = uniqid('article_', true) . '.' . $extension;
        $targetPath = $uploadDir . $filename;

        if (!move_uploaded_file($tmpName, $targetPath)) {
            return null;
        }

        return 'uploads/articles/' . $filename;
    }

    private function removeStoredFile($relativePath)
    {
        $relativePath = ltrim((string) $relativePath, '/');
        if ($relativePath === '') {
            return;
        }

        $fullPath = __DIR__ . '/../../public/' . $relativePath;
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
