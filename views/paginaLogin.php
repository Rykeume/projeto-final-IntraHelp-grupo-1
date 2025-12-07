<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Login</title>
  <link rel="stylesheet" href="../style.css" />
</head>
<body>
  <div class="container">
    <h2>Entrar</h2>
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
      <div id="lembrar-email">
        <label>Lembrar Email</label>
        <input type="checkbox" name="lembrar" value="1" <?= isset($_COOKIE['email_salvo']) ? 'checked' : '' ?>>
      </div>
      <input type="hidden" name="acao" value="login" />
      <div class="form-group">
        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" required placeholder="E-mail" value="<?php echo isset($_COOKIE['email_salvo']) ? $_COOKIE['email_salvo'] : ''; ?>"/>
      </div>
      <div class="form-group">
        <label for="senha">Senha</label>
        <input id="senha" type="password" name="senha" required placeholder="Senha"/>
      </div>
      <button class="btn">Entrar</button>
    </form>
    <div class="link"><a href="recuperarSenha.php" >Esqueci minha senha!</a></div>
    <div class="link"><a href="cadastro.php" >Não tem uma conta? Cadastre-se</a></div>
  </div>
</body>
</html>