<?php
$servername = "localhost";
$database = "bd_mundo";
$username = "SEU_USUARIO";
$password = "SUA_SENHA";

$conexao = mysqli_connect($servername, $username, $password, $database);

if (!$conexao) {
    die("Falha na Conexão: " . mysqli_connect_error());
}

mysqli_set_charset($conexao, "utf8");
?>