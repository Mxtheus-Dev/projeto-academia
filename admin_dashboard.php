<?php
// Importa conexão com banco
require "database.php";

// Inicia a sessão
session_start();

// Verifica se o admin está logado
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php"); // Redireciona para login
    exit;
}

/* ============================
   BUSCAR ALUNOS NO BANCO
============================ */
$usuarios = $db->query("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Instrutor</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- HEADER -->
<header>
    <div class="header-container">

        <h1 class="logo">Painel do Instrutor</h1>

        <div class="header-buttons">
            <a href="index.php">
                <button type="button">Home</button>
            </a>

            <a href="logout.php">
                <button type="button">Sair</button>
            </a>
        </div>

    </div>
</header>

<!-- CONTEÚDO PRINCIPAL -->
<div class="treinos-container">

    <h2>Alunos da Academia</h2>

    <!-- TABELA DE USUÁRIOS -->
    <table>

        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Idade</th>
            <th>Plano</th>
        </tr>

        <!-- LOOP DOS USUÁRIOS -->
        <?php foreach ($usuarios as $user) { ?>

            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['nome']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['telefone']; ?></td>
                <td><?php echo $user['idade']; ?></td>
                <td><?php echo $user['plano']; ?></td>
            </tr>

        <?php } ?>

    </table>

    <br>

    <!-- BOTÃO PARA ADICIONAR TREINO -->
    <a href="add_treino.php">
        <button type="button">Adicionar Treino</button>
    </a>

</div>

</body>
</html>