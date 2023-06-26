<?php
include_once '../conn.php';
session_start();

if (isset($_POST['email'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Consulta para verificar as credenciais do usuário
  $sql = $pdo->prepare("SELECT * FROM user WHERE email = ?");
  $sql->execute([$email]);
  $user = $sql->fetch();

  // Verifique se o usuário existe e a senha está correta
  if ($user && $password = $user['senha']) {
    // Autenticação bem-sucedida
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user'] = $user['usuario'];
    echo $_SESSION['user'];
    header('Location: dashboard.php'); // Redirecionar para a página de dashboard ou página protegida
    exit();
  } else {
    // Autenticação falhou
    $_SESSION['login_error'] = 'Credenciais inválidas';
    header('Location: index.php'); // Redirecionar de volta para a página de login
    exit();
  }
}

// // Função para criar o hash da senha antes de armazená-la no banco de dados
// function createPasswordHash($password) {
//   return password_hash($password, PASSWORD_DEFAULT);
// }




?>
<!DOCTYPE html>
<html>

<head>
  <title>Tela de Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    html,
    body {
      height: 100%;
    }

    body {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      border-radius: 20px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-center align-items-center">

              <img src="../assets/img/logo_esoficial.png" height="100">
            </div>
            <br>
            <h2 class="text-center">Área exclusiva para gestores</h2>
            <?php
              if (isset($_SESSION['login_error'])) {
                // Exibe o alerta de sucesso
                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['login_error'] . '</div>';

                // Remove a variável de sessão após exibir o alerta
                unset($_SESSION['login_error']);
            }
            ?>
          </div>

          <div class="card-body">
            <form method="post" action="index.php">
              <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Informe seu email">
              </div>
              <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Senha:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Informe sua senha">
              </div>
              <button type="submit" class="btn btn-success btn-block"><i class="fas fa-sign-in-alt"></i> Entrar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>