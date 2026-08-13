<?php

include("conexao.php");


if (isset($_GET["excluir"])) {

    $id = $_GET["excluir"];

    $sql = "delete from governante
            where id_governante = $id";

    if (mysqli_query($conexao, $sql)) {

        header("Location: governantes.php");
        exit;

    } else {

        $mensagem = "Não foi possível excluir o governante. Ele está associado a um país ou cidade.";

    }
}


if (isset($_POST["cadastrar"])) {

    $nome = $_POST["nome"];
    $partido_politico = $_POST["partido_politico"];
    $data_nascimento = $_POST["data_nascimento"];
    $idade = $_POST["idade"];
    $data_inicio_mandato = $_POST["data_inicio_mandato"];
    $data_fim_mandato = $_POST["data_fim_mandato"];


    if ($data_fim_mandato == "") {

        $fim_mandato = "null";

    } else {

        $fim_mandato = "'$data_fim_mandato'";

    }


    $sql = "insert into governante
            (
                nome,
                partido_politico,
                data_nascimento,
                idade,
                data_inicio_mandato,
                data_fim_mandato
            )
            values
            (
                '$nome',
                '$partido_politico',
                '$data_nascimento',
                '$idade',
                '$data_inicio_mandato',
                $fim_mandato
            )";


    if (mysqli_query($conexao, $sql)) {

        header("Location: governantes.php");
        exit;

    }

}


if (isset($_POST["editar"])) {

    $id = $_POST["id_governante"];

    $nome = $_POST["nome"];
    $partido_politico = $_POST["partido_politico"];
    $data_nascimento = $_POST["data_nascimento"];
    $idade = $_POST["idade"];
    $data_inicio_mandato = $_POST["data_inicio_mandato"];
    $data_fim_mandato = $_POST["data_fim_mandato"];


    if ($data_fim_mandato == "") {

        $fim_mandato = "null";

    } else {

        $fim_mandato = "'$data_fim_mandato'";

    }


    $sql = "update governante set

            nome = '$nome',

            partido_politico = '$partido_politico',

            data_nascimento = '$data_nascimento',

            idade = '$idade',

            data_inicio_mandato = '$data_inicio_mandato',

            data_fim_mandato = $fim_mandato

            where id_governante = $id";


    if (mysqli_query($conexao, $sql)) {

        header("Location: governantes.php");
        exit;

    }

}


$editar = false;
$governante_editar = null;


if (isset($_GET["editar"])) {

    $editar = true;

    $id = $_GET["editar"];

    $sql = "select *
            from governante
            where id_governante = $id";

    $resultado_editar = mysqli_query($conexao, $sql);

    $governante_editar = mysqli_fetch_array($resultado_editar);

}

?>


<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Governantes</title>

    <link rel="stylesheet" href="style.css">

</head>


<body>


<div class="container">


<a class="voltar" href="index.php">
    Voltar
</a>


<h1>Governantes</h1>


<?php

if (isset($mensagem)) {

    echo "<div class='mensagem'>$mensagem</div>";

}

?>


<h2>

<?php

if ($editar) {

    echo "Editar governante";

} else {

    echo "Cadastrar governante";

}

?>

</h2>


<form method="post" class="formulario">


<?php

if ($editar) {

?>

<input
    type="hidden"
    name="id_governante"
    value="<?php echo $governante_editar["id_governante"]; ?>"
>

<?php

}

?>


<div class="campo">

<label>Nome:</label>

<input
    type="text"
    name="nome"
    required
    value="<?php

    if ($editar) {

        echo $governante_editar["nome"];

    }

    ?>"
>

</div>


<div class="campo">

<label>Partido político:</label>

<input
    type="text"
    name="partido_politico"
    required
    value="<?php

    if ($editar) {

        echo $governante_editar["partido_politico"];

    }

    ?>"
>

</div>


<div class="campo">

<label>Data de nascimento:</label>

<input
    type="date"
    name="data_nascimento"
    required
    value="<?php

    if ($editar) {

        echo $governante_editar["data_nascimento"];

    }

    ?>"
>

</div>


<div class="campo">

<label>Idade:</label>

<input
    type="number"
    name="idade"
    required
    value="<?php

    if ($editar) {

        echo $governante_editar["idade"];

    }

    ?>"
>

</div>


<div class="campo">

<label>Início do mandato:</label>

<input
    type="date"
    name="data_inicio_mandato"
    required
    value="<?php

    if ($editar) {

        echo $governante_editar["data_inicio_mandato"];

    }

    ?>"
>

</div>


<div class="campo">

<label>Fim do mandato:</label>

<input
    type="date"
    name="data_fim_mandato"
    value="<?php

    if (
        $editar &&
        $governante_editar["data_fim_mandato"] != null
    ) {

        echo $governante_editar["data_fim_mandato"];

    }

    ?>"
>

</div>


<div class="campo-completo">

<?php

if ($editar) {

?>

<input
    type="submit"
    name="editar"
    value="Salvar alterações"
>

<a href="governantes.php">
    Cancelar
</a>

<?php

} else {

?>

<input
    type="submit"
    name="cadastrar"
    value="Cadastrar"
>

<?php

}

?>

</div>


</form>


<h2>Lista de governantes</h2>


<table>

<tr>

<th>ID</th>
<th>Nome</th>
<th>Partido</th>
<th>Nascimento</th>
<th>Idade</th>
<th>Início do mandato</th>
<th>Fim do mandato</th>
<th>Ações</th>

</tr>


<?php

$sql = "select *
        from governante
        order by nome";

$resultado = mysqli_query($conexao, $sql);


while ($linha = mysqli_fetch_array($resultado)) {

?>

<tr>

<td>
<?php echo $linha["id_governante"]; ?>
</td>

<td>
<?php echo $linha["nome"]; ?>
</td>

<td>
<?php echo $linha["partido_politico"]; ?>
</td>

<td>
<?php echo $linha["data_nascimento"]; ?>
</td>

<td>
<?php echo $linha["idade"]; ?>
</td>

<td>
<?php echo $linha["data_inicio_mandato"]; ?>
</td>

<td>
<?php echo $linha["data_fim_mandato"]; ?>
</td>

<td class="acoes">

<a href="governantes.php?editar=<?php echo $linha["id_governante"]; ?>">
Editar
</a>

<a href="governantes.php?excluir=<?php echo $linha["id_governante"]; ?>">
Excluir
</a>

</td>

</tr>

<?php

}

?>

</table>


</div>

</body>

</html>