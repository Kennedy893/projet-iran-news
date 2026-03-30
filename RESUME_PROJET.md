# Resume du projet Iran News

## 1. Objectif
Ce projet est une application web PHP (sans framework) pour publier des articles d'actualite sur l'Iran, avec:
- un front public (accueil, consultation par article/categorie, recherche),
- un backoffice admin (authentification, dashboard, CRUD articles/categories),
- une gestion d'images liees aux articles (1 image primaire + images secondaires multiples).

## 2. Stack technique
- Langage: PHP 8.x
- Base de donnees: MySQL/MariaDB
- Acces DB: PDO
- Routing: routeur maison (`src/Core/Router.php`)
- Vues: PHP server-side rendering
- Front assets: CSS/JS dans `public/assets`
- Serveur local cible: Apache (XAMPP) avec rewrite

## 3. Structure principale
- Point d'entree HTTP: `public/index.php`
- Rewriting Apache: `public/.htaccess`
- Config globale: `config/config.php`
- Routeur: `src/Core/Router.php`
- Connexion DB: `src/Core/Database.php`
- Controleurs:
  - `src/Controllers/FrontController.php`
  - `src/Controllers/AuthController.php`
  - `src/Controllers/AdminController.php`
- Modeles:
  - `src/Models/Article.php`
  - `src/Models/Category.php`
  - `src/Models/User.php`
- Meta/SEO: `src/Helpers/MetaManager.php`

## 4. Base URL et environnement
La base URL applicative est centralisee via:
- `APP_URL` dans `config/config.php`
- helper `app_url($path)`

Valeur par defaut actuelle:
- `http://localhost/S6/projet-iran-news/public`

## 5. Schema de donnees (etat actuel)
Defini dans `sql/database.sql`.

Tables:
- `categorie(id, libelle)`
- `article(id, titre, contenu, date_pub, id_categorie)`
- `utilisateur(id, nom, mdp, email, role)`
- `image(id, chemin, type_image, id_article)`
  - `type_image = 1` image primaire
  - `type_image = 2` image secondaire

Notes:
- La colonne `article.image_url` n'est plus utilisee.
- Les images sont gerees via la table `image`.

## 6. Routing (resume)
Defini dans `public/index.php`.

Front:
- `GET /`
- `GET /article/{id}`
- `GET /categorie/{id}`
- `GET /search`

Admin auth:
- `GET /admin/login`
- `POST /admin/login`
- `GET /admin/logout`

Admin metier:
- `GET /admin/dashboard`
- `GET /admin/articles`
- `POST /admin/articles/store`
- `POST /admin/articles/update/{id}`
- `POST /admin/articles/delete/{id}`
- `POST /admin/articles/images/delete/{id}`
- `GET /admin/categories`
- `POST /admin/categories/store`
- `POST /admin/categories/update/{id}`
- `POST /admin/categories/delete/{id}`

## 7. Fonctionnalites front
Implantees principalement dans `FrontController` + vues front.

- Accueil:
  - liste des articles recents
  - categories avec compteur
  - image primaire recuperable depuis la table `image`
- Page article:
  - recuperation article par id
  - suggestions d'articles lies
- Page categorie:
  - filtrage des articles par categorie
- Recherche:
  - recherche sur titre/contenu
- SEO:
  - meta dynamiques via `MetaManager`

Vues front presentes actuellement:
- `src/Views/front/home.php`
- `src/Views/front/layout/header.php`
- `src/Views/front/layout/footer.php`

## 8. Fonctionnalites admin
Implantees dans `AuthController` et `AdminController` + vues admin.

### 8.1 Authentification
- Login par `nom` ou `email`
- Verification mot de passe:
  - `password_verify` (hash)
  - fallback legacy en clair
- CSRF sur formulaire login
- Session admin (`$_SESSION['admin_user']`)

### 8.2 Dashboard
- cartes statistiques:
  - total articles
  - total categories
  - articles publies aujourd'hui
- acces rapide aux pages de gestion

### 8.3 CRUD Categories
- creation
- modification
- suppression
- affichage compteur d'articles par categorie

### 8.4 CRUD Articles
- creation article via popup
- modification article via popup
- suppression article

### 8.5 Gestion images article
- upload image primaire obligatoire a la creation
- upload images secondaires multiples optionnelles
- remplacement image primaire en modification
- ajout d'images secondaires en modification
- affichage primaire + secondaires dans la liste admin
- suppression image individuelle avec confirmation
- apercu agrandi (lightbox) au clic sur miniature

## 9. Uploads et fichiers media
- Repertoire cible: `public/uploads/articles`
- Validation extension: `ALLOWED_EXTENSIONS` dans `config/config.php`
- Taille max configuree: `MAX_FILE_SIZE` (5MB)
- Lors de suppression:
  - suppression en base (`image`)
  - suppression du fichier physique si present

## 10. UI/UX admin
- Theme admin dedie: `public/assets/css/admin-dashboard.css`
- Login style dedie: `public/assets/css/admin-login.css`
- JS modales/backoffice: `public/assets/js/admin-crud-modal.js`
- JS login: `public/assets/js/admin-login.js`

## 11. Rewriting Apache
`public/.htaccess` redirige les routes applicatives vers `index.php`.
Important pour que les URLs type `/admin/login` fonctionnent sur Apache/XAMPP.

## 12. Donnees de demo
`sql/database.sql` inclut:
- 1 utilisateur admin de base (`admin` / `123`)
- categories de demo
- articles de demo
- images de demo reliees aux articles

## 13. Points d'attention actuels
- Certaines routes front (`/article/{id}`, `/categorie/{id}`, `/search`) referencent des vues non presentes dans le dossier front si non creees manuellement (`article.php`, `category.php`, `search.php`, `404.php`).
- Le mot de passe admin de seed est faible (usage dev uniquement).
- Le fallback mot de passe en clair est pratique pour legacy mais a retirer en prod.

## 14. Demarrage rapide (local)
1. Importer `sql/database.sql` dans MySQL.
2. Verifier `config/config.php` (DB + APP_URL).
3. Lancer Apache/MySQL (XAMPP).
4. Ouvrir: `http://localhost/S6/projet-iran-news/public/`
5. Admin: `http://localhost/S6/projet-iran-news/public/admin/login`
