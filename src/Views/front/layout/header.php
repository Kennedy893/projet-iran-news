<?php
$meta = $meta ?? [];

$title = $meta['title'] ?? 'Iran Info - Actualites du conflit en Iran';
$description = $meta['description'] ?? "Suivez en direct l'actualite du conflit en Iran.";
$keywords = $meta['keywords'] ?? 'Iran, conflit, actualites';
$robots = $meta['robots'] ?? 'index, follow';
$ogTitle = $meta['og_title'] ?? $title;
$ogDescription = $meta['og_description'] ?? $description;
$ogImage = $meta['og_image'] ?? app_url('assets/images/default-og-image.jpg');
$ogType = $meta['og_type'] ?? 'website';
$twitterCard = $meta['twitter_card'] ?? 'summary_large_image';
$canonical = $meta['canonical'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?= htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="<?= htmlspecialchars((string) $description, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="keywords" content="<?= htmlspecialchars((string) $keywords, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="robots" content="<?= htmlspecialchars((string) $robots, ENT_QUOTES, 'UTF-8') ?>">

    <meta property="og:title" content="<?= htmlspecialchars((string) $ogTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars((string) $ogDescription, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image" content="<?= htmlspecialchars((string) $ogImage, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:type" content="<?= htmlspecialchars((string) $ogType, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:site_name" content="Iran Info">

    <meta name="twitter:card" content="<?= htmlspecialchars((string) $twitterCard, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:title" content="<?= htmlspecialchars((string) $ogTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars((string) $ogDescription, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars((string) $ogImage, ENT_QUOTES, 'UTF-8') ?>">

    <?php if (!empty($canonical)): ?>
        <link rel="canonical" href="<?= htmlspecialchars((string) $canonical, ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>

    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/responsive.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body>
<header class="site-header" style="padding:1rem;border-bottom:1px solid #ddd;">
    <div class="container" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
        <a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>" style="font-weight:700;text-decoration:none;color:inherit;">Iran Info</a>
        <nav aria-label="Navigation principale" style="display:flex;gap:1rem;">
            <a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>">Accueil</a>
            <a href="<?= htmlspecialchars(app_url('search'), ENT_QUOTES, 'UTF-8') ?>">Recherche</a>
            <a href="<?= htmlspecialchars(app_url('admin/login'), ENT_QUOTES, 'UTF-8') ?>">Page d'admin</a>
        </nav>
    </div>
</header>
