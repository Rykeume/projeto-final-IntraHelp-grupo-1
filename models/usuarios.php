<?php 
require_once dirname(__DIR__) . '/utils/connect.php';
require_once dirname(__DIR__) . '/utils/validacoes.php';

function cadastrarUsuario($nome, $senha, $email, $categoria){

    if (usuarioPorEmail($email)){
        return false;
    }

    inserirUsuario($nome, $senha, $email, $categoria);
    return true;
}

function inserirUsuario($nome, $senha, $email, $categoria){
    $pdo = conectarDB();
    $sql = 'INSERT INTO usuarios(nome, senha, email, categoria) values (:nome,:senha,:email,:categoria)';
    $stmt = $pdo->prepare($sql);
    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    try{
        $stmt->execute([
            ':nome' => $nome,
            ':senha' => $senhaCriptografada,
            ':email' => $email,
            ':categoria' => $categoria]
        );
    }catch(\PDOException $e){
        echo $e->getMessage();
        return false;
    }
    return true;
}

function atualizarSenha($email, $senha){
    $usuario = usuarioPorEmail( $email );
    $pdo = conectarDB();
    $sql = 'UPDATE usuarios SET senha = :senha WHERE usuario_id = :id';
    $stmt = $pdo->prepare($sql);
    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    try{
        $stmt->execute([
            ':senha' => $senhaCriptografada,
            ':id' => $usuario['usuario_id']
            ]
        );
        return true;
    }catch(\PDOException $e){
        echo $e->getMessage();
        return false;
    }
}

function todosUsuarios(){
    $pdo = conectarDB();
    $sql = 'SELECT * from usuarios';
    $stmt = $pdo -> query($sql);
    $usuarios = $stmt->fetchAll(\PDO::FETCH_ASSOC);
   
    return $usuarios;
}

function usuarioPorId($id){
    $pdo = conectarDB();
    $sql = 'SELECT * from usuarios WHERE usuario_id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    return $usuario;
}

function usuarioPorEmail($email){
    $pdo = conectarDB();
    $sql = 'SELECT * from usuarios WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    return $usuario;
}

function deletarUsuario($id){
    $pdo = conectarDB();
    $sql = 'DELETE FROM usuarios WHERE usuario_id = :id';
    $stmt = $pdo -> prepare($sql);
    $stmt-> execute([
        ':id' => $id
    ]);
}

function atualizarDados($nomeNovo, $emailNovo, $senhaNova, $email, $senha){
    if (!validarCredenciais($email, $senha)) {
        return false;
    }

    $usuario = usuarioPorEmail( $email );

    if (empty($nomeNovo)){
        $nomeNovo = $usuario['nome'];
    }

    if (empty($senhaNova)){
        $senhaNova = $usuario['senha'];
    }

    if (empty($emailNovo)){
        $emailNovo = $usuario['email'];
    }

    $pdo = conectarDB();
    $sql = 'UPDATE usuarios SET nome = :nomeNovo, email = :emailNovo,
            senha = :senhaNova WHERE usuario_id = :id';
    $stmt = $pdo->prepare($sql);
    $senhaCriptografada = password_hash($senhaNova, PASSWORD_DEFAULT);

    try{
        $stmt->execute([
            ':nomeNovo' => $nomeNovo,
            ':emailNovo'=> $emailNovo,
            ':senhaNova' => $senhaCriptografada,
            ':id' => $usuario['usuario_id']
            ]
        );
        return true;
    }catch(\PDOException $e){
        echo $e->getMessage();
        return false;
    }
}