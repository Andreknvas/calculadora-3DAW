<form method="post">
ID: <input name="id"><br>
Nova pergunta: <input name="pergunta"><br>
Nova resposta: <input name="resposta"><br>
<button>Alterar</button>
</form>

<?php
if ($_POST) {
    $id = $_POST['id'];
    $linhas = file("dados.txt");
    $novo = "";

    foreach ($linhas as $linha) {
        $dados = explode("|", $linha);

        if ($dados[0] == $id) {
            $dados[2] = $_POST['pergunta'];

            if ($dados[1] == "T") {
                $dados[3] = $_POST['resposta'];
            }

            $linha = implode("|", $dados);
        }

        $novo .= $linha;
    }

    file_put_contents("dados.txt", $novo);
    echo "Alterado!";
}
?>