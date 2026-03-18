<?php
/* ============================
   INICIAR SESSÃO
============================ */

session_start();


/* ============================
   LIMPAR SESSÃO
============================ */

// Remove todas as variáveis de sessão
session_unset();

// Destroi a sessão
session_destroy();


/* ============================
   REMOVER COOKIE DE SESSÃO
============================ */

// Se existir cookie de sessão, remove também
if (ini_get("session.use_cookies")) {

    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}


/* ============================
   REDIRECIONAR
============================ */

header("Location: login.php");
exit;