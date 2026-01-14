<!--feito por leandro-->
<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: /views/login.php");
    exit;
}

$usuario = $_SESSION['usuario'];

if ($usuario['categoria'] === 'Funcionario') {
    header("Location: /views/relatorio.php");
    exit;
}

if ($usuario['categoria'] === 'Cliente') {
    header("Location: /views/painel.php");
    exit;
}
?>
<!-- fim -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>login</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container">
    <div class="btn">
        <a href="views/login.php">acessar página de login</a>
    </div>
</div>
</body>
</html>
