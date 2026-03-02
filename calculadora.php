<?php
$resultado = "";
$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = isset($_POST["a"]) ? (float)$_POST["a"] : 0;
    $b = isset($_POST["b"]) ? (float)$_POST["b"] : 0;
    $operador = $_POST["operador"] ?? "";

    if ($operador == "soma") {
        $resultado = $a + $b;
    } elseif ($operador == "sub") {
        $resultado = $a - $b;
    } elseif ($operador == "multi") {
        $resultado = $a * $b;
    } elseif ($operador == "divide") {
        if ($b != 0) {
            $resultado = $a / $b;
        } else {
            $erro = "Erro: Divisão por zero!";
        }
    } else {
        $erro = "Selecione uma operação!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>

    <form method="POST" action="">
        Número A: <input type="number" name="a" step="any" required><br>
        Número B: <input type="number" name="b" step="any" required><br>

        <br>Operação:
        <br><input type="radio" name="operador" value="soma" checked> Soma
        <br><input type="radio" name="operador" value="sub"> Subtração
        <br><input type="radio" name="operador" value="multi"> Multiplicação
        <br><input type="radio" name="operador" value="divide"> Divisão
        <br><br>

        <input type="submit" value="Calcular">
    </form>

    <hr>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($erro != "") {
            echo "<b>$erro</b>";
        } else {
            echo "<b>Resultado: $resultado</b>";
        }
    }
    ?>
</body>
</html>
