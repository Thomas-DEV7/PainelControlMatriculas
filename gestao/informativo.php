<?php
include_once '../conn.php';

session_start(); // Inicia a sessão (certifique-se de chamar isso antes de qualquer saída)
if (isset($_POST['titulo'])) {
    $dataHoraPost = date('Y-m-d H:i:s');
    $sql = $pdo->prepare("INSERT INTO post VALUES (null, ?,?,?)");
    $sql->execute(array($_POST['titulo'], $_POST['conteudo'], $dataHoraPost));
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
                        <h2><ion-icon name="add-outline"></ion-icon>Nova publicação</h2>
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
                                            <h5 class="modal-title" id="exampleModalLabel">Título do Modal</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Conteúdo do modal...</p>
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