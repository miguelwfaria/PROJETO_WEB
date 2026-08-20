<?php
include("conexao.php");

// ==============================
// EXCLUSÃO
// ==============================
if (isset($_GET["excluir"])) {

    $id = $_GET["excluir"];

    $sql = "DELETE FROM continente WHERE id_continente = $id";

    if (mysqli_query($conexao, $sql)) {
        echo "<script>alert('Continente excluído com sucesso!'); window.location='continente.php';</script>";
    }
    else {
        echo "<script>alert('Não foi possível excluir. Verifique se existem países associados a este continente.'); window.location='continente.php';</script>";
    }
}

// ==============================
// CADASTRO E ALTERAÇÃO
// ==============================
if (isset($_POST["salvar"])) {

    $nome = $_POST["nome"];
    $populacao = $_POST["populacao"];
    $area = $_POST["area"];
    $total_paises = $_POST["total_paises"];

    if ($_POST["salvar"] == "cadastrar") {

        $sql = "INSERT INTO continente(nome, populacao, area, total_paises)
                VALUES ('$nome', $populacao, $area, $total_paises)";
    }
    else {

        $id = $_POST["id_continente"];

        $sql = "UPDATE continente
                SET nome='$nome',
                    populacao=$populacao,
                    area=$area,
                    total_paises=$total_paises
                WHERE id_continente=$id";
    }

    if (mysqli_query($conexao, $sql)) {
        echo "<script>alert('Registro salvo com sucesso!'); window.location='continente.php';</script>";
    }
    else {
        echo "Erro: " . mysqli_error($conexao);
    }
}

// ==============================
// DADOS PARA EDIÇÃO
// ==============================
$editar = false;

$continente = array(
    "id_continente"=>"",
    "nome"=>"",
    "populacao"=>"",
    "area"=>"",
    "total_paises"=>""
);

if (isset($_GET["editar"])) {

    $editar = true;

    $id = $_GET["editar"];

    $resultado_edicao = mysqli_query(
        $conexao,
        "SELECT * FROM continente WHERE id_continente=$id"
    );

    $continente = mysqli_fetch_array($resultado_edicao);
}

// ==============================
// LISTAGEM
// ==============================
$resultado = mysqli_query(
    $conexao,
    "SELECT * FROM continente ORDER BY nome"
);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Continentes</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <a class="voltar" href="index.php">← Voltar</a>

    <h1>Continentes</h1>

    <form method="POST">

        <input
            type="hidden"
            name="id_continente"
            value="<?php echo $continente['id_continente']; ?>"
        >

        <label>Nome:</label>
        <input
            type="text"
            name="nome"
            value="<?php echo $continente['nome']; ?>"
            required
        >

        <label>População:</label>
        <input
            type="number"
            name="populacao"
            value="<?php echo $continente['populacao']; ?>"
            required
        >

        <label>Área (km²):</label>
        <input
            type="number"
            step="0.01"
            name="area"
            value="<?php echo $continente['area']; ?>"
            required
        >

        <label>Total de países:</label>
        <input
            type="number"
            name="total_paises"
            value="<?php echo $continente['total_paises']; ?>"
            required
        >

        <button
            type="submit"
            name="salvar"
            value="<?php echo $editar ? 'editar' : 'cadastrar'; ?>"
        >
            <?php echo $editar ? 'Alterar' : 'Cadastrar'; ?>
        </button>

        <?php if ($editar) { ?>

            <a class="botao cancelar" href="continente.php">
                Cancelar
            </a>

        <?php } ?>

    </form>

    <h2>Continentes cadastrados</h2>

    <table>

        <tr>
            <th>Nome</th>
            <th>População</th>
            <th>Área</th>
            <th>Total de países</th>
            <th>Ações</th>
        </tr>

        <?php while ($linha = mysqli_fetch_array($resultado)) { ?>

        <tr>

            <td><?php echo $linha["nome"]; ?></td>

            <td><?php echo $linha["populacao"]; ?></td>

            <td><?php echo $linha["area"]; ?></td>

            <td><?php echo $linha["total_paises"]; ?></td>

            <td>

                <a
                    class="editar"
                    href="continente.php?editar=<?php echo $linha['id_continente']; ?>"
                >
                    Editar
                </a>

                <a
                    class="excluir"
                    href="continente.php?excluir=<?php echo $linha['id_continente']; ?>"
                    onclick="return confirm('Deseja realmente excluir este continente?')"
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