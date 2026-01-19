<?php
    session_start();
    require_once dirname(__DIR__) . '/models/chamados.php';
    
    $solicitante = $_SESSION['usuario']['usuario_id'];
    
    session_write_close();
    $chamados = chamadosPorIdSolicitante($solicitante);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário - IntraHelp</title>
    <link rel="stylesheet" href="./painelUsuario.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
</head>
<body>

    <nav>
        <h3>Intra-Help | Área do Usuário</h3>
        <div class="nav-links">
            <a href="painel-usuario.php" class="active">Meus Chamados</a>
            <a href="criarChamado.php">Novo Chamado</a>
            <a href="../controllers/backend.php?acao=sair">Sair</a>
        </div>
    </nav>

    <div class="main-content">
        <div class="container">
            <div class="header-painel">
                <div>
                    <h2>Meus Chamados</h2>
                    <p>Acompanhe o status das suas solicitações</p>
                </div>
                <a href="criarChamado.php" class="btn-novo">
                    <i class="fa-solid fa-plus"></i> Abrir Novo Chamado
                </a>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Assunto</th>
                        <th>Prioridade</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($chamados as $c): ?>
                    <tr>
                        <td><?= $c['numero'] ?></td>
                        <td><?= $c['titulo'] ?></td>
                        <td><span class="badge-<?= $c['prioridade'] ?>"><?= $c['prioridade'] ?></span></td>
                        <td><span class="badge badge-<?= $c['status'] ?>"><?= $c['status'] ?></span></td>
                        <td><?= date('d/m/Y', strtotime($c['data_criacao'])) ?></td>
                        <td>
                            <a href="#" title="Ver Detalhes">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
