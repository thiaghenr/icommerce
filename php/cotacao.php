<?php
 require_once("../biblioteca.php");
 require_once("../config.php");
 conexao();

$query = $_POST['query'];
$acao_nome = $_GET['acao_nome'];
$acao = $_POST['acao'];
$CodCliente = $_POST['CodCliente'];

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');



/////////////////////////////////////////////////////////////////////////////////////////////////
if($acao == "codCli"){

	$rs = mysql_query ("SELECT controle,nome,endereco,telefonecom FROM clientes where controle = '$CodCliente' ");
	$linha = mysql_num_rows ($rs);
	$arr = array();
	$reg = mysql_fetch_array($rs, MYSQL_ASSOC);
	$arr = $reg;
	echo json_encode($arr);

}
/////////////////////////////////////////////////////////////////////////////////////////////////////


if($acao_nome == "nomeCliente"){	
$r = mysql_query ("SELECT controle,nome,endereco,telefonecom FROM clientes where nome LIKE '%$query%' ORDER BY nome ASC");

$result = fetch_all($r);
	
echo json_encode(array(
	"resultados" => $result
));

}




//////////////////////////////////////////////////////////////////////////////////////////////////////////////










?>