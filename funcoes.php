<?php

function calcularSaldo($transacoes) {
    $saldo = 0;

    foreach ($transacoes as $transacao) {
        if ($transacao["tipo"] == "receita") {
            $saldo += $transacao["valor"];
        } else {
            $saldo -= $transacao["valor"];
        }
    }

    return $saldo;
}

function formatarMoeda($valor) {
    return "R$ " . number_format($valor, 2, ",", ".");
}

function calcularPercentual($valor, $totalDespesas) {
    if ($totalDespesas == 0) {
        return 0;
    }

    return ($valor / $totalDespesas) * 100;
}

?>