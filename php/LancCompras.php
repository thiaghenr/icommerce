<?	
require_once("../biblioteca.php");
require_once ("../config.php");
conexao();
include_once("json/JSON.php");
$json = new Services_JSON();

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

		$sql_caixa = "INSERT INTO lancamento_caixa (receita_id, caixa_id, data_lancamento, num_nota, despesa_cod, contas_pagar_id, valor, fornecedor_id, lanc_despesa_id,venda_id) 
		VALUES( '2', '$caixa_id', NOW(), UCASE('$ndoc'), '$plano', '$cont_pag_id', '$valor', '$fornecedor_id', '$lanc_desp_id', '$compra_id') ";
			$exe_caixa = mysql_query($sql_caixa, $base) or die (mysql_error().'-'.$sql_caixa);
			
			$sql_plan = "INSERT INTO lanc_contas (plano_id,plan_codigo,documento,dt_lanc_desp,desc_desp,valor,usuario_id,receita_id,valor_total,entidade_id,caixaid) ";
		$sql_plan.= "VALUES ('135', '2.01.05.01.000.00', '$ndoc', NOW(), 'Compra de Mercaderias al Contado', '$valor', '$user', '2', '$valor', '$fornecedor_id', '$caixaid' )";
		mysql_query($sql_plan) or die (mysql_error());
		
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

if($acao == "NovaCompra"){
 $user = $_POST['user'];
 
		$sql_compra = "INSERT INTO compras (status,data_lancamento) 
		VALUES ('A', NOW() )";
		$exe_compra = mysql_query($sql_compra) or die(mysql_error());
		$compra_id = mysql_insert_id();

		echo "{success: true,idcompranova: '$compra_id '}";
	




}

if($acao_nome == "fornNome"){
$query =  addslashes($_POST['query']);
$r = mysql_query ("SELECT controle,nome,endereco FROM entidades where nome LIKE '%$query%' ORDER BY nome ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$idforn = mysql_result ($r,$i,"controle");
	$nomeforn = mysql_result ($r,$i, "nome");
	$endereco = mysql_result ($r,$i, "endereco");
	
	if($i == ($l-1)) {
		$nomes .= '{idforn:'.$idforn.',nomeforn:"'.$nomeforn.'",EndForn:"'.$endereco.'"}';
	}else{
		$nomes .= '{idforn:'.$idforn.',nomeforn:"'.$nomeforn.'",EndForn:"'.$endereco.'"},';
	}
}

echo ('{resultados:['.$nomes.']}');
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($acao == "ListaPgto"){ 
$compraid = $_POST['idcompranova'];

	$sql = "SELECT c.*, t.tipo_pgto_descricao FROM  compra_pgto c, tipo_pagamento t 
	WHERE compra_id = '$compraid' AND t.idtipo_pagamento = c.pgto_id ";
	$exe = mysql_query($sql);
	$arr = array();
	while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
	$total += $reg['vlpgto']; 
	$arr[] = $reg;
	}
	
	echo '({"totalpgto":'.$total.', "PgtoCompras":'.json_encode($arr).'})'; 
}

if($acao == "CadPagos"){ 
$nmfatura = $_POST['nmfatura'];
$user = $_POST['user'];
$idforn = $_POST['idforn'];
$total_nota = str_replace('.', '',$_POST['total_nota']);
$idCompra = $_POST['idCompra'];
$emissaofat = substr($_POST['emissaofat'],0,10);
$dados = $json->decode($_POST['dados']);

$count_cheque = 0;
$count_crediario = 0;
$count_vista = 0;

	$sqlcompra = "UPDATE compras SET fornecedor_id = '$idforn', nm_fatura = '$nmfatura', dt_emissao_fatura = '$emissaofat',
							vl_total_fatura = '$total_nota', usuario_id =  '$user'   WHERE id_compra = '$idCompra' ";
	$execompra = mysql_query($sqlcompra);

	for($i = 0; $i < count($dados); $i++){
	
		$pgto_id = $dados[$i]->pgto_id;
		$vlpgto  = $dados[$i]->vlpgto;
		$idcompra_pgto  = $dados[$i]->idcompra_pgto;

		// Se Cheques
		if($pgto_id == 2){
			
			$sql = "UPDATE cheque_emit SET disponivel = 'S' WHERE idpgto = '$idcompra_pgto' ";
			$exe = mysql_query($sql);
					
			$sql = "SELECT * FROM cheque_emit WHERE idpgto = '$idcompra_pgto' "; 
			$exe = mysql_query($sql);
			while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
			$vlcheque = $reg['vlcheque'];
			$sqlins = "INSERT INTO lanc_contas (plano_id, plan_codigo, documento, desc_desp, dt_lanc_desp,  valor, usuario_id, entidade_id, valor_total, receita_id, pgtoid  ) 
						VALUES('136', '2.01.05.02.000.00', '$nmfatura', 'Pago de Proveedores', NOW(), '$vlcheque', '$user', '$idforn', '$total_nota', '2', '2' )";
			$exeins = mysql_query($sqlins);
			$rows_affected_che = mysql_affected_rows();			
			if ($rows_affected_che) $count_cheque++;
			}
			
		}
		
		// Se Crediario
		if($pgto_id == 1){
			
			$sql = "SELECT * FROM pgto_temp WHERE idcompra = '$idCompra' AND status = 'A' AND formapgto = '1' ";
			$exe = mysql_query($sql);
			while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
				$dtvencimento = $reg['dtvencimento'];
				$valor = $reg['valor'];
				
				$sqlins = "INSERT INTO contas_pagar (num_fatura,fornecedor_id,dt_emissao_fatura,vl_total_fatura,status,dt_vencimento_parcela,vl_parcela,compra_id)
							VALUES('$nmfatura', '$idforn', '$emissaofat', '$total_nota', 'A', '$dtvencimento', '$valor', '$idCompra' )";
				$exeins = mysql_query($sqlins);
				$rows_affected_cred = mysql_affected_rows();			
				if ($rows_affected_cred) $count_crediario++;
			
			}
			$sqlup = "UPDATE pgto_temp SET status = 'F' WHERE idcompra = '$idCompra' AND status = 'A' AND formapgto = '1' ";
			$exeup = mysql_query($sqlup);
		}
		
		// Se Al Contado
		if($pgto_id == 4){
			
			$sql_caixa_balcao = "SELECT id FROM caixa WHERE  status = 'A' ";
			$rs_caixa_balcao = mysql_query($sql_caixa_balcao);
			$linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao, MYSQL_ASSOC);
			$caixa_id = $linha_caixa_balcao['id'];
		
			$sql = "SELECT * FROM pgto_temp WHERE idcompra = '$idCompra' AND status = 'A' AND formapgto = '4' ";
			$exe = mysql_query($sql) or die(mysql_error().'-'.$sql);
			while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
				$valor = $reg['valor'];
			
				$sql_pagar = "INSERT INTO contas_pagar (num_fatura,fornecedor_id,dt_emissao_fatura,vl_total_fatura, status, dt_vencimento_parcela, vl_parcela, lanc_desp_id, compra_id)";
				$sql_pagar.= "VALUES ('$nmfatura', '$idforn', '$emissaofat', '$total_nota', 'P', NOW(), '$valor', '$lanc_desp_id', '$idCompra')";
				mysql_query($sql_pagar) or die(mysql_error().'-'.$sql_pagar);
				$cont_pag_id = mysql_insert_id();
				
				$sql_caixa = "INSERT INTO lancamento_caixa (receita_id, caixa_id, data_lancamento, num_nota, despesa_cod, contas_pagar_id, valor, fornecedor_id, lanc_despesa_id,venda_id) 
				VALUES( '2', '$caixa_id', NOW(), UCASE('$nmfatura'), '135', '$cont_pag_id', '$valor', '$idforn', '$lanc_desp_id', '$idCompra') ";
				$exe_caixa = mysql_query($sql_caixa, $base) or die (mysql_error().'-'.$sql_caixa);
				$pgtocaixa = mysql_insert_id();
				
				$sql_plan = "INSERT INTO lanc_contas (plano_id, plan_codigo, documento, dt_lanc_desp, desc_desp, valor, usuario_id, receita_id, valor_total, entidade_id, caixaid, pgtoid) ";
				$sql_plan.= "VALUES ('135', '2.01.05.01.000.00', '$nmfatura', NOW(), 'Compra de Mercaderias al Contado', '$valor', '$user', '2', '$valor', '$idforn', '$pgtocaixa', '4' )";
				mysql_query($sql_plan) or die (mysql_error().'-'.$sql_plan);
				$rows_affected_vista = mysql_affected_rows();			
				if ($rows_affected_vista) $count_vista++;
				}
				$sqlup = "UPDATE pgto_temp SET status = 'F' WHERE idcompra = '$idCompra' AND status = 'A' AND formapgto = '4' ";
				$exeup = mysql_query($sqlup);		
		}
	}
		if ($count_cheque || count_crediario ) {
		echo "{success:true, cheques: ".$count_cheque.", crediario: ".$count_crediario.", vista: ".$count_vista.", response: 'Cheque Cadastrado' }"; 
		}
		else {
			echo '{failure: true}';
		}	

}

if($acao == "deletapago"){ 
$idpgto = $_POST['idpgto'];
$idCompra = $_POST['idCompra'];
$pgto_id = $_POST['pgto_id'];
	
		$sql = "DELETE FROM pgto_temp WHERE compraid_pgto = '$idpgto' AND idcompra = '$idCompra' AND formapgto = '$pgto_id'  ";
		$exe = mysql_query($sql);
		
		$sqldel = "DELETE FROM compra_pgto WHERE idcompra_pgto = '$idpgto' AND compra_id = '$idCompra' ";
		$exedel = mysql_query($sqldel);
		$rows_affected = mysql_affected_rows();			
	
		if ($rows_affected) {
		echo "{success:true, response: 'Pago Eliminado' }"; 
		}
		else {
			echo '{failure: true}';
		}	
}

























?>