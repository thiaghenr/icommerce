<?	
require_once("../biblioteca.php");
require_once ("../config.php");
conexao();
include_once("json/JSON.php");
$json = new Services_JSON();

 $id_usuario = $_POST['user'];
 $caixapagoconta = $_POST['caixapagoconta'];
 
if($caixapagoconta == "cxuser"){
$sql_caixa_balcao = "SELECT id FROM caixa_balcao WHERE usuario_id = '$id_usuario' AND st_caixa = 'A' ";
		$rs_caixa_balcao = mysql_query($sql_caixa_balcao);
		$linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao, MYSQL_ASSOC);
		$caixa_id = $linha_caixa_balcao['id'];
		if($caixa_id == ''){
			echo "{success: true,msg: 'Hacer login novamente, o tu caja esta cerrado'}";
		exit();
		}
}
		
$sql_lista = "SELECT * FROM caixa ORDER BY id DESC limit 0,1 ";
$exe_lista = mysql_query($sql_lista, $base);
$reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC);
$caixa_atual = $reg_lista['id'];



mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');
	
$query = $_POST['query'];
$acao_nome = $_GET['acao_nome'];
$acao = $_POST['acao'];
$CodForn = $_POST['CodForn'];
$user = $_POST['user'];

if($acao == "fornCod"){

	$rs = mysql_query ("SELECT controle,nome,endereco FROM entidades where controle = '$CodForn' ");
	$linha = mysql_num_rows ($rs);
	$arr = array();
	$reg = mysql_fetch_array($rs, MYSQL_ASSOC);
	$arr = $reg;
	echo json_encode($arr);

}
////////////////////////////////////////////////////////////////////////////////////////////////////
if($acao == "Cadastra"){
$plano = $_POST['iddesp'];
$ndoc = $_POST['documento'];
$dt_fatura = converte_data('2',$_POST['dtfatura']);
//$valora = str_replace('.', '',$_POST['vltotal']);
$valor = str_replace(',', '.',$_POST['vltotal']);
$desc = $_POST['desc'];
$fornecedor_id = $_POST['idFornecedor'];
$obs = $_POST['obsDesp'];
$user = $_POST['user'];
$qtd = $_POST['index'];
$idnode = $_POST['idnode'];
$nomedesp = $_POST['nomedesp'];


$receita = $nomedesp{0};
if($receita == "1"){
}

function ctpagar($lanc_desp_id,$ndoc,$fornecedor_id,$dt_fatura,$valor,$status,$dtpgto,$dt_vencimento_parcela,$total){

	$sql_pagar = "INSERT INTO contas_pagar (lanc_desp_id,num_fatura,fornecedor_id,dt_emissao_fatura,vl_total_fatura,status,dt_pgto_parcela,dt_vencimento_parcela,vl_parcela,dt_vencimento_parcelab)";
			$sql_pagar.= "VALUES ('$lanc_desp_id','$ndoc','$fornecedor_id','$dt_fatura','$total','$status', '$dtpgto', '$dt_vencimento_parcela','$valor', NOW() )";
			mysql_query($sql_pagar) or die(mysql_error());
			global $cont_pag_id;
			$cont_pag_id = mysql_insert_id();
}

$r = mysql_query ("SELECT plandescricao,plancodigo FROM planocontas where idplanocontas = '$idnode' ");
$reg = mysql_fetch_array($r, MYSQL_ASSOC);
$plandescricao = $reg['plandescricao'];
$plancodigo = $reg['plancodigo'];


$z=1;
		if($caixapagoconta == "credito"){
			$dt_vencimento_parcela = converte_data('2',$_POST["vencimentoconta"]);
			$vl_parcelaa = str_replace("." , "" , $_POST["valor$z"]);
			$vl_parcela = $valor;					
			$num_parcela = '0';
			// Alterado para lancamento de faturas antigas dt_lanc_desp, venc_desp NOW(),NOW()
			
			/* Comentado,pois lancamentos a prazo nao podem ainda aparecer em lancamento de caixa e contas lancadas.
			$sql_per = "INSERT INTO lanc_contas (receita_id, plano_id, documento, dt_lanc_desp, venc_desp, dt_fatura_desp, 
						desc_desp, valor, usuario_id, nm_total_parcela, nm_parcela, entidade_id, valor_total, plan_codigo, dt_lanc_despb ) 
						VALUES('$receita', '$idnode', UCASE('$ndoc'), '$dt_fatura', '$dt_fatura', '$dt_fatura',  '$plandescricao', 
						'$valor', '$user', '1', '1', '$fornecedor_id', '$valor', '$nomedesp', NOW() )";
			$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
			$lanc_desp_id = mysql_insert_id();
			*/
			
			$sql_pagar = "INSERT INTO contas_pagar (num_fatura,fornecedor_id,dt_emissao_fatura,vl_total_fatura,nm_total_parcela,nm_parcela,status,dt_vencimento_parcela,vl_parcela,lanc_desp_id)";
			$sql_pagar.= "VALUES ('$ndoc','$fornecedor_id','$dt_fatura','$valor','$qtd','$num_parcela','A','$dt_vencimento_parcela','$vl_parcela','$lanc_desp_id')";
			
			mysql_query($sql_pagar) or die(mysql_error());
			$cont_pag_id = mysql_insert_id();
		
			$z++;
			
		}
		
			
if($caixapagoconta == "cxuser"){
		
	//	$status = 'P';
	//	$dt_vencimento_parcela = date("Y/m/d");
	//	$dtpgto = $dt_vencimento_parcela;
	//	ctpagar($ndoc,$fornecedor_id,$dt_fatura,$valor,$status,$dtpgto,$dt_vencimento_parcela);
	
		// Alterado para lancamento de faturas antigas dt_lanc_desp, venc_desp NOW(),NOW()
		$sql_per = "INSERT INTO lanc_contas (receita_id, tipo_pgto_id, plano_id, documento, dt_lanc_desp, venc_desp, dt_fatura_desp, 
		desc_desp, valor, usuario_id, nm_total_parcela, nm_parcela, entidade_id, valor_total, plan_codigo, dt_lanc_despb ) 
		VALUES('2', '4', '$idnode', UCASE('$ndoc'), '$dt_fatura', '$dt_fatura',  '$dt_fatura',  '$plandescricao', 
		'$valor', '$user', '1', '1', '$fornecedor_id', '$valor', '$nomedesp', NOW() )";
		$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
		$lanc_desp_id = mysql_insert_id();

			
		// Alterado para lancamento de faturas antigas
		$sql_caixa = "INSERT INTO lancamento_caixa_balcao (receita_id, idlanc, caixa_id, dt_lancamento, descricao, vl_pago, despesa_cod, lanc_despesa_id,
						entidade_id, num_nota, contas_pagar_id, dt_lancamentob) 
						
					VALUES( '$receita', '$lanc_desp_id', '$caixa_id', '$dt_fatura', UCASE('$ndoc'), '$valor', '$plancodigo', '$idnode',
					'$fornecedor_id', '$ndoc', '$cont_pag_id',  NOW() ) ";
			$exe_caixa = mysql_query($sql_caixa, $base) or die (mysql_error().'-'.$sql_caixa);
		
			}
if($caixapagoconta == "cxempr"){
	
	//	$status = 'P';
	//	$dt_vencimento_parcela = date("Y/m/d");
	//	$dtpgto = $dt_vencimento_parcela;
	//	ctpagar($ndoc,$fornecedor_id,$dt_fatura,$valor,$status,$dtpgto,$dt_vencimento_parcela);
		
	// Alterado para lancamento de faturas antigas dt_lanc_desp, venc_desp NOW(),NOW()
			$sql_per = "INSERT INTO lanc_contas (receita_id, tipo_pgto_id, plano_id, documento, dt_lanc_desp, venc_desp, dt_fatura_desp, 
			desc_desp, valor, usuario_id, nm_total_parcela, nm_parcela, entidade_id, valor_total, plan_codigo, dt_lanc_despb, caixaid ) 
			VALUES('2', '4', '$idnode', UCASE('$ndoc'), '$dt_fatura', '$dt_fatura', '$dt_fatura',  '$plandescricao', 
			'$valor', '$user', '1', '1', '$fornecedor_id', '$valor', '$nomedesp', NOW(), '$lanc_id')";
			$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
			$lanc_desp_id = mysql_insert_id();
		
	// Alterado para lancamento de faturas antigas
			$sql_lancamento_caixa = "INSERT INTO lancamento_caixa (receita_id, idlanc, caixa_id, data_lancamento,valor,fornecedor_id,
			lanc_despesa_id,despesa_cod,historico,contas_pagar_id,data_lancamentob)
            VALUES ('2', '$lanc_desp_id', '$caixa_atual', '$dt_fatura', '$valor', '$fornecedor_id','$idnode', '$plancodigo','$plandescricao', '$cont_pag_id', NOW() )";
			$exe_caixa = mysql_query($sql_lancamento_caixa, $base) or die (mysql_error().'-'.$sql_lancamento_caixa);
			
			}
			
if($caixapagoconta == "cheque"){
$dadosCheque = $json->decode($_POST['jsonCheques']);


	for($i = 0; $i < count($dadosCheque); $i++){
	
		$conta = $dadosCheque[$i]->conta;
		$num_cheque  = $dadosCheque[$i]->num_cheque;
		$idmoeda  = $dadosCheque[$i]->idmoeda;
		$valorcx  = $dadosCheque[$i]->valor;
		$idmoeda  = $dadosCheque[$i]->idmoeda;
		$cbcompra  = $dadosCheque[$i]->cbcompra;
		if($cbcompra == "")
			$cbcompra = 1;
		if($idmoeda != 1){
			$total = ($valor * $cbcompra);
		}
		else{
			$total += $valor;
		}		
			
			$sql_per = "INSERT INTO lanc_contas (receita_id, tipo_pgto_id, plano_id, documento, dt_lanc_desp, venc_desp, dt_fatura_desp, 
			desc_desp, valor, usuario_id, nm_total_parcela, nm_parcela, entidade_id, valor_total, plan_codigo, dt_lanc_despb, caixaid ) 
			VALUES('2', '2', '$idnode', UCASE('$ndoc'), '$dt_fatura', '$dt_fatura', '$dt_fatura',  '$plandescricao', 
			'$valor', '$user', '1', '1', '$fornecedor_id', '$valor', '$nomedesp', NOW(), '$lanc_id')";
			$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
			$lanc_desp_id = mysql_insert_id();
		
			$re = mysql_query("select count(*) as total from cheque_emit where numerocheque = '$num_cheque'  ");
			$totalconsulta = mysql_result($re, 0, "total");
				
			$sql_per = "INSERT INTO cheque_emit (contabancoid, idlanc, numerocheque, vlcheque, dtemissao, dtvencimento, compraid, entid, 
						user, situacao, totalcheques, idpgto, idplano, moedaid, vlcambio, dt_lcto, historico) 
			VALUES( '$conta', '$lanc_desp_id', UCASE('$num_cheque'), '$valorcx', '$dt_fatura', '$dt_fatura', '$idCompra', '$fornecedor_id', 
			'$user', 'COMPENSADO', '$total', '$idpgto', '$idnode', '$idmoeda', '$cbcompra', NOW(), '$obs' )";
				$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
				$idCheque = mysql_insert_id();
				$rows_affected = mysql_affected_rows();			
			if ($rows_affected) $count++;
			
			$sql_upc = "INSERT INTO conta_bancaria_lanc (idcontabancaria,dtlancamentoconta,valorlancamento,tipolancamento,historico,
								user,host,statuslancamento,idcheque_emit,contab,lctosis)
								VALUES('$conta', '$dt_fatura', '$valor', '2', 'Emision. Cheque $num_cheque', '$user', '$host', 'DISP', '$idCheque', 'N', NOW() )";
			$exe_upc = mysql_query($sql_upc, $base) or die (mysql_error().'-'.$sql_upc);
			
		
		}

}
if($caixapagoconta == "credito"){
$dadosCred = $json->decode($_POST['jsonCred']);

	for($i = 0; $i < count($dadosCred); $i++){
		$valorcred  = $dadosCred[$i]->valor;
		$total += $valorcred;
	}	
	
	for($i = 0; $i < count($dadosCred); $i++){
	
	//$idIten    = isset($dadosCred[$i]->id) ? $dadosCred[$i]->id : false;
	$conta = $dadosCred[$i]->conta;
	$num_cheque  = $dadosCred[$i]->num_cheque;
	$dt_vencimento_parcela  = substr($dadosCred[$i]->data_validade,0,10);
	$emissor  = $dadosCred[$i]->emissor;
	$moeda  = $dadosCred[$i]->moeda;
	$valor  = $dadosCred[$i]->valor;
	
		$sql_per = "INSERT INTO lanc_contas (receita_id, tipo_pgto_id, plano_id, documento, dt_lanc_desp, venc_desp, dt_fatura_desp, 
			desc_desp, valor, usuario_id, nm_total_parcela, nm_parcela, entidade_id, valor_total, plan_codigo, dt_lanc_despb, caixaid ) 
			VALUES('2', '1', '$idnode', UCASE('$ndoc'), '$dt_fatura', '$dt_fatura', '$dt_fatura',  '$plandescricao', 
			'$valor', '$user', '1', '1', '$fornecedor_id', '$valor', '$nomedesp', NOW(), '$lanc_id')";
		$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
		$lanc_desp_id = mysql_insert_id();
		
		$status = 'A';
		$dt_vencimento_parcela = $dt_vencimento_parcela;
		$dtpgto = '';
		ctpagar($lanc_desp_id,$ndoc,$fornecedor_id,$dt_fatura,$valor,$status,$dtpgto,$dt_vencimento_parcela,$total);
			
	}
	
	

}			
			
			
			 echo "{success: true,msg: 'Operacao realizada com sucesso'}";
}



/////////////////////////////////////////////////////////////////////////////////////////////////////

if($acao_nome == "fornNome"){	
$r = mysql_query ("SELECT controle,nome,endereco FROM entidades where nome LIKE '%$query%' ORDER BY nome ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$idforn = mysql_result ($r,$i,"controle");
	$nomeforn = mysql_result ($r,$i, "nome");
	$endereco = mysql_result ($r,$i, "endereco");
	
	if($i == ($l-1)) {
		$nomes .= '{idforn:'.$idforn.',  nomeforn:"'.$nomeforn.'",EndForn:"'.$endereco.'"}';
	}else{
		$nomes .= '{idforn:'.$idforn.',  nomeforn:"'.$nomeforn.'",EndForn:"'.$endereco.'"},';
	}
}

echo ('{resultados: [ '.$nomes.']}');
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($acao_nome == "despesa"){	
$r = mysql_query ("SELECT despesa_id,nome_despesa FROM despesa where nome_despesa LIKE '%$query%' ORDER BY nome_despesa ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$iddesp = mysql_result ($r,$i,"despesa_id");
	$nomedesp = mysql_result ($r,$i, "nome_despesa");
	
	if($i == ($l-1)) {
		$nomes .= '{iddesp:'.$iddesp.', nomedesp:"'.$nomedesp.'"}';
	}else{
		$nomes .= '{iddesp:'.$iddesp.', nomedesp:"'.$nomedesp.'"},';
	}
}

echo ('{resultados: [ '.$nomes.']}');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($acao == "ListarDesp"){

	$sql = "SELECT d.despesa_id AS desp_id,d.nome_despesa, l.*,date_format(dt_lanc_desp, '%d/%m/%Y') AS dt_lanc_desp,
			date_format(venc_desp, '%d/%m/%Y') AS venc_desp, u.id_usuario,u.nome_user, p.nome FROM despesa d, lanc_despesa l, usuario u, entidades p WHERE
			l.usuario_id = u.id_usuario AND
			l.forn_id = p.controle AND
			l.despesa_id = d.despesa_id GROUP BY l.id_lanc_despesa ORDER BY l.id_lanc_despesa DESC LIMIT 0, 30";
	$exe = mysql_query($sql);
	$arr = array();
	while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
	$arr[] = $reg;
	}
	
	echo '({"Despesas":'.json_encode($arr).'})'; 
	



}

?>