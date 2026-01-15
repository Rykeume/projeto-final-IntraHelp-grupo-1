<?php
session_start();
require_once dirname(__DIR__) . '/models/chamados.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit;
}
$usuario = $_SESSION['usuario'];
session_write_close();

$meusChamados = chamadosPorIdSolicitante($usuario['usuario_id']);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Chamados</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
<?php
include 'menu.php';
?>
    <div class="container container-lg">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <a href="painel.php" style="text-decoration: none; color: var(--text-secondary); display: flex; align-items: center; margin-bottom: 10px; font-size: 14px;">
                    <span class="material-symbols-outlined" style="font-size: 18px; margin-right: 5px;">arrow_back</span> Voltar ao Painel
                </a>
                <h1>Meus Chamados</h1>
            </div>
            <a href="criarChamado.php" class="btn" style="width: auto; padding: 10px 24px;">
                <span style="display: flex; align-items: center; gap: 8px;">
                    <span class="material-symbols-outlined">add</span> Novo
                </span>
            </a>
        </div>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="sucesso-msg">Chamado criado com sucesso!</div>
        <?php endif; ?>

        <?php if (empty($meusChamados)): ?>
            <div style="padding: 60px; text-align: center; color: var(--text-secondary); background: #f8f9fa; border-radius: 8px;">
                <span class="material-symbols-outlined" style="font-size: 48px; color: #dadce0;">inbox</span>
                <p style="margin-top: 10px;">Você ainda não tem nenhum chamado registrado.</p>
            </div>
        <?php else: ?>
            <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid var(--border-color);">
                <table class="data-table" style="margin-top: 0;">
                    <thead>
                        <tr>
                            <th>Protocolo</th>
                            <th>Descrição / Título</th>
                            <th>Responsável</th>
                            <th>Data</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($meusChamados as $c): ?>
                            <?php 
                                // Lógica visual para separar [Prioridade] do texto, se existir
                                $desc = htmlspecialchars($c['descricao']);
                                // Define classe da badge baseada no status (assumindo que status vem do banco)
                                $statusClass = 'pendente'; 
                                if(stripos($c['status'], 'Fechado') !== false) $statusClass = 'fechado';
                                if(stripos($c['status'], 'Aberto') !== false) $statusClass = 'aberto';
                            ?>
                            <tr>
                                <td style="color: var(--text-secondary);">#<?= $c['numero'] ?></td>
                                <td>
                                    <div style="font-weight: 500; color: var(--text-main);">
                                        <?= mb_strimwidth($desc, 0, 60, "...");?>
                                    </div>
                                </td>
                                <td>
                                    <?php if($c['responsavel']): ?>
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <span class="material-symbols-outlined" style="font-size: 16px;">person</span>
                                            <?= htmlspecialchars($c['responsavel']) ?>
                                        </div>
                                    <?php else: ?>
                                        <span style="color: #9aa0a6; font-style: italic;">Aguardando...</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y', strtotime($c['data_criacao'])) ?></td>
                                <td>
                                    <span class="badge <?= $statusClass ?>">
                                        <?= htmlspecialchars($c['status'] ?? 'Aberto') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>