<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Alterar Usuario</title>
  <link rel="stylesheet" href="../style.css" />
</head>
<body>
<?php
include 'menu.php';
?>
  <div class="container">
    <p2>Você pode alterar as informações abaixo</p2>
    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == '1'): ?>
      <div class="sucesso-msg">Senha alterada com sucesso!</div>
    <?php endif; ?>
    <?php if (isset($_GET['erro']) && $_GET['erro'] == '1'): ?>
      <div class="erro-msg">E-mail ou senha incorretos.</div>
    <?php endif; ?>
    <form method="POST" action="../controllers/backend.php">
      <input type="hidden" name="acao" value="alterarDados" />
      <div class="form-group">
        <label for="nome">Nome</label>
          <?php
          session_start();
          $usuario = $_SESSION['usuario'];
          ?>
        <input id="nomeNovo" type="text" name="nomeNovo" placeholder="Novo Nome" value="<?php echo $usuario['nome']; ?>"/>
      </div>
      <div class="form-group">
        <label for="emailNovo">E-mail</label>
        <input id="emailNovo" type="email" name="emailNovo" placeholder="Novo E-mail"/>
      </div>
      <div class="form-group">
        <label for="senhaNova">Senha</label>
        <input id="senhaNova" type="password" name="senhaNova" placeholder="Nova Senha"/>
      </div>
      <p>Confirme seus dados atuais</p>
      <div class="form-group">
        <label for="email">E-mail Atual</label>
        <input id="email" type="email" name="email" required placeholder="E-mail"/>
      </div>
      <div class="form-group">
        <label for="senha">Senha Atual</label>
        <input id="senha" type="password" name="senha" required placeholder="Senha"/>
      </div>
      <button class="btn">Atualizar Dados</button>
    </form>
    <a href="../controllers/backend.php?acao=sair" class="btn">Sair</a>
  </div>
</body>
</html>