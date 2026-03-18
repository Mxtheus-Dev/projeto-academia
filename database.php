<?php
try {

    /* ============================
       CONEXÃO COM BANCO SQLITE
    ============================ */
    $db = new PDO("sqlite:academia.db");

    // Ativa erros como exceção (melhor debug)
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /* ============================
       TABELA: USUÁRIOS
    ============================ */
    $db->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT,
            email TEXT UNIQUE,
            senha TEXT,
            telefone TEXT,
            idade INTEGER,
            plano TEXT
        )
    ");

    /* ============================
       TABELA: PLANOS
    ============================ */
    $db->exec("
        CREATE TABLE IF NOT EXISTS planos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT,
            preco REAL,
            duracao INTEGER
        )
    ");

    /* ============================
       TABELA: TREINOS
    ============================ */
    $db->exec("
        CREATE TABLE IF NOT EXISTS treinos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER,
            dia TEXT,
            exercicio TEXT,
            series TEXT,
            repeticoes TEXT,

            -- Relacionamento com usuários
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        )
    ");

    /* ============================
       INSERIR PLANOS PADRÃO
    ============================ */
    $checkPlanos = $db->query("SELECT COUNT(*) as total FROM planos")->fetch();

    if ($checkPlanos['total'] == 0) {

        $db->exec("
            INSERT INTO planos (nome, preco, duracao) VALUES
            ('Mensal', 89, 30),
            ('Trimestral', 219, 90),
            ('Anual', 699, 365)
        ");
    }

    /* ============================
       TABELA: ADMIN
    ============================ */
    $db->exec("
        CREATE TABLE IF NOT EXISTS admin (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario TEXT,
            senha TEXT
        )
    ");

    /* ============================
       CRIAR ADMIN PADRÃO
    ============================ */
    $checkAdmin = $db->query("SELECT COUNT(*) as total FROM admin")->fetch();

    if ($checkAdmin['total'] == 0) {

        // Senha criptografada
        $senhaHash = password_hash("1234", PASSWORD_DEFAULT);

        $sql = $db->prepare("INSERT INTO admin (usuario, senha) VALUES (?, ?)");
        $sql->execute(["admin", $senhaHash]);
    }

} catch (PDOException $e) {

    // Exibe erro 
    echo "Erro: " . $e->getMessage();
}
?>