<?php
include_once '../conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirecionar para a página de login
    $_SESSION['login_error'] = 'Faça login para acessar a gestão do ES OFICIAL';
    exit();
}
$sql = $pdo->prepare("SELECT COUNT(*) AS total FROM user");
$sql->execute();
$result = $sql->fetch();
$totalUsers = $result['total'];

// Consulta para obter o número total de posts
$sqlPosts = $pdo->prepare("SELECT COUNT(*) AS totalPosts FROM post");
$sqlPosts->execute();
$resultPosts = $sqlPosts->fetch();
$totalPosts = $resultPosts['totalPosts'];

// Consulta para obter o número total de alunos
$sqlAlunos = $pdo->prepare("SELECT COUNT(*) AS totalAlunos FROM alunos");
$sqlAlunos->execute();
$resultAlunos = $sqlAlunos->fetch();
$totalAlunos = $resultAlunos['totalAlunos'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos adicionais, se necessário */
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">Dashboard</span>
        <span class="navbar-text">Bem-vindo, <?php echo $_SESSION['user']; ?>!</span>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total de Usuários</h5>
                        <p class="card-text"><?php echo $totalUsers; ?></p>
                        <a href="./informativo.php" class="btn btn-light"><ion-icon name="construct-outline"></ion-icon></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total de Posts</h5>
                        <p class="card-text"><?php echo $totalPosts; ?></p>
                        <a href="pagina2.php" class="btn btn-light"><ion-icon name="construct-outline"></ion-icon></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total de Alunos</h5>
                        <p class="card-text"><?php echo $totalAlunos; ?></p>
                        <a href="./alunos.php" class="btn btn-light"><ion-icon name="construct-outline"></ion-icon></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>