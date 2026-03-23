<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

require "database.php";

/* ============================
   PEGAR ID
============================ */
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: admin_dashboard.php");
    exit;
}

/* ============================
   BUSCAR USUÁRIO
============================ */
$sql = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
$sql->execute([$id]);
$user = $sql->fetch();

if (!$user) {
    header("Location: admin_dashboard.php");
    exit;
}

/* ============================
   ATUALIZAR DADOS
============================ */
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $nome     = $_POST['nome'];
    $email    = $_POST['email'];
    $telefone = $_POST['telefone'];
    $idade    = $_POST['idade'];
    $plano    = $_POST['plano'];

    $update = $db->prepare("
        UPDATE usuarios 
        SET nome=?, email=?, telefone=?, idade=?, plano=? 
        WHERE id=?
    ");

    $update->execute([
        $nome,
        $email,
        $telefone,
        $idade,
        $plano,
        $id
    ]);

    header("Location: admin_dashboard.php?editado=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Editar Aluno</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
<div class="header-container">
<h1 class="logo">Editar Aluno</h1>
<a href="admin_dashboard.php"><button>Voltar</button></a>
</div>
</header>

<form method="POST">

<h2>Editar Dados</h2>

<input name="nome" value="<?= htmlspecialchars($user['nome']) ?>" required>
<input name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
<input name="telefone" value="<?= htmlspecialchars($user['telefone']) ?>">
<input type="number" name="idade" value="<?= htmlspecialchars($user['idade']) ?>">
<input name="plano" value="<?= htmlspecialchars($user['plano']) ?>">

<button type="submit">Salvar Alterações</button>

</form>

</body>
</html>