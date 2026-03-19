<?php
/* ============================
   CONEXÃO + SESSÃO
============================ */

// Importa conexão com banco
require "database.php";

// Inicia sessão
session_start();


/* ============================
   PROCESSAR LOGIN
============================ */

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Captura dados com segurança
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Validação básica
    if (!empty($email) && !empty($senha)) {

        /* ============================
           BUSCAR USUÁRIO
        ============================ */
        $sql = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $sql->execute([$email]);

        $user = $sql->fetch();

        /* ============================
           VERIFICAR SENHA
        ============================ */
        if ($user && password_verify($senha, $user['senha'])) {

            // Cria sessão
            $_SESSION['usuario'] = $user['id'];

            // Redireciona
            header("Location: area_aluno.php");
            exit;

        } else {
            $erro = "Email ou senha inválidos";
        }

    } else {
        $erro = "Preencha todos os campos";
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

<!-- ============================
     HEADER
============================ -->
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


<!-- ============================
     FORMULÁRIO
============================ -->
<form method="POST">

    <h2>Login do Aluno</h2>

    <!-- ERRO -->
    <?php if (isset($erro)): ?>
        <p class="erro"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <!-- CAMPOS -->
    <input 
        type="email" 
        name="email" 
        placeholder="Email" 
        value="<?= htmlspecialchars($email ?? '') ?>"
        required
    >

    <input 
        type="password" 
        name="senha" 
        placeholder="Senha" 
        required
    >

    <!-- BOTÃO -->
    <button type="submit">Entrar</button>

    <!-- LINK CADASTRO -->
    <p style="text-align:center;margin-top:10px;">
        Não tem conta?
        <a href="cadastro.php">Criar conta</a>
        <br><br>
    </p>

</form>

</body>
</html>