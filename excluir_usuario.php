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

// Pega o ID do usuário
$id = $_GET['id'] ?? null;

// Valida ID
if (!$id || !is_numeric($id)) {
    header("Location: admin_dashboard.php");
    exit;
}


/* ============================
   VERIFICAR SE USUÁRIO EXISTE
============================ */

$check = $db->prepare("SELECT id FROM usuarios WHERE id = ?");
$check->execute([$id]);

if ($check->rowCount() === 0) {
    header("Location: admin_dashboard.php");
    exit;
}


/* ============================
   EXCLUIR USUÁRIO + TREINOS
============================ */

try {

    // Inicia transação (IMPORTANTE)
    $db->beginTransaction();

    // Remove todos os treinos do aluno
    $sqlTreinos = $db->prepare("DELETE FROM treinos WHERE usuario_id = ?");
    $sqlTreinos->execute([$id]);

    // Remove o aluno
    $sqlUsuario = $db->prepare("DELETE FROM usuarios WHERE id = ?");
    $sqlUsuario->execute([$id]);

    // Confirma alterações
    $db->commit();

} catch (Exception $e) {

    // Se der erro, desfaz tudo
    $db->rollBack();
}


/* ============================
   REDIRECIONAR
============================ */

header("Location: admin_dashboard.php?sucesso=1");
exit;