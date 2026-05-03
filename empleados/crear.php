<?php
/**
 * crear.php
 * Formulari per afegir un nou empleat a la base de dades.
 */
require_once __DIR__ . '/../includes/header.php';
protegirPagina();

$errors  = [];
$dades   = ['nom' => '', 'cognoms' => '', 'departament' => '',
            'salari' => '', 'data_alta' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recollim i netejem les dades del formulari
    $dades['nom']         = netejarEntrada($_POST['nom'] ?? '');
    $dades['cognoms']     = netejarEntrada($_POST['cognoms'] ?? '');
    $dades['departament'] = netejarEntrada($_POST['departament'] ?? '');
    $dades['salari']      = $_POST['salari'] ?? '';
    $dades['data_alta']   = $_POST['data_alta'] ?? '';
    $dades['email']       = netejarEntrada($_POST['email'] ?? '');

    // Validacions
    if (empty($dades['nom']))
        $errors[] = "El nom és obligatori.";

    if (empty($dades['cognoms']))
        $errors[] = "Els cognoms són obligatoris.";

    if (empty($dades['departament']))
        $errors[] = "El departament és obligatori.";

    if (!is_numeric($dades['salari']) || $dades['salari'] <= 0)
        $errors[] = "El salari ha de ser un número positiu.";

    if (empty($dades['data_alta']))
        $errors[] = "La data d'alta és obligatòria.";

    if (!filter_var($dades['email'], FILTER_VALIDATE_EMAIL))
        $errors[] = "El format de l'email no és vàlid.";

    // Si no hi ha errors, inserim a la BD
    if (empty($errors)) {
        $ok = crearEmpleat(
            $dades['nom'],
            $dades['cognoms'],
            $dades['departament'],
            (float)$dades['salari'],
            $dades['data_alta'],
            $dades['email']
        );
        if ($ok) {
            header("Location: listar.php?ok=creat");
            exit();
        } else {
            $errors[] = "Error en guardar l'empleat. Potser l'email ja existeix.";
        }
    }
}
?>

<h1>➕ Nou Empleat</h1>
<a href="listar.php" class="btn btn-secondary">← Tornar</a>

<?php if (!empty($errors)): ?>
    <div class="alerta error">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= $err ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="crear.php" class="formulari">
    <div class="form-group">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom"
               value="<?= htmlspecialchars($dades['nom']) ?>" required>
    </div>
    <div class="form-group">
        <label for="cognoms">Cognoms:</label>
        <input type="text" id="cognoms" name="cognoms"
               value="<?= htmlspecialchars($dades['cognoms']) ?>" required>
    </div>
    <div class="form-group">
        <label for="departament">Departament:</label>
        <select id="departament" name="departament" required>
            <option value="">-- Selecciona --</option>
            <?php
            $departaments = ['Informàtica','Recursos Humans',
                             'Comptabilitat','Vendes','Màrqueting','Direcció'];
            foreach ($departaments as $dep):
                $sel = ($dades['departament'] === $dep) ? 'selected' : '';
            ?>
                <option value="<?= $dep ?>" <?= $sel ?>><?= $dep ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="salari">Salari (€):</label>
        <input type="number" id="salari" name="salari" step="0.01" min="0"
               value="<?= htmlspecialchars($dades['salari']) ?>" required>
    </div>
    <div class="form-group">
        <label for="data_alta">Data d'alta:</label>
        <input type="date" id="data_alta" name="data_alta"
               value="<?= htmlspecialchars($dades['data_alta']) ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"
               value="<?= htmlspecialchars($dades['email']) ?>" required>
    </div>
    <button type="submit" class="btn btn-success">💾 Guardar Empleat</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>