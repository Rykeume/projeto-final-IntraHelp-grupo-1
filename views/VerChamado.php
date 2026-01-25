<!--feito por leandro-->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/models/chamados.php';
require_once dirname(__DIR__) . '/models/usuarios.php';
require_once dirname(__DIR__) . '/utils/validacoes.php';

if (!eUsuarioLogado()){
    header("Location: /views/login.php");
    exit;
}

$usuario = $_SESSION['usuario'];
$funcao = $_SESSION['categoria'];
session_write_close();

$idChamado = htmlspecialchars($_GET['id']);
if(!isset($_GET['id'])){
    header("Location: ../views/painelUsuario.php");
}
$meuChamado = chamadoPorId($idChamado);
if(!isset($meuChamado['numero'])){
    header("Location: ../views/painelUsuario.php");
}

$funcionarios = todosColaboradores();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>ver chamado</title>
    <link rel="stylesheet" href="../theme.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../forms.css">
    <link rel="stylesheet" href="verChamado.css">
</head>
<body>

<?php include 'menu.php'; ?>

<div class="main-content">
<div class="container">
        <div class="back_arrow_container">
            <a href="javascript:history.back()" class="back_arrow">
                ← Voltar
            </a>
        </div>

    <h1>Detalhes do chamado #<?= $meuChamado['numero'] ?></h1>

    <div>

        <div class="form-group">
            <div>
                <p><strong>Assunto:</strong> <?= htmlspecialchars($meuChamado['titulo']) ?></p>
                <p><strong>Descrição:</strong> <?= htmlspecialchars($meuChamado['descricao']) ?></p>
                <p><strong>Aberto por:</strong> <?= htmlspecialchars($meuChamado['solicitante']) ?></p>
                <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($meuChamado['data_criacao'])) ?></p>
            </div>
        </div>

        <?php if ($funcao === 'Funcionario'): ?>
            <form action="../controllers/atualizarChamado.php" method="POST">
                <input type="hidden" name="id_chamado" value="<?= $idChamado ?>">
                
                <div class="form-group">
                    <label>Prioridade</label>
                    <select name="prioridade">
                        <option value="Baixa" <?= $meuChamado['prioridade'] == 'Baixa' ? 'selected' : '' ?>>Baixa</option>
                        <option value="Media" <?= $meuChamado['prioridade'] == 'Media' ? 'selected' : '' ?>>Média</option>
                        <option value="Alta" <?= $meuChamado['prioridade'] == 'Alta' ? 'selected' : '' ?>>Alta</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="Aberto" <?= $meuChamado['status'] == 'Aberto' ? 'selected' : '' ?>>Aberto</option>
                        <option value="Em Andamento" <?= $meuChamado['status'] == 'Em Andamento' ? 'selected' : '' ?>>Em Andamento</option>
                        <option value="Encerrado" <?= $meuChamado['status'] == 'Encerrado' ? 'selected' : '' ?>>Encerrado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Responsável</label>
                    <select name="responsavel_id">
                        <?php foreach($funcionarios as $f): ?>
                        <option value="<?= $f['usuario_id'] ?>" <?= $meuChamado['responsavel'] == $f['nome'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($f['nome']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="comentario">Comentário de Atendimento</label>
                    <textarea id="comentario" name="comentario" rows="4" required placeholder="Descreva o progresso ou solução..."></textarea>
                </div>

                <button type="submit" class="btn">Atualizar Chamado</button>
            </form>
        <?php else: ?>
            <!-- VISÃO DO CLIENTE -->
            <div class="form-group">
                <p><strong>Prioridade:</strong> <?= $meuChamado['prioridade'] ?></p>
                <p><strong>Status:</strong> <?= $meuChamado['status'] ?></p>
                <p><strong>Responsável:</strong> <?= $meuChamado['responsavel'] ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>
</body>
</html>