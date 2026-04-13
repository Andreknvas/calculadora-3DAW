<?php
if ($_POST) {
    $id = time();
    $pergunta = $_POST['pergunta'];
    $r1 = $_POST['r1'];
    $r2 = $_POST['r2'];
    $r3 = $_POST['r3'];
    $r4 = $_POST['r4'];
    $correta = $_POST['correta'];

    $linha = "$id|M|$pergunta|$r1,$r2,$r3,$r4|$correta\n";

    if (!file_exists("dados.txt")) {
       $arqDisc = fopen("dados.txt","w") or die("erro ao criar arquivo");
       $linha = "Perguntas abaixo\n";
       fwrite($arqDisc,$linha);
       fclose($arqDisc);
   }

    file_put_contents("dados.txt", $linha, FILE_APPEND);

    echo "Salvo!";
}
?>

<form method="post">
Pergunta: <input name="pergunta"><br>
R1: <input name="r1"><br>
R2: <input name="r2"><br>
R3: <input name="r3"><br>
R4: <input name="r4"><br>
Correta (1-4): <input name="correta"><br>
<button>Salvar</button>
</form>