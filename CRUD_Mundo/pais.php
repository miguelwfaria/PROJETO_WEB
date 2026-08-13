<?php

include("conexao.php");


if (isset($_GET["excluir"])) {

    $id = $_GET["excluir"];

    $sql = "delete from pais
            where id_pais = $id";


    if (mysqli_query($conexao, $sql)) {

        header("Location: paises.php");
        exit;

    } else {

        $mensagem = "Não foi possível excluir o país. Existem cidades associadas a ele.";

    }

}


if (isset($_POST["cadastrar"])) {

    $nome = $_POST["nome"];
    $id_continente = $_POST["id_continente"];
    $populacao = $_POST["populacao"];
    $area = $_POST["area"];
    $idioma = $_POST["idioma"];
    $id_governante = $_POST["id_governante"];
    $clima = $_POST["clima"];
    $regime_politico = $_POST["regime_politico"];
    $moeda = $_POST["moeda"];


    $sql = "insert into pais
            (
                nome,
                id_continente,
                populacao,
                area,
                idioma,
                id_governante,
                clima,
                regime_politico,
                moeda
            )
            values
            (
                '$nome',
                '$id_continente',
                '$populacao',
                '$area',
                '$idioma',
                '$id_governante',
                '$clima',
                '$regime_politico',
                '$moeda'
            )";


    if (mysqli_query($conexao, $sql)) {

        header("Location: paises.php");
        exit;

    }

}


if (isset($_POST["editar"])) {

    $id = $_POST["id_pais"];

    $nome = $_POST["nome"];
    $id_continente = $_POST["id_continente"];
    $populacao = $_POST["populacao"];
    $area = $_POST["area"];
    $idioma = $_POST["idioma"];
    $id_governante = $_POST["id_governante"];
    $clima = $_POST["clima"];
    $regime_politico = $_POST["regime_politico"];
    $moeda = $_POST["moeda"];


    $sql = "update pais set

            nome = '$nome',

            id_continente = '$id_continente',

            populacao = '$populacao',

            area = '$area',

            idioma = '$idioma',

            id_governante = '$id_governante',

            clima = '$clima',

            regime_politico = '$regime_politico',

            moeda = '$moeda'

            where id_pais = $id";


    if (mysqli_query($conexao, $sql)) {

        header("Location: paises.php");
        exit;

    }

}


$editar = false;
$pais_editar = null;


if (isset($_GET["editar"])) {

    $editar = true;

    $id = $_GET["editar"];

    $sql = "select *
            from pais
            where id_pais = $id";

    $resultado_editar = mysqli_query($conexao, $sql);

    $pais_editar = mysqli_fetch_array($resultado_editar);

}

?>


<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Países</title>

<link rel="stylesheet" href="style.css">

</head>


<body>


<div class="container">


<a class="voltar" href="index.php">
    Voltar
</a>


<h1>Países</h1>


<?php

if (isset($mensagem)) {

    echo "<div class='mensagem'>$mensagem</div>";

}

?>


<h2>

<?php

if ($editar) {

    echo "Editar país";

} else {

    echo "Cadastrar país";

}

?>

</h2>


<form method="post" class="formulario">


<?php

if ($editar) {

?>

<input
    type="hidden"
    name="id_pais"
    value="<?php echo $pais_editar["id_pais"]; ?>"
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

        echo $pais_editar["nome"];

    }

    ?>"
>

</div>


<div class="campo">

<label>Continente:</label>

<select name="id_continente" required>

<option value="">
Selecione
</option>


<?php

$sql_continentes = "select *
                    from continente
                    order by nome";

$resultado_continentes =
mysqli_query(
    $conexao,
    $sql_continentes
);


while (
    $continente =
    mysqli_fetch_array(
        $resultado_continentes
    )
) {

    $selecionado = "";


    if (
        $editar &&
        $pais_editar["id_continente"]
        ==
        $continente["id_continente"]
    ) {

        $selecionado = "selected";

    }


?>

<option
    value="<?php echo $continente["id_continente"]; ?>"
    <?php echo $selecionado; ?>
>

<?php echo $continente["nome"]; ?>

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

        echo $pais_editar["populacao"];

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

        echo $pais_editar["area"];

    }

    ?>"
>

</div>


<div class="campo">

<label>Idioma:</label>

<input
    type="text"
    name="idioma"
    required
    value="<?php

    if ($editar) {

        echo $pais_editar["idioma"];

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

$sql_governantes = "select *
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
        $pais_editar["id_governante"]
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

<label>Clima:</label>

<input
    type="text"
    name="clima"
    required
    value="<?php

    if ($editar) {

        echo $pais_editar["clima"];

    }

    ?>"
>

</div>


<div class="campo">

<label>Regime político:</label>

<input
    type="text"
    name="regime_politico"
    required
    value="<?php

    if ($editar) {

        echo $pais_editar["regime_politico"];

    }

    ?>"
>

</div>


<div class="campo">

<label>Moeda:</label>

<input
    type="text"
    name="moeda"
    required
    value="<?php

    if ($editar) {

        echo $pais_editar["moeda"];

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

<a href="paises.php">
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


<h2>Lista de países</h2>


<table>

<tr>

<th>ID</th>
<th>Nome</th>
<th>Continente</th>
<th>População</th>
<th>Área</th>
<th>Idioma</th>
<th>Governante</th>
<th>Clima</th>
<th>Regime político</th>
<th>Moeda</th>
<th>Ações</th>

</tr>


<?php

$sql = "select

        pais.*,

        continente.nome as nome_continente,

        governante.nome as nome_governante

        from pais

        inner join continente
        on pais.id_continente =
           continente.id_continente

        inner join governante
        on pais.id_governante =
           governante.id_governante

        order by pais.nome";


$resultado =
mysqli_query(
    $conexao,
    $sql
);


while ($linha = mysqli_fetch_array($resultado)) {

?>

<tr>

<td>
<?php echo $linha["id_pais"]; ?>
</td>

<td>
<?php echo $linha["nome"]; ?>
</td>

<td>
<?php echo $linha["nome_continente"]; ?>
</td>

<td>
<?php echo $linha["populacao"]; ?>
</td>

<td>
<?php echo $linha["area"]; ?>
</td>

<td>
<?php echo $linha["idioma"]; ?>
</td>

<td>
<?php echo $linha["nome_governante"]; ?>
</td>

<td>
<?php echo $linha["clima"]; ?>
</td>

<td>
<?php echo $linha["regime_politico"]; ?>
</td>

<td>
<?php echo $linha["moeda"]; ?>
</td>

<td class="acoes">

<a href="paises.php?editar=<?php echo $linha["id_pais"]; ?>">
Editar
</a>

<a href="paises.php?excluir=<?php echo $linha["id_pais"]; ?>">
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