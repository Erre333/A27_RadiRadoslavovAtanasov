<?php
/**
 * logout.php
 * Tanca la sessió de l'usuari i redirigeix al login.
 */
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit();