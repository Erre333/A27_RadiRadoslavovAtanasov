<?php
/**
 * listar.php
 * Mostra la llista completa d'empleats de la base de dades.
 */
require_once __DIR__ . '/../includes/header.php';
protegirPagina();

$empleats = obtenirEmpleats();

// Missatge d'èxit o error provinent d'altres pàgines
$missatge = '';
if (isset($_GET['ok'])) {
    $missatge = match($_GET['ok']) {
        'creat'    => '✅ Empleat afegit correctament.',
        'editat'   => '✅ Empleat actualitzat correctament.',
        'eliminat' => '✅ Empleat eliminat correctament.',
        default    => ''
    };
}
?>

<h1>📋 Llista d'Empleats</h1>

<?php if ($missatge): ?>
    <div class="alerta exit"><?= $missatge ?></div>
<?php endif; ?>

<div class="accions-rapides">
    <a href="crear.php" class="btn btn-success">➕ Nou Empleat</a>
</div>

<?php if (count($empleats) > 0): ?>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Cognoms</th>
            <th>Departament</th>
            <th>Salari</th>
            <th>Data alta</th>
            <th>Email</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($empleats as $e): ?>
        <tr>
            <td><?= $e['id'] ?></td>
            <td><?= htmlspecialchars($e['nom']) ?></td>
            <td><?= htmlspecialchars($e['cognoms']) ?></td>
            <td><?= htmlspecialchars($e['departament']) ?></td>
            <td><?= number_format($e['salari'], 2) ?> €</td>
            <td><?= $e['data_alta'] ?></td>
            <td><?= htmlspecialchars($e['email']) ?></td>
            <td class="accions">
                <a href="editar.php?id=<?= $e['id'] ?>" 
                   class="btn btn-warning">✏️ Editar</a>
                <a href="eliminar.php?id=<?= $e['id'] ?>" 
                   class="btn btn-danger"
                   onclick="return confirm('Segur que vols eliminar aquest empleat?')">
                   🗑️ Eliminar
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <p>No hi ha empleats registrats. 
       <a href="crear.php">Afegeix el primer!</a>
    </p>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>