<?php
session_start();
require_once dirname(__DIR__) . '/models/usuarios.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}
$usuario = $_SESSION["usuario"];
session_write_close();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletarDB'])) {
    $id = (int)$_POST['deletarDB'];
    deletarUsuario($id);
}

$usuarios = todosUsuarios();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Usuários</title>
    <link rel="stylesheet" href="../style.css" />
</head>
<body>
    <div class="container">
        <h1>Bem vindo, <?= htmlspecialchars($usuario['nome']) ?>!</h1>
        <h2>Relatório de Usuários</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Data de Cadastro</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $i => $u): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($u['nome']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['data_cadastro']) ?></td>
                        <td>
                            <form method="post" action="relatorio.php" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                <input type="hidden" name="deletar" value="<?= $i ?>">
                                <input type="hidden" name="deletarDB" value="<?= $u['usuario_id'] ?>">
                                <button type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <a href="../controllers/backend.php?acao=sair" class="btn">Sair</a>
    </div>
</body>
</html>