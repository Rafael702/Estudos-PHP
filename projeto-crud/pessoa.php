<?php

class Pessoa
{
    private $pdo;
    //CONEXÃO COM O BANCO DE DADOS.
    public function __construct($dbname, $host, $user, $senha)
    {
        try {

            $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $user, $senha);
        } catch (PDOException $e) {
            echo "Erro com o banco de dados: " . $e->getMessage();
            exit();
        } catch (Exception $e) {
            echo "Erro Genérico: " . $e->getMessage();
            exit();
        }
    }
    //FUNÇÃO PARA BUSCAR DADOS E COLOCAR NO CANTO DIREITO DA TELA.
    public function buscarDados()
    {
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    //FUNÇÃO PARA CADASTRAR PESSOAS NO BANCO DE DADOS
    public function cadastrarPessoa($nome, $telefone, $email)
    {   
        //ANTES DE CADASTRAR VERIFICAR SE JA TEM O EMAIL CADASTRADO 
        $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        if ($cmd->rowCount() > 0) //email ja cadastrado no banco 
        {
            return false;
        } else {
            $cmd = $this->pdo->prepare("INSERT INTO pessoa(nome,telefone,email)
            VALUES(:n,:t,:e)");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->execute();
            return true;
        }
    }
}
