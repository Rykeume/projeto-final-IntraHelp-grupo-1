<?php
require_once dirname(__DIR__). "/utils/connect.php";
function atualizarComLog($idChamado, $status, $idFuncionario, $comentario) {
    try {
        $pdo = conectarDB();
        $pdo->beginTransaction();

        // 1. Atualiza o chamado
        $sql1 = "UPDATE chamados SET status = ?, responsavel_id = ? WHERE id = ?";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([$status, $idFuncionario, $idChamado]);

        // 2. Insere no log
        $sql2 = "INSERT INTO logChamados (chamado_id, funcionario_id, comentario, data_atualizacao) VALUES (?, ?, ?, NOW())";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$idChamado, $_SESSION['usuario_id'], $comentario]);

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}