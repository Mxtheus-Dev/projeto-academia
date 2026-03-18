<?php 
// Importa conexão com banco
require "database.php";

/* ============================
   CONSULTA NO BANCO
============================ */
$sql = "
    SELECT id, nome, telefone, plano
    FROM usuarios
";

// Executa a consulta
$rows = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alunos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- HEADER -->
<header>

    <h1>Physical Center</h1>

    <nav>
        <a href="index.php">Home</a>
        <a href="cadastro.php">Cadastrar</a>
    </nav>

</header>

<!-- CONTEÚDO -->
<div class="container">

    <h2>Lista de Alunos</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Plano</th>
        </tr>

        <?php
        // Loop nos dados do banco
        while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {

            // Captura os dados
            $id = htmlspecialchars($row['id']);
            $nome = htmlspecialchars($row['nome']);
            $telefone = htmlspecialchars($row['telefone']);
            $plano = htmlspecialchars($row['plano']);

            // Exibe linha da tabela
            echo "
                <tr>
                    <td>$id</td>
                    <td>$nome</td>
                    <td>$telefone</td>
                    <td>$plano</td>
                </tr>
            ";
        }
        ?>

    </table>

</div>

</body>
</html>