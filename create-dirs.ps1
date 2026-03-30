# Script pour créer la structure des dossiers assets
$dirs = @(
    "public\assets\css",
    "public\assets\js",
    "public\assets\images",
    "public\assets\fonts"
)

foreach ($dir in $dirs) {
    if (-not (Test-Path $dir)) {
        New-Item -ItemType Directory -Path $dir -Force | Out-Null
        Write-Host "Created: $dir"
    } else {
        Write-Host "Already exists: $dir"
    }
}

Write-Host "`nStructure créée avec succès!"
Get-ChildItem "public\assets" -Directory
