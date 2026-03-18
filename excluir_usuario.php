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
   EXCLUIR USUÁRIO
============================ */

try {

    $db->beginTransaction();

    // EXCLUI TREINOS PRIMEIRO
    $sql1 = $db->prepare("DELETE FROM treinos WHERE usuario_id = ?");
    $sql1->execute([$id]);

    // DEPOIS EXCLUI USUÁRIO
    $sql2 = $db->prepare("DELETE FROM usuarios WHERE id = ?");
    $sql2->execute([$id]);

    $db->commit();

} catch (Exception $e) {

    $db->rollBack();
}

/* ============================
   REDIRECIONAR
============================ */

header("Location: admin_dashboard.php?ok=1");
exit;