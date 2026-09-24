<?php
include_once('autenticacao.php');

if (isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit;
}

$resultado = mysqli_query($conexao, 'SELECT COUNT(*) AS total FROM usuarios');
$sem_usuarios = mysqli_fetch_assoc($resultado)['total'] == 0;
$erro = '';

if (isset($_POST['entrar'])) {
    $login = trim($_POST['login']);
    $senha = $_POST['senha'];

    if ($login == '' || $senha == '' || strlen($login) > 100) {
        $erro = 'Informe o usuário e a senha.';
    } else {
        $sql = 'SELECT * FROM usuarios WHERE login = ?';
        $consulta = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($consulta, 's', $login);
        mysqli_stmt_execute($consulta);
        $usuario = mysqli_fetch_assoc(mysqli_stmt_get_result($consulta));

        if (!$usuario) {
            $erro = 'Usuário ou senha incorretos.';
        } elseif ($usuario['bloqueado']) {
            $erro = 'Usuário bloqueado após três senhas incorretas.';
        } elseif (!password_verify($senha, $usuario['senha'])) {
            $id = (int) $usuario['id_usuario'];
            $tentativas = (int) $usuario['tentativas_falhas'] + 1;
            $bloqueado = $tentativas >= 3 ? 1 : 0;
            mysqli_query($conexao, "UPDATE usuarios SET tentativas_falhas = $tentativas, bloqueado = $bloqueado WHERE id_usuario = $id");
            registrar_log($id, $usuario['login'], 'senha_incorreta');
            $erro = $bloqueado ? 'Usuário bloqueado após três senhas incorretas.' : 'Usuário ou senha incorretos.';
        } else {
            $id = (int) $usuario['id_usuario'];
            mysqli_query($conexao, "UPDATE usuarios SET tentativas_falhas = 0 WHERE id_usuario = $id");
            registrar_log($id, $usuario['login'], 'entrada');
            session_regenerate_id(true);
            $_SESSION['id_usuario'] = $id;
            if ($usuario['trocar_senha']) {
                header('Location: trocar_senha.php');
            } else {
                header('Location: index.php');
            }
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - CRUD Mundo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header><h1>CRUD Mundo</h1></header>
<div class="container autenticar">
    <h1>Entrar</h1>
    <?php if ($erro): ?><p class="mensagem-erro"><?php echo $erro; ?></p><?php endif; ?>
    <?php if ($sem_usuarios): ?>
        <p>Antes de entrar, <a href="primeiro_usuario.php">cadastre o primeiro usuário</a>.</p>
    <?php else: ?>
        <form method="POST">
            <label for="login">Usuário:</label>
            <input type="text" id="login" name="login" maxlength="100" required>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <div class="acoes"><button type="submit" name="entrar">Entrar</button></div>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
