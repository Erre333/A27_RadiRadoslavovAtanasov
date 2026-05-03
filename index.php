<?php
/**
 * index.php
 * Pàgina principal de login de l'aplicació.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', '/A27_TuNombre/');
require_once __DIR__ . '/includes/funcions.php';

// Si ja hi ha sessió activa, anem directament al dashboard
if (isset($_SESSION['usuari_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

// Processem el formulari quan s'envia
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = netejarEntrada($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validació bàsica
    if (empty($username) || empty($password)) {
        $error = "⚠️ Omple tots els camps.";
    } else {
        $usuari = validarLogin($username, $password);
        if ($usuari) {
            // Login correcte: guardem dades a la sessió
            $_SESSION['usuari_id']  = $usuari['id'];
            $_SESSION['usuari_nom'] = $usuari['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "❌ Usuari o contrasenya incorrectes.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gestió d'Empleats</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/estils.css">
</head>
<body class="login-page">

<div class="login-container">
    <h1>👥 Gestió d'Empleats</h1>
    <h2>Inicia sessió</h2>

    <?php if ($error): ?>
        <div class="alerta error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php">
        <div class="form-group">
            <label for="username">Usuari:</label>
            <input type="text" id="username" name="username" 
                   value="<?= htmlspecialchars($username ?? '') ?>"
                   placeholder="Introdueix el teu usuari" required>
        </div>
        <div class="form-group">
            <label for="password">Contrasenya:</label>
            <input type="password" id="password" name="password"
                   placeholder="Introdueix la teua contrasenya" required>
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</div>

</body>
</html>