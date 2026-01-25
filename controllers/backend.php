<?php
date_default_timezone_set('America/Sao_Paulo');
require_once dirname(__DIR__) . '/models/chamados.php';
require_once dirname(__DIR__) . '/utils/login.php';
require_once dirname(__DIR__) . '/utils/validacoes.php';
require_once dirname(__DIR__) . '/models/logChamados.php';
require_once dirname(__DIR__) . '/models/usuarios.php';

$post = $_POST['acao'];
$req = $_SERVER['REQUEST_METHOD'];


if ($req === 'POST' && $post === 'cadastrar') {
    session_start();
    $usuario = $_SESSION['usuario'];
    session_write_close();

    if (!isset($usuario) || $usuario['categoria'] !== 'Funcionario'){
        header("Location: ../views/cadastro.php?erro=4");
        exit;
    }

    $senha = $_POST['senha'];
    $categoria = $_POST['categoria'];
    
    if (!validarNome($_POST['nome'])){
        header("Location: ../views/cadastro.php?erro=3");
        exit;
    }
    $nome = $_POST['nome'];
    if (!validarEmail($_POST['email'])){
        header("Location:  ../views/cadastro.php?erro=2");
        exit;
    }
    $email = $_POST['email'];
    if(!isset($_POST['categoria'])){
        $categoria = "Cliente";
    }

    if (cadastrarUsuario($nome, $senha, $email, $categoria)){
        header("Location: ../views/login.php?sucesso=1");
        exit;
    }else{
        header("Location: ../views/cadastro.php?erro=1");
        exit;
    }
}

if ($req === 'POST' && $post === 'login') {
    if (validarEmail($_POST['email'])){
        header("Location: ../views/login.php?erro=1");
    }
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (login($email, $senha)){
        $usuario = $_SESSION['usuario'];

        if ($usuario['categoria'] === 'Funcionario'){
            header("Location: ../views/painelTecnico.php");    
        } else{
            header("Location: ../views/painelUsuario.php");
        }
    }else{
        header("Location: ../views/login.php?erro=1");
    };
    exit;
}
if ($req === 'POST' && $post === 'recuperarSenha') {
    if (!validarEmail($_POST['email'])){
        header("Location: ../views/recuperarSenha.php?erro=1");
    }
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (atualizarSenha($email,$senha)){
        header("Location: ../views/recuperarSenha.php?sucesso=1");
    }else{
        header("Location: ../views/recuperarSenha.php?erro=1");
    };
    exit;
}

if ($req === 'POST' && $post === 'alterarDados') {
    if (!validarEmail($_POST['email'])){
        header("Location: ../views/alterarUsuario.php?erro=1");
    }
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $emailNovo = $_POST['emailNovo'];
    $senhaNova = $_POST['senhaNova'];
    $nome = $_POST['nomeNovo'];

    if (empty($senhaNova)) {
        $senhaNova = $senha;
    }
    if(empty($emailNovo)){
        $emailNovo = $email;
    }
    if (atualizarDados($nome, $emailNovo, $senhaNova, $email, $senha)){
        header("Location: ../views/alterarUsuario.php?sucesso=1");
    }else{
        header("Location: ../views/alterarUsuario.php?erro=1");
    };
    exit;
}

if($req === 'POST' && $post === 'criarChamado'){
    session_start();
    $usuario = $_SESSION['usuario'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $prioridade = $_POST['prioridade'];
    if(criarChamado($usuario['usuario_id'], $descricao, 2, $prioridade, $titulo)){
        header("Location: ../views/painelUsuario.php?sucesso=1");
    }
    else{
        header("Location: ../views/painelUsuario.php?erro=1");
    }
}

if($req === 'POST' && $post === 'atualizarChamado'){
    session_start();
    $idResponsavelSessao = $_SESSION['usuario']['usuario_id'];
    $idResponsavel = $_POST['responsavel_id'];
    $idChamado = $_POST['chamado_id'];
    $status = $_POST['status'];
    $prioridade = $_POST['prioridade'];
    $comentario = $_POST['comentario'] ?? '';

    if ($idResponsavelSessao !== 2 && $idResponsavel !== $idResponsavelSessao){
        header("Location: ../views/VerChamado.php?id=" . $idChamado . "&erro=2");
        exit();
    }

    if(atualizarChamado($idChamado, $status ,$idResponsavel, $prioridade)){
        criarLog($idChamado, $status ,$idResponsavel, $prioridade, $comentario);
        header("Location: ../views/VerChamado.php?id=" . $idChamado . "&sucesso=1");
        exit();
    }
    else{
        header("Location: ../views/VerChamado.php?id=" . $idChamado . "&erro=1");
        exit();
    }
}

if (isset($_GET['acao']) && $_GET['acao'] === 'sair') {
    logout();
}
?>