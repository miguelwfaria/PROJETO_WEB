<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Análise</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="resultado">

    <div class="alunos-area">

        <?php
            // ==============================
            // 3.1 - RECEBIMENTO DOS DADOS
            // ==============================
            $turma = $_POST["turma"];
            $nome = $_POST["nome"];
            $nota1 = $_POST["nota1"];
            $nota2 = $_POST["nota2"];
            $trabalho = $_POST["trabalho"];

            echo "<h2>Turma: $turma</h2>";

            // ==============================
            // 3.2 - VARIÁVEIS DA TURMA
            // ==============================
            $somaMedias = 0;
            $somaTotalNotas = 0;

            $aprovados = 0;
            $recuperacao = 0;
            $reprovados = 0;

            $maiorMedia = 0;
            $menorMedia = 10;

            // ==============================
            // 3.2 - PROCESSAMENTO INDIVIDUAL
            // ==============================
            for ($i = 0; $i < count($nome); $i++) {
                echo "<div class='aluno'>";

                $soma = $nota1[$i] + $nota2[$i] + $trabalho[$i];
                $media = $soma / 3;
                $raiz = sqrt($soma);

                $maiorNota = max($nota1[$i], $nota2[$i], $trabalho[$i]);
                $menorNota = min($nota1[$i], $nota2[$i], $trabalho[$i]);
                $diferenca = abs($maiorNota - $menorNota);

                $somaMedias += $media;
                $somaTotalNotas += $soma;

                if ($media >= 7) {
                    $situacao = "Aprovado";
                    $classe = "aprovado";
                    $aprovados++;
                }
                else if ($media >= 5) {
                    $situacao = "Recuperação";
                    $classe = "recuperacao";
                    $recuperacao++;
                }
                else {
                    $situacao = "Reprovado";
                    $classe = "reprovado";
                    $reprovados++;
                }

                if ($media > $maiorMedia) {
                    $maiorMedia = $media;
                }

                if ($media < $menorMedia) {
                    $menorMedia = $media;
                }

                // ==============================
                // 3.3 - RELATÓRIO INDIVIDUAL
                // ==============================
                echo "<h3>Aluno: " . $nome[$i] . "</h3>";
                echo "<p>Média Aritmética: " . number_format($media, 2, ",", ".") . "</p>";
                echo "<p>Raiz Quadrada: " . number_format($raiz, 2, ",", ".") . "</p>";
                echo "<p>Diferença Absoluta: " . number_format($diferenca, 2, ",", ".") . "</p>";
                echo "<p class='$classe'>Situação Acadêmica: $situacao</p>";

                echo "</div>";
            }
        ?>

    </div>

    <div class="turma-area">

        <?php
            // ==============================
            // 3.2 - PROCESSAMENTO DA TURMA
            // ==============================
            $totalAlunos = count($nome);
            $mediaGeral = $somaMedias / $totalAlunos;
            $percentualAprovacao = ($aprovados / $totalAlunos) * 100;

            // ==============================
            // 3.3 - RELATÓRIO FINAL DA TURMA
            // ==============================
            echo "<h2>Resumo da Turma</h2>";

            echo "<p>Média Geral: " . number_format($mediaGeral, 2, ",", ".") . "</p>";
            echo "<p>Maior Média: " . number_format($maiorMedia, 2, ",", ".") . "</p>";
            echo "<p>Menor Média: " . number_format($menorMedia, 2, ",", ".") . "</p>";

            echo "<p>Aprovados: $aprovados</p>";
            echo "<p>Recuperação: $recuperacao</p>";
            echo "<p>Reprovados: $reprovados</p>";

            echo "<p>Percentual de Aprovação: " . number_format($percentualAprovacao, 2, ",", ".") . "%</p>";
            echo "<p>Soma Total das Notas: " . number_format($somaTotalNotas, 2, ",", ".") . "</p>";
        ?>

    </div>

</div>

</body>
</html>