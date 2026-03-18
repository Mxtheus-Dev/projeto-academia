<?php
/* ============================
   CONEXÃO COM BANCO
============================ */

require "database.php";


/* ============================
   PROCESSAR FORMULÁRIO
============================ */

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Captura os dados com segurança
    $nome     = $_POST['nome'] ?? '';
    $email    = $_POST['email'] ?? '';
    $senha    = $_POST['senha'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $idade    = $_POST['idade'] ?? '';

    // Validação básica
    if ($nome && $email && $senha && $telefone && $idade) {

        /* ============================
           VERIFICAR SE EMAIL EXISTE
        ============================ */
        $check = $db->prepare("SELECT id FROM usuarios WHERE email = ?");
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

            $sql->execute([
                $nome,
                $email,
                $senhaHash,
                $telefone,
                $idade,
                'Mensal'
            ]);

            // Redireciona para login
            header("Location: login.php");
            exit;
        }

    } else {
        $erro = "Preencha todos os campos.";
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

<!-- ============================
     HEADER
============================ -->
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


<!-- ============================
     FORMULÁRIO
============================ -->
<form method="POST">

    <h2>Criar Conta</h2>

    <!-- ERRO -->
    <?php if (isset($erro)): ?>
        <p class="erro"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <!-- CAMPOS -->
    <input 
        name="nome" 
        placeholder="Nome" 
        value="<?= htmlspecialchars($nome ?? '') ?>" 
        required
    >

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

    <input 
        name="telefone" 
        placeholder="Telefone" 
        value="<?= htmlspecialchars($telefone ?? '') ?>" 
        required
    >

    <input 
        type="number" 
        name="idade" 
        placeholder="Idade" 
        value="<?= htmlspecialchars($idade ?? '') ?>" 
        required
    >

    <!-- BOTÃO -->
    <button type="submit">Cadastrar</button>

    <!-- LINK LOGIN -->
    <p style="text-align:center;margin-top:10px;">
        Já tem conta?
        <a href="login.php">Entrar</a>
    </p>

</form>

</body>
</html>