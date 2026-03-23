<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

require "database.php";

/* ============================
   PEGAR ID
============================ */
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: admin_dashboard.php");
    exit;
}

/* ============================
   BUSCAR TREINO
============================ */
$sql = $db->prepare("SELECT * FROM treinos WHERE id = ?");
$sql->execute([$id]);
$treino = $sql->fetch();

if (!$treino) {
    header("Location: admin_dashboard.php");
    exit;
}

/* ============================
   BUSCAR USUÁRIOS
============================ */
$usuarios = $db->query("SELECT * FROM usuarios");

/* ============================
   ATUALIZAR TREINO
============================ */
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $usuario     = $_POST['usuario'];
    $dia         = $_POST['dia'];
    $exercicio   = $_POST['exercicio'];
    $series      = $_POST['series'];
    $repeticoes  = $_POST['repeticoes'];
    $carga       = $_POST['carga'];

    $update = $db->prepare("
        UPDATE treinos 
        SET usuario_id=?, dia=?, exercicio=?, series=?, repeticoes=?, carga=? 
        WHERE id=?
    ");

    $update->execute([
        $usuario,
        $dia,
        $exercicio,
        $series,
        $repeticoes,
        $carga,
        $id
    ]);

    header("Location: admin_dashboard.php?editado=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Editar Treino</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
<div class="header-container">
<h1 class="logo">Editar Treino</h1>
<a href="admin_dashboard.php"><button>Voltar</button></a>
</div>
</header>

<form method="POST">

<h2>Editar Treino</h2>

<select name="usuario" required>
<?php foreach ($usuarios as $user): ?>
<option 
    value="<?= $user['id'] ?>"
    <?= $treino['usuario_id'] == $user['id'] ? 'selected' : '' ?>
>
    <?= $user['nome'] ?>
</option>
<?php endforeach; ?>
</select>

<input name="dia" value="<?= htmlspecialchars($treino['dia']) ?>" required>
<input name="exercicio" value="<?= htmlspecialchars($treino['exercicio']) ?>" required>
<input name="series" value="<?= htmlspecialchars($treino['series']) ?>" required>
<input name="repeticoes" value="<?= htmlspecialchars($treino['repeticoes']) ?>" required>
<input name="carga" value="<?= htmlspecialchars($treino['carga']) ?>" required>

<button type="submit">Salvar Alterações</button>

</form>

</body>
</html>