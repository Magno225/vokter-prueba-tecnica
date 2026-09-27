<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Elimina todas las variables de sesión (usuario_id, etc.)
session_unset();

// Destruye la sesión por completo en el servidor
session_destroy();

// Redirige al login
header('Location: Login.php');
exit;