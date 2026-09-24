<?php
include_once('autenticacao.php');

$resultado = mysqli_query($conexao, 'SELECT COUNT(*) AS total FROM usuarios');
if (mysqli_fetch_assoc($resultado)['total'] > 0) {
    header('Location: login.php');
    exit;
}

$erro = '';
if (isset($_POST['cadastrar'])) {
    $nome = trim($_POST['nome']);
    $login = trim($_POST['login']);
    $senha = $_POST['senha'];

    if ($nome == '' || $login == '' || strlen($nome) > 100 || strlen($login) > 100 || strlen($senha) < 8) {
        $erro = 'Preencha os dados e escolha uma senha de pelo menos 8 caracteres.';
    } else {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO usuarios (nome, login, senha) VALUES (?, ?, ?)';
        $consulta = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($consulta, 'sss', $nome, $login, $hash);
        mysqli_stmt_execute($consulta);
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primeiro usuário - CRUD Mundo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header><h1>CRUD Mundo</h1></header>
<div class="container autenticar">
    <h1>Primeiro usuário</h1>
    <p>Essa senha deverá ser trocada no primeiro acesso.</p>
    <?php if ($erro): ?><p class="mensagem-erro"><?php echo $erro; ?></p><?php endif; ?>
    <form method="POST">
        <label for="nome">Nome:</label><input id="nome" name="nome" maxlength="100" required>
        <label for="login">Usuário:</label><input id="login" name="login" maxlength="100" required>
        <label for="senha">Senha inicial:</label><input id="senha" name="senha" type="password" minlength="8" required>
        <div class="acoes"><button type="submit" name="cadastrar">Cadastrar</button></div>
    </form>
</div>
</body>
</html>
