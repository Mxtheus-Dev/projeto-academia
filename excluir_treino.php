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

// Verifica se ID foi enviado e é válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$id = $_GET['id'];


/* ============================
   VERIFICAR SE TREINO EXISTE
============================ */

$check = $db->prepare("SELECT id FROM treinos WHERE id = ?");
$check->execute([$id]);

if ($check->rowCount() === 0) {
    header("Location: admin_dashboard.php");
    exit;
}


/* ============================
   EXCLUIR TREINO
============================ */

$sql = $db->prepare("DELETE FROM treinos WHERE id = ?");
$sql->execute([$id]);


/* ============================
   REDIRECIONAR
============================ */

header("Location: admin_dashboard.php?sucesso=1");
exit;