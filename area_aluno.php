<?php
// Importa conexão com banco
require "database.php";

// Inicia sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Pega o ID do usuário logado
$id = $_SESSION['usuario'];

/* ============================
   BUSCAR DADOS DO USUÁRIO
============================ */

// Usando prepare 
$sql = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
$sql->execute([$id]);

$user = $sql->fetch();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Área do Aluno</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- HEADER -->
<header>
    <div class="header-container">

        <h1 class="logo">Physical Center</h1>

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

<!-- CONTEÚDO DO ALUNO -->
<div class="aluno-container">

    <div class="aluno-info">

        <h1>Área do Aluno</h1>

        <!-- Dados do usuário (com segurança) -->
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($user['nome']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($user['telefone']); ?></p>
        <p><strong>Idade:</strong> <?php echo htmlspecialchars($user['idade']); ?></p>
        <p><strong>Plano:</strong> <?php echo htmlspecialchars($user['plano']); ?></p>

        <!-- Menu -->
        <div class="menu-aluno">

            <a href="treinos.php">
                <button type="button">Ver Treinos</button>
            </a>

        </div>

    </div>

</div>

</body>
</html>