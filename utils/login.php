<?php 
require_once dirname(__DIR__) . '/models/usuarios.php';
require_once dirname(__DIR__) . '/utils/validacoes.php';

function login($email, $senha) {
    $usuario = usuarioPorEmail($email);
    session_start();

    if (!validarCredenciais($email, $senha)) {
        return false;
    }

    $_SESSION['usuario'] = $usuario;
    session_write_close();

    if (isset($_POST['lembrar'])) {
        setcookie('email_salvo', $email, time() + (86400 * 30), "/");
    } else {
        setcookie('email_salvo', '', time() - 3600, "/");
    }
    return true;
}

function logout() {
    session_start();
    session_destroy();
    header("Location: /views/login.php?logout=1");
    exit();
}