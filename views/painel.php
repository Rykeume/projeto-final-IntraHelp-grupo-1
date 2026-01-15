<?php
    session_start();
    $usuario = $_SESSION['usuario'];

    //leandro
if ($usuario['categoria'] === 'Funcionario')
    header("Location: /views/relatorio.php");
if (!isset($_SESSION['usuario'])) {
    header("Location: /views/login.php");
}
    //fim


    session_write_close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
include 'menu.php';
?>
    <div class="container">
        <h1>Bem vindo, <?= htmlspecialchars($usuario['nome']) ?>!</h1>
        <div class="link"><a href="alterarUsuario.php" >Alterar Dados e Credenciais</a></div>
        <div class="link"><a href="criarChamado.php" >Criar um chamado</a></div>
        <div class="link"><a href="listarChamados.php" >Meus chamados</a></div>
        <a href="../controllers/backend.php?acao=sair" class="btn">Sair</a>
    </div>
</body>
</html>