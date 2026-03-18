<?php
// Importa banco
require "database.php";

// Inicia sessão
session_start();

// Verifica login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// ID do usuário logado
$id = $_SESSION['usuario'];

/* ============================
   BUSCAR TREINOS DO USUÁRIO
============================ */
$sql = $db->prepare("SELECT * FROM treinos WHERE usuario_id = ?");
$sql->execute([$id]);

$treinos = $sql->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Treinos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- HEADER -->
<header>
    <div class="header-container">

        <h1 class="logo">Physical Center</h1>

        <div class="header-buttons">

            <a href="area_aluno.php">
                <button type="button">Área do Aluno</button>
            </a>

            <a href="logout.php">
                <button type="button">Sair</button>
            </a>

        </div>

    </div>
</header>

<!-- CONTEÚDO -->
<div class="treinos-container">

    <h2>Meus Treinos</h2>

    <table>

        <tr>
            <th>Dia</th>
            <th>Exercício</th>
            <th>Séries</th>
            <th>Repetições</th>
        </tr>

        <?php foreach ($treinos as $treino) { ?>

            <tr>
                <td><?php echo htmlspecialchars($treino['dia']); ?></td>
                <td><?php echo htmlspecialchars($treino['exercicio']); ?></td>
                <td><?php echo htmlspecialchars($treino['series']); ?></td>
                <td><?php echo htmlspecialchars($treino['repeticoes']); ?></td>
            </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>