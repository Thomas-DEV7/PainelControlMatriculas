<?php
include_once '../conn.php';

session_start(); // Inicia a sessão (certifique-se de chamar isso antes de qualquer saída)

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirecionar para a página de login
    $_SESSION['login_error'] = 'Sessão expirada, faça o login novamente!';
    exit();
}

//deletar aluno
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $pdo->exec("DELETE FROM post WHERE id=$id");
    echo "<br>deletado: ".$id;
    if ($id) {
        $_SESSION['delete_message'] = 'Usuário deletado:'.$id;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit(); // Encerra o script para evitar que o restante do código seja executado
    }

}

if (isset($_POST['titulo'])) {
    $dataHoraPost = date('Y-m-d H:i:s');
    $nm_session = $_SESSION['user'];
    $sql = $pdo->prepare("INSERT INTO post VALUES (null, ?,?,?,?)");
    $sql->execute(array($_POST['titulo'], $_POST['conteudo'], $dataHoraPost, $nm_session));
    if ($sql) {
        $_SESSION['success_message'] = 'Inserção realizada com sucesso';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit(); // Encerra o script para evitar que o restante do código seja executado
    }
}





?>
<!DOCTYPE html>
<html>

<head>
    <title>Ala de informativos | restrito</title>
    <!-- imports CSS and Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">

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

        h2 {
            display: flex;
            align-items: center;
        }

        ion-icon {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2><a href="./dashboard.php"><ion-icon name="arrow-back-outline"></ion-icon></a> Nova publicação</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="informativo.php">
                            <?php

                            // Verifica se a variável de sessão existe e contém uma mensagem de sucesso
                            if (isset($_SESSION['success_message'])) {
                                // Exibe o alerta de sucesso
                                echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';

                                // Remove a variável de sessão após exibir o alerta
                                unset($_SESSION['success_message']);
                            }
                            
                            if (isset($_SESSION['delete_message'])) {
                                // Exibe o alerta de sucesso
                                echo '<div class="alert alert-warning" role="alert">' . $_SESSION['delete_message'] . '</div>';

                                // Remove a variável de sessão após exibir o alerta
                                unset($_SESSION['delete_message']);
                            }

                            ?>
                            <div class="form-group">
                                <label><ion-icon name="document-text-outline"></ion-icon> Titulo:</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Informe o titulo" required>
                            </div>
                            <div class="form-group">
                                <label><ion-icon name="file-tray-full-outline"></ion-icon> Conteúdo:</label>
                                <textarea name="conteudo" id="conteudo" cols="30" class="form-control" rows="10"></textarea>
                            </div>
                            <button type="submit m-2" class="btn btn-success btn-lg"><ion-icon name="cloud-upload-outline"></ion-icon>Publicar</button>
                            <!-- Modal para excluir/gerenciar -->
                            <button type="button" class="btn btn-outline-danger btn-lg m-2" data-bs-toggle="modal" data-bs-target="#meuModal">Gerenciar publicações</button>
                            <div class="modal fade" id="meuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Gerenciar posts</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            $sql = $pdo->prepare("SELECT * FROM post");
                                            $sql->execute();
                                            $post = $sql->fetchAll();
                                            $conta = count($post);
                                            
                                            foreach ($post as $a => $linha) {
                                                echo '<div class="row mb-3">';
                                                echo '<div class="col-12 d-flex align-items-center">'; // Adiciona as classes "d-flex" e "align-items-center"
                                                echo '<table class="table table-striped">';
                                                echo '<tr>';

                                                echo '<a href="?delete=' . $linha['id'] . '"><ion-icon name="trash-outline"></ion-icon></a>';
                                                echo '<td>' . $linha['titulo'] . '</td>';
                                                echo '<td>';

                                                echo '</td>';
                                                echo '</tr>';
                                                echo '</table>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                            ?>
                                        </div>




                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>

    <!-- imports Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>