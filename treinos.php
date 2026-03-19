<?php
/* ============================
   CONEXÃO + SESSÃO
============================ */

require "database.php";
session_start();


/* ============================
   SEGURANÇA
============================ */

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['usuario'];


/* ============================
   BUSCAR TREINOS
============================ */

$sql = $db->prepare("
    SELECT * 
    FROM treinos 
    WHERE usuario_id = ?
    ORDER BY id DESC
");

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

<!-- ============================
     HEADER
============================ -->
<header>
    <div class="header-container">

        <h1 class="logo">Academia Physical Center</h1>

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


<!-- ============================
     CONTEÚDO
============================ -->
<div class="treinos-container">

    <h2>Meus Treinos</h2>

    <?php if (count($treinos) === 0): ?>
        <p>Nenhum treino disponível ainda.</p>
    <?php else: ?>

    <table>

        <tr>
            <th>Dia</th>
            <th>Exercício</th>
            <th>Séries</th>
            <th>Repetições</th>
            <th>Carga</th>
            <th>Status</th>
        </tr>

        <?php foreach ($treinos as $treino): ?>
            <tr>

                <td><?= htmlspecialchars($treino['dia']) ?></td>
                <td><?= htmlspecialchars($treino['exercicio']) ?></td>
                <td><?= htmlspecialchars($treino['series']) ?></td>
                <td><?= htmlspecialchars($treino['repeticoes']) ?></td>
                <td><?= htmlspecialchars($treino['carga']) ?></td>

                <!-- STATUS -->
                <td>
                    <?= $treino['status'] === 'concluido' 
                        ? '✅ Concluído' 
                        : '⏳ Pendente' ?>
                </td>

            </tr>
        <?php endforeach; ?>

    </table>

    <?php endif; ?>

</div>

</body>
</html>