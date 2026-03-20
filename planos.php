<?php
require "database.php";

/* ============================
   BUSCAR PLANOS
============================ */
$planos = $db->query("SELECT * FROM planos")->fetchAll();

// Captura plano vindo da URL
$planoSelecionado = $_GET['plano'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Planos</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <div class="header-container">
        <h1 class="logo">Academia Physical Center</h1>

        <div class="header-buttons">
            <a href="index.php">
                <button type="button">Voltar</button>
            </a>
        </div>
    </div>
</header>

<div class="planos" style="margin-top:40px;">

    <h2>Escolha seu plano</h2>

    <div class="cards">

        <?php foreach ($planos as $p): ?>

            <div class="card <?= ($planoSelecionado == $p['id']) ? 'destaque' : '' ?>">

                <h3><?= htmlspecialchars($p['nome']) ?></h3>

                <p>R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>

                <p><?= $p['duracao'] ?> dias</p>

                <a href="cadastro.php?plano=<?= $p['nome'] ?>">
                    <button>Selecionar</button>
                </a>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>