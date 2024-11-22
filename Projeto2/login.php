<?php
// Inclui o banco de dados
include_once('index.php');
session_start();
// Verifica se a conexão com o banco foi estabelecida
if (!$db) {
    die("Erro: Banco não disponível");
}

// Autentica o usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepara a consulta para verificar o usuário
        $stmt = $db->prepare("SELECT username, password FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);

        // Executa a consulta
        $result = $stmt->execute();

        // Verifica se encontrou algum registro
        if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // Verifica se a senha está correta
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username']; 
                $url = 'http://localhost:8000/index.html?user=' . $_SESSION['username'];
                header('Location: ' . $url);
                exit(); 
                // Iniciar sessão ou redirecionar
            } else {
                echo "Senha incorreta!";
            }
        } else {
            echo "Usuário não encontrado!";
        }
    } catch (Exception $e) {
        echo "Erro ao executar consulta no SQLite: " . $e->getMessage();
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
                <h5 >Login</h5>            
                <br>
                <form method="post" action="login.php">
                <div class="form-group">
                    <label for="emailLogin">E-mail</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Digite seu e-mail" style="max-width: 50%">
                </div>
                <div class="form-group">
                    <label for="senhaLogin">Senha</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Digite sua senha" style="max-width: 50%">
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
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

  <!-- Modal de Informações de Contato -->
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
