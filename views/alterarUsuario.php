<?php
session_start();
require_once dirname(__DIR__) . '/utils/validacoes.php';

if (!eUsuarioLogado()){
    header("Location: /views/login.php");
    exit;
}
$usuario = $_SESSION['usuario'];
session_write_close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Alterar Usuario</title>
  <link rel="stylesheet" href="../theme.css">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../forms.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
      <h2>Alterar Dados do Perfil</h2>
    </div>
    <div class="container_p">
      <p id="solicitacao_p">Você pode alterar as informações abaixo</p>
    </div>

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
      
      <div class="container_p">
        <p id="solicitacao_p">Confirme seus dados atuais!</p>
      </div>

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
  </div>
</div>
</body>
</html>