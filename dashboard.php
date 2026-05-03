<?php
/**
 * dashboard.php
 * Pàgina principal després del login.
 * Mostra un resum de l'aplicació.
 */
require_once __DIR__ . '/includes/header.php';
protegirPagina();

// Obtenim el total d'empleats per mostrar-lo al dashboard
$empleats = obtenirEmpleats();
$total = count($empleats);

// Calculem el salari mitjà
$salariMitja = 0;
if ($total > 0) {
    $sumaSalaris = array_sum(array_column($empleats, 'salari'));
    $salariMitja = $sumaSalaris / $total;
}

// Obtenim els departaments únics
$departaments = array_unique(array_column($empleats, 'departament'));
$totalDepartaments = count($departaments);
?>

<h1>🏠 Panell de Control</h1>
<p>Benvingut/da, <strong><?= htmlspecialchars($_SESSION['usuari_nom']) ?></strong>!</p>

<!-- Targetes de resum -->
<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon">👥</div>
        <div class="card-info">
            <span class="card-numero"><?= $total ?></span>
            <span class="card-label">Empleats totals</span>
        </div>
    </div>
    <div class="card">
        <div class="card-icon">🏢</div>
        <div class="card-info">
            <span class="card-numero"><?= $totalDepartaments ?></span>
            <span class="card-label">Departaments</span>
        </div>
    </div>
    <div class="card">
        <div class="card-icon">💶</div>
        <div class="card-info">
            <span class="card-numero"><?= number_format($salariMitja, 2) ?> €</span>
            <span class="card-label">Salari mitjà</span>
        </div>
    </div>
</div>

<!-- Accions ràpides -->
<div class="accions-rapides">
    <h2>Accions ràpides</h2>
    <a href="empleados/listar.php" class="btn btn-primary">📋 Veure empleats</a>
    <a href="empleados/crear.php" class="btn btn-success">➕ Afegir empleat</a>
</div>

<!-- Taula resum dels últims empleats -->
<div class="seccio">
    <h2>Empleats registrats</h2>
    <?php if ($total > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Cognoms</th>
                <th>Departament</th>
                <th>Salari</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (array_slice($empleats, 0, 5) as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['nom']) ?></td>
                <td><?= htmlspecialchars($e['cognoms']) ?></td>
                <td><?= htmlspecialchars($e['departament']) ?></td>
                <td><?= number_format($e['salari'], 2) ?> €</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No hi ha empleats registrats encara.</p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>