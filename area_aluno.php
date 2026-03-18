<?php
/* ============================
   CONEXÃO + SESSÃO
============================ */

// Importa conexão com banco
require "database.php";

// Inicia sessão
session_start();


/* ============================
   SEGURANÇA
============================ */

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// ID do usuário logado
$id = $_SESSION['usuario'];


/* ============================
   BUSCAR DADOS DO USUÁRIO
============================ */

// Prepara a consulta (seguro contra SQL Injection)
$sql = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
$sql->execute([$id]);

$user = $sql->fetch();

// Se não encontrar usuário (extra segurança)
if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Área do Aluno</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- ============================
     HEADER
============================ -->
<header>
    <div class="header-container">

        <h1 class="logo">Physical Center</h1>

        <div class="header-buttons">

            <a href="index.php">
                <button type="button">Sair</button>
            </a>

        </div>

    </div>
</header>


<!-- ============================
     CONTEÚDO DO ALUNO
============================ -->
<div class="aluno-container">

    <div class="aluno-info">

        <h1>Área do Aluno</h1>

        <!-- DADOS DO USUÁRIO -->
        <p><strong>Nome:</strong> <?= htmlspecialchars($user['nome']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Telefone:</strong> <?= htmlspecialchars($user['telefone']) ?></p>
        <p><strong>Idade:</strong> <?= htmlspecialchars($user['idade']) ?></p>
        <p><strong>Plano:</strong> <?= htmlspecialchars($user['plano']) ?></p>

        <!-- MENU -->
        <div class="menu-aluno">

            <a href="treinos.php">
                <button type="button">Ver Treinos</button>
            </a>

        </div>

    </div>

</div>

</body>
</html>