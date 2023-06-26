<?php
include_once('../conn.php');
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: index.php'); // Redirecionar para a página de login
  $_SESSION['login_error'] = 'Sessão expirada, faça o login novamente!';
  exit();
}

//deletar aluno
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $pdo->exec("DELETE FROM alunos WHERE id=$id");
  echo "<br>deletado: " . $id;
  if ($id) {
    $_SESSION['delete_message'] = 'Usuário deletado:' . $id;
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); // Encerra o script para evitar que o restante do código seja executado
  }
}

// inserção
if (isset($_POST['nome'])) {
  $sql = $pdo->prepare("INSERT INTO alunos VALUES (null, ?,?)");
  $sql->execute(array($_POST['nome'], $_POST['email']));
  if ($sql) {
    $_SESSION['success_message'] = 'Usuário cadastrado com sucesso: '. $_POST['nome'];
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit(); // Encerra o script para evitar que o restante do código seja executado
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Formulário de Cadastro</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
  <div class="container mt-5">
    <?php
    if (isset($_SESSION['success_message'])) {
      // Exibe o alerta de sucesso
      echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';

      // Remove a variável de sessão após exibir o alerta
      unset($_SESSION['success_message']);
    }
    if (isset($_SESSION['delete_message'])) {
      // Exibe o alerta de sucesso
      echo '<div class="alert alert-success" role="alert">' . $_SESSION['delete_message'] . '</div>';

      // Remove a variável de sessão após exibir o alerta
      unset($_SESSION['delete_message']);
    }
    ?>
    <form method="post">
      <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
      </div>
      <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <div class="mt-5">
      <h2><a href="./dashboard.php"><ion-icon name="arrow-back-outline"></ion-icon></a>Dados cadastrados:</h2>
      <table class="table">
        <thead>
          <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = $pdo->prepare("SELECT * FROM alunos");
          $sql->execute();
          $alunos = $sql->fetchAll();
          foreach ($alunos as $a => $linha) {
            echo '<tr>';
            echo '<td>' . $linha['nome'] . '</td>';
            echo '<td>' . $linha['email'] . '</td>';
            echo '<td>';
            echo '<a href="editar.php?id=' . $linha['id'] . '"><i class="fas fa-edit"></i></a>';
            echo '<a href="?delete=' . $linha['id'] . '"><i class="fas fa-trash-alt ml-2"></i></a>';
            echo '</td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>