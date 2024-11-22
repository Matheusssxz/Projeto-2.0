<?php
// Conectar ao banco de dados SQLite
$db = new SQLite3('meu_banco.db');

session_start();

// Receber os dados do pedido do frontend
$data = json_decode(file_get_contents('php://input'), true);

// Iniciar uma transação para garantir que ambos os dados (pedido e itens) sejam inseridos de forma segura
$db->exec('BEGIN');

// Inserir o pedido na tabela 'pedidos'
$stmt = $db->prepare('INSERT INTO pedidos (nome_cliente) VALUES (:nome_cliente)');
$stmt->bindValue(':nome_cliente', $_SESSION["username"]);  // Aqui você pode pegar o nome do cliente, se disponível
$stmt->execute();
$pedido_id = $db->lastInsertRowID();  // Pega o ID do pedido inserido

// Inserir os itens na tabela 'itens_pedido'
foreach ($data as $item) {
    $stmt = $db->prepare('INSERT INTO itens_pedido (pedido_id, nome_produto, quantidade, preco) VALUES (:pedido_id, :nome_produto, :quantidade, :preco)');
    $stmt->bindValue(':pedido_id', $pedido_id, SQLITE3_INTEGER);
    $stmt->bindValue(':nome_produto', $item['name'], SQLITE3_TEXT);
    $stmt->bindValue(':quantidade', $item['quantity'], SQLITE3_INTEGER);
    $stmt->bindValue(':preco', $item['price'], SQLITE3_FLOAT);
    $stmt->execute();
}

// Confirmar a transação
$db->exec('COMMIT');

// Enviar uma resposta de sucesso para o frontend
echo json_encode(['success' => true]);
?>
