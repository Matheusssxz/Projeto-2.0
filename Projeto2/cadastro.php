<?php
session_start();

include_once('index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura e valida os dados
    $user = trim($_POST['user']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (empty($user) || empty($email) || empty($password)) {
        die("Por favor, preencha todos os campos.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido.");
    }


    $checkStmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE email = :email");
    $checkStmt->bindParam(":email", $email, SQLITE3_TEXT);
    $result = $checkStmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($result['count'] > 0) {
        die("Email já cadastrado.");
    }

    // Hash da senha
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insere o usuário no banco
    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:name, :email, :password)");
    $stmt->bindValue(":name", $user, SQLITE3_TEXT);
    $stmt->bindValue(":email", $email, SQLITE3_TEXT);
    $stmt->bindValue(":password", $hashedPassword, SQLITE3_TEXT);

    if ($stmt->execute()) {
        header("Location: index.html");
        exit();
    } else {
        die("Erro ao cadastrar o usuário.");
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loja Virtual CAMM.com.br - CAMM.com.br</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/login.css">
</head>

<body>

  <!--Inicio do Banner da Página Inicial-->
    <div class="banner">
        <div class="container">
            <div class="navbar navbar-expand-lg navbar-light ">
                <div class="logo">
                    <img src="img/icons/logo.svg" alt="CAMM">
                </div>

                <!-- Botão do Menu Hambúrguer -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu"
                aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>


                <!-- Menu de Navegação -->
                <div class="collapse navbar-collapse" id="navbarMenu">
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="#empresaModal" data-toggle="modal">Empresa</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contatoModal" data-toggle="modal">Contatos</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro.php">Cadastro</a></li>
                  </ul>
                </div>

                <button id="cart-button" class="ml-3" data-toggle="modal" data-target="#cartModal" style="background-color: transparent; border: none;">
                <img src="img/icons/carrinho.svg" alt="Ícone do carrinho" id="cart-icon" width="30px" height="30px">
                <span id="cart-count" class="badge badge-pill badge-warning">0</span>
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="coluna-1" style="padding-left: 150px;">
            <img src="img/banner/banner.png" alt="Banner de estilo de vida">
        </div>
            
            
        <div class="coluna-1">
        <div class="container-login" style="background-color: white; justify-content: center; align-items: center; padding: 5% 15px;padding-left:120px">
                    <h5>Faça seu Cadastro</h5>
                    <form method="post" action="cadastro.php">
                        <div class="form-group">
                            <label for="nomeCadastro">Nome</label>
                            <input name="user" type="text" class="form-control" id="user" placeholder="Digite seu nome" style="max-width: 50%">
                        </div>

                        <div class="form-group">
                            <label for="emailCadastro">E-mail</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Digite seu e-mail" style="max-width: 50%">
                        </div>

                        <div class="form-group">
                            <label for="senhaCadastro">Senha</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Digite sua senha" style="max-width: 50%">
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
            </div>
        </div>
    </div>

  <!-------------Modal Sobre a Empresa---------------->
  <div class="modal fade" id="empresaModal" tabindex="-1" aria-labelledby="empresaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="empresaModalLabel">Bem-vindo à Nossa Empresa</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body text-center">
            <p>Na CAMM, acreditamos que a moda é uma forma de expressão única. Oferecemos as últimas tendências em roupas e acessórios para todos os estilos, com peças de alta qualidade, confortáveis e acessíveis. Nosso compromisso é proporcionar uma experiência de compra incrível, tanto online quanto em nossa loja física, com atendimento personalizado e uma curadoria de produtos feita especialmente para você.
              Venha descobrir as coleções que combinam com sua personalidade e encontre aquele look perfeito para cada ocasião. Se você busca elegância, conforto ou estilo,CAMM um estilo que une a todos!</p>
            <img src="img/icons/logo.svg"  alt="logo da Empresa" class="img-fluid rounded" style="background-color: black;">
          </div>
      </div>
    </div>
  </div>

<!----------------------- Modal de Informações de Contato ------------------------>
<div class="modal fade" id="contatoModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Informações de Contato</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>E-mail:</strong> CAMM@gmail.com</p>
                <p><strong>Telefone:</strong> (81) 94002-8922</p>
                <p><strong>Endereço:</strong> Av. Abdias de Carvalho, 123 - Recife, PE</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
  </div>

  <!------------------------------------------ Modal do Carrinho de Compras ----------------------------------->
  
  <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cartModalLabel">Carrinho de Compras</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul id="cart-items" class="list-group">
            <!-- Itens do carrinho serão adicionados aqui dinamicamente -->
            <li class="list-group-item text-center">O carrinho está vazio.</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Continuar Comprando</button>
          <button type="button" class="btn btn-primary" onclick="checkout()">Finalizar Compra</button>
        </div>
      </div>
    </div>
  </div>



  <footer class="rodape">

    <div class="container">
      <div class="row">

        <div class="rodape-col-1">
          <h3>Baixe o nosso app</h3>
          <p>Baixe o nosso aplicativo nas melhores plataformas.</p>
          <div class="app-logo">
            <img src="img/icons/play.png" alt="">
            <img src="img/icons/apple.png" alt="">
          </div>
        </div>

        <div class="rodape-col-2">
          <img src="img/icons/logo.svg" alt="CAMM">
          <p>Com uma seleção cuidadosamente de peças únicas,<br> a loja de roupas CAMM é o destino perfeito para quem
            busca se destacar na multidão.</p>
        </div>

        <div class="rodape-col-3">
          <h3>Mais Informações</h3>
          <ul>
            <li href="#empresaModal" data-toggle="modal" style="cursor: pointer;">Empresa</li>
            <li>Política de Privacidade</li>
            <li href="#contatoModal" data-toggle="modal" style="cursor: pointer;">Contatos</li>
          </ul>
        </div>

      </div>
      <hr>
      <p class="direitos">
        &#169; Todos os Direitos Reservados.
      </p>
    </div>
  </footer>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="js/categorias.js"></script>
  <script src="js/lermais.js"></script>
  <script src="js/jquery-3.5.1.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/carrinho.js"></script>z
</body>

</html>
