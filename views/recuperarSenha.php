<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Recuperar Senha</title>
  <link rel="stylesheet" href="../style.css" />
</head>
<body>
<?php
include 'menu.php';
?>
  <div class="container">
    <h2>Recuperar Senha</h2>
    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == '1'): ?>
      <div class="sucesso-msg">Senha alterada com sucesso!</div>
    <?php endif; ?>
    <?php if (isset($_GET['erro']) && $_GET['erro'] == '1'): ?>
      <div class="erro-msg">E-mail ou senha incorretos.</div>
    <?php endif; ?>
    <form method="POST" action="../controllers/backend.php">
      <input type="hidden" name="acao" value="recuperarSenha" />
      <div class="form-group">
        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" required placeholder="E-mail"/>
      </div>
      <div class="form-group">
        <label for="senha">Senha</label>
        <input id="senha" type="password" name="senha" required placeholder="Senha"/>
      </div>
      <button class="btn">Atualizar Senha</button>
    </form>
    <div class="link"><a href="login.php" >Já tem uma conta? Faça login</a></div>
    <div class="link"><a href="cadastro.php" >Não tem uma conta? Cadastre-se</a></div>
  </div>
</body>
</html>