<form method="post">
ID: <input name="id">
<button>Excluir</button>
</form>

<?php
if ($_POST) {
    $id = $_POST['id'];
    $linhas = file("dados.txt");
    $novo = "";

    foreach ($linhas as $linha) {
        $dados = explode("|", $linha);

        if ($dados[0] != $id) {
            $novo .= $linha;
        }
    }

    file_put_contents("dados.txt", $novo);
    echo "Excluído!";
}
?>