<!--feito por leandro-->
<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: /views/login.php");
    exit;
}

$usuario = $_SESSION['usuario'];

if ($usuario['categoria'] === 'Funcionario') {
    header("Location: /views/painelTecnico.php");
    exit;
}

if ($usuario['categoria'] === 'Cliente') {
    header("Location: /views/painelUsuario.php");
    exit;
}
?>

