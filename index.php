<?php
include_once('conn.php');

//deletar aluno
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $pdo->exec("DELETE FROM alunos WHERE id=$id");

}

// inserção
if(isset($_POST['nome'])){
    $sql = $pdo->prepare("INSERT INTO alunos VALUES (null, ?,?)");
    $sql->execute(array($_POST['nome'], $_POST['email']));
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
      <h2>Dados cadastrados:</h2>
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
          foreach($alunos as $a => $linha){
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
</body>
</html>