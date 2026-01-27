<!--feito por leandro-->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/models/chamados.php';
require_once dirname(__DIR__) . '/models/usuarios.php';
require_once dirname(__DIR__) . '/utils/validacoes.php';
require_once dirname(__DIR__) . '/models/logChamados.php';

if (!eUsuarioLogado()){
    header("Location: /views/login.php");
    exit;
}

$usuario = $_SESSION['usuario'];
$funcao = $usuario['categoria'];
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
$comentarios = comentariosPorIdChamado($idChamado);

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
<div class="view-wrapper">
    <div class="container">
        <div class="back_arrow_container">
            <a href="javascript:history.back()" class="back_arrow">
                ← Voltar
            </a>
        </div>

        <h1>Detalhes do chamado #<?= $meuChamado['numero'] ?></h1>
        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == '1'): ?>
            <div class="sucesso-msg">Chamado atualizado com sucesso!</div>
        <?php endif; ?>
        <?php if (isset($_GET['erro']) && $_GET['erro'] == '1'): ?>
            <div class="erro-msg">Houve um problema ao atualizar o chamado, favor tentar novamente.</div>
        <?php endif; ?>
        <?php if (isset($_GET['erro']) && $_GET['erro'] == '2'): ?>
            <div class="erro-msg">Um chamado só pode ser atualizado pelo Responsável do chamado.</div>
        <?php endif; ?>

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
                <form action="../controllers/backend.php" method="POST">
                    <input type="hidden" name="acao" value="atualizarChamado">
                    <input type="hidden" name="chamado_id" value="<?= $meuChamado['numero'] ?>">
                    
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
                            <option value="Em atendimento" <?= $meuChamado['status'] == 'Em atendimento' ? 'selected' : '' ?>>Em atendimento</option>
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
                        <textarea id="comentario" name="comentario" rows="4" placeholder="Descreva o progresso ou solução..."></textarea>
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
     <div class="comments-container">
            <h2>Histórico de Atendimento</h2>
            
            <?php if (empty($comentarios)): ?>
                <div class="comment-card">
                    <p class="no-comments">Nenhum comentário registrado.</p>
                </div>
            <?php else: ?>
                <?php foreach ($comentarios as $c): ?>
                    <div class="comment-card">
                        <div class="comment-header">
                            <strong><?= htmlspecialchars($c['nome']) ?></strong>
                            <span><?= date('d/m/Y H:i', strtotime($c['data_log'])) ?></span>
                        </div>
                        <div class="comment-body">
                            <?= nl2br(htmlspecialchars($c['comentario'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
</div>
</div>
</body>
</html>
