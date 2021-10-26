<?php
try{
    $pdo = new PDO("mysql:dbname=crudpdo;host=localhost","root","");
}catch(PDOException $e){
    echo "Erro com o Banco de dados: ".$e->getMessage();
}catch(Exception $e){
    echo "Erro genérico: ".$e->getMessage();;
}
