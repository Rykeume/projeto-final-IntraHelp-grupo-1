<?php

function validarEmail($email){
    if (empty($email)){
        return false;
    }
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return false;
    }
    return true;
}

function validarNome($nome){
    if (empty($nome)){
        return false;
    }
    if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)){
        return false;
    }
    return true;
}

function eUsuarioLogado(){
    session_start();
    if (empty($_SESSION['usuario']) || !isset( $_SESSION['usuario'] )) {
        return false;
    };
    session_write_close();
    return true;
}

function validarCredenciais($email, $senha){
    $usuario = usuarioPorEmail( $email );
    
    if (!$usuario || !password_verify($senha, $usuario['senha'])) {
        $_SESSION['error'] = 'Credenciais inválidas.';
        return false;
    }
    return true;
}