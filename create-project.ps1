# Script simplifié - juste la structure
Write-Host "🚀 Création de la structure du projet..." -ForegroundColor Green

# Création du dossier
New-Item -ItemType Directory -Path "projet-iran-news" -Force
Set-Location "projet-iran-news"

# Création de l'arborescence
$folders = @(
    "public\assets\css", "public\assets\js", "public\assets\images",
    "public\uploads\articles", "public\uploads\categories",
    "src\Controllers", "src\Models", "src\Views\front\layout",
    "src\Views\admin\layout", "src\Views\admin\articles",
    "src\Views\admin\categories", "src\Views\admin\users",
    "src\Core", "src\Helpers", "src\Middleware",
    "config", "sql", "docker", "logs"
)

foreach ($folder in $folders) {
    New-Item -ItemType Directory -Path $folder -Force | Out-Null
}

# Création des fichiers vides
$files = @(
    "public\index.php", "public\.htaccess", "public\robots.txt",
    "config\config.php", "sql\database.sql",
    "docker\docker-compose.yml", ".env.example", ".gitignore"
)

foreach ($file in $files) {
    New-Item -ItemType File -Path $file -Force | Out-Null
}

# Création du docker-compose.yml minimal
@'
version: '3.8'
services:
  web:
    image: php:8.2-apache
    ports:
      - "8080:80"
    volumes:
      - ./public:/var/www/html
  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: iran_news
    ports:
      - "3306:3306"
'@ | Out-File -FilePath "docker\docker-compose.yml" -Encoding UTF8

Write-Host "✅ Structure créée !" -ForegroundColor Green
Write-Host ""
Write-Host "Pour démarrer :" -ForegroundColor Yellow
Write-Host "cd projet-iran-news"
Write-Host "docker-compose -f docker\docker-compose.yml up -d"