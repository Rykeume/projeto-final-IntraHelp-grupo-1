<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Cadastrar</title>
  <link rel="stylesheet" href="../style.css" />
</head>
<body>
  <div class="container">
    <h2>Cadastrar</h2>
    <?php if (isset($_GET['erro']) && $_GET['erro'] == '1'): ?>
      <div class="erro-msg">Este e-mail já está cadastrado.</div>
    <?php endif; ?>
    <?php if (isset($_GET['erro']) && $_GET['erro'] == '2'): ?>
      <div class="erro-msg">Este e-mail é inválido.</div>
    <?php endif; ?>
    <?php if (isset($_GET['erro']) && $_GET['erro'] == '3'): ?>
      <div class="erro-msg">O nome informado possui caracteres inválidos.</div>
    <?php endif; ?>
    <?php if (isset($_GET['erro']) && $_GET['erro'] == '4'): ?>
      <div class="erro-msg">Você precisa estar logado para cadastrar um usuário</div>
    <?php endif; ?>
    <form method="POST" action="../controllers/backend.php">
      <input type="hidden" name="acao" value="cadastrar" />
      <div class="tipo-usuario">
        <div>
          <label for="Cliente">Cliente</label>
        <input type="radio" name="categoria" value="Cliente">
        </div>
        <div>
          <label for="Funcionario">Funcionario</label>
        <input type="radio" name="categoria" value="Funcionario">
        </div>
      </div>
      <div class="form-group">
        <label for="nome">Nome completo</label>
        <input id="nome" type="text" name="nome" required placeholder="Nome Completo"/>
      </div>
      <div class="form-group">
        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" required placeholder="E-mail"/>
      </div>
      <div class="form-group">
        <label for="senha">Senha</label>
        <input id="senha" type="password" name="senha" required minlength="6" placeholder="Senha (min. 6 caracteres)" />
      </div>
      <button class="btn">Cadastrar</button>
    </form>
    <div class="link"><a href="paginaLogin.php" >Já tem uma conta? Faça login</a></div>
  </div>
</body>
</html>