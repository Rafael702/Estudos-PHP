<?php
require_once '../projeto-crud/pessoa.php';
$p = new Pessoa("crudpdo", "localhost", "root", "");

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CADASTRO PESSOA</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <?php
    if (isset($_POST['nome'])) {
        $nome = addslashes($_POST['nome']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST['email']);
        if (!empty($nome) && !empty($telefone) && !empty($email)) {
            //cadastrar
            if (!$p->cadastrarPessoa($nome, $telefone, $email)) {
                echo "Email já está cadastrado!";
            }
        } else {
            echo "Preencha todos os campos";
        }
    }
    ?>
    <section id="esquerda">
        <form method="POST">
            <h2>CADASTRAR PESSOA</h2>
            <label for="name">NOME</label>
            <input type="text" name="nome" id="nome">
            <label for="tel">TELEFONE</label>
            <input type="text" name="telefone" id="telefone">
            <label for="em">EMAIL</label>
            <input type="email" name="email" id="email">
            <input type="submit" value="Cadastrar">
        </form>
    </section>
    <section id="direita">
        <table>
            <tr id="titulo">
                <td>NOME</td>
                <td>TELEFONE</td>
                <td colspan="2">EMAIL</td>
            </tr>
            <?php
            $dados = $p->buscarDados();
            if (count($dados) > 0) { // Tem Pessoas cadastradas no banco 
                for ($i = 0; $i < count($dados); $i++) {
                    echo "<tr>";
                    foreach ($dados[$i] as $k => $v) {
                        if ($k != "id") {
                            echo "<td>" . $v . "</td>";
                        }
                    }
            ?>
                    <td><a href="">Editar</a><a href="">Excluir</a></td>
            <?php
                    echo "</tr>";
                }
            } else {
                echo "Ainda não há pessoas cadastradas!";
            }
            ?>

            </tr>
        </table>
    </section>
</body>

</html>