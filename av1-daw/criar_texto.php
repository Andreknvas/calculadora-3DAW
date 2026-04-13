<?php
if ($_POST) {
    $id = time();
    $pergunta = $_POST['pergunta'];
    $resposta = $_POST['resposta'];

    $linha = "$id|T|$pergunta|$resposta|\n";

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
Resposta: <input name="resposta"><br>
<button>Salvar</button>
</form>