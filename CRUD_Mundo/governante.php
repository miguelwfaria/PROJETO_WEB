<?php
include("conexao.php");

// ==============================
// EXCLUSÃO
// ==============================
if (isset($_GET["excluir"])) {

    $id = $_GET["excluir"];

    $sql = "DELETE FROM governante WHERE id_governante=$id";

    if (mysqli_query($conexao, $sql)) {

        echo "<script>alert('Governante excluído com sucesso!'); window.location='governante.php';</script>";
    }
    else {

        echo "<script>alert('Não foi possível excluir. Este governante pode estar associado a um país ou cidade.'); window.location='governante.php';</script>";
    }
}

// ==============================
// CADASTRO E ALTERAÇÃO
// ==============================
if (isset($_POST["salvar"])) {

    $nome = $_POST["nome"];
    $partido_politico = $_POST["partido_politico"];
    $data_nascimento = $_POST["data_nascimento"];
    $idade = $_POST["idade"];
    $data_inicio_mandato = $_POST["data_inicio_mandato"];
    $data_fim_mandato = $_POST["data_fim_mandato"];

    if ($_POST["salvar"] == "cadastrar") {

        if ($data_fim_mandato == "") {
            $fim_mandato = "NULL";
        }
        else {
            $fim_mandato = "'$data_fim_mandato'";
        }

        $sql = "INSERT INTO governante
                (nome, partido_politico, data_nascimento, idade,
                 data_inicio_mandato, data_fim_mandato)
                VALUES
                ('$nome', '$partido_politico', '$data_nascimento',
                 $idade, '$data_inicio_mandato', $fim_mandato)";
    }
    else {

        $id = $_POST["id_governante"];

        if ($data_fim_mandato == "") {
            $fim_mandato = "NULL";
        }
        else {
            $fim_mandato = "'$data_fim_mandato'";
        }

        $sql = "UPDATE governante
                SET nome='$nome',
                    partido_politico='$partido_politico',
                    data_nascimento='$data_nascimento',
                    idade=$idade,
                    data_inicio_mandato='$data_inicio_mandato',
                    data_fim_mandato=$fim_mandato
                WHERE id_governante=$id";
    }

    if (mysqli_query($conexao, $sql)) {

        echo "<script>alert('Registro salvo com sucesso!'); window.location='governante.php';</script>";
    }
    else {

        echo "Erro: " . mysqli_error($conexao);
    }
}

// ==============================
// DADOS PARA EDIÇÃO
// ==============================
$editar = false;

$governante = array(
    "id_governante"=>"",
    "nome"=>"",
    "partido_politico"=>"",
    "data_nascimento"=>"",
    "idade"=>"",
    "data_inicio_mandato"=>"",
    "data_fim_mandato"=>""
);

if (isset($_GET["editar"])) {

    $editar = true;

    $id = $_GET["editar"];

    $resultado_edicao = mysqli_query(
        $conexao,
        "SELECT * FROM governante WHERE id_governante=$id"
    );

    $governante = mysqli_fetch_array($resultado_edicao);
}

// ==============================
// LISTAGEM
// ==============================
$resultado = mysqli_query(
    $conexao,
    "SELECT * FROM governante ORDER BY nome"
);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Governantes</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <a class="voltar" href="index.php">← Voltar</a>

    <h1>Governantes</h1>

    <form method="POST">

        <input
            type="hidden"
            name="id_governante"
            value="<?php echo $governante['id_governante']; ?>"
        >

        <label>Nome:</label>

        <input
            type="text"
            name="nome"
            value="<?php echo $governante['nome']; ?>"
            required
        >

        <label>Partido político:</label>

        <input
            type="text"
            name="partido_politico"
            value="<?php echo $governante['partido_politico']; ?>"
            required
        >

        <label>Data de nascimento:</label>

        <input
            type="date"
            name="data_nascimento"
            value="<?php echo $governante['data_nascimento']; ?>"
            required
        >

        <label>Idade:</label>

        <input
            type="number"
            name="idade"
            value="<?php echo $governante['idade']; ?>"
            required
        >

        <label>Data de início do mandato:</label>

        <input
            type="date"
            name="data_inicio_mandato"
            value="<?php echo $governante['data_inicio_mandato']; ?>"
            required
        >

        <label>Data de fim do mandato:</label>

        <input
            type="date"
            name="data_fim_mandato"
            value="<?php echo $governante['data_fim_mandato']; ?>"
        >

        <button
            type="submit"
            name="salvar"
            value="<?php echo $editar ? 'editar' : 'cadastrar'; ?>"
        >
            <?php echo $editar ? 'Alterar' : 'Cadastrar'; ?>
        </button>

        <?php if ($editar) { ?>

            <a class="botao cancelar" href="governante.php">
                Cancelar
            </a>

        <?php } ?>

    </form>

    <h2>Governantes cadastrados</h2>

    <table>

        <tr>
            <th>Nome</th>
            <th>Partido</th>
            <th>Nascimento</th>
            <th>Idade</th>
            <th>Início</th>
            <th>Fim</th>
            <th>Ações</th>
        </tr>

        <?php while ($linha = mysqli_fetch_array($resultado)) { ?>

        <tr>

            <td><?php echo $linha["nome"]; ?></td>
            <td><?php echo $linha["partido_politico"]; ?></td>
            <td><?php echo $linha["data_nascimento"]; ?></td>
            <td><?php echo $linha["idade"]; ?></td>
            <td><?php echo $linha["data_inicio_mandato"]; ?></td>

            <td>
                <?php
                if ($linha["data_fim_mandato"] == NULL) {
                    echo "-";
                }
                else {
                    echo $linha["data_fim_mandato"];
                }
                ?>
            </td>

            <td>

                <a
                    class="editar"
                    href="governante.php?editar=<?php echo $linha['id_governante']; ?>"
                >
                    Editar
                </a>

                <a
                    class="excluir"
                    href="governante.php?excluir=<?php echo $linha['id_governante']; ?>"
                    onclick="return confirm('Deseja realmente excluir este governante?')"
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