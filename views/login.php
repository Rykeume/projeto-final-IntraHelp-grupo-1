<!--feito por leandro-->
<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    if ($usuario['categoria'] === 'Funcionario') {
        header("Location: ../views/relatorio.php");
        exit;
    }

    if ($usuario['categoria'] === 'Cliente') {
        header("Location: ../views/painel.php");
        exit;
    }
}
?>
<!--fim-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/estilo-global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <!--Feito por Mahienny-->

    <?php
    include 'menu.php';
    ?>

    <div class="container">
        <h2>Login Intra-Help</h2>

        <?php if (isset($_GET['logout']) && $_GET['logout'] == '1'): ?>
          <div class="sucesso-msg">Sessão encerrada com sucesso.</div>
        <?php endif; ?>
        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == '1'): ?>
            <div class="sucesso-msg">Cadastro realizado com sucesso! Faça login abaixo.</div>
        <?php endif; ?>
        <?php if (isset($_GET['erro']) && $_GET['erro'] == '1'): ?>
            <div class="erro-msg">E-mail ou senha incorretos.</div>
        <?php endif; ?>

        <form method="POST" action="../controllers/backend.php">
            <input type="hidden" name="acao" value="login" />
            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="E-mail" required>
            </div>

            <div class="input-group">
               <i class="fa-solid fa-lock"></i>
                <input type="password" name="senha" placeholder="Senha" required>
            </div>

            <button type="submit">Entrar</button>
        </form>
        <a href="recuperarSenha.php" >Esqueci minha senha!</a>
        <a href="cadastro.php">Ainda não possui cadastro?</a>
    </div>

</body>

</html>