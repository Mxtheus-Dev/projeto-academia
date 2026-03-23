<?php
/* ============================
   INÍCIO + SEGURANÇA
============================ */

session_start();

// Verifica se o admin está logado
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}


/* ============================
   CONEXÃO COM BANCO
============================ */

require "database.php";


/* ============================
   BUSCAR ALUNOS
============================ */

$usuarios = $db->query("SELECT * FROM usuarios");


/* ============================
   BUSCAR TREINOS
============================ */

$sql = $db->query("
    SELECT treinos.*, usuarios.nome 
    FROM treinos 
    JOIN usuarios ON usuarios.id = treinos.usuario_id
    ORDER BY treinos.id DESC
");

$treinos = $sql->fetchAll();
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Painel Instrutor</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<!-- ============================
     HEADER
============================ -->
<header>
<div class="header-container">

<h1 class="logo">Painel do Instrutor</h1>

<div class="header-buttons">
<a href="index.php"><button type="button">Sair</button></a>
</div>

</div>
</header>


<!-- ============================
     ALUNOS
============================ -->
<div class="treinos-container">

<h2>Alunos da Academia</h2>

<table>

<tr>
<th>ID</th>
<th>Nome</th>
<th>Email</th>
<th>Telefone</th>
<th>Idade</th>
<th>Plano</th>
<th>Ações</th>
</tr>

<?php foreach ($usuarios as $user): ?>
<tr>

<td><?= htmlspecialchars($user['id']) ?></td>
<td><?= htmlspecialchars($user['nome']) ?></td>
<td><?= htmlspecialchars($user['email']) ?></td>
<td><?= htmlspecialchars($user['telefone']) ?></td>
<td><?= htmlspecialchars($user['idade']) ?></td>
<td><?= htmlspecialchars($user['plano']) ?></td>

<td>
<div class="acoes">

<a href="editar_usuario.php?id=<?= $user['id']; ?>">
    <button style="background:#3b82f6;color:white;">Editar</button>
</a>

<a href="excluir_usuario.php?id=<?= $user['id']; ?>" 
   onclick="return confirm('Excluir aluno?')">
    <button class="btn-excluir">Excluir</button>
</a>

</div>
</td>

</tr>
<?php endforeach; ?>

</table>

<br>

<a href="add_treino.php">
<button type="button">Adicionar Treino</button>
</a>

</div>


<!-- ============================
     TREINOS
============================ -->
<div class="treinos-container">

<h2>Treinos Cadastrados</h2>

<?php if (count($treinos) === 0): ?>
    <p>Nenhum treino cadastrado.</p>
<?php endif; ?>

<table>

<tr>
<th>Aluno</th>
<th>Dia</th>
<th>Exercício</th>
<th>Séries</th>
<th>Repetições</th>
<th>Carga</th>
<th>Status</th>
<th>Ações</th>
</tr>

<?php foreach ($treinos as $t): ?>
<tr>

<td><?= htmlspecialchars($t['nome']) ?></td>
<td><?= htmlspecialchars($t['dia']) ?></td>
<td><?= htmlspecialchars($t['exercicio']) ?></td>
<td><?= htmlspecialchars($t['series']) ?></td>
<td><?= htmlspecialchars($t['repeticoes']) ?></td>
<td><?= htmlspecialchars($t['carga']) ?></td>

<!-- STATUS -->
<td>
<?= $t['status'] === 'concluido' ? '✅ Concluído' : '⏳ Pendente' ?>
</td>

<!-- AÇÕES -->
<td>
<div class="acoes">

<a href="editar_treino.php?id=<?= $t['id'] ?>">
    <button style="background:#3b82f6;color:white;">Editar</button>
</a>

<a href="concluir_treino.php?id=<?= $t['id'] ?>">
    <button class="btn-concluir">Concluir</button>
</a>

<a href="excluir_treino.php?id=<?= $t['id'] ?>" 
   onclick="return confirm('Excluir treino?')">
    <button class="btn-excluir">Excluir</button>
</a>

</div>
</td>

</tr>
<?php endforeach; ?>

</table>

</div>

</body>
</html>