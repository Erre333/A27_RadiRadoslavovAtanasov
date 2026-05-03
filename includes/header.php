<?php
/**
 * header.php
 * Capçalera HTML reutilitzable per a totes les pàgines.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define('BASE_URL', '/A27_RadiRadoslavovAtanasov/');
require_once __DIR__ . '/funcions.php';
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestió d'Empleats</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/estils.css">
</head>
<body>

<?php if (isset($_SESSION['usuari_id'])): ?>
<nav class="navbar">
    <div class="nav-brand">👥 Gestió d'Empleats</div>
    <ul class="nav-links">
        <li><a href="<?= BASE_URL ?>dashboard.php">🏠 Inici</a></li>
        <li><a href="<?= BASE_URL ?>empleados/listar.php">📋 Empleats</a></li>
        <li><a href="<?= BASE_URL ?>empleados/crear.php">➕ Nou Empleat</a></li>
        <li><a href="<?= BASE_URL ?>logout.php">🚪 Tancar sessió 
            (<?= htmlspecialchars($_SESSION['usuari_nom']) ?>)
        </a></li>
    </ul>
</nav>
<?php endif; ?>

<main class="container">