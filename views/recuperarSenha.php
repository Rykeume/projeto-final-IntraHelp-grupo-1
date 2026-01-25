<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Recuperar Senha</title>
  <link rel="stylesheet" href="../theme.css">
  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="../forms.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
<?php include 'menu.php'; ?>

<div class="main-content">
  <div class="container">

    <div class="back_arrow_container">
      <a href="javascript:history.back()" class="back_arrow">
        <span class="material-symbols-outlined">arrow_back</span> Voltar
      </a>
    </div>

    <div class="form-header">
      <h2>Recuperar Senha</h2>
    </div>

    <div class="container_p">
      <p id="solicitacao_p">Informe seu e-mail e defina uma nova senha.</p>
    </div>

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
        <input id="email" type="email" name="email" required placeholder="E-mail" />
      </div>

      <div class="form-group">
        <label for="senha">Nova senha</label>
        <input id="senha" type="password" name="senha" required placeholder="Nova senha" />
      </div>

      <button class="btn" type="submit">Atualizar Senha</button>
    </form>

    <div class="link">
      <a href="login.php">Já tem uma conta? Faça login</a>
    </div>

    <div class="link">
      <p>Se não possui acesso, solicite um cadastro!</p>
    </div>

  </div>
</div>

</body>
</html>
