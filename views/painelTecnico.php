<?php
    session_start();
    require_once dirname(__DIR__) . '/models/chamados.php';
    
    if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

        if ($usuario['categoria'] !== 'Funcionario') {
            header("Location: ../views/login.php");
            exit;
        }
    }
    session_write_close();

    $statusFiltro = $_GET['status'] ?? '';
    $buscaFiltro = $_GET['busca'] ?? '';  

    $chamados = todosChamados($statusFiltro, $buscaFiltro);
    $contagemStatus = contagemTodosChamadosPorStatus();
    $totalChamados = contagemTodosChamados();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Técnico - IntraHelp</title>
    <link rel="stylesheet" href="../theme.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./painelTecnico.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php
    include 'menu.php';
    ?>
    <div class="main-content">
        <div class="container">

            <div class="header-painel">
                <div>
                    <h2>Gerenciamento de Chamados</h2>
                    <p>Visualize e gerencie as solicitações de suporte</p>
                </div>
            </div>

            <div class="stats-cards">
                <div class="card">
                    <h3><?= $totalChamados ?></h3>
                    <p>Total de Chamados</p>
                </div>
                <?php foreach($contagemStatus as $c):?>
                <div class="card">
                    <h3><?= $c['Total'] ?></h3>
                    <p><?= $c['status'] ?></p>
                </div>
                <?php endforeach?>
            </div>
            <form method="GET" action="">
                <div class="filters">
                    <span>Filtrar por:</span>
                    <select name="status">
                        <option value="">Todos os status</option>
                        <option value="Aberto"<?= htmlspecialchars($statusFiltro) == 'Aberto' ? 'selected' : '' ?>>Aberto</option>
                        <option value="Em atendimento"<?= htmlspecialchars($statusFiltro) == 'Em atendimento' ? 'selected' : '' ?>>Em Andamento</option>
                        <option value="Encerrado"<?= htmlspecialchars($statusFiltro )== 'Encerrado' ? 'selected' : '' ?>>Encerrado</option>
                    </select>
                    <input type="text" name="busca" value="<?= htmlspecialchars($buscaFiltro) ?>" placeholder="Buscar por ID ou Assunto...">
                    <button class="filters-btn btn" >Filtrar</button>
                </div>
            </form>
            <table class="data-table" style="max-width: 100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Assunto</th>
                        <th>Solicitante</th>
                        <th>Prioridade</th>
                        <th>Status</th>
                        <th>Data Abertura</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Exemplo 1 -->
                    <?php foreach($chamados as $ch): ?>
                    <tr>
                        <td><?= $ch['numero'] ?></td>
                        <td><?= $ch['titulo'] ?></td>
                        <td><?= $ch['solicitante'] ?></td>
                        <td><span class="span-<?= $ch['prioridade'] ?>"><?= $ch['prioridade'] ?></span></td>
                        <td><span class="badge badge-<?= $ch['status'] ?>"><?= $ch['status'] ?></span></td>
                        <td><?= date('d/m/Y', strtotime($ch['data_criacao'])) ?></td>
                        <td>
                            <a href="../views/verChamado.php?id=<?= $ch['numero'] ?>" title="Visualizar">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <!-- <button class="btn-action btn-edit" title="Atualizar Status"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn-action btn-close" title="Encerrar Chamado">
                                <?php if($ch['status'] != "Encerrado"): ?>
                                    <i class="fa-solid fa-check-circle"></i>
                                <?php endif; ?>
                            </button> -->
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>