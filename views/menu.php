<?php
require_once dirname(__DIR__) . '/utils/validacoes.php';

$funcao = null;

if(eUsuarioLogado()){
    $funcao = $_SESSION['usuario']['categoria'];
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./menu.css">
</head>
<body>

    <!--Feito por Mahienny-->

<nav>
    <?php if ($funcao == "Funcionario"): ?>
        <h3>Intra-Help | Painel Administrativo</h3>
        <div class="nav-links">
            <a href="painelUsuario.php" class="active">Meus Chamados</a>
            <a href="painelTecnico.php" class="active">Gerenciar Chamados</a>
            <a href="relatorio.php">Gerenciar Usuários</a>
            <a href="cadastro.php">Cadastro</a>
            <a href="alterarUsuario.php">Alterar Dados</a>
            <a href="../controllers/backend.php?acao=sair">Sair</a>
        </div>

    <?php elseif ($funcao == "Cliente"):?>
        <h3>Intra-Help | Área do Usuário</h3>
        <div class="nav-links">
            <a href="painelUsuario.php" class="active">Meus Chamados</a>
            <a href="criarChamado.php">Novo Chamado</a>
            <a href="alterarUsuario.php">Alterar Dados</a>
            <!-- <a href="recuperarSenha.php">Recuperar Senha</a> -->
            <a href="../controllers/backend.php?acao=sair">Sair</a>
        </div>

    <?php else: ?>
        <h3>Bem vindo(a) a Intra-Help</h3>
        <div class="nav-links">
            <a href="painel.php">Home</a>
            <a href="#">Contato</a>
            <a href="cadastro.php">Solicitar Cadastro</a>
        </div>
    <?php endif; ?>
</nav>
</body>

</html>
