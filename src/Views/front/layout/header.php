<?php
$meta = $meta ?? [];

$title = $meta['title'] ?? 'Iran Info - Actualites du conflit en Iran';
$description = $meta['description'] ?? "Suivez en direct l'actualite du conflit en Iran.";
$keywords = $meta['keywords'] ?? 'Iran, conflit, actualites';
$robots = $meta['robots'] ?? 'index, follow';
$ogTitle = $meta['og_title'] ?? $title;
$ogDescription = $meta['og_description'] ?? $description;
$ogImage = $meta['og_image'] ?? '/assets/images/default-og-image.jpg';
$ogType = $meta['og_type'] ?? 'website';
$twitterCard = $meta['twitter_card'] ?? 'summary_large_image';
$canonical = $meta['canonical'] ?? '';
$currentPage = $_SERVER['REQUEST_URI'] ?? '/';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#1a3a52">

    <title><?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="<?= htmlspecialchars((string) $description, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="keywords" content="<?= htmlspecialchars((string) $keywords, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="robots" content="<?= htmlspecialchars((string) $robots, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="author" content="Iran Info">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="<?= htmlspecialchars((string) $ogTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars((string) $ogDescription, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image" content="<?= htmlspecialchars((string) $ogImage, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:type" content="<?= htmlspecialchars((string) $ogType, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:site_name" content="Iran Info">
    <meta property="og:locale" content="fr_FR">

    <!-- Twitter -->
    <meta name="twitter:card" content="<?= htmlspecialchars((string) $twitterCard, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:title" content="<?= htmlspecialchars((string) $ogTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars((string) $ogDescription, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars((string) $ogImage, ENT_QUOTES, 'UTF-8') ?>">

    <?php if (!empty($canonical)): ?>
        <link rel="canonical" href="<?= htmlspecialchars((string) $canonical, ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" href="/favicon.png">

    <!-- Stylesheets -->
    <!-- <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css"> -->

    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/variables.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/responsive.css'), ENT_QUOTES, 'UTF-8') ?>">

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
</head>
<body>
    <!-- Skip to main content pour accessibilité -->
    <a href="#main-content" class="sr-only">Aller au contenu principal</a>

    <header class="site-header" role="banner">
        <div class="container">
            <a href="/" class="site-logo" aria-label="Iran Info - Retour à l'accueil">
                <span aria-hidden="true">📰</span>
                <span>Iran Info</span>
            </a>
            <nav class="main-nav" role="navigation" aria-label="Navigation principale">
                <a href="/" <?= $currentPage === '/' ? 'class="active" aria-current="page"' : '' ?>>Accueil</a>
                <a href="/search" <?= strpos($currentPage, '/search') === 0 ? 'class="active" aria-current="page"' : '' ?>>Recherche</a>
            </nav>
        </div>
    </header>
