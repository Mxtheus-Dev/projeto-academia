<?php
/* ============================
   CONEXÃO COM BANCO
============================ */

require "database.php";


/* ============================
   CAPTURAR DADOS
============================ */

$nome     = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$plano    = $_POST['plano'] ?? '';

$msg_status = "";


try {

    /* ============================
       VALIDAÇÃO
    ============================ */
    if (empty($nome) || empty($telefone) || empty($plano)) {
        throw new Exception("Preencha todos os campos.");
    }

    /* ============================
       INSERIR NO BANCO
    ============================ */
    $sql = $db->prepare("
        INSERT INTO usuarios (nome, telefone, plano)
        VALUES (?, ?, ?)
    ");

    $sql->execute([
        $nome,
        $telefone,
        $plano
    ]);

    /* ============================
       SUCESSO
    ============================ */
    if ($db->lastInsertId()) {
        $msg_status = "sucesso";
    } else {
        $msg_status = "erro";
    }

} catch (Exception $e) {

    $msg_status = "erro";
    $erro = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container" style="text-align:center; margin-top:80px;">

    <h1>Resultado do Cadastro</h1>

    <?php if ($msg_status === "sucesso"): ?>
        
        <p style="color: #22c55e; font-weight: bold;">
            ✅ Cadastro realizado com sucesso!
        </p>

        <p><?= htmlspecialchars($nome) ?> foi cadastrado.</p>

    <?php else: ?>

        <p style="color: #ef4444; font-weight: bold;">
            ❌ Erro ao cadastrar
        </p>

        <?php if (isset($erro)): ?>
            <p><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <br>

    <a href="alunos.php">
        <button type="button">Voltar</button>
    </a>

</div>

</body>
</html>