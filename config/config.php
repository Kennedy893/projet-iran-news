<?php
// Configuration générale
define('APP_NAME', 'Iran Info');
define('APP_URL', 'http://localhost:8080');
define('APP_ENV', 'development'); // production / development

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