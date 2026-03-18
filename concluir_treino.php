<?php
/* ============================
   CONEXÃO + SESSÃO
============================ */

require "database.php";
session_start();


/* ============================
   SEGURANÇA
============================ */

// Verifica se admin está logado
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}


/* ============================
   VALIDAR ID
============================ */

// Verifica se o ID foi enviado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$id = $_GET['id'];


/* ============================
   ATUALIZAR STATUS DO TREINO
============================ */

$sql = $db->prepare("
    UPDATE treinos 
    SET status = 'concluido' 
    WHERE id = ?
");

$sql->execute([$id]);


/* ============================
   REDIRECIONAR
============================ */

header("Location: admin_dashboard.php");
exit;