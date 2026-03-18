<?php
/* ============================
   CONEXÃO + SESSÃO
============================ */

require "database.php";
session_start();


/* ============================
   PROCESSAR LOGIN
============================ */

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Captura os dados com segurança
    $user  = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Validação básica
    if (!empty($user) && !empty($senha)) {

        // Busca admin pelo usuário
        $sql = $db->prepare("SELECT * FROM admin WHERE usuario = ?");
        $sql->execute([$user]);

        $admin = $sql->fetch();

        // Verifica se existe e se a senha está correta
        if ($admin && password_verify($senha, $admin['senha'])) {

            // Cria sessão do admin
            $_SESSION['admin'] = $admin['id'];

            // Redireciona para o painel
            header("Location: admin_dashboard.php");
            exit;

        } else {
            $erro = "Usuário ou senha inválidos";
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
    <title>Instrutor Login</title>
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

    <h2>Login Instrutor</h2>

    <!-- ERRO -->
    <?php if (isset($erro)): ?>
        <p class="erro"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <!-- CAMPOS -->
    <input 
        name="usuario" 
        placeholder="Usuário" 
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

</form>

</body>
</html>