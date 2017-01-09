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
$dataini = isset($_POST['dataini']) ? substr($_POST['dataini'],0,10) : $data ;
$datafim = isset($_POST['datafim']) ? substr($_POST['datafim'],0,10) : $hoje ;

// Usa a função strtotime() e pega o timestamp das duas datas:  
$time_inicial = strtotime($dataini);  
$time_final = strtotime($datafim);  
 // Calcula a diferença de segundos entre as duas datas:  
$diferenca = $time_final - $time_inicial; // 19522800 segundos  
 // Calcula a diferença de dias  
$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias  


if($acao == 'LctoDespesas'){
function addCaracter($var, $caracter, $lim){
	$tamanho = strlen($var);
	if($tamanho > $lim){	
		$quebra = $tamanho/$lim;
		$ini = 0;
		$fim = $lim;
	
		for($i=0; $i <= intval($quebra); $i++){
			if($i == intval($quebra))
				$nova.= substr($var, $ini, $lim);
			else
				$nova.= substr($var, $ini, $lim).$caracter;
		
			$ini = $fim;
			$fim = $fim+$lim;
		}
	
		return $nova;
		
	} else {
		return $var;
	}

}
$contaid = $_POST['contaid'];

	$sql = "SELECT plancodigo,plancodigopai,plantipo FROM planocontas WHERE idplanocontas = '$contaid' ";
	$exe = mysql_query($sql);
	$reg = mysql_fetch_array($exe, MYSQL_ASSOC);
	$inicio = substr($reg['plancodigo'],0,2);
	$meio = substr($reg['plancodigo'],2,9);
	$fim = substr($reg['plancodigo'],11,6);
	$codigo = str_replace('.','',$reg['plancodigo']);
	$plantipo = $reg['plantipo'];

	$meio = str_replace('.','',$meio);
	$fim = str_replace('.','',$fim);
	
	$meio = rtrim($meio, "0");
	$fim = rtrim($fim, "0");
	
	$codigo = $meio.$fim;
	$codigo = addCaracter($codigo, ".", "2");
	$codigo = $inicio.$codigo;
	
	if($plantipo == "A"){
		$sql_lancamentos = "SELECT l.*, u.nome_user, date_format(l.dt_lanc_desp, '%d/%m/%Y')AS data, e.nome FROM entidades e, lanc_contas l";
		$sql_lancamentos .=	" LEFT JOIN usuario u ON u.id_usuario = l.usuario_id ";
		$sql_lancamentos .=	" WHERE l.dt_lanc_desp BETWEEN '$dataini' AND '$datafim 23:59:59.999' AND l.valor != '0' ";
		$sql_lancamentos .=	" AND e.controle = l.entidade_id AND l.receita_id = '2' ";
		if($contaid != ""){
		$sql_lancamentos .= " AND l.plano_id = '$contaid' ";
		}
		$sql_lancamentos .= " ORDER BY  l.id_lanc_despesa ASC ";
	}
	if($plantipo == "S"){
		$sql_lancamentos = "SELECT l.*, u.nome_user, date_format(l.dt_lanc_desp, '%d/%m/%Y')AS data, e.nome FROM entidades e, lanc_contas l";
		$sql_lancamentos .=	" LEFT JOIN usuario u ON u.id_usuario = l.usuario_id ";
		$sql_lancamentos .=	" WHERE l.dt_lanc_desp BETWEEN '$dataini' AND '$datafim 23:59:59.999' AND l.valor != '0' ";
		$sql_lancamentos .=	" AND e.controle = l.entidade_id AND l.receita_id = '2' ";
		if($contaid != ""){
		$sql_lancamentos .= " AND l.plan_codigo LIKE '$codigo%' ";
		}
		$sql_lancamentos .= " ORDER BY  l.id_lanc_despesa ASC ";
	}
	
	//echo $codigo;
	
	
	
		$exe_lancamentos = mysql_query($sql_lancamentos) or die(mysql_error().'-'.$sql_lancamentos);
		$total_geral = mysql_num_rows($exe_lancamentos);
		$arr = array();
		while($obj = mysql_fetch_array($exe_lancamentos, MYSQL_ASSOC)){
		
		$id = $obj['id_lanc_despesa'];
		$desc_desp = $obj['desc_desp'];
		$contaid = $obj['plano_id'];
		$nome = $obj['nome'];
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

		 $arr[] = array("id"=>$id, "informe"=>'Informe', "valor"=>$valor, "nome_despesa"=>$desc_desp, "nome"=>$nome, "nome_user"=>$nome_user,
						"doc"=>$doc, "documento"=>$documento, "dt_lanc_desp"=>$data);
	}
	 echo '({"Despesas":'.json_encode($arr).'})'; 
	
	
	
}


?>