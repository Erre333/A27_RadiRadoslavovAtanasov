<?php
/**
 * eliminar.php
 * Elimina un empleat de la base de dades i redirigeix a la llista.
 */
require_once __DIR__ . '/../includes/header.php';
protegirPagina();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    eliminarEmpleat($id);
}

header("Location: listar.php?ok=eliminat");
exit();