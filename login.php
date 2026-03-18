<?php
// Importa conexão com banco
require "database.php";

// Inicia sessão
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Captura os dados
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    /* ============================
       BUSCAR USUÁRIO PELO EMAIL
    ============================ */
    $sql = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
    $sql->execute([$email]);

    $user = $sql->fetch();

    /* ============================
       VERIFICAR SENHA CRIPTOGRAFADA
    ============================ */
    if ($user && password_verify($senha, $user['senha'])) {

        // Cria sessão
        $_SESSION['usuario'] = $user['id'];

        // Redireciona
        header("Location: area_aluno.php");
        exit;

    } else {
        $erro = "Login inválido";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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

    <h2>Login do Aluno</h2>

    <!-- Exibe erro -->
    <?php if (isset($erro)) { ?>
        <p style="color:red;"><?php echo $erro; ?></p>
    <?php } ?>

    <input type="email" name="email" placeholder="Email" required>

    <input type="password" name="senha" placeholder="Senha" required>

    <button type="submit">Entrar</button>

    <p style="text-align:center;margin-top:10px;">
        Não tem conta?
        <a href="cadastro.php">Criar conta</a>
        <br><br>
    </p>

</form>

</body>
</html>