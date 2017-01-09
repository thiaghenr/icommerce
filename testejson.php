<?php
include "config.php";
conexao();
include_once("php/json/JSON.php");
$json = new Services_JSON();
$dados = $json->decode($_GET["json"]);

for($i = 0; $i < count($dados); $i++){

$busca = mysql_query("SELECT Descricao FROM produtos where id = '".$dados[$i]->id."' ");
$itens = mysql_fetch_array($busca, MYSQL_ASSOC);


for($w = 0; $w < $dados[$i]->qtd; ){

echo $id = $dados[$i]->id." - ";
echo $itens['Descricao']." - ";
echo $qtd = $dados[$i]->qtd."<br>";

$w++;
}


}



?>