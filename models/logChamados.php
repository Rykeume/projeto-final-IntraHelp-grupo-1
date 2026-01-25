<?php
require_once dirname(__DIR__). "/utils/connect.php";

function logSemComentario($idChamado, $status, $idFuncionario, $prioridade) {
    try {
        $pdo = conectarDB();
        $pdo->beginTransaction();

        $sql2 = "INSERT INTO log_chamados (chamado_id, responsavel_id, status, prioridade) VALUES (?, ?, ?, ?)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$idChamado, $idFuncionario, $status, $prioridade]);

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

function logComComentario($idChamado, $status, $idFuncionario, $prioridade, $comentario ) {
    try {
        $pdo = conectarDB();
        $pdo->beginTransaction();

        $sql2 = "INSERT INTO log_chamados (chamado_id, responsavel_id, comentario, status, prioridade) VALUES (?, ?, ?, ?, ?)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$idChamado, $idFuncionario, $comentario, $status, $prioridade]);

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

function criarLog($idChamado, $status ,$idResponsavel, $prioridade, $comentario){
    if(!empty($comentario)){
        logComComentario($idChamado, $status ,$idResponsavel, $prioridade, $comentario);
    } else{
        logSemComentario($idChamado, $status ,$idResponsavel, $prioridade);
    }
}

function comentariosPorIdChamado($idChamado){
    $pdo = conectarDB();
    $sql = "SELECT l.comentario, l.data_log, u.nome 
            from log_chamados l
            INNER JOIN usuarios u
            ON responsavel_id = u.usuario_id
            WHERE l.chamado_id = :id AND l.comentario NOT NULL;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        [":id"=> $idChamado]
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}