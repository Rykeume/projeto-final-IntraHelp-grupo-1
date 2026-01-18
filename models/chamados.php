<?php
require_once dirname(__DIR__). "/utils/connect.php";
function todosChamados(){
    $pdo = conectarDB();
    $sql = "SELECT c.numero, u.nome as solicitante, c.descricao, us.nome as responsavel, c.status, c.data_criacao, c.prioridade, c.titulo 
            FROM chamados c
            INNER JOIN usuarios u
            ON solicitante_id = u.usuario_id
            INNER JOIN usuarios us
            ON responsavel_id = us.usuario_id;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function contagemTodosChamadosPorStatus(){
    $pdo = conectarDB();
    $sql = "SELECT status, count(status) as Total FROM chamados c
            GROUP BY status";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function contagemTodosChamados() : int{
    $pdo = conectarDB();
    $sql = "SELECT COUNT(status) as Total FROM chamados";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}

function contagemTodosChamadosPorSolicitante(){
    $pdo = conectarDB();
    $sql = "SELECT u.nome, c.status, COUNT(c.status) as Total 
            FROM chamados c
            INNER JOIN usuarios u ON u.usuario_id = c.solicitante_id
            GROUP BY c.solicitante_id;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function contagemTodosChamadosPorResponsavel(){
    $pdo = conectarDB();
    $sql = "SELECT u.nome, c.status, COUNT(c.status) as Total 
            FROM chamados c
            INNER JOIN usuarios u ON u.usuario_id = c.responsavel_id
            GROUP BY c.responsavel_id;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function chamadoPorId($idChamado){
    $pdo = conectarDB();
    $sql = "SELECT c.numero, u.nome as solicitante, c.descricao, us.nome as responsavel, c.status, c.data_criacao, c.prioridade FROM chamados c
            INNER JOIN usuarios u
            ON solicitante_id = u.usuario_id
            INNER JOIN usuarios us
            ON responsavel_id = us.usuario_id
            WHERE c.numero = :numero;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        [":numero"=> $idChamado]
    );
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function chamadosPorIdSolicitante($idSolicitante){
    $pdo = conectarDB();
    $sql = "SELECT c.numero, u.nome as solicitante, c.descricao, us.nome as responsavel, c.status, c.data_criacao, c.prioridade FROM chamados c
            INNER JOIN usuarios u
            ON solicitante_id = u.usuario_id
            INNER JOIN usuarios us
            ON responsavel_id = us.usuario_id
            WHERE c.solicitante_id = :solicitante_id;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        [":solicitante_id"=> $idSolicitante]
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function chamadosPorIdResponsavel($idResponsavel){
    $pdo = conectarDB();
    $sql = "SELECT c.numero, u.nome as solicitante, c.descricao, us.nome as responsavel, c.status, c.data_criacao, c.prioridade FROM chamados c
            INNER JOIN usuarios u
            ON solicitante_id = u.usuario_id
            INNER JOIN usuarios us
            ON responsavel_id = us.usuario_id
            WHERE c.responsavel_id = :responsavel_id;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        [":responsavel_id"=> $idResponsavel]
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function criarChamado($idSolicitante, $descricao, $idResponsavel, $prioridade, $titulo){
    $pdo = conectarDB();
    $sql = "INSERT INTO chamados (solicitante_id, descricao, responsavel_id, prioridade, titulo)
            VALUES (:solicitante_id, :descricao, :responsavel_id, :prioridade, :titulo);";
    $stmt = $pdo->prepare($sql);
    $resultado = false;

    try{
        $stmt->execute([
                ":solicitante_id" => $idSolicitante,
                ":descricao" => $descricao,
                ":responsavel_id"=> $idResponsavel,
                ":prioridade" => $prioridade,
                ":titulo" => $titulo
            ]
        );        
    $resultado = true;
    } catch(PDOException $e) {
        die($e->getMessage());
    }
    return $resultado;
}

function atualizarResponsavelChamado($idChamado, $idResponsavel){
    $pdo = conectarDB();
    $sql = "UPDATE chamados (responsavel_id)
            VALUES (:responsavel_id)
            WHERE numero = :numero;";
    $stmt = $pdo->prepare($sql);
    $resultado = false;

    try{
        $stmt->execute([
                ":numero" => $idChamado,
                ":responsavel_id"=> $idResponsavel
            ]
        );        
    $resultado = true;
    } catch(PDOException $e) {
        die($e->getMessage());
    }
    return $resultado;
}
function atualizarStatusChamado($idChamado, $status){
    $pdo = conectarDB();
    $sql = "UPDATE chamados (status)
            VALUES (:status)
            WHERE numero = :numero;";
    $stmt = $pdo->prepare($sql);
    $resultado = false;

    try{
        $stmt->execute([
                ":numero" => $idChamado,
                ":status"=> $status
            ]
        );        
    $resultado = true;
    } catch(PDOException $e) {
        die($e->getMessage());
    }
    return $resultado;
}