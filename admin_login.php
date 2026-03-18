<?php
// Importa conexão com banco
require "database.php";

// Inicia sessão
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Captura os dados do formulário
    $user = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Prepara a consulta para evitar SQL Injection
    $sql = $db->prepare("SELECT * FROM admin WHERE usuario = ? AND senha = ?");
    $sql->execute([$user, $senha]);

    // Busca o admin
    $admin = $sql->fetch();

    // Se encontrou o admin
    if ($admin) {

        // Salva sessão
        $_SESSION['admin'] = $admin['id'];

        // Redireciona para o painel
        header("Location: admin_dashboard.php");
        exit;

    } else {
        // Mensagem de erro
        $erro = "Login inválido";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Instrutor Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- HEADER -->
<header>
    <div class="header-container">

        <h1 class="logo">Physical Center</h1>

        <div class="header-buttons">
            <a href="index.php">
                <button type="button">Voltar para Home</button>
            </a>
        </div>

    </div>
</header>

<!-- FORMULÁRIO -->
<form method="POST">

    <h2>Login Instrutor</h2>

    <!-- Exibe erro se existir -->
    <?php if (isset($erro)) { ?>
        <p style="color:red;"><?php echo $erro; ?></p>
    <?php } ?>

    <input name="usuario" placeholder="Usuário" required>

    <input type="password" name="senha" placeholder="Senha" required>

    <button type="submit">Entrar</button>

</form>

</body>
</html>