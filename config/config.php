<?php
// Configuration générale
define('APP_NAME', 'Iran Info');
// URL racine de l'application (sans slash final).
$configuredAppUrl = getenv('APP_URL') ?: 'http://localhost/S6/projet-iran-news';
define('APP_URL', rtrim($configuredAppUrl, '/'));
define('APP_ENV', 'development'); // production / development

if (!function_exists('app_url')) {
    function app_url($path = '')
    {
        $path = ltrim((string) $path, '/');
        return $path === '' ? APP_URL : APP_URL . '/' . $path;
    }
}

if (!function_exists('image_url')) {
    function image_url($path = '', $fallback = 'assets/images/default-og-image.jpg')
    {
        $path = trim((string) $path);
        if ($path === '') {
            return app_url($fallback);
        }

        // Keep fully qualified or protocol-relative URLs unchanged.
        if (preg_match('#^(?:https?:)?//#i', $path) || stripos($path, 'data:') === 0) {
            return $path;
        }

        $normalized = ltrim($path, '/');
        if (strpos($normalized, 'public/') === 0) {
            $normalized = substr($normalized, 7);
        }

        // Legacy records may contain /uploads/file.jpg while files are in /uploads/articles/.
        if (strpos($normalized, 'uploads/') === 0 && strpos($normalized, 'uploads/articles/') !== 0) {
            $legacyCandidate = 'uploads/articles/' . basename($normalized);
            $legacyFullPath = __DIR__ . '/../public/' . $legacyCandidate;
            if (is_file($legacyFullPath)) {
                $normalized = $legacyCandidate;
            }
        }

        $fullPath = __DIR__ . '/../public/' . $normalized;
        if (!is_file($fullPath)) {
            return app_url($fallback);
        }

        return app_url($normalized);
    }
}

// Base de données
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'iran_news');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

// Sécurité
define('SALT', 'votre_cle_secrete_tres_longue_et_complexe');
define('CSRF_TOKEN_LIFETIME', 3600);

// Uploads
define('UPLOAD_DIR', __DIR__ . '/../public/uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Pagination
define('ARTICLES_PER_PAGE', 12);
define('ADMIN_ARTICLES_PER_PAGE', 20);

// Cache
define('CACHE_ENABLED', false);
define('CACHE_DIR', __DIR__ . '/../cache/');

// Affichage des erreurs (désactiver en production)
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}