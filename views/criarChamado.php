<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit;
}
$usuario = $_SESSION['usuario'];
session_write_close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Novo Chamado</title>
  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
<?php
include 'menu.php';
?>
  <div class="container">
    <div style="text-align: left;">
        <a href="painel.php" style="text-decoration: none; color: var(--text-secondary); display: flex; align-items: center; margin-bottom: 20px;">
            <span class="material-symbols-outlined">arrow_back</span> Voltar
        </a>
    </div>

    <h2>Abrir Solicitação</h2>
    <p>Descreva o problema detalhadamente.</p>

    <?php if (isset($_GET['erro'])): ?>
      <div class="erro-msg">Houve um erro ao tentar criar o chamado. Tente novamente.</div>
    <?php endif; ?>

    <form method="POST" action="../controllers/backend.php">
      <input type="hidden" name="acao" value="criarChamado" />
      
      <div class="form-group">
        <label for="titulo">Assunto</label>
        <input id="titulo" type="text" name="titulo" required placeholder="Ex: Erro ao logar" />
      </div>

      <div class="form-group">
        <label for="prioridade">Prioridade</label>
        <select name="prioridade" id="prioridade">
            <option value="Baixa">Baixa</option>
            <option value="Media" selected>Média</option>
            <option value="Alta">Alta</option>
        </select>
      </div>

      <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="4" required placeholder="O que aconteceu?"></textarea>
      </div>

      <button class="btn">Enviar Solicitação</button>
    </form>
  </div>
</body>
</html>