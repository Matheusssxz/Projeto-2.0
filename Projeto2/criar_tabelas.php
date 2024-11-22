<?php
// Conectar ao banco de dados SQLite (se o banco não existir, ele será criado automaticamente)
$db = new SQLite3('meu_banco.db');

// Criar a tabela de pedidos
$query1 = "
CREATE TABLE IF NOT EXISTS pedidos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome_cliente TEXT NOT NULL,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";
$db->exec($query1);

// Criar a tabela de itens de pedido
$query2 = "
CREATE TABLE IF NOT EXISTS itens_pedido (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pedido_id INTEGER,
    nome_produto TEXT,
    quantidade INTEGER,
    preco REAL,
    FOREIGN KEY(pedido_id) REFERENCES pedidos(id)
);
";
$db->exec($query2);

echo "Tabelas criadas com sucesso!";
?>
