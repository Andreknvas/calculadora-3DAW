<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    $nome = $_POST["nome"];
    $sigla = $_POST["sigla"];
    $carga = $_POST["carga"];
    $msg = "";
    echo "Nome da disciplina: " . $nome . "<br>";
    echo "Sigla da disciplina: " . $sigla . "<br>";
    echo "Carga Horária: " . $carga . "H" . "<br>";
   if (!file_exists("disciplinas.txt")) {
       $arqDisciplina = fopen("disciplinas.txt","w") or die("Não foi possível criar o arquivo");
       $linha = "nome;sigla;carga\n";
       fwrite($arqDisciplina,$linha);
       fclose($arqDisciplina);
   }
   $arqDisciplina = fopen("disciplinas.txt","a") or die("Não foi possível criar o arquivo");
    $linha = $nome . ";" . $sigla . ";" . $carga . "\n";
    fwrite($arqDisciplina,$linha);
    fclose($arqDisciplina);
    $msg = "Concluido";
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Criar Nova Disciplina</h1>
<form action="incluirDisciplina.php" method="POST">
    Nome da Disciplina: <input type="text" name="nome" required>
    <br><br>
    Sigla da Disciplina: <input type="text" name="sigla" required>
    <br><br>
    Carga Horaria: <input type="text" name="carga" required>
    <br><br>
    <input type="submit" value="Criar Nova Disciplina">
</form>
<p><?php echo $msg ?></p>
<br>
</body>
</html>
