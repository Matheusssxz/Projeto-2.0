<?php
// Conectar ao banco de dados SQLite
$db = new SQLite3('meu_banco.db');

// Recuperar todos os pedidos
$result = $db->query('SELECT * FROM pedidos ORDER BY data_pedido DESC');

// Criar um array para armazenar os pedidos
$pedidos = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $pedido = [
        'id' => $row['id'],
        'nome_cliente' => $row['nome_cliente'],
        'data_pedido' => $row['data_pedido'],
    ];

    // Recuperar os itens do pedido
    $itens_result = $db->query('SELECT * FROM itens_pedido WHERE pedido_id = ' . $row['id']);
    $itens = [];
    while ($item = $itens_result->fetchArray(SQLITE3_ASSOC)) {
        $itens[] = $item;
    }

    $pedido['itens'] = $itens;
    $pedidos[] = $pedido;
}

// Exibir os pedidos como JSON (ou você pode criar uma página HTML)
echo json_encode($pedidos);
