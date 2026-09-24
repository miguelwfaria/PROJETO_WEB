<?php
include_once('autenticacao.php');
proteger_pagina();

$erro = '';
if (isset($_POST['salvar'])) {
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $confirmacao = $_POST['confirmacao'];
    $id = (int) $_SESSION['id_usuario'];
    $resultado = mysqli_query($conexao, "SELECT senha, login FROM usuarios WHERE id_usuario = $id");
    $usuario = mysqli_fetch_assoc($resultado);

    if (!password_verify($senha_atual, $usuario['senha'])) {
        $erro = 'A senha atual está incorreta.';
    } elseif (strlen($nova_senha) < 8) {
        $erro = 'A nova senha deve ter pelo menos 8 caracteres.';
    } elseif ($nova_senha != $confirmacao) {
        $erro = 'As senhas novas não são iguais.';
    } elseif (password_verify($nova_senha, $usuario['senha'])) {
        $erro = 'A nova senha precisa ser diferente da atual.';
    } else {
        $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $sql = 'UPDATE usuarios SET senha = ?, trocar_senha = 0 WHERE id_usuario = ?';
        $consulta = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($consulta, 'si', $hash, $id);
        mysqli_stmt_execute($consulta);
        registrar_log($id, $usuario['login'], 'troca_senha');
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trocar senha - CRUD Mundo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header><h1>CRUD Mundo</h1></header>
<div class="container autenticar">
    <h1>Trocar senha no primeiro acesso</h1>
    <?php if ($erro): ?><p class="mensagem-erro"><?php echo $erro; ?></p><?php endif; ?>
    <form method="POST">
        <label for="senha_atual">Senha atual:</label><input id="senha_atual" name="senha_atual" type="password" required>
        <label for="nova_senha">Nova senha:</label><input id="nova_senha" name="nova_senha" type="password" minlength="8" required>
        <label for="confirmacao">Confirmar nova senha:</label><input id="confirmacao" name="confirmacao" type="password" minlength="8" required>
        <div class="acoes"><button type="submit" name="salvar">Salvar</button></div>
    </form>
    <a href="sair.php">Sair</a>
</div>
</body>
</html>
