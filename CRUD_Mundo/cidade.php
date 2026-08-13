<?php

include("conexao.php");


if (isset($_GET["excluir"])) {

    $id = $_GET["excluir"];

    $sql = "delete from cidade
            where id_cidade = $id";


    if (mysqli_query($conexao, $sql)) {

        header("Location: cidades.php");
        exit;

    } else {

        $mensagem = "Não foi possível excluir a cidade.";

    }

}


if (isset($_POST["cadastrar"])) {

    $nome = $_POST["nome"];
    $id_pais = $_POST["id_pais"];
    $populacao = $_POST["populacao"];
    $area = $_POST["area"];
    $clima = $_POST["clima"];
    $id_governante = $_POST["id_governante"];
    $data_fundacao = $_POST["data_fundacao"];


    $sql = "insert into cidade
            (
                nome,
                id_pais,
                populacao,
                area,
                clima,
                id_governante,
                data_fundacao
            )
            values
            (
                '$nome',
                '$id_pais',
                '$populacao',
                '$area',
                '$clima',
                '$id_governante',
                '$data_fundacao'
            )";


    if (mysqli_query($conexao, $sql)) {

        header("Location: cidades.php");
        exit;

    }

}


if (isset($_POST["editar"])) {

    $id = $_POST["id_cidade"];

    $nome = $_POST["nome"];
    $id_pais = $_POST["id_pais"];
    $populacao = $_POST["populacao"];
    $area = $_POST["area"];
    $clima = $_POST["clima"];
    $id_governante = $_POST["id_governante"];
    $data_fundacao = $_POST["data_fundacao"];


    $sql = "update cidade set

            nome = '$nome',

            id_pais = '$id_pais',

            populacao = '$populacao',

            area = '$area',

            clima = '$clima',

            id_governante = '$id_governante',

            data_fundacao = '$data_fundacao'

            where id_cidade = $id";


    if (mysqli_query($conexao, $sql)) {

        header("Location: cidades.php");
        exit;

    }

}


$editar = false;
$cidade_editar = null;


if (isset($_GET["editar"])) {

    $editar = true;

    $id = $_GET["editar"];

    $sql = "select *
            from cidade
            where id_cidade = $id";

    $resultado_editar =
    mysqli_query(
        $conexao,
        $sql
    );

    $cidade_editar =
    mysqli_fetch_array(
        $resultado_editar
    );

}

?>


<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Cidades</title>

<link rel="stylesheet" href="style.css">

</head>


<body>


<div class="container">


<a class="voltar" href="index.php">
    Voltar
</a>


<h1>Cidades</h1>


<?php

if (isset($mensagem)) {

    echo "<div class='mensagem'>$mensagem</div>";

}

?>


<h2>

<?php

if ($editar) {

    echo "Editar cidade";

} else {

    echo "Cadastrar cidade";

}

?>

</h2>


<form method="post" class="formulario">


<?php

if ($editar) {

?>

<input
    type="hidden"
    name="id_cidade"
    value="<?php echo $cidade_editar["id_cidade"]; ?>"
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

        echo $cidade_editar["nome"];

    }

    ?>"
>

</div>


<div class="campo">

<label>País:</label>

<select name="id_pais" required>

<option value="">
Selecione
</option>


<?php

$sql_paises = "select *
               from pais
               order by nome";

$resultado_paises =
mysqli_query(
    $conexao,
    $sql_paises
);


while (
    $pais =
    mysqli_fetch_array(
        $resultado_paises
    )
) {

    $selecionado = "";


    if (
        $editar &&
        $cidade_editar["id_pais"]
        ==
        $pais["id_pais"]
    ) {

        $selecionado = "selected";

    }

?>

<option
    value="<?php echo $pais["id_pais"]; ?>"
    <?php echo $selecionado; ?>
>

<?php echo $pais["nome"]; ?>

</option>

<?php

}

?>

</select>

</div>


<div class="campo">

<label>População:</label>

<input
    type="number"
    name="populacao"
    required
    value="<?php

    if ($editar) {

        echo $cidade_editar["populacao"];

    }

    ?>"
>

</div>


<div class="campo">

<label>Área:</label>

<input
    type="number"
    step="0.01"
    name="area"
    required
    value="<?php

    if ($editar) {

        echo $cidade_editar["area"];

    }

    ?>"
>

</div>


<div class="campo">

<label>Clima:</label>

<input
    type="text"
    name="clima"
    required
    value="<?php

    if ($editar) {

        echo $cidade_editar["clima"];

    }

    ?>"
>

</div>


<div class="campo">

<label>Governante:</label>

<select name="id_governante" required>

<option value="">
Selecione
</option>


<?php

$sql_governantes =
"select *
 from governante
 order by nome";


$resultado_governantes =
mysqli_query(
    $conexao,
    $sql_governantes
);


while (
    $governante =
    mysqli_fetch_array(
        $resultado_governantes
    )
) {

    $selecionado = "";


    if (
        $editar &&
        $cidade_editar["id_governante"]
        ==
        $governante["id_governante"]
    ) {

        $selecionado = "selected";

    }

?>

<option
    value="<?php echo $governante["id_governante"]; ?>"
    <?php echo $selecionado; ?>
>

<?php echo $governante["nome"]; ?>

</option>

<?php

}

?>

</select>

</div>


<div class="campo">

<label>Data de fundação:</label>

<input
    type="date"
    name="data_fundacao"
    required
    value="<?php

    if ($editar) {

        echo $cidade_editar["data_fundacao"];

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

<a href="cidades.php">
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


<h2>Lista de cidades</h2>


<table>

<tr>

<th>ID</th>
<th>Nome</th>
<th>País</th>
<th>População</th>
<th>Área</th>
<th>Clima</th>
<th>Governante</th>
<th>Fundação</th>
<th>Ações</th>

</tr>


<?php

$sql = "select

        cidade.*,

        pais.nome as nome_pais,

        governante.nome as nome_governante

        from cidade

        inner join pais
        on cidade.id_pais =
           pais.id_pais

        inner join governante
        on cidade.id_governante =
           governante.id_governante

        order by cidade.nome";


$resultado =
mysqli_query(
    $conexao,
    $sql
);


while ($linha = mysqli_fetch_array($resultado)) {

?>

<tr>

<td>
<?php echo $linha["id_cidade"]; ?>
</td>

<td>
<?php echo $linha["nome"]; ?>
</td>

<td>
<?php echo $linha["nome_pais"]; ?>
</td>

<td>
<?php echo $linha["populacao"]; ?>
</td>

<td>
<?php echo $linha["area"]; ?>
</td>

<td>
<?php echo $linha["clima"]; ?>
</td>

<td>
<?php echo $linha["nome_governante"]; ?>
</td>

<td>
<?php echo $linha["data_fundacao"]; ?>
</td>

<td class="acoes">

<a href="cidades.php?editar=<?php echo $linha["id_cidade"]; ?>">
Editar
</a>

<a href="cidades.php?excluir=<?php echo $linha["id_cidade"]; ?>">
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