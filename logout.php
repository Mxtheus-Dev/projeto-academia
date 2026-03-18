<?php
// Inicia a sessão
session_start();

/* ============================
   DESTRUIR SESSÃO (LOGOUT)
============================ */

// Remove todas as variáveis de sessão
session_unset();

// Destroi a sessão
session_destroy();

/* ============================
   REDIRECIONAR PARA LOGIN
============================ */
header("Location: login.php");
exit;
?>