<?php
// Importa conexão com banco
require "database.php";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $idade = $_POST['idade'];

    /* ============================
       VERIFICAR SE EMAIL JÁ EXISTE
    ============================ */
    $check = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {

        $erro = "Este email já está cadastrado.";

    } else {

        /* ============================
           CRIPTOGRAFAR SENHA
        ============================ */
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        /* ============================
           INSERIR USUÁRIO
        ============================ */
        $sql = $db->prepare("
            INSERT INTO usuarios
            (nome, email, senha, telefone, idade, plano)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $sql->execute([$nome, $email, $senhaHash, $telefone, $idade, 'Mensal']);

        // Redireciona para login
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
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

    <h2>Criar Conta</h2>

    <!-- Exibir erro -->
    <?php if (isset($erro)) { ?>
        <p style="color:red;"><?php echo $erro; ?></p>
    <?php } ?>

    <input name="nome" placeholder="Nome" required>

    <input type="email" name="email" placeholder="Email" required>

    <input type="password" name="senha" placeholder="Senha" required>

    <input name="telefone" placeholder="Telefone" required>

    <input type="number" name="idade" placeholder="Idade" required>

    <button type="submit">Cadastrar</button>

    <p style="text-align:center;margin-top:10px;">
        Já tem conta?
        <a href="login.php">Entrar</a>
    </p>

</form>

</body>
</html>