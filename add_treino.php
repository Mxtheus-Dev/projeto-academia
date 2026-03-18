<?php
// Inicia a sessão
session_start();

// Verifica se o admin está logado
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php"); // Redireciona para login
    exit;
}

// Importa conexão com banco de dados
require "database.php";

// Busca todos os usuários cadastrados
$usuarios = $db->query("SELECT * FROM usuarios");

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Captura os dados do formulário
    $usuario = $_POST['usuario'];
    $dia = $_POST['dia'];
    $exercicio = $_POST['exercicio'];
    $series = $_POST['series'];
    $repeticoes = $_POST['repeticoes'];

    // Prepara o SQL para evitar SQL Injection
    $sql = $db->prepare("
        INSERT INTO treinos
        (usuario_id, dia, exercicio, series, repeticoes)
        VALUES (?, ?, ?, ?, ?)
    ");

    // Executa o insert com os dados
    $sql->execute([$usuario, $dia, $exercicio, $series, $repeticoes]);
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

<!-- Cabeçalho -->
<header>
    <div class="header-container">
        <h1 class="logo">Physical Center</h1>

        <div class="header-buttons">
            <a href="admin_dashboard.php">
                <button>Voltar</button>
            </a>
        </div>
    </div>
</header>

<!-- Formulário -->
<form method="POST">

    <h2>Adicionar Treino</h2>

    <!-- Seleção de usuário -->
    <select name="usuario" required>
        <?php foreach ($usuarios as $user) { ?>
            <option value="<?php echo $user['id']; ?>">
                <?php echo $user['nome']; ?>
            </option>
        <?php } ?>
    </select>

    <!-- Campos do treino -->
    <input name="dia" placeholder="Dia (Ex: Segunda)" required>
    <input name="exercicio" placeholder="Exercício" required>
    <input name="series" placeholder="Séries" required>
    <input name="repeticoes" placeholder="Repetições" required>

    <!-- Botão -->
    <button type="submit">Salvar Treino</button>

</form>

</body>
</html>