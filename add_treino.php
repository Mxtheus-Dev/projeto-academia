<?php
/* ============================
   INÍCIO DA SESSÃO E SEGURANÇA
============================ */

// Inicia a sessão
session_start();

// Verifica se o admin está logado
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php"); // Redireciona para login
    exit;
}


/* ============================
   CONEXÃO COM O BANCO
============================ */

// Importa conexão com banco de dados
require "database.php";


/* ============================
   BUSCAR USUÁRIOS
============================ */

// Busca todos os usuários cadastrados
$usuarios = $db->query("SELECT * FROM usuarios");


/* ============================
   PROCESSAR FORMULÁRIO
============================ */

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Captura e limpa os dados do formulário
    $usuario    = $_POST['usuario'] ?? null;
    $dia        = $_POST['dia'] ?? '';
    $exercicio  = $_POST['exercicio'] ?? '';
    $series     = $_POST['series'] ?? '';
    $repeticoes = $_POST['repeticoes'] ?? '';
    $carga = $_POST['carga'];

    // Validação simples (evita dados vazios)
    if ($usuario && $dia && $exercicio && $series && $repeticoes) {

        // Prepara o SQL para evitar SQL Injection
        $sql = $db->prepare("
            INSERT INTO treinos 
            (usuario_id, dia, exercicio, series, repeticoes, carga) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        // Executa o insert com os dados
        $sql->execute([
            $usuario,
            $dia,
            $exercicio,
            $series,
            $repeticoes,
            $carga
        ]);
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Treino</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- ============================
     CABEÇALHO
============================ -->
<header>
    <div class="header-container">
        <h1 class="logo">Adicionar Treino</h1>

        <div class="header-buttons">
            <a href="admin_dashboard.php">
                <button type="button">Voltar</button>
            </a>
        </div>
    </div>
</header>


<!-- ============================
     FORMULÁRIO
============================ -->
<form method="POST">

    <h2>Adicionar Treino</h2>

    <!-- Seleção de usuário -->
    <select name="usuario" required>
        <option value="">Selecione um usuário</option>

        <?php foreach ($usuarios as $user): ?>
            <option value="<?= $user['id']; ?>">
                <?= $user['nome']; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Campos do treino -->
    <input name="dia" placeholder="Dia (Ex: Segunda)" required>
    <input name="exercicio" placeholder="Exercício" required>
    <input name="series" placeholder="Séries" required>
    <input name="repeticoes" placeholder="Repetições" required>
    <input name="carga" placeholder="Carga (Ex: 10kg)" required>

    <!-- Botão -->
    <button type="submit">Salvar Treino</button>

</form>

</body>
</html>