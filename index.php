<?php
require 'sessao.php';
require 'funcoes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["limpar"])) {
    $nome = $_POST["nome"];
    $valor = floatval($_POST["valor"]);
    $tipo = $_POST["tipo"];

    $novaTransacao = [
        "nome" => $nome,
        "valor" => $valor,
        "tipo" => $tipo
    ];

    $_SESSION["transacoes"][] = $novaTransacao;
}

$saldo = calcularSaldo($_SESSION["transacoes"]);

$totalReceitas = 0;
$totalDespesas = 0;

foreach ($_SESSION["transacoes"] as $transacao) {
    if ($transacao["tipo"] == "receita") {
        $totalReceitas += $transacao["valor"];
    } else {
        $totalDespesas += $transacao["valor"];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Financeiro</title>

    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            text-align: center;
            margin-top: 40px;
        }

        .container {
            width: 750px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
        }

        .cards {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin: 25px 0;
        }

        .card {
            flex: 1;
            padding: 20px;
            border-radius: 14px;
            background: #f9f9f9;
        }

        .card h3 {
            margin-bottom: 10px;
            color: #444;
        }

        .valor {
            font-size: 24px;
            font-weight: bold;
        }

        .receita {
            color: green;
        }

        .despesa {
            color: red;
        }
        .disponivel {
            color: #2d6cdf;
        }
        .adicionar {
            color: white;
        }

        input, select, button {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 15px;
        }

        button {
            background-color: #2d6cdf;
            color: gray;
            border: none;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: #2d6cdf;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Dashboard Financeiro</h1>

    <div class="cards">

        <div class="card">
            <h3>Total Receitas</h3>
            <p class="valor receita">
                <?php echo formatarMoeda($totalReceitas); ?>
            </p>
        </div>

        <div class="card">
            <h3>Total Despesas</h3>
            <p class="valor despesa">
                <?php echo formatarMoeda($totalDespesas); ?>
            </p>
        </div>

        <div class="card">
            <h3>Saldo Disponível</h3>
            <p class="valor disponivel <?php echo $saldo >= 0 ? 'receita' : 'despesa'; ?>">
                <?php echo formatarMoeda($saldo); ?>
            </p>
        </div>

    </div>

    <h2>Nova Transação</h2>

    <form method="POST">
        <input type="text" name="nome" placeholder="Nome da transação" required>

        <input type="number" step="0.01" name="valor" placeholder="Valor" required>

        <select name="tipo">
            <option value="receita">Receita</option>
            <option value="despesa">Despesa</option>
        </select>

        <button type="submit" class="valor adicionar">Adicionar</button>
    </form>

    <br>

    <a href="historico.php">Ver Histórico</a><br><br>
    <a href="logout.php">Sair</a>

</div>

</body>
</html>