<?php
 require_once("../config.php");
 conexao();
//include "../funcao.php";
require_once("../biblioteca.php");
include_once("json/JSON.php");
 $json = new Services_JSON();
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 40 ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';

if($acao == 'ListaSolicit'){

	$rss = mysql_query("SELECT idproducao_solicit FROM producao_solicit WHERE 1=1 ");
	$total  =mysql_num_rows($rss);
	$sql = "SELECT ps.*, date_format(ps.data_solicit, '%d-%m-%Y') AS data_solicit, date_format(ps.data_validade, '%d-%m-%Y') AS data_validade, 
			date_format(ps.dtconclusao, '%d-%m-%Y') AS dtconclusao, u.nome_user FROM producao_solicit ps
			LEFT JOIN usuario u ON u.id_usuario = ps.user
			WHERE 1=1 ORDER BY ps.idproducao_solicit DESC LIMIT $inicio, $limite ";
	$exe = mysql_query($sql);
	$total  =mysql_num_rows($rss);
	$arr = array();
	while($obj = mysql_fetch_object($exe))
	{
		$arr[] = $obj;
	}
	echo '{"total":'.$total.',"results":'.json_encode($arr).'}'; 


}

if($acao == 'VerificaQtd'){
$idproduto = $_POST["idprod"];
$qtdnecessario = $_POST["qtd"];

	$sql = "SELECT prd.idproducao FROM  produtos p,  producao_prod prd WHERE prd.idproduto = p.id AND prd.idproduto = '$idproduto' ";
	$exe = mysql_query($sql)or die(mysql_error());
	$reg = mysql_fetch_array($exe, MYSQL_ASSOC);
		$idproducao = $reg['idproducao'];
		$sqlprod = "SELECT ig.qtd_ingred, p.Estoque,p.Descricao FROM produtos p, producao_ingred ig WHERE ig.idproducaoprod = '$idproducao' AND p.id = ig.id_produto";
		$exeprod = mysql_query($sqlprod)or die(mysql_error());
		$arr = array();
		$total = 0;
		WHILE($regprod = mysql_fetch_array($exeprod, MYSQL_ASSOC)){
		//echo	$Estoque = $regprod['Estoque']." - ";
     	//echo	$qtdutilisar = $regprod['qtd_ingred']." - ";
		//echo	$totalneces = $qtdnecessario * $qtdutilisar."\n";
			$Descricao = $regprod['Descricao'];
			$Estoque = $regprod['Estoque'];
     		$qtdutilisar = $regprod['qtd_ingred'];
			$totalneces = $qtdnecessario * $qtdutilisar;
		
		if($totalneces > $Estoque){ 
			$arr[] = array('Descricao'=>$Descricao);
			$total++; 
		}	
			
		}
		echo '{"total":'.$total.',"results":'.json_encode($arr).'}'; 
}

if($acao == 'CadSolicit'){

$dados = $json->decode($_POST["dados"]);
$dtproduzir = substr($_POST["dtproduzir"],0,10);
$user = $_POST["user"];

	$sqlins = "INSERT INTO producao_solicit (data_solicit, data_validade, user)
											VALUES(NOW(), '$dtproduzir', '$user')";
	$exeins = mysql_query($sqlins);
	$idsolicit = mysql_insert_id();

	for($i = 0; $i < count($dados); $i++){
	
	$idprod = $dados[$i]->idprod;
	$qtd_prdoduzir = $dados[$i]->qtd_prdoduzir;
	$obs  = $dados[$i]->obs; 
	
	$sql_ins = "INSERT INTO producao_solicit_itens (idsolicit,idproduto_produzir,qtd_prdoduzir,obs)
							VALUES('$idsolicit', '$idprod', '$qtd_prdoduzir', '$obs' )";
	$exe_ins = mysql_query($sql_ins, $base)or die (mysql_error().'-'.$sql_ins);	
	$rows_affected = mysql_affected_rows();			
	AtualizaEstoque($dados);
	if ($rows_affected) $count++;
	// funcao vai aki
	
	}
	if ($count) {
	$response = array('success'=>'true', 'del_count'=>$count, 'Ordem'=>$idsolicit);			
	echo json_encode($response);
	} else {
	echo '{failure: true}';
	}

}

if($acao == 'ListaItensOrdem'){
$id = $_POST["id"];

	$sql = "SELECT io.*, p.Codigo,p.Descricao,p.Estoque, un.sigla_medida, sum(psip.qtdproduzido) AS qtdproduzido 
	FROM produtos p
	LEFT JOIN unidade_medida un ON un.idunidade_medida = p.un_medida,
	producao_solicit_itens io
	LEFT JOIN producao_itens_parcial psip ON psip.iditens_solicit = io.idproducao_solicit_itens
	WHERE io.idsolicit = '$id' AND io.idproduto_produzir = p.id 
	GROUP BY io.idproducao_solicit_itens ";
	$exe = mysql_query($sql)or die(mysql_error());
	$total = mysql_num_rows($exe);
		$arr = array();
		while($obj = mysql_fetch_object($exe)){
		
		$arr[] = $obj;
		}
	echo '{"total":'.$total.',"results":'.json_encode($arr).'}'; 




}




?>

