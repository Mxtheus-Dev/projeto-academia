<?php
// Importa conexão com banco
require "database.php";

/* ============================
   BUSCAR PLANOS DO BANCO
============================ */
$planos = $db->query("SELECT * FROM planos");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Physical Center</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- HEADER -->
<header>
    <div class="header-container">

        <h1 class="logo">Physical Center</h1>

        <div class="header-buttons">
            <a href="login.php">
                <button type="button">Área do Aluno</button>
            </a>

            <a href="admin_login.php">
                <button type="button">Área do Instrutor</button>
            </a>
        </div>

    </div>
</header>

<!-- HERO (DESTAQUE) -->
<section class="hero">

    <div class="hero-content">
        <h2>Treine no melhor centro fitness</h2>
        <p>Força, disciplina e evolução todos os dias.</p>

        <a href="cadastro.php">
            <button type="button">Matricule-se</button>
        </a>
    </div>

</section>

<!-- PLANOS -->
<section class="planos">

    <h2>Nossos Planos</h2>

    <div class="cards">

        <?php foreach ($planos as $plano) { ?>

            <div class="card">

                <h3><?php echo htmlspecialchars($plano['nome']); ?></h3>

                <p>
                    R$ <?php echo number_format($plano['preco'], 2, ',', '.'); ?>
                </p>

                <button type="button">Assinar</button>

            </div>

        <?php } ?>

    </div>

</section>

<!-- BENEFÍCIOS -->
<section class="beneficios">

    <h2>Por que treinar aqui?</h2>

    <div class="grid">
        <div>Equipamentos modernos</div>
        <div>Treinadores qualificados</div>
        <div>Ambiente climatizado</div>
        <div>Treinos personalizados</div>
    </div>

</section>

<!-- RODAPÉ -->
<footer>
    <p>Academia Physical Center - 2026 - Porto Alegre</p>
</footer>

</body>
</html>