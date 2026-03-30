<?php
namespace Helpers;

class MetaManager
{
    private $meta = [
        'title' => 'Iran Info - Actualités du conflit en Iran',
        'description' => 'Suivez en direct l\'actualité du conflit en Iran : analyses, reportages et informations vérifiées par notre rédaction.',
        'keywords' => 'Iran, guerre, conflit, actualités, Moyen-Orient, Téhéran',
        'robots' => 'index, follow',
        'og_title' => 'Iran Info',
        'og_description' => 'Suivez l\'actualité du conflit en Iran',
        'og_image' => '',
        'og_type' => 'website',
        'twitter_card' => 'summary_large_image',
        'canonical' => ''
    ];

    public function __construct()
    {
        $this->meta['og_image'] = app_url('assets/images/default-og-image.jpg');
    }
    
    public function setHomeMeta()
    {
        $this->meta['title'] = 'Iran Info - Actualités du conflit en Iran';
        $this->meta['description'] = 'Suivez en direct l\'actualité du conflit en Iran : analyses, reportages et informations vérifiées.';
        $this->meta['og_type'] = 'website';
        $this->meta['canonical'] = app_url();
    }
    
    public function setArticleMeta($article)
    {
        $title = (string) ($article['titre'] ?? ($article['title'] ?? 'Article'));
        $rawContent = (string) ($article['excerpt'] ?? ($article['contenu'] ?? ''));
        $description = mb_substr(trim(strip_tags($rawContent)), 0, 155);
        $categoryName = (string) ($article['categorie_libelle'] ?? ($article['category_name'] ?? 'Actualités'));
        $articleId = (int) ($article['id'] ?? 0);

        $this->meta['title'] = $title . ' | Iran Info';
        $this->meta['description'] = $description !== '' ? $description : 'Article d\'actualité sur le conflit en Iran.';
        $this->meta['keywords'] = $categoryName . ', Iran, actualités, guerre';
        $this->meta['og_title'] = $title;
        $this->meta['og_description'] = $this->meta['description'];
        $this->meta['og_image'] = $article['image_url'] ?? ($article['featured_image'] ?? $this->meta['og_image']);
        $this->meta['og_type'] = 'article';
        $this->meta['twitter_card'] = 'summary_large_image';
        $this->meta['canonical'] = $articleId > 0 ? article_url($articleId, $title) : app_url();
    }
    
    public function setCategoryMeta($category)
    {
        $name = (string) ($category['libelle'] ?? ($category['name'] ?? 'Catégorie'));
        $categoryId = (int) ($category['id'] ?? 0);

        $this->meta['title'] = $name . ' - Iran Info';
        $this->meta['description'] = $category['meta_description'] ?? ('Articles sur ' . $name . ' en Iran');
        $this->meta['keywords'] = $name . ', Iran, actualités';
        $this->meta['canonical'] = $categoryId > 0 ? category_url($categoryId, $name) : app_url();
    }
    
    public function set404Meta()
    {
        $this->meta['title'] = 'Page non trouvée - Iran Info';
        $this->meta['description'] = 'La page que vous recherchez n\'existe pas.';
        $this->meta['robots'] = 'noindex, follow';
    }
    
    public function setSearchMeta($query)
    {
        $this->meta['title'] = 'Résultats de recherche : ' . htmlspecialchars($query) . ' - Iran Info';
        $this->meta['description'] = 'Résultats de recherche pour "' . htmlspecialchars($query) . '"';
        $this->meta['robots'] = 'noindex, follow';
    }
    
    public function getMeta()
    {
        return $this->meta;
    }
    
    public function render()
    {
        ?>
        <title><?= htmlspecialchars($this->meta['title']) ?></title>
        <meta name="description" content="<?= htmlspecialchars($this->meta['description']) ?>">
        <meta name="keywords" content="<?= htmlspecialchars($this->meta['keywords']) ?>">
        <meta name="robots" content="<?= $this->meta['robots'] ?>">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:title" content="<?= htmlspecialchars($this->meta['og_title']) ?>">
        <meta property="og:description" content="<?= htmlspecialchars($this->meta['og_description']) ?>">
        <meta property="og:image" content="<?= $this->meta['og_image'] ?>">
        <meta property="og:type" content="<?= $this->meta['og_type'] ?>">
        <meta property="og:site_name" content="Iran Info">
        
        <!-- Twitter -->
        <meta name="twitter:card" content="<?= $this->meta['twitter_card'] ?>">
        <meta name="twitter:title" content="<?= htmlspecialchars($this->meta['og_title']) ?>">
        <meta name="twitter:description" content="<?= htmlspecialchars($this->meta['og_description']) ?>">
        <meta name="twitter:image" content="<?= $this->meta['og_image'] ?>">
        
        <!-- Canonical URL -->
        <?php if($this->meta['canonical']): ?>
        <link rel="canonical" href="<?= $this->meta['canonical'] ?>">
        <?php endif; ?>
        <?php
    }
}