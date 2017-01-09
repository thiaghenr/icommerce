<?php
include "../config.php";
conexao();
//require_once("../verifica_login.php");
function ajustaValor($v) {
		$v = str_replace(".","",$v);
		$v = str_replace(".","",$v);
		$v = str_replace(".","",$v);
		$v = str_replace(",",".",$v);
		$v = str_replace("$","",$v);
		return $v;
	}


$query = $_POST['query'];
$acao = $_POST['acao'];
$idCaixa = $_POST['idCaixa'];
$user = $_POST['user'];


 $idcaixa = $_POST['caixaid'];

		$sql_lancamentos = "SELECT l.id AS idl,l.*,date_format(l.dt_lancamento, '%d/%m/%Y')AS dt_lancamento, e.nome
		FROM caixa_balcao c, lancamento_caixa_balcao l
		LEFT JOIN entidades e ON e.controle = l.entidade_id
		WHERE l.receita_id = '2'  AND l.caixa_id != '2'  ORDER BY l.id ASC ";
		$exe_lancamentos = mysql_query($sql_lancamentos) or die(mysql_error().'-'.$sql_lancamentos);
		$total = mysql_num_rows($exe_lancamentos);
		$arr = array();
		while($obj = mysql_fetch_array($exe_lancamentos, MYSQL_ASSOC)){
		
		
		
		$arr[] = $obj;
		}
	echo '({"result":'.json_encode($arr).'})'; 
?>

