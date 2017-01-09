<?	
require_once("../biblioteca.php");
require_once ("../config.php");
conexao();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');
	
 $acao = $_POST['acao'];
 $acao_nome = $_GET['acao_nome'];

if($acao == "Cadastra"){
 $ndoc = $_POST['fatura'];
 $dt_fatura = converte_data('2',$_POST['datafatura']);
 $valora = str_replace('.', '',$_POST['valortotal']);
 $valor = str_replace('.', '',$valora);
 $valor = str_replace('.', '',$valor);
 $valor = str_replace(',', '.',$valor);
 $fornecedor_id = $_POST['IdForne'];
 $user = $_POST['user'];
 $qtd = $_POST['auto'];
 


$z=1;
		$sql_compra = "INSERT INTO compras (fornecedor_id,nm_fatura,dt_emissao_fatura,vl_total_fatura,status,data_lancamento) 
		VALUES ('$fornecedor_id', '$ndoc', '$dt_fatura', '$valor', 'A', NOW() )";
		$exe_compra = mysql_query($sql_compra) or die(mysql_error());
		$compra_id = mysql_insert_id();

		while($z <= $qtd) {
			$dt_vencimento_parcela = converte_data('2',$_POST["Data$z"]);
			$vl_parcelaa = str_replace("." , "" , $_POST["Vlparc$z"]);
			$vl_parcela = str_replace("," , "." , "$vl_parcelaa$z");					
			$num_parcela = $z."/".$qtd;
						
			$sql_pagar = "INSERT INTO contas_pagar (num_fatura,fornecedor_id,dt_emissao_fatura,vl_total_fatura,nm_total_parcela,nm_parcela,status,dt_vencimento_parcela,vl_parcela,compra_id)";
			$sql_pagar.= "VALUES ('$ndoc','$fornecedor_id','$dt_fatura','$valor','$qtd','$num_parcela','A','$dt_vencimento_parcela','$vl_parcela','$compra_id')";
			
			mysql_query($sql_pagar) or die(mysql_error());
			$cont_pag_id = mysql_insert_id();
			
			$z++;
		}
		
			
if(isset($_POST['ckb'])){
			
			$sql_pagar = "INSERT INTO contas_pagar (num_fatura,fornecedor_id,dt_emissao_fatura,vl_total_fatura,nm_total_parcela,nm_parcela,status,dt_vencimento_parcela,vl_parcela,lanc_desp_id,compra_id)";
			$sql_pagar.= "VALUES ('$ndoc','$fornecedor_id','$dt_fatura','$valor','$qtd','$num_parcela','P',NOW(),'$valor','$lanc_desp_id','$compra_id')";
			
			mysql_query($sql_pagar) or die(mysql_error());
			$cont_pag_id = mysql_insert_id();

		$sql_caixa_balcao = "SELECT id FROM caixa WHERE  status = 'A' ";
		$rs_caixa_balcao = mysql_query($sql_caixa_balcao);
		$linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao, MYSQL_ASSOC);
		$caixa_id = $linha_caixa_balcao['id'];

		$sql_caixa = "INSERT INTO lancamento_caixa (receita_id, caixa_id, data_lancamento, num_nota, despesa_cod, contas_pagar_id, valor, fornecedor_id, lanc_despesa_id,venda_id) VALUES( '2', '$caixa_id', NOW(), UCASE('$ndoc'), '$plano', '$cont_pag_id', '$valor', '$fornecedor_id', '$lanc_desp_id', '$compra_id') ";
			$exe_caixa = mysql_query($sql_caixa, $base) or die (mysql_error().'-'.$sql_caixa);
			}
			
			 echo "{success: true,msg: 'Operacao realizada com sucesso'}";

}

/////////////////////////////////////////////////////////////////////////////////////////////////////

if($acao == "ListarCompras"){

	$sql = "SELECT c.*,date_format(dt_emissao_fatura, '%d/%m/%Y') AS dt_emissao_fatura,
			date_format(data_lancamento, '%d/%m/%Y') AS data_lancamento, u.id_usuario,u.nome_user, p.nome FROM  entidades p, compras c
			LEFT JOIN usuario u ON u.id_usuario = c.usuario_id   
			WHERE c.fornecedor_id = p.controle
			GROUP BY c.id_compra ORDER BY c.id_compra DESC LIMIT 0, 30";
	$exe = mysql_query($sql);
	$arr = array();
	while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
	$arr[] = $reg;
	}
	
	echo '({"Compras":'.json_encode($arr).'})'; 
	



}

/////////////////////////////////////////////////////////////////////////////////////////////////////

if($acao == "deletacompra"){
 $compra = $_POST['compra'];

	$sql = "SELECT status,fornecedor_id FROM compras WHERE id_compra = '$compra' ";
	$exe =  mysql_query($sql, $base);
	$reg = mysql_fetch_array($exe, MYSQL_ASSOC);
	
	$status =  $reg['status'];
	$fornecedor = $reg['fornecedor_id'];

		if($status == 'A'){
		
		$sql_del = "DELETE FROM compras WHERE id_compra = '$compra' AND fornecedor_id = '$fornecedor' AND status = 'A' ";
		$exe_del = mysql_query($sql_del, $base) or die (mysql_error().'-'.$sql_del);
		
		$sql_delct = "DELETE FROM contas_pagar WHERE compra_id = '$compra' AND fornecedor_id = '$fornecedor' ";
		$exe_delct = mysql_query($sql_delct, $base) or die (mysql_error().'-'.$sql_delct);
		
		$sql_delcx = "DELETE FROM lancamento_caixa WHERE venda_id = '$compra' AND fornecedor_id = '$fornecedor' ";
		$exe_delcx = mysql_query($sql_delcx, $base) or die (mysql_error().'-'.$sql_delcx);
		
		echo "Operacao realizada com sucesso";
		}
		if($status == 'F'){
		
		echo "Esta compra ja foi finalizada";
		
		}

}
//////////////////////////////////////////////////////////////////////////////////////////////////////


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






























?>