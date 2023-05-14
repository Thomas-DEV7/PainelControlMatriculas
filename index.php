<?php
$dsn = 'mysql:host=localhost;dbname=crud';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão realizada com sucesso";
} catch(PDOException $e) {
    echo "Erro ao conectar: " . $e->getMessage();
}

// inserção

?>

<form method="post">
<p>Nome:</p><br>
<input type="text"><br><br>
<p>Email:</p> <br>
<input type="text"><br><br>
<input type="submit" value="Cadastrar">
</form>