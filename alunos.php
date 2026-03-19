<?php 
/* ============================
   CONEXÃO COM BANCO
============================ */

require "database.php";


/* ============================
   CONSULTA DE ALUNOS
============================ */

// SQL para buscar dados dos alunos
$sql = "
    SELECT id, nome, telefone, plano
    FROM usuarios
";

// Executa a consulta
$stmt = $db->query($sql);

// Converte em array (melhor que while)
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alunos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- ============================
     HEADER
============================ -->
<header>

    <h1>Academia Physical Center</h1>

    <nav>
        <a href="index.php">Home</a>
        <a href="cadastro.php">Cadastrar</a>
    </nav>

</header>


<!-- ============================
     CONTEÚDO
============================ -->
<div class="container">

    <h2>Lista de Alunos</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Plano</th>
        </tr>

        <!-- LISTAGEM -->
        <?php if (count($usuarios) > 0): ?>

            <?php foreach ($usuarios as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['nome']) ?></td>
                    <td><?= htmlspecialchars($user['telefone']) ?></td>
                    <td><?= htmlspecialchars($user['plano']) ?></td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>

            <!-- Caso não tenha alunos -->
            <tr>
                <td colspan="4">Nenhum aluno cadastrado.</td>
            </tr>

        <?php endif; ?>

    </table>

</div>

</body>
</html>