<?php

/* ============================
   CONEXÃO COM BANCO (SQLITE)
============================ */

try {

    // Cria conexão com SQLite
    $db = new PDO("sqlite:academia.db");

    // Ativa erros como exceção (melhor debug)
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    /* ============================
       CRIAÇÃO DAS TABELAS
    ============================ */

    // Tabela de usuários
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

    // Tabela de planos
    $db->exec("
        CREATE TABLE IF NOT EXISTS planos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT,
            preco REAL,
            duracao INTEGER
        )
    ");

    // Tabela de treinos
    $db->exec("
        CREATE TABLE IF NOT EXISTS treinos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER,
            dia TEXT,
            exercicio TEXT,
            series TEXT,
            repeticoes TEXT,
            status TEXT DEFAULT 'pendente',

            FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        )
    ");

    // Tabela de admin
    $db->exec("
        CREATE TABLE IF NOT EXISTS admin (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario TEXT UNIQUE,
            senha TEXT
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
       CRIAR ADMIN PADRÃO
    ============================ */

    $checkAdmin = $db->query("SELECT COUNT(*) as total FROM admin")->fetch();

    if ($checkAdmin['total'] == 0) {

        // Gera hash seguro da senha
        $senhaHash = password_hash("1234", PASSWORD_DEFAULT);

        $sql = $db->prepare("
            INSERT INTO admin (usuario, senha) 
            VALUES (?, ?)
        ");

        $sql->execute(["admin", $senhaHash]);
    }


} catch (PDOException $e) {

    /* ============================
       TRATAMENTO DE ERRO
    ============================ */

    // Em produção, o ideal é não mostrar erro direto
    echo "Erro ao conectar com o banco.";
    
    // Debug (usar só em desenvolvimento)
    // echo $e->getMessage();
}
?>