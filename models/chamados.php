<?php
require_once dirname(__DIR__). "/utils/connect.php";
function todosChamados($status = '', $busca = ''){
    $pdo = conectarDB();
    $sql = "SELECT c.numero, u.nome as solicitante, c.descricao, us.nome as responsavel, c.status, c.data_criacao, c.prioridade, c.titulo 
            FROM chamados c
            INNER JOIN usuarios u
            ON solicitante_id = u.usuario_id
            INNER JOIN usuarios us
            ON responsavel_id = us.usuario_id
            WHERE 1=1";
    $params = [];
    if (!empty($status)) {
        $sql .= " AND c.status = ?";
        $params[] = $status;
    }

    $busca = trim($busca);
    if (!empty($busca)) {
        if (is_numeric($busca)) {
            $sql .= " AND (c.numero = ? OR c.titulo LIKE ?)";
            $params[] = (int)$busca; 
            $params[] = "%$busca%";   
        } else {
            $sql .= " AND c.titulo LIKE ?";
            $params[] = "%$busca%";
        }
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
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
    $sql = "SELECT c.numero, u.nome as solicitante, c.descricao, us.nome as responsavel, c.status, c.data_criacao, c.prioridade, c.titulo  
            FROM chamados c
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
function chamadosPorIdSolicitante(int $idSolicitante){
    $pdo = conectarDB();
    $sql = "SELECT c.numero, u.nome as solicitante, c.descricao, us.nome as responsavel, c.status, c.data_criacao, c.prioridade, c.titulo 
            FROM chamados c
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
function chamadosPorIdResponsavel(int $idResponsavel){
    $pdo = conectarDB();
    $sql = "SELECT c.numero, u.nome as solicitante, c.descricao, us.nome as responsavel, c.status, c.data_criacao, c.prioridade, c.titulo 
            FROM chamados c
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
    $sql = "UPDATE chamados 
            SET responsavel_id = :responsavel_id
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
    $sql = "UPDATE chamados
            SET status = :status
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

function atualizarPrioridadeChamado($idChamado, $prioridade){
    $pdo = conectarDB();
    $sql = "UPDATE chamados
            SET prioridade = :prioridade
            WHERE numero = :numero;";
    $stmt = $pdo->prepare($sql);
    $resultado = false;

    try{
        $stmt->execute([
                ":numero" => $idChamado,
                ":status"=> $prioridade
            ]
        );        
    $resultado = true;
    } catch(PDOException $e) {
        die($e->getMessage());
    }
    return $resultado;
}

function statusDeChamados(){
    $pdo = conectarDB();
    $sql = "SELECT DISTINCT status
            FROM chamados
            ORDER BY status asc";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function atualizarChamado($idChamado, $status, $idResponsavel, $prioridade) {
    try {
        $pdo = conectarDB();
        $pdo->beginTransaction();

        $sql1 = "UPDATE chamados SET status = ?, prioridade = ?, responsavel_id = ? WHERE numero = ?";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([$status, $prioridade, $idResponsavel, $idChamado]);

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}
