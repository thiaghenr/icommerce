<?	
require_once("../biblioteca.php");
require_once ("../config.php");
conexao();

mysql_query("SET NAMES 'utf8'");mysql_query('SET character_set_connection=utf8');mysql_query('SET character_set_client=utf8');mysql_query('SET character_set_results=utf8');
	
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
$valora = str_replace('.', '',$_POST['vltotal']);
$valor = str_replace(',', '.',$valora);
$desc = $_POST['desc'];
$fornecedor_id = $_POST['idFornecedor'];
$obs = $_POST['obsDesp'];
$user = $_POST['user'];
$qtd = $_POST['index'];

$z=1;
		while($z <= $qtd) {
			$dt_vencimento_parcela = converte_data('2',$_POST["data$z"]);
			$vl_parcelaa = str_replace("." , "" , $_POST["vlparc$z"]);
			$vl_parcela = str_replace("," , "." , "$vl_parcelaa$z");					
			$num_parcela = $z."/".$qtd;
			
		$sql_per = "INSERT INTO lanc_despesa (receita_id, despesa_id, documento, dt_lanc_desp, venc_desp, dt_fatura_desp, desc_desp, valor, usuario_id, nm_total_parcela, nm_parcela, forn_id, valor_total ) VALUES('2', '$plano', UCASE('$ndoc'), NOW(), '$dt_vencimento_parcela', '$dt_fatura',  UCASE('$obs'), '$vl_parcela', '$user', '$qtd','$num_parcela', '$fornecedor_id', '$valor')";
			$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
			$lanc_desp_id = mysql_insert_id();
			
			$sql_pagar = "INSERT INTO contas_pagar (num_fatura,fornecedor_id,dt_emissao_fatura,vl_total_fatura,nm_total_parcela,nm_parcela,status,dt_vencimento_parcela,vl_parcela,lanc_desp_id)";
			$sql_pagar.= "VALUES ('$ndoc','$fornecedor_id','$dt_fatura','$valor','$qtd','$num_parcela','A','$dt_vencimento_parcela','$vl_parcela','$lanc_desp_id')";
			
			mysql_query($sql_pagar) or die(mysql_error());
			$cont_pag_id = mysql_insert_id();
			
			$z++;
		}
		
			
if(isset($_POST['ckbVista'])){
		$sql_per = "INSERT INTO lanc_despesa (receita_id, despesa_id, documento, dt_lanc_desp, venc_desp, dt_fatura_desp, desc_desp, valor, usuario_id, nm_total_parcela, nm_parcela, forn_id, valor_total ) VALUES('2', '$plano', UCASE('$ndoc'), NOW(), NOW(), '$dt_fatura',  UCASE('$obs'), '$valor', '$user', '1', '1', '$fornecedor_id', '$valor')";
			$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
			$lanc_desp_id = mysql_insert_id();
			
			$sql_pagar = "INSERT INTO contas_pagar (num_fatura,fornecedor_id,dt_emissao_fatura,vl_total_fatura,nm_total_parcela,nm_parcela,status,dt_vencimento_parcela,vl_parcela,lanc_desp_id)";
			$sql_pagar.= "VALUES ('$ndoc','$fornecedor_id','$dt_fatura','$valor','$qtd','$num_parcela','P',NOW(),'$valor','$lanc_desp_id')";
			
			mysql_query($sql_pagar) or die(mysql_error());
			$cont_pag_id = mysql_insert_id();

		$sql_caixa_balcao = "SELECT id FROM caixa WHERE  status = 'A' ";
		$rs_caixa_balcao = mysql_query($sql_caixa_balcao);
		$linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao, MYSQL_ASSOC);
		$caixa_id = $linha_caixa_balcao['id'];

		$sql_caixa = "INSERT INTO lancamento_caixa (receita_id, caixa_id, data_lancamento, num_nota, despesa_cod, contas_pagar_id, valor, fornecedor_id, lanc_despesa_id) VALUES( '2', '$caixa_id', NOW(), UCASE('$ndoc'), '$plano', '$cont_pag_id', '$valor', '$fornecedor_id',  '$lanc_desp_id') ";
			$exe_caixa = mysql_query($sql_caixa, $base) or die (mysql_error().'-'.$sql_caixa);
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