<?php
include("conexao.php");

// ==============================
// EXCLUSÃO
// ==============================
if (isset($_GET["excluir"])) {

    $id = $_GET["excluir"];

    $sql = "DELETE FROM cidade WHERE id_cidade=$id";

    if (mysqli_query($conexao, $sql)) {

        echo "<script>alert('Cidade excluída com sucesso!'); window.location='cidade.php';</script>";
    }
    else {

        echo "<script>alert('Erro ao excluir cidade.'); window.location='cidade.php';</script>";
    }
}

// ==============================
// CADASTRO E ALTERAÇÃO
// ==============================
if (isset($_POST["salvar"])) {

    $nome = $_POST["nome"];
    $id_pais = $_POST["id_pais"];
    $populacao = $_POST["populacao"];
    $area = $_POST["area"];
    $clima = $_POST["clima"];
    $id_governante = $_POST["id_governante"];
    $data_fundacao = $_POST["data_fundacao"];

    if ($_POST["salvar"] == "cadastrar") {

        $sql = "INSERT INTO cidade
                (nome, id_pais, populacao, area, clima,
                 id_governante, data_fundacao)
                VALUES
                ('$nome', $id_pais, $populacao, $area, '$clima',
                 $id_governante, '$data_fundacao')";
    }
    else {

        $id = $_POST["id_cidade"];

        $sql = "UPDATE cidade
                SET nome='$nome',
                    id_pais=$id_pais,
                    populacao=$populacao,
                    area=$area,
                    clima='$clima',
                    id_governante=$id_governante,
                    data_fundacao='$data_fundacao'
                WHERE id_cidade=$id";
    }

    if (mysqli_query($conexao, $sql)) {

        echo "<script>alert('Registro salvo com sucesso!'); window.location='cidade.php';</script>";
    }
    else {

        echo "Erro: " . mysqli_error($conexao);
    }
}

// ==============================
// DADOS PARA EDIÇÃO
// ==============================
$editar = false;

$cidade = array(
    "id_cidade"=>"",
    "nome"=>"",
    "id_pais"=>"",
    "populacao"=>"",
    "area"=>"",
    "clima"=>"",
    "id_governante"=>"",
    "data_fundacao"=>""
);

if (isset($_GET["editar"])) {

    $editar = true;

    $id = $_GET["editar"];

    $resultado_edicao = mysqli_query(
        $conexao,
        "SELECT * FROM cidade WHERE id_cidade=$id"
    );

    $cidade = mysqli_fetch_array($resultado_edicao);
}

// ==============================
// LISTAS PARA OS SELECTS
// ==============================
$paises = mysqli_query(
    $conexao,
    "SELECT * FROM pais ORDER BY nome"
);

$governantes = mysqli_query(
    $conexao,
    "SELECT * FROM governante ORDER BY nome"
);

// ==============================
// LISTAGEM
// ==============================
$resultado = mysqli_query(
    $conexao,
    "SELECT cidade.*,
            pais.nome AS nome_pais,
            governante.nome AS nome_governante
     FROM cidade
     INNER JOIN pais
     ON cidade.id_pais=pais.id_pais
     INNER JOIN governante
     ON cidade.id_governante=governante.id_governante
     ORDER BY cidade.nome"
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

    <title>Cidades</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <a class="voltar" href="index.php">← Voltar</a>

    <h1>Cidades</h1>

    <form method="POST">

        <input
            type="hidden"
            name="id_cidade"
            value="<?php echo $cidade['id_cidade']; ?>"
        >

        <label>Nome:</label>

        <input
            type="text"
            name="nome"
            value="<?php echo $cidade['nome']; ?>"
            required
        >

        <label>País:</label>

        <select name="id_pais" required>

            <option value="">Selecione</option>

            <?php while ($linha = mysqli_fetch_array($paises)) { ?>

                <option
                    value="<?php echo $linha['id_pais']; ?>"
                    <?php
                    if ($cidade['id_pais'] == $linha['id_pais']) {
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
            value="<?php echo $cidade['populacao']; ?>"
            required
        >

        <label>Área (km²):</label>

        <input
            type="number"
            step="0.01"
            name="area"
            value="<?php echo $cidade['area']; ?>"
            required
        >

        <label>Clima:</label>

        <input
            type="text"
            name="clima"
            value="<?php echo $cidade['clima']; ?>"
            required
        >

        <label>Governante:</label>

        <select name="id_governante" required>

            <option value="">Selecione</option>

            <?php while ($linha = mysqli_fetch_array($governantes)) { ?>

                <option
                    value="<?php echo $linha['id_governante']; ?>"
                    <?php
                    if ($cidade['id_governante'] == $linha['id_governante']) {
                        echo "selected";
                    }
                    ?>
                >

                    <?php echo $linha['nome']; ?>

                </option>

            <?php } ?>

        </select>

        <label>Data de fundação:</label>

        <input
            type="date"
            name="data_fundacao"
            value="<?php echo $cidade['data_fundacao']; ?>"
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

            <a class="botao cancelar" href="cidade.php">
                Cancelar
            </a>

        <?php } ?>

    </form>

    <h2>Cidades cadastradas</h2>

    <table>

        <tr>

            <th>Nome</th>
            <th>País</th>
            <th>População</th>
            <th>Área</th>
            <th>Clima</th>
            <th>Governante</th>
            <th>Fundação</th>
            <th>Ações</th>

        </tr>

        <?php while ($linha = mysqli_fetch_array($resultado)) { ?>

        <tr>

            <td><?php echo $linha["nome"]; ?></td>

            <td><?php echo $linha["nome_pais"]; ?></td>

            <td><?php echo $linha["populacao"]; ?></td>

            <td><?php echo $linha["area"]; ?></td>

            <td><?php echo $linha["clima"]; ?></td>

            <td><?php echo $linha["nome_governante"]; ?></td>

            <td><?php echo $linha["data_fundacao"]; ?></td>

            <td>

                <a
                    class="editar"
                    href="cidade.php?editar=<?php echo $linha['id_cidade']; ?>"
                >
                    Editar
                </a>

                <a
                    class="excluir"
                    href="cidade.php?excluir=<?php echo $linha['id_cidade']; ?>"
                    onclick="return confirm('Deseja realmente excluir esta cidade?')"
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