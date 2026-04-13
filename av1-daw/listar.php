<?php
$linhas = file("dados.txt");

foreach ($linhas as $linha) {
    $dados = explode("|", $linha);

    echo "ID: " . $dados[0] . "<br>";
    echo "Pergunta: " . $dados[2] . "<br>";
    echo "Tipo: " . $dados[1] . "<br>";
    echo "----------------------<br>";
}
?>