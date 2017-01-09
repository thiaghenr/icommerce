<?php
include "../config.php";
//include "../funcao.php";
require_once("../biblioteca.php");
conexao();
$mespassado = strftime("%Y-%m-%d", strtotime("-1 month")); // Hoje menos 1 mes
//echo $mespassado;

$mes= date("m");
$ano= date("Y");
$hoje = date("Y-m");

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

$acao = $_POST['acao'];

if($acao == "ListaProds"){ 
$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 50;  // LEFT JOIN producao_solicit ps ON ps.idproducao_solicit = psi.idprodsolicit 

	$rs    = mysql_query("SELECT pdc.*, p.Descricao, p.Codigo, p.Estoque, psi.qtd_produzido FROM  producao_prod pdc, produtos p 
			LEFT JOIN producao_solicit_itens psi ON psi.idprodsolicit = p.id 
			WHERE pdc.idproduto = p.id  
			ORDER BY pdc.idproducao DESC LIMIT $inicio, $limite ")or die (mysql_error().'-'.$rs);
	$total = mysql_num_rows($rs);
	
	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	echo '({"total":"'.$total.'","results":'.json_encode($arr).'})'; 
}

if($acao == "AddProducao"){ 
$idprod = $_POST['idprod'];

	$sql = mysql_query("SELECT idproduto FROM producao_prod WHERE idproduto = '$idprod' ");
	$row = mysql_num_rows($sql);
	if($row == 0){
		$sqlins = "INSERT INTO producao_prod (idproduto) VALUES('$idprod')";
		$exeins = mysql_query($sqlins, $base);
		$rows_affected = mysql_affected_rows();
		if($rows_affected){
			echo "{success:true, response: 'Operacion Realizada con Exito' }"; 
		}
		else{
			echo "{success:true, response: 'Erro, Verifique'}"; 
		}
	}
	else{
			echo "{success:true, response: 'Produto ja incluido'}"; 
		}
}
if($acao == "ListaInsumos"){
$idproducao = $_POST['idproducao'];

	$sql = "SELECT pi.*, p.Descricao,p.Codigo,p.custo, pdc.idproduto, un.sigla_medida FROM producao_ingred pi, producao_prod pdc, produtos p
			LEFT JOIN unidade_medida un ON un.idunidade_medida = p.un_medida
			WHERE pi.idproducaoprod = '$idproducao' AND pi.id_produto = p.id AND pi.idproducaoprod = pdc.idproducao ";
	$exe = mysql_query($sql);
	$total = mysql_num_rows($exe);
	$arr = array();
	while($obj = mysql_fetch_object($exe))
	{
		$idproducaoprod = $obj->idproducaoprod;	
		$idprod = $obj->id_produto;
		$codigo = $obj->Codigo.' - '.$obj->Descricao;
		$idproduto = $obj->idproduto;
		$sigmed = $obj->sigla_medida;
		$custo = $obj->custo;
		$qtd = $obj->qtd_ingred;
		
		$arr[] = array('idproduto'=>$idproduto, 'codigo'=>$codigo, 'qtd_produto'=>$qtd, 'idproducaoprod'=>$idproducaoprod, 'idprod'=>$idprod,  'custo'=>$custo, 'sigmed'=>$sigmed);
		
	}
	echo '({"total":"'.$total.'","results":'.json_encode($arr).'})'; 
	



}


if($acao == "AddInsumo"){ 
$idproduto = $_POST['idproduto'];
$idinsumo = $_POST['idinsumo'];
$qtd = $_POST['qtd'];
$idproducao = $_POST['idproducao'];   //resolver adicionando itens nao devido

	$sql = "SELECT COUNT(*) AS itens FROM producao_ingred WHERE id_produto = '$idinsumo' AND idproducaoprod = '$idproducao' ";
	$exe = mysql_query($sql);
	$reg = mysql_fetch_array($exe, MYSQL_ASSOC);
		$itens = $reg['itens'];
		if($itens == 0){
			$sqlins = "INSERT INTO producao_ingred (idproducaoprod,id_produto,un_medida,qtd_ingred,userid )
						VALUES('$idproducao', '$idinsumo', '', '$qtd', '' )";
			$exe = mysql_query($sqlins);
			$rows_affected = mysql_affected_rows();
				if($rows_affected){
						AtualizaCusto($idproduto,$idinsumo,$qtd);
						echo "{success:true, response: 'Operacion Realizada con Exito' }"; 
				}
		}
		if($itens > 0){
			$sqlup = "UPDATE producao_ingred SET qtd_ingred = '$qtd' WHERE idproducaoprod = '$idproducao' AND id_produto = '$idinsumo' ";
			$exe = mysql_query($sqlup);
			$rows_affected = mysql_affected_rows();
				if($rows_affected){
						AtualizaCusto($idproduto,$idinsumo,$qtd);
						echo "{success:true, response: 'Alterado con Exito' }"; 
				}
		
		
		}
}

if($acao == "RemInsumo"){ 
$idproduto = $_POST['idproduto'];
$idinsumo = $_POST['idinsumo'];	
$idproducao = $_POST['idproducao'];

		$sql = "DELETE FROM producao_ingred WHERE idproducaoprod = '$idproducao' AND id_produto = '$idinsumo' ";
		$exe = mysql_query($sql)or die(mysql_error());
		$rows_affected = mysql_affected_rows();
				if($rows_affected){
						AtualizaCusto($idproduto,$idinsumo,$qtd);
						echo "{success:true, response: 'Alterado con Exitos' }"; 
				}
	
}
	










?>