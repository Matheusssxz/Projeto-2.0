fetch('visualizar_pedidos.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao carregar os pedidos: ' + response.statusText);
        }
        return response.json();
    })
    .then(pedidos => {
        console.log(pedidos); // Verifique os dados recebidos
        const pedidosContainer = document.getElementById('pedidos-list');
        pedidosContainer.innerHTML = ''; // Limpa os pedidos anteriores

        pedidos.forEach(pedido => {
            const pedidoElement = document.createElement('div');
            pedidoElement.classList.add('pedido');
            pedidoElement.innerHTML = `
                <h3>Pedido #${pedido.id} - ${pedido.nome_cliente} - ${pedido.data_pedido}</h3>
                <ul>
                    ${pedido.itens.map(item => `
                        <li>${item.nome_produto || 'Produto desconhecido'} - ${item.quantidade} x R$ ${(item.preco || 0).toFixed(2)}</li>
                    `).join('')}
                </ul>
                <hr>
            `;
            pedidosContainer.appendChild(pedidoElement);
        });
    })
    .catch(error => console.error('Erro ao carregar os pedidos:', error));
