<?php
require "database.php";
session_start();

/* ============================
   SEGURANÇA
============================ */

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

/* ============================
   VALIDAR ID
============================ */

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: admin_dashboard.php");
    exit;
}

/* ============================
   EXCLUIR TREINO
============================ */

try {

    $sql = $db->prepare("DELETE FROM treinos WHERE id = ?");
    $sql->execute([$id]);

} catch (Exception $e) {
    // opcional debug
    // echo $e->getMessage();
}

/* ============================
   REDIRECIONAR
============================ */

header("Location: admin_dashboard.php?ok=1");
exit;