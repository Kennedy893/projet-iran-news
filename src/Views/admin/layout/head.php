<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <?php if (isset($meta) && is_object($meta) && method_exists($meta, 'render')): ?>
        <?php $meta->render(); ?>
    <?php elseif (isset($meta) && is_array($meta)): ?>
        <title><?= htmlspecialchars((string) ($meta['title'] ?? 'Iran Info - Actualites du conflit en Iran'), ENT_QUOTES, 'UTF-8') ?></title>
        <meta name="description" content="<?= htmlspecialchars((string) ($meta['description'] ?? "Suivez l'actualite du conflit en Iran"), ENT_QUOTES, 'UTF-8') ?>">
        <meta name="keywords" content="<?= htmlspecialchars((string) ($meta['keywords'] ?? 'Iran, guerre, conflit, actualites'), ENT_QUOTES, 'UTF-8') ?>">
        <meta name="robots" content="<?= htmlspecialchars((string) ($meta['robots'] ?? 'index, follow'), ENT_QUOTES, 'UTF-8') ?>">

        <meta property="og:title" content="<?= htmlspecialchars((string) ($meta['og_title'] ?? ($meta['title'] ?? 'Iran Info')), ENT_QUOTES, 'UTF-8') ?>">
        <meta property="og:description" content="<?= htmlspecialchars((string) ($meta['og_description'] ?? ($meta['description'] ?? 'Suivez l\'actualite du conflit en Iran')), ENT_QUOTES, 'UTF-8') ?>">
        <meta property="og:image" content="<?= htmlspecialchars((string) ($meta['og_image'] ?? '/assets/images/default-og-image.jpg'), ENT_QUOTES, 'UTF-8') ?>">
        <meta property="og:type" content="<?= htmlspecialchars((string) ($meta['og_type'] ?? 'website'), ENT_QUOTES, 'UTF-8') ?>">

        <meta name="twitter:card" content="<?= htmlspecialchars((string) ($meta['twitter_card'] ?? 'summary_large_image'), ENT_QUOTES, 'UTF-8') ?>">
        <meta name="twitter:title" content="<?= htmlspecialchars((string) ($meta['og_title'] ?? ($meta['title'] ?? 'Iran Info')), ENT_QUOTES, 'UTF-8') ?>">
        <meta name="twitter:description" content="<?= htmlspecialchars((string) ($meta['og_description'] ?? ($meta['description'] ?? 'Suivez l\'actualite du conflit en Iran')), ENT_QUOTES, 'UTF-8') ?>">
        <meta name="twitter:image" content="<?= htmlspecialchars((string) ($meta['og_image'] ?? '/assets/images/default-og-image.jpg'), ENT_QUOTES, 'UTF-8') ?>">

        <?php if (!empty($meta['canonical'])): ?>
            <link rel="canonical" href="<?= htmlspecialchars((string) $meta['canonical'], ENT_QUOTES, 'UTF-8') ?>">
        <?php endif; ?>
    <?php else: ?>
        <title>Iran Info - Actualités du conflit en Iran</title>
        <meta name="description" content="Suivez l'actualité du conflit en Iran">
    <?php endif; ?>
    
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
    <link rel="alternate" type="application/rss+xml" title="Iran Info RSS" href="/rss.xml">
    
    <!-- Preload critical assets -->
    <link rel="preload" href="/assets/css/style.css" as="style">
    <link rel="preload" href="/assets/js/main.js" as="script">
    
    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    
    <!-- Structured Data / JSON-LD -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsMediaOrganization",
        "name": "Iran Info",
        "url": "https://iraninfo.com",
        "logo": "https://iraninfo.com/assets/images/logo.svg",
        "sameAs": [
            "https://twitter.com/iraninfo",
            "https://facebook.com/iraninfo"
        ]
    }
    </script>
</head>
<body>