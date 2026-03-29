<?php
$error = $error ?? null;
$oldLogin = $oldLogin ?? '';
$csrfToken = $_SESSION['csrf_token'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connexion admin | Iran Info</title>
	<link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/admin-login.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body>
	<main class="login-page" role="main">
		<section class="login-card" aria-labelledby="login-title">
			<h1 id="login-title">Backoffice admin</h1>
			<p class="login-subtitle">Connectez-vous pour gerer les contenus.</p>

			<?php if (!empty($error)): ?>
				<div class="alert-error" role="alert">
					<?= htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8') ?>
				</div>
			<?php endif; ?>

			<form action="<?= htmlspecialchars(app_url('admin/login'), ENT_QUOTES, 'UTF-8') ?>" method="POST" novalidate>
				<input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) $csrfToken, ENT_QUOTES, 'UTF-8') ?>">

				<label for="login">Nom d'utilisateur ou email</label>
				<input
					id="login"
					name="login"
					type="text"
					autocomplete="username"
					value="<?= htmlspecialchars((string) $oldLogin, ENT_QUOTES, 'UTF-8') ?>"
					required>

				<label for="password">Mot de passe</label>
				<div class="password-row">
					<input id="password" name="password" type="password" autocomplete="current-password" required>
					<button type="button" id="toggle-password" class="btn-light" aria-label="Afficher le mot de passe">Afficher</button>
				</div>

				<button type="submit" class="btn-primary">Se connecter</button>
			</form>
		</section>
	</main>

	<script src="<?= htmlspecialchars(app_url('assets/js/admin-login.js'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
</body>
</html>
