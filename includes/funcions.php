<?php
/**
 * funcions.php
 * Biblioteca de funcions per a l'aplicació de Gestió d'Empleats.
 * Conté la connexió a la base de dades i les funcions principals.
 * 
 * @author Radi Radoslavov Atanasov
 * @version 1.0
 */

// ─── CONNEXIÓ A LA BASE DE DADES ───────────────────────────────────────────

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gestio_empleats');

/**
 * Crea i retorna una connexió a la base de dades MySQL.
 * Mostra un error i atura l'execució si la connexió falla.
 * 
 * @return mysqli Objecte de connexió
 */
function connectarBD() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Error de connexió: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
    return $conn;
}

// ─── FUNCIONS D'AUTENTICACIÓ ───────────────────────────────────────────────

/**
 * Comprova si un usuari existeix a la BD i la contrasenya és correcta.
 * 
 * @param string $username Nom d'usuari
 * @param string $password Contrasenya en text pla
 * @return array|false Dades de l'usuari si és correcte, false si no
 */
function validarLogin($username, $password) {
    $conn = connectarBD();
    $stmt = $conn->prepare("SELECT * FROM usuaris WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $resultat = $stmt->get_result();
    $usuari = $resultat->fetch_assoc();
    $conn->close();

    if ($usuari && password_verify($password, $usuari['password'])) {
        return $usuari;
    }
    return false;
}

/**
 * Comprova si hi ha una sessió activa. 
 * Si no, redirigeix a la pàgina de login.
 */
function protegirPagina() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['usuari_id'])) {
        header("Location: " . BASE_URL . "index.php");
        exit();
    }
}

// ─── FUNCIONS D'EMPLEATS ──────────────────────────────────────────────────

/**
 * Retorna tots els empleats de la base de dades.
 * 
 * @return array Llista d'empleats
 */
function obtenirEmpleats() {
    $conn = connectarBD();
    $resultat = $conn->query("SELECT * FROM empleats ORDER BY cognoms ASC");
    $empleats = $resultat->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $empleats;
}

/**
 * Retorna un empleat concret pel seu ID.
 * 
 * @param int $id Identificador de l'empleat
 * @return array|false Dades de l'empleat o false si no existeix
 */
function obtenirEmpleatPerId($id) {
    $conn = connectarBD();
    $stmt = $conn->prepare("SELECT * FROM empleats WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultat = $stmt->get_result();
    $empleat = $resultat->fetch_assoc();
    $conn->close();
    return $empleat;
}

/**
 * Insereix un nou empleat a la base de dades.
 * 
 * @param string $nom Nom de l'empleat
 * @param string $cognoms Cognoms de l'empleat
 * @param string $departament Departament
 * @param float  $salari Salari
 * @param string $data_alta Data d'alta (YYYY-MM-DD)
 * @param string $email Correu electrònic
 * @return bool True si s'ha inserit correctament
 */
function crearEmpleat($nom, $cognoms, $departament, $salari, $data_alta, $email) {
    $conn = connectarBD();
    $stmt = $conn->prepare(
        "INSERT INTO empleats (nom, cognoms, departament, salari, data_alta, email) 
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssdss", $nom, $cognoms, $departament, $salari, $data_alta, $email);
    $ok = $stmt->execute();
    $conn->close();
    return $ok;
}

/**
 * Actualitza les dades d'un empleat existent.
 * 
 * @param int    $id ID de l'empleat a actualitzar
 * @param string $nom Nou nom
 * @param string $cognoms Nous cognoms
 * @param string $departament Nou departament
 * @param float  $salari Nou salari
 * @param string $data_alta Nova data d'alta
 * @param string $email Nou email
 * @return bool True si s'ha actualitzat correctament
 */
function actualitzarEmpleat($id, $nom, $cognoms, $departament, $salari, $data_alta, $email) {
    $conn = connectarBD();
    $stmt = $conn->prepare(
        "UPDATE empleats SET nom=?, cognoms=?, departament=?, salari=?, data_alta=?, email=? 
         WHERE id=?"
    );
    $stmt->bind_param("sssdssi", $nom, $cognoms, $departament, $salari, $data_alta, $email, $id);
    $ok = $stmt->execute();
    $conn->close();
    return $ok;
}

/**
 * Elimina un empleat de la base de dades pel seu ID.
 * 
 * @param int $id ID de l'empleat a eliminar
 * @return bool True si s'ha eliminat correctament
 */
function eliminarEmpleat($id) {
    $conn = connectarBD();
    $stmt = $conn->prepare("DELETE FROM empleats WHERE id = ?");
    $stmt->bind_param("i", $id);
    $ok = $stmt->execute();
    $conn->close();
    return $ok;
}

/**
 * Neteja i valida un text d'entrada per evitar XSS.
 * 
 * @param string $dada Text a netejar
 * @return string Text net
 */
function netejarEntrada($dada) {
    return htmlspecialchars(strip_tags(trim($dada)));
}