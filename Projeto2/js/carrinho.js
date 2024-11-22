// Declaração inicial do carrinho
let cart = [];

// Função para exibir o modal de produto com detalhes
function showProductModal(name, price, image, description) {
    document.getElementById('modalProductName').innerText = name;
    document.getElementById('modalProductPrice').innerText = `R$ ${price.toFixed(2)}`;
    document.getElementById('modalProductImage').src = image;
    document.getElementById('modalProductDescription').innerText = description;
    document.getElementById('productQuantity').value = 1;

    $('#productModal').modal('show');
}

// Função para adicionar o produto do modal ao carrinho
function addProductToCart() {
    const name = document.getElementById('modalProductName').innerText;
    const price = parseFloat(document.getElementById('modalProductPrice').innerText.replace('R$', ''));
    const image = document.getElementById('modalProductImage').src;
    const quantity = parseInt(document.getElementById('productQuantity').value);

    const item = cart.find(item => item.name === name);
    if (item) {
        item.quantity += quantity;
    } else {
        cart.push({ name: name, price: price, quantity: quantity, image: image });
    }

    updateCart();
    $('#productModal').modal('hide');
}

// Função para atualizar o carrinho
function updateCart() {
    const cartCount = document.getElementById('cart-count');
    const cartItems = document.getElementById('cart-items');
    cartCount.innerText = cart.reduce((sum, item) => sum + item.quantity, 0);

    cartItems.innerHTML = ''; // Limpa os itens do carrinho
    let total = 0; // Variável para armazenar o total do carrinho

    cart.forEach((item, index) => {
        const listItem = document.createElement('li');
        listItem.className = 'list-group-item d-flex align-items-center justify-content-between';

        // Adiciona a imagem do produto
        const productImage = document.createElement('img');
        productImage.src = item.image;
        productImage.alt = item.name;
        productImage.style.width = "100px"; // Define o tamanho desejado para a imagem
        productImage.className = "mr-3"; // Classe para espaçamento

        // Adiciona os detalhes do produto
        const productDetails = document.createElement('div');
        productDetails.innerHTML = `<strong>${item.name}</strong><br>R$${item.price.toFixed(2)} x ${item.quantity}`;

        // Adiciona o botão de remover com "x" do Bootstrap
        const removeButton = document.createElement('button');
        removeButton.className = 'close'; // Classe do "x" do Bootstrap
        removeButton.setAttribute('aria-label', 'Close'); // Atributo para acessibilidade
        removeButton.innerHTML = '&times;'; // Ícone de "x"
        removeButton.onclick = () => removeItemFromCart(index); // Chama a função para remover o item

        // Adiciona a imagem, detalhes e o botão de remoção ao item da lista
        listItem.appendChild(productImage);
        listItem.appendChild(productDetails);
        listItem.appendChild(removeButton);

        // Adiciona o item ao carrinho
        cartItems.appendChild(listItem);

        // Calcula o total para cada item
        total += item.price * item.quantity;
    });

    // Adiciona o valor total ao final da lista de itens
    const totalItem = document.createElement('li');
    totalItem.className = 'list-group-item text-right font-weight-bold';
    totalItem.innerText = `Total: R$ ${total.toFixed(2)}`;
    cartItems.appendChild(totalItem);

    // Exibe uma mensagem caso o carrinho esteja vazio
    if (cart.length === 0) {
        const emptyMessage = document.createElement('li');
        emptyMessage.className = 'list-group-item text-center';
        emptyMessage.innerText = 'O carrinho está vazio.';
        cartItems.appendChild(emptyMessage);
    }

    // Salva o estado do carrinho no localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Função para remover um item do carrinho
function removeItemFromCart(index) {
    cart.splice(index, 1); // Remove o item do array pelo índice
    updateCart(); // Atualiza o carrinho na interface
}

// Função para finalizar a compra (checkout)
function checkout() {
    // Verifica se a função foi chamada
    console.log('Função checkout chamada');

    if (cart.length === 0) {
        alert('O carrinho está vazio!');
        return;
    }

    // Enviar os dados do carrinho via POST para o PHP
    fetch('processar_pedido.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(cart), // Envia o carrinho como JSON
    })
    .then(response => response.json())  // Espera uma resposta JSON do servidor
    .then(data => {
        if (data.success) {
            alert('Pedido realizado com sucesso!');
            cart = []; // Limpa o carrinho após o pedido ser realizado
            updateCart(); // Atualiza o carrinho na interface
            $('#cartModal').modal('hide'); // Fecha o modal do carrinho
        } else {
            alert('Ocorreu um erro ao realizar o pedido. Tente novamente.');
        }
    })
    .catch(error => {
        console.error('Erro ao enviar o pedido:', error);
        alert('Erro ao realizar o pedido. Tente novamente.');
    });
}

// Verifica se há carrinho salvo no localStorage ao carregar a página
window.onload = function() {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart); // Carrega o carrinho salvo
        updateCart(); // Atualiza o carrinho na interface
    }
};
