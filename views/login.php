<!--feito por leandro-->
<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    if ($usuario['categoria'] === 'Funcionario') {
        header("Location: ../views/paginaTecnico.php");
        exit;
    }

    if ($usuario['categoria'] === 'Cliente') {
        header("Location: ../views/painelUsuario.php");
        exit;
    }
}
?>
<!--fim-->

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Login</title>
  <link rel="stylesheet" href="../theme.css">
  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>

<?php include 'menu.php'; ?>

<div class="main-content">
  <div class="container">

    <h2>Login IntraHelp</h2>

    <div class="container_p">
      <p id="solicitacao_p">Informe seus dados para acessar o sistema.</p>
    </div>

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

      <div class="form-group">
        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" required placeholder="E-mail" />
      </div>

      <div class="form-group">
        <label for="senha">Senha</label>
        <input id="senha" type="password" name="senha" required placeholder="Senha" />
      </div>

      <button class="btn" type="submit">Entrar</button>
    </form>

    <div class="link">
      <a href="recuperarSenha.php">Esqueci minha senha</a>
    </div>

    <div class="link">
      <p>Se não possui acesso, solicite um cadastro!</p>
    </div>

  </div>
</div>

</body>
</html>