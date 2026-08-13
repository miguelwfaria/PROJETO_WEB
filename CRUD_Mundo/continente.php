<?php

include("conexao.php");

if (isset($_GET["excluir"])) {

    $id = $_GET["excluir"];

    $sql = "delete from continente
            where id_continente = $id";

    if (mysqli_query($conexao, $sql)) {

        header("Location: continentes.php");
        exit;

    } else {

        $mensagem = "Não foi possível excluir o continente. Existem países associados a ele.";

    }
}


if (isset($_POST["cadastrar"])) {

    $nome = $_POST["nome"];
    $populacao = $_POST["populacao"];
    $area = $_POST["area"];
    $total_paises = $_POST["total_paises"];

    $sql = "insert into continente
            (nome, populacao, area, total_paises)
            values
            ('$nome', '$populacao', '$area', '$total_paises')";

    if (mysqli_query($conexao, $sql)) {

        header("Location: continentes.php");
        exit;

    }
}


if (isset($_POST["editar"])) {

    $id = $_POST["id_continente"];

    $nome = $_POST["nome"];
    $populacao = $_POST["populacao"];
    $area = $_POST["area"];
    $total_paises = $_POST["total_paises"];

    $sql = "update continente set
            nome = '$nome',
            populacao = '$populacao',
            area = '$area',
            total_paises = '$total_paises'
            where id_continente = $id";

    if (mysqli_query($conexao, $sql)) {

        header("Location: continentes.php");
        exit;

    }
}


$editar = false;
$continente_editar = null;


if (isset($_GET["editar"])) {

    $editar = true;

    $id = $_GET["editar"];

    $sql = "select *
            from continente
            where id_continente = $id";

    $resultado_editar = mysqli_query($conexao, $sql);

    $continente_editar = mysqli_fetch_array($resultado_editar);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Continentes</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <a class="voltar" href="index.php">
        Voltar
    </a>

    <h1>Continentes</h1>


    <?php

    if (isset($mensagem)) {

        echo "<div class='mensagem'>$mensagem</div>";

    }

    ?>


    <h2>
        <?php

        if ($editar) {

            echo "Editar continente";

        } else {

            echo "Cadastrar continente";

        }

        ?>
    </h2>


    <form method="post" class="formulario">


        <?php

        if ($editar) {

        ?>

            <input
                type="hidden"
                name="id_continente"
                value="<?php echo $continente_editar["id_continente"]; ?>"
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

                    echo $continente_editar["nome"];

                }

                ?>"
            >

        </div>


        <div class="campo">

            <label>População:</label>

            <input
                type="number"
                name="populacao"
                required
                value="<?php

                if ($editar) {

                    echo $continente_editar["populacao"];

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

                    echo $continente_editar["area"];

                }

                ?>"
            >

        </div>


        <div class="campo">

            <label>Total de países:</label>

            <input
                type="number"
                name="total_paises"
                required
                value="<?php

                if ($editar) {

                    echo $continente_editar["total_paises"];

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

                <a href="continentes.php">
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


    <h2>Lista de continentes</h2>


    <table>

        <tr>

            <th>ID</th>
            <th>Nome</th>
            <th>População</th>
            <th>Área</th>
            <th>Total de países</th>
            <th>Ações</th>

        </tr>


        <?php

        $sql = "select *
                from continente
                order by nome";

        $resultado = mysqli_query($conexao, $sql);


        while ($linha = mysqli_fetch_array($resultado)) {

        ?>

            <tr>

                <td>
                    <?php echo $linha["id_continente"]; ?>
                </td>

                <td>
                    <?php echo $linha["nome"]; ?>
                </td>

                <td>
                    <?php echo $linha["populacao"]; ?>
                </td>

                <td>
                    <?php echo $linha["area"]; ?>
                </td>

                <td>
                    <?php echo $linha["total_paises"]; ?>
                </td>

                <td class="acoes">

                    <a href="continentes.php?editar=<?php echo $linha["id_continente"]; ?>">
                        Editar
                    </a>

                    <a href="continentes.php?excluir=<?php echo $linha["id_continente"]; ?>">
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