<?php
try{
    $pdo = new PDO("mysql:dbname=crudpdo;host=localhost","root","");
}catch(PDOException $e){
    echo "Erro com o Banco de dados: ".$e->getMessage();
}catch(Exception $e){
    echo "Erro genérico: ".$e->getMessage();;
}
//-------------------------------------INSERT--------------------------------------------------------//
//1°Forma
//Inserir Valores no Banco de Dados
$res = $pdo->prepare("INSERT INTO pessoa(nome,telefone,email)
    VALUES(:n,:t,:e)");

//Valores
$res->bindValue(":n","Roberta");
$res->bindValue(":t","987643461");
$res->bindValue(":e","roberta@gmail.com");
$res->execute(); 


//2°Forma:
//$pdo->query("INSERT INTO pessoa(nome,telefone,email)
//VALUES ('Paulo','906856536','paulo@gmail')");
?>