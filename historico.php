<?php
require 'sessao.php';
require 'funcoes.php';

if (isset($_GET["excluir"])) {
    $indice = $_GET["excluir"];

    if (isset($_SESSION["transacoes"][$indice])) {
        unset($_SESSION["transacoes"][$indice]);
        $_SESSION["transacoes"] = array_values($_SESSION["transacoes"]);
    }

    header("Location: historico.php");
    exit();
}

if (isset($_POST["limpar"])) {
    $_SESSION["transacoes"] = [];
    header("Location: historico.php");
    exit();
}

$totalDespesas = 0;

foreach ($_SESSION["transacoes"] as $transacao) {
    if ($transacao["tipo"] == "despesa") {
        $totalDespesas += $transacao["valor"];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Histórico</title>

    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            text-align: center;
            margin-top: 40px;
        }

        .container {
            width: 900px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2d6cdf;
            color: white;
        }

        .positivo {
            color: green;
            font-weight: bold;
        }

        .negativo {
            color: red;
            font-weight: bold;
        }

        .btn {
            background-color: #2d6cdf;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin: 8px;
            border: none;
            cursor: pointer;
        }

        .excluir {
            color: red;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
        }

        .vazio {
            margin: 30px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Histórico de Transações</h1>

    <?php if (count($_SESSION["transacoes"]) == 0): ?>
        <p class="vazio">Nenhuma transação registrada.</p>
    <?php else: ?>

        <table>
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Impacto</th>
                <th>Percentual</th>
                <th>Excluir</th>
            </tr>

            <?php foreach ($_SESSION["transacoes"] as $indice => $transacao): ?>
                <tr>
                    <td><?php echo $transacao["nome"]; ?></td>

                    <td><?php echo $transacao["tipo"]; ?></td>

                    <td><?php echo formatarMoeda($transacao["valor"]); ?></td>

                    <td class="<?php echo $transacao["tipo"] == "receita" ? 'positivo' : 'negativo'; ?>">
                        <?php echo $transacao["tipo"] == "receita" ? '+' : '-'; ?>
                    </td>

                    <td>
                        <?php
                        if ($transacao["tipo"] == "despesa") {
                            echo number_format(
                                calcularPercentual($transacao["valor"], $totalDespesas),
                                2
                            ) . "%";
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>

                    <td>
                        <a class="excluir" href="historico.php?excluir=<?php echo $indice; ?>">✖</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>

    <?php endif; ?>

    <br>

    <a class="btn" href="index.php">Voltar</a>

    <form method="POST" style="display:inline;">
        <button class="btn" type="submit" name="limpar">Zerar Mês</button>
    </form>

    <a class="btn" href="logout.php">Sair</a>

</div>

</body>
</html>