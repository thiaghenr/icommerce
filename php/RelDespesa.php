<?php
require_once("../biblioteca.php");
include "../config.php";
conexao();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


$data = strftime("%Y-%m-%d", strtotime("-30 days")); // Hoje menos 30 dias
$hoje = date("Y-m-d");
//$dias = 30;



$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';
$dataini = isset($_POST['dataini']) ? converte_data('2',$_POST['dataini']) : $data ;
$datafim = isset($_POST['datafim']) ? converte_data('2',$_POST['datafim']) : $hoje ;

// Usa a funчуo strtotime() e pega o timestamp das duas datas:  
$time_inicial = strtotime($dataini);  
$time_final = strtotime($datafim);  
 // Calcula a diferenчa de segundos entre as duas datas:  
$diferenca = $time_final - $time_inicial; // 19522800 segundos  
 // Calcula a diferenчa de dias  
$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias  


if($acao == 'LctoDespesas'){
$entidade = $_POST['entidade'];

	$sql_lancamentos = "SELECT l.*, u.nome_user, date_format(l.dt_lanc_desp, '%d/%m/%Y')AS data, e.nome FROM entidades e, lanc_contas l";
	$sql_lancamentos .=	" LEFT JOIN usuario u ON u.id_usuario = l.usuario_id ";
	$sql_lancamentos .=	" WHERE l.dt_lanc_desp BETWEEN '$dataini' AND '$datafim 23:59:59.999' AND l.valor != '0' ";
	$sql_lancamentos .=	" AND e.controle = l.entidade_id AND l.receita_id = '2' ";
	if($entidade != ""){
	$sql_lancamentos .= " AND l.entidade_id = '$entidade' ";
	}
	$sql_lancamentos .= " ORDER BY  l.id_lanc_despesa ASC ";
		
		$exe_lancamentos = mysql_query($sql_lancamentos) or die(mysql_error().'-'.$sql_lancamentos);
		$total_geral = mysql_num_rows($exe_lancamentos);
		$arr = array();
		while($obj = mysql_fetch_array($exe_lancamentos, MYSQL_ASSOC)){
		
		$id = $obj['id_lanc_despesa'];
		$desc_desp = $obj['desc_desp'];
		$entidade = $obj['nome'];
		$documento = $obj['documento'];
		$data = $obj['data'];
		$nome_user = $obj['nome_user'];
		
		
		if($obj['receita_id'] == 2){
		$valor =  $obj['valor'];
		$entrada = 0;
		}
		
		$saldo = $entrada - $saida;
		$saldos += $entrada - $saida;
		
	//	$arr[] = $obj;
		
	//echo '({"total":"'.$total.'","Entradas":"'.$Entradas.'","Saidas":"'.$Saidas.'","Trf":"'.$Trf.'","Movimento":'.json_encode($arr).'})'; 

		 $arr[] = array("id"=>$id, "dia"=>$dia, "valor"=>$valor, "desc_desp"=>$desc_desp, "nome"=>$entidade, "nome_user"=>$nome_user,
						"doc"=>$doc, "documento"=>$documento, "data"=>$data);
	}
	 echo '({"totalLcto":"'.$total_geral.'","Lcto":'.json_encode($arr).'})'; 
	
	
	
}


?>