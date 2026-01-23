<!--feito por leandro-->
<?php
session_start();
require_once dirname(__DIR__) . '/models/chamados.php';

$usuario = $_SESSION['usuario'];
session_write_close();


$idChamado = htmlspecialchars($_GET['id']);
$meuChamado = chamadoPorId($idChamado);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>ver chamado</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../views/verChamado.css">
</head>
<body>

<?php include 'menu.php'; ?>

<div class="container">

    <h1>Detalhes do chamado</h1>

    <div>

        <p><strong>Assunto:</strong> <?= htmlspecialchars($meuChamado['titulo']) ?></p>

        <p><strong>Descrição:</strong></p>
        <p><?= htmlspecialchars($meuChamado['descricao']) ?></p>

        <p id="<?= $meuChamado['prioridade'] ?>"><strong>Prioridade:</strong> <?= $meuChamado['prioridade'] ?></p>

        <p><strong>Status:</strong> <?= $meuChamado['status'] ?></p>

        <p><strong>Aberto por:</strong> <?= $meuChamado['solicitante'] ?></p>

        <p><strong>Responsável:</strong> <?= $meuChamado['responsavel'] ?></p>

        <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($meuChamado['data_criacao'])) ?></p>

    </div>

</div>

</body>
</html>