<?php
// Conectar ao banco de dados SQLite
$db = new SQLite3('carrinho.db'); // O SQLite cria o arquivo 'carrinho.db' se não existir

// Cria a tabela 'pedidos', caso ainda não exista
$db->exec("CREATE TABLE IF NOT EXISTS pedidos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    produto TEXT,
    preco REAL,
    quantidade INTEGER
)");

echo "Tabela criada com sucesso!";
?>
