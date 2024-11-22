<?php
// Conecta ao banco de dados
$db = new SQLite3('loja.db');

// Lê os dados do carrinho enviados via JSON
$data = file_get_contents('php://input');
$cartItems = json_decode($data, true);

if ($cartItems) {
    foreach ($cartItems as $item) {
        $stmt = $db->prepare("INSERT INTO carrinho (produto_nome, preco, quantidade, cliente_id) VALUES (:produto_nome, :preco, :quantidade, :cliente_id)");
        $stmt->bindValue(':produto_nome', $item['name']);
        $stmt->bindValue(':preco', $item['price']);
        $stmt->bindValue(':quantidade', $item['quantity']);
        $stmt->bindValue(':cliente_id', 1); // ID do cliente fixo para teste
        $stmt->execute();
    }

    echo "Itens do carrinho adicionados com sucesso!";
} else {
    echo "Erro ao processar os dados.";
}
?>
