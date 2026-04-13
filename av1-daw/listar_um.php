<form method="post">
ID: <input name="id">
<button>Buscar</button>
</form>

<?php
if ($_POST) {
    $id = $_POST['id'];
    $linhas = file("dados.txt");

    foreach ($linhas as $linha) {
        $dados = explode("|", $linha);

        if ($dados[0] == $id) {
            echo "Pergunta: " . $dados[2] . "<br>";

            if ($dados[1] == "M") {
                $respostas = explode(",", $dados[3]);
                foreach ($respostas as $r) {
                    echo $r . "<br>";
                }
            } else {
                echo "Resposta: " . $dados[3];
            }
        }
    }
}
?>