# ✅ Checklist de Mise en Production - Iran Info

## 🚀 Étapes Obligatoires

### 1. Structure Assets ⚠️ IMPORTANT
```bash
# Créer les dossiers
mkdir public\assets\css
mkdir public\assets\js
mkdir public\assets\images
mkdir public\assets\fonts

# Déplacer les fichiers
move public\variables.css public\assets\css\
move public\style.css public\assets\css\
move public\responsive.css public\assets\css\
move public\main.js public\assets\js\
```
- [ ] Dossiers créés
- [ ] Fichiers déplacés

### 2. Mettre à Jour les Chemins
**Fichier**: `src/Views/front/layout/header.php`
```php
<!-- REMPLACER -->
<link rel="stylesheet" href="/variables.css">
<link rel="stylesheet" href="/style.css">
<link rel="stylesheet" href="/responsive.css">

<!-- PAR -->
<link rel="stylesheet" href="/assets/css/variables.css">
<link rel="stylesheet" href="/assets/css/style.css">
<link rel="stylesheet" href="/assets/css/responsive.css">
```
- [ ] header.php mis à jour

**Fichier**: `src/Views/front/layout/footer.php`
```php
<!-- REMPLACER -->
<script src="/main.js" defer></script>

<!-- PAR -->
<script src="/assets/js/main.js" defer></script>
```
- [ ] footer.php mis à jour

### 3. Images
Ajouter dans `public\uploads\`:
- [ ] 1.jpeg - Manifestations Téhéran
- [ ] 2.jpeg - Coupures électricité  
- [ ] 3.jpeg - Rôle Russie/Chine
- [ ] 4.jpeg - Iran et voisins
- [ ] 5.jpeg - Fragilités économiques
- [ ] 6.jpeg - Unité nationale
- [ ] 7.jpeg - Témoignage Leila
- [ ] 8.jpeg - Témoignage Reza
- [ ] 9.jpeg - Bilan militaire
- [ ] 10.jpeg - Drones
- [ ] 11.jpeg - Sanctions
- [ ] 12.jpeg - Pourparlers Genève

**Format**: JPEG, dimensions recommandées 1200x600px

### 4. Base de Données
```bash
# Importer le data.sql mis à jour
mysql -u votre_user -p iran_news < sql/data.sql
```
- [ ] data.sql importé avec les URLs d'images

### 5. Nettoyage
```bash
# Supprimer le fichier temporaire
del create-dirs.ps1
```
- [ ] Fichiers temporaires supprimés

---

## 🧪 Tests Fonctionnels

### Navigation
- [ ] Page d'accueil s'affiche correctement
- [ ] Clic sur article fonctionne
- [ ] Navigation catégorie fonctionne
- [ ] Recherche fonctionne
- [ ] Page 404 s'affiche pour URLs invalides

### Responsive
- [ ] Mobile (< 768px) - Navigation verticale
- [ ] Tablet (768-1024px) - Grille adaptée
- [ ] Desktop (> 1024px) - Grille complète

### Images
- [ ] Images s'affichent sur page d'accueil
- [ ] Images s'affichent dans articles
- [ ] Lazy loading fonctionne (scroll)
- [ ] Alt text présent sur toutes images

### JavaScript
- [ ] Bouton "Retour en haut" apparaît au scroll
- [ ] Smooth scroll pour ancres fonctionne
- [ ] Navigation active (page courante highlightée)
- [ ] Liens externes ouvrent nouvel onglet

---

## 🎯 Tests Qualité (Google Lighthouse)

### Mobile
Ouvrir Chrome DevTools (F12) > Lighthouse > Mobile
- [ ] Performance: > 90
- [ ] Accessibility: > 95
- [ ] Best Practices: > 95
- [ ] SEO: > 95

### Desktop
Lighthouse > Desktop
- [ ] Performance: > 90
- [ ] Accessibility: > 95
- [ ] Best Practices: > 95
- [ ] SEO: > 95

---

## 🔍 Validation SEO

### Meta Tags
- [ ] Chaque page a un title unique
- [ ] Meta description présente sur chaque page
- [ ] Open Graph tags pour partage social
- [ ] Twitter Cards configurées

### Structure
- [ ] Un seul h1 par page
- [ ] Hiérarchie h1-h6 respectée
- [ ] Images ont attribut alt
- [ ] Liens ont texte descriptif

### Schema.org
- [ ] NewsArticle markup sur page article
- [ ] BreadcrumbList sur pages avec fil d'ariane
- [ ] Organization markup dans footer

### Fichiers
- [ ] sitemap.xml accessible
- [ ] robots.txt configuré
- [ ] Favicon visible dans onglet

---

## ♿ Accessibilité

### Navigation Clavier
- [ ] Tab parcourt tous les liens
- [ ] Enter active les liens
- [ ] Focus visible sur éléments
- [ ] Skip link fonctionne

### Lecteur d'Écran
- [ ] ARIA labels présents
- [ ] Roles définis (banner, navigation, main, contentinfo)
- [ ] Images décoratives avec alt=""
- [ ] Formulaires ont labels

### Contraste
- [ ] Texte sur fond clair: ratio > 4.5:1
- [ ] Liens distincts du texte
- [ ] Boutons clairement identifiables

---

## 📱 Tests Multi-Navigateurs

### Desktop
- [ ] Chrome (dernière version)
- [ ] Firefox (dernière version)
- [ ] Edge (dernière version)
- [ ] Safari (si Mac disponible)

### Mobile
- [ ] Chrome Android (ou émulateur)
- [ ] Safari iOS (ou émulateur)

---

## 🐛 Débogage

### Si les styles ne s'appliquent pas:
1. Vérifier chemins CSS dans header.php
2. Vérifier que fichiers existent dans public/assets/css/
3. Vider cache navigateur (Ctrl+Shift+R)

### Si les images ne s'affichent pas:
1. Vérifier que fichiers existent dans public/uploads/
2. Vérifier permissions dossier (lecture)
3. Vérifier console navigateur (F12) pour erreurs

### Si JavaScript ne fonctionne pas:
1. Vérifier chemin dans footer.php
2. Ouvrir console (F12) pour voir erreurs
3. Vérifier que main.js existe dans public/assets/js/

---

## 📝 Livraison Finale

### Avant de soumettre:
- [ ] Tous les tests passent
- [ ] Aucune erreur console
- [ ] README.md à jour
- [ ] Documentation technique préparée
- [ ] Copie écran FO et BO
- [ ] User/pass admin documenté
- [ ] Numéro ETU ajouté

### Zip de livraison doit contenir:
- [ ] Code source complet
- [ ] Fichiers SQL (database.sql + data.sql)
- [ ] docker/ avec docker-compose.yml
- [ ] README.md avec instructions
- [ ] Documentation technique avec:
  - Captures écran
  - Modélisation BDD
  - Credentials admin
  - Numéro ETU

---

## ✨ Checklist Bonus (Optionnel)

### Performance
- [ ] Compresser images (TinyPNG, ImageOptim)
- [ ] Minifier CSS/JS pour production
- [ ] Activer gzip dans .htaccess
- [ ] Configurer cache navigateur

### SEO Avancé
- [ ] Google Analytics installé
- [ ] Google Search Console configuré
- [ ] Structured data validator passé
- [ ] Mobile-friendly test Google passé

### Accessibilité
- [ ] Test avec lecteur d'écran réel
- [ ] Test WAVE (webaim.org/wave/)
- [ ] Test axe DevTools
- [ ] Couleurs testées pour daltoniens

---

## 🎉 Félicitations !

Une fois toutes les cases cochées, votre site est prêt pour production !

**Bon courage pour la livraison le 31 mars ! 🚀**
