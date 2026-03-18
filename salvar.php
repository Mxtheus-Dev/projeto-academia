<?php
require "database.php";

/* ============================
   CAPTURAR DADOS DO FORMULÁRIO
============================ */
$nome = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$plano = $_POST['plano'] ?? '';

// Data atual
$data = date("Y-m-d");

// Mensagem de status
$msg_status = "";

try {

    /* ============================
       VALIDAR DADOS
    ============================ */
    if (empty($nome) || empty($telefone) || empty($plano)) {
        throw new Exception("Preencha todos os campos.");
    }

    /* ============================
       INSERIR NO BANCO
    ============================ */
    $sql = $db->prepare("
        INSERT INTO usuarios (nome, telefone, plano)
        VALUES (:nome, :telefone, :plano)
    ");

    $sql->execute([
        ':nome' => $nome,
        ':telefone' => $telefone,
        ':plano' => $plano
    ]);

    /* ============================
       VERIFICAR INSERÇÃO
    ============================ */
    $id = $db->lastInsertId();

    if ($id) {
        $msg_status = "Sucesso!";
    } else {
        $msg_status = "Erro ao cadastrar.";
    }

} catch (Exception $e) {
    $msg_status = "Erro: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
</head>

<body>

<h1>Resultado do Cadastro</h1>

<p><?php echo htmlspecialchars($msg_status); ?></p>

<?php if ($msg_status == "Sucesso!") { ?>
    <p><?php echo htmlspecialchars($nome); ?> cadastrado com sucesso!</p>
<?php } ?>

<a href="alunos.php">Voltar</a>

</body>
</html>