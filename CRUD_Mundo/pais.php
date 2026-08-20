<?php
include("conexao.php");

// ==============================
// EXCLUSÃO
// ==============================
if (isset($_GET["excluir"])) {

    $id = $_GET["excluir"];

    $sql = "DELETE FROM pais WHERE id_pais=$id";

    if (mysqli_query($conexao, $sql)) {

        echo "<script>alert('País excluído com sucesso!'); window.location='pais.php';</script>";
    }
    else {

        echo "<script>alert('Não foi possível excluir este país. Verifique se existem cidades associadas.'); window.location='pais.php';</script>";
    }
}

// ==============================
// CADASTRO E ALTERAÇÃO
// ==============================
if (isset($_POST["salvar"])) {

    $nome = $_POST["nome"];
    $id_continente = $_POST["id_continente"];
    $populacao = $_POST["populacao"];
    $area = $_POST["area"];
    $idioma = $_POST["idioma"];
    $id_governante = $_POST["id_governante"];
    $clima = $_POST["clima"];
    $regime_politico = $_POST["regime_politico"];
    $moeda = $_POST["moeda"];

    if ($_POST["salvar"] == "cadastrar") {

        $sql = "INSERT INTO pais
                (nome, id_continente, populacao, area, idioma,
                 id_governante, clima, regime_politico, moeda)
                VALUES
                ('$nome', $id_continente, $populacao, $area, '$idioma',
                 $id_governante, '$clima', '$regime_politico', '$moeda')";
    }
    else {

        $id = $_POST["id_pais"];

        $sql = "UPDATE pais
                SET nome='$nome',
                    id_continente=$id_continente,
                    populacao=$populacao,
                    area=$area,
                    idioma='$idioma',
                    id_governante=$id_governante,
                    clima='$clima',
                    regime_politico='$regime_politico',
                    moeda='$moeda'
                WHERE id_pais=$id";
    }

    if (mysqli_query($conexao, $sql)) {

        echo "<script>alert('Registro salvo com sucesso!'); window.location='pais.php';</script>";
    }
    else {

        echo "Erro: " . mysqli_error($conexao);
    }
}

// ==============================
// DADOS PARA EDIÇÃO
// ==============================
$editar = false;

$pais = array(
    "id_pais"=>"",
    "nome"=>"",
    "id_continente"=>"",
    "populacao"=>"",
    "area"=>"",
    "idioma"=>"",
    "id_governante"=>"",
    "clima"=>"",
    "regime_politico"=>"",
    "moeda"=>""
);

if (isset($_GET["editar"])) {

    $editar = true;

    $id = $_GET["editar"];

    $resultado_edicao = mysqli_query(
        $conexao,
        "SELECT * FROM pais WHERE id_pais=$id"
    );

    $pais = mysqli_fetch_array($resultado_edicao);
}

// ==============================
// LISTAS PARA OS SELECTS
// ==============================
$continentes = mysqli_query(
    $conexao,
    "SELECT * FROM continente ORDER BY nome"
);

$governantes = mysqli_query(
    $conexao,
    "SELECT * FROM governante ORDER BY nome"
);

// ==============================
// LISTAGEM DOS PAÍSES
// ==============================
$resultado = mysqli_query(
    $conexao,
    "SELECT pais.*,
            continente.nome AS nome_continente,
            governante.nome AS nome_governante
     FROM pais
     INNER JOIN continente
     ON pais.id_continente=continente.id_continente
     INNER JOIN governante
     ON pais.id_governante=governante.id_governante
     ORDER BY pais.nome"
);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Países</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <a class="voltar" href="index.php">← Voltar</a>

    <h1>Países</h1>

    <form method="POST">

        <input
            type="hidden"
            name="id_pais"
            value="<?php echo $pais['id_pais']; ?>"
        >

        <label>Nome:</label>

        <input
            type="text"
            name="nome"
            value="<?php echo $pais['nome']; ?>"
            required
        >

        <label>Continente:</label>

        <select name="id_continente" required>

            <option value="">Selecione</option>

            <?php while ($linha = mysqli_fetch_array($continentes)) { ?>

                <option
                    value="<?php echo $linha['id_continente']; ?>"
                    <?php
                    if ($pais['id_continente'] == $linha['id_continente']) {
                        echo "selected";
                    }
                    ?>
                >

                    <?php echo $linha['nome']; ?>

                </option>

            <?php } ?>

        </select>

        <label>População:</label>

        <input
            type="number"
            name="populacao"
            value="<?php echo $pais['populacao']; ?>"
            required
        >

        <label>Área (km²):</label>

        <input
            type="number"
            step="0.01"
            name="area"
            value="<?php echo $pais['area']; ?>"
            required
        >

        <label>Idioma:</label>

        <input
            type="text"
            name="idioma"
            value="<?php echo $pais['idioma']; ?>"
            required
        >

        <label>Governante:</label>

        <select name="id_governante" required>

            <option value="">Selecione</option>

            <?php while ($linha = mysqli_fetch_array($governantes)) { ?>

                <option
                    value="<?php echo $linha['id_governante']; ?>"
                    <?php
                    if ($pais['id_governante'] == $linha['id_governante']) {
                        echo "selected";
                    }
                    ?>
                >

                    <?php echo $linha['nome']; ?>

                </option>

            <?php } ?>

        </select>

        <label>Clima:</label>

        <input
            type="text"
            name="clima"
            value="<?php echo $pais['clima']; ?>"
            required
        >

        <label>Regime político:</label>

        <input
            type="text"
            name="regime_politico"
            value="<?php echo $pais['regime_politico']; ?>"
            required
        >

        <label>Moeda:</label>

        <input
            type="text"
            name="moeda"
            value="<?php echo $pais['moeda']; ?>"
            required
        >

        <button
            type="submit"
            name="salvar"
            value="<?php echo $editar ? 'editar' : 'cadastrar'; ?>"
        >

            <?php echo $editar ? "Alterar" : "Cadastrar"; ?>

        </button>

        <?php if ($editar) { ?>

            <a class="botao cancelar" href="pais.php">
                Cancelar
            </a>

        <?php } ?>

    </form>

    <h2>Países cadastrados</h2>

    <table>

        <tr>

            <th>Nome</th>
            <th>Continente</th>
            <th>População</th>
            <th>Idioma</th>
            <th>Governante</th>
            <th>Clima</th>
            <th>Regime</th>
            <th>Moeda</th>
            <th>Ações</th>

        </tr>

        <?php while ($linha = mysqli_fetch_array($resultado)) { ?>

        <tr>

            <td><?php echo $linha["nome"]; ?></td>

            <td><?php echo $linha["nome_continente"]; ?></td>

            <td><?php echo $linha["populacao"]; ?></td>

            <td><?php echo $linha["idioma"]; ?></td>

            <td><?php echo $linha["nome_governante"]; ?></td>

            <td><?php echo $linha["clima"]; ?></td>

            <td><?php echo $linha["regime_politico"]; ?></td>

            <td><?php echo $linha["moeda"]; ?></td>

            <td>

                <a
                    class="editar"
                    href="pais.php?editar=<?php echo $linha['id_pais']; ?>"
                >
                    Editar
                </a>

                <a
                    class="excluir"
                    href="pais.php?excluir=<?php echo $linha['id_pais']; ?>"
                    onclick="return confirm('Deseja realmente excluir este país?')"
                >
                    Excluir
                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>