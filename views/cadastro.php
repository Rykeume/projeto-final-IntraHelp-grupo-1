<?php
session_start();
require_once dirname(__DIR__) . '/utils/validacoes.php';

if (!eUsuarioLogado()){
    header("Location: /views/login.php");
    exit;
}

$usuario = $_SESSION['usuario'];

if ($usuario['categoria'] === 'Cliente') {
    header("Location: /views/painelUsuario.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Cadastrar</title>
  <link rel="stylesheet" href="../theme.css">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../forms.css">
  <link rel="stylesheet" href="cadastro.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!--Parte feita por Mahienny-->
</head>
<body>
<?php
include 'menu.php';
?>
<div class="main-content">
  <div class="container">

    <div class="back_arrow_container">
      <a href="javascript:history.back()" class="back_arrow">
        <span class="material-symbols-outlined">arrow_back</span> Voltar
      </a>
    </div>
    <div class="form-header">
      <h2>Cadastrar Usuário na IntraHelp</h2>
    </div>
    <div class="container_p">
      <p id="solicitacao_p">Preencha os dados para cadastrar um novo usuário.</p>
    </div>

    <?php if (isset($_GET['erro']) && $_GET['erro'] == '1'): ?>
      <div class="erro-msg">Este e-mail já está cadastrado.</div>
    <?php endif; ?>
    <?php if (isset($_GET['erro']) && $_GET['erro'] == '2'): ?>
      <div class="erro-msg">Este e-mail é inválido.</div>
    <?php endif; ?>
    <?php if (isset($_GET['erro']) && $_GET['erro'] == '3'): ?>
      <div class="erro-msg">O nome informado possui caracteres inválidos.</div>
    <?php endif; ?>

    <form method="POST" action="../controllers/backend.php">
      <input type="hidden" name="acao" value="cadastrar" />

      <div class="form-group">
        <label>Tipo de usuário</label>
        <div class="tipo-usuario">
          <label><input type="radio" name="categoria" value="Cliente" required> Cliente</label>
          <label><input type="radio" name="categoria" value="Funcionario"> Funcionário</label>
        </div>
      </div>

      <div class="form-group">
        <label for="nome">Nome completo</label>
        <input id="nome" type="text" name="nome" required placeholder="Nome completo" />
      </div>

      <div class="form-group">
        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" required placeholder="E-mail" />
      </div>

      <div class="form-group">
        <label for="senha">Senha</label>
        <input id="senha" type="password" name="senha" required minlength="6" placeholder="Senha (mín. 6 caracteres)" />
      </div>

      <button class="btn" type="submit">Cadastrar</button>
    </form>

  </div>
</div>
</body>
</html>