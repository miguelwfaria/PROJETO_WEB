<?php
session_start();
include_once('conexao.php');

function registrar_log($id, $login, $acao) {
    global $conexao;
    $consulta = mysqli_prepare($conexao, 'INSERT INTO logs (id_usuario, login_informado, acao) VALUES (?, ?, ?)');
    mysqli_stmt_bind_param($consulta, 'iss', $id, $login, $acao);
    mysqli_stmt_execute($consulta);
}

// Protege o menu e as páginas de cadastro.
function proteger_pagina() {
    global $conexao;

    if (!isset($_SESSION['id_usuario'])) {
        header('Location: login.php');
        exit;
    }

    $id = (int) $_SESSION['id_usuario'];
    $resultado = mysqli_query($conexao, "SELECT bloqueado, trocar_senha FROM usuarios WHERE id_usuario = $id");
    $usuario = mysqli_fetch_assoc($resultado);

    if (!$usuario || $usuario['bloqueado']) {
        session_unset();
        header('Location: login.php');
        exit;
    }

    if ($usuario['trocar_senha'] && basename($_SERVER['SCRIPT_NAME']) != 'trocar_senha.php') {
        header('Location: trocar_senha.php');
        exit;
    }
}
