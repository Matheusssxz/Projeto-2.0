// Simulação do estado de login (pode ser substituído por um valor real)
let usuarioLogado = false; // ou true, dependendo do login do usuário

// Função que altera o href do link "Minha Conta" conforme o estado de login
function atualizarLinkMinhaConta() {
  const linkMinhaConta = document.getElementById('minhaContaLink');
  
  if (usuarioLogado) {
    // Quando o usuário está logado
    linkMinhaConta.setAttribute('href', '#minhaContaLogado');
    linkMinhaConta.setAttribute('data-toggle', 'modal');
  } else {
    // Quando o usuário não está logado
    linkMinhaConta.setAttribute('href', '#minhaContaNaoLogado');
    linkMinhaConta.setAttribute('data-toggle', 'modal');
  }
}

// Chame a função ao carregar a página ou após o login
window.onload = atualizarLinkMinhaConta;

// Caso o estado de login mude, chame novamente a função
// Exemplo para quando o usuário logar:
function usuarioLogou() {
  usuarioLogado = true; // Agora o usuário está logado
  atualizarLinkMinhaConta();
}

// Exemplo para quando o usuário sair:
function usuarioSaiu() {
  usuarioLogado = false; // O usuário saiu
  atualizarLinkMinhaConta();
}
