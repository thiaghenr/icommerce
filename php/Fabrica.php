<?php
include "../config.php";
conexao();
//require_once("../verifica_login.php");

 mysql_query("SET NAMES 'utf8'");
 mysql_query('SET character_set_connection=utf8');
 mysql_query('SET character_set_client=utf8');
 mysql_query('SET character_set_results=utf8');

//require_once("../biblioteca.php");

$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 30 ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';

// LEFT JOIN producao_itens_parcial psip ON psip.iditens_solicit = psi.idproducao_solicit_itens
//		LEFT JOIN unidade_medida un ON un.idunidade_medida = p.un_medida, 

// sum(psip.qtdproduzido) AS qtdproduzido,   un.sigla_medida  ,

if($acao == 'ListaProducao'){
$rss    = mysql_query("SELECT COUNT(*) AS total FROM producao_solicit WHERE 1=1 ");
$regs = mysql_fetch_array($rss, MYSQL_ASSOC);
$rs    = mysql_query("SELECT ps.*, psi.*, un.sigla_medida, date_format(ps.data_solicit, '%d/%m/%Y') AS data_solicit, 
		date_format(ps.data_validade, '%d/%m/%Y') AS data_validade,
		p.Descricao,p.Estoque,p.Codigo,  sum(psip.qtdproduzido) AS qtdproduzido
		FROM producao_solicit ps,  producao_solicit_itens psi		
		LEFT JOIN producao_itens_parcial psip ON psip.iditens_solicit = psi.idproducao_solicit_itens,
		produtos p
		LEFT JOIN unidade_medida un ON un.idunidade_medida = p.un_medida		
		WHERE psi.idproduto_produzir = p.id AND ps.idproducao_solicit = psi.idsolicit		
		GROUP BY ps.idproducao_solicit,psi.idproduto_produzir ORDER BY ps.idproducao_solicit DESC LIMIT $inicio, $limite")or die (mysql_error());	
		$arr = array();
		$total = $regs['total'];
		while($obj = mysql_fetch_array($rs))
		{	
			$arr[] = $obj;
			
		}

		echo '({"total":'.$total.',"result":'.json_encode($arr).'})'; 
		}
		
if($acao == 'listarInformes'){
$idIten = $_POST['idIten'];

	$sql = "SELECT *, date_format(dataproducao, '%d/%m/%Y') AS dataproducao FROM producao_itens_parcial WHERE iditens_solicit = '$idIten' ";
	$exe = mysql_query($sql);
	$arr = array();
		$total = mysql_num_rows($exe);
		while($obj = mysql_fetch_array($exe))
		{	
			$arr[] = $obj;
			
		}

		echo '({"total":'.$total.',"result":'.json_encode($arr).'})'; 
}

if($acao == 'novoInforme'){
$idIten = $_POST['idIten'];
$qtd = str_replace('.', '',$_POST['CantParcial']);
$qtd = str_replace('.', '',$qtd);
$qtd = str_replace('.', '',$qtd);
$qtd = str_replace('.', '',$qtd);
$qtd = str_replace(',', '.',$qtd);

		$exe = mysql_query("SELECT sum(qtdproduzido) AS totalprod FROM producao_itens_parcial WHERE iditens_solicit = '$idIten' ");
		$reg = mysql_fetch_array($exe,MYSQL_ASSOC);
		$totalproduzido = $reg['totalprod'];
		
		$exea = mysql_query("SELECT qtd_prdoduzir,idproduto_produzir FROM producao_solicit_itens WHERE idproducao_solicit_itens = '$idIten' ");
		$rega = mysql_fetch_array($exea,MYSQL_ASSOC);
		$totalproduzir = $rega['qtd_prdoduzir'];
		$idproduto_produzir = $rega['idproduto_produzir'];
		
		$restante = round($totalproduzir - $totalproduzido,2);
	
		$total = 0;
		if($qtd > ($restante)){
			echo "{success:true, total:'".$total."', response: 'Erro, Cantidad informada mayor que cantidad a producir'}"; 
			exit();
		}
		else{
		
			$sqlins = "INSERT INTO producao_itens_parcial (iditens_solicit, qtdproduzido, dataproducao, user, idproduto)
			VALUES('$idIten', '$qtd', NOW(), '$id_usuario', '$idproduto_produzir' )";
			$exeins = mysql_query($sqlins);
			$rows_affected = mysql_affected_rows();
				if($rows_affected){
				
						echo "{success:true, total:'".$rows_affected."', response: 'Operacion Realizada con Exito' }"; 
				}
			
		}
		
		





}
?>