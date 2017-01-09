
	$update = "INSERT INTO compra_pgto (compra_id, pgto_id, vltotal_compra, vlpgto, status, user)
								VALUES( '$idCompra', '1', '$total', '$valorcred', 'A', '$user') ";
	$exe_update = mysql_query($update, $base) or die (mysql_error().'-'.$update);
	$idpgto = mysql_insert_id(); 
		
	for($i = 0; $i < count($dadosCred); $i++){
	
	//$idIten    = isset($dadosCred[$i]->id) ? $dadosCred[$i]->id : false;
	$conta = $dadosCred[$i]->conta;
	$num_cheque  = $dadosCred[$i]->num_cheque;
	$data_validade  = substr($dadosCred[$i]->data_validade,0,10);
	$emissor  = $dadosCred[$i]->emissor;
	$moeda  = $dadosCred[$i]->moeda;
	$valorcred  = $dadosCred[$i]->valor;
							
			$sql_per = "INSERT INTO pgto_temp (idcompra, compraid_pgto, ident, valor, dtvencimento, nmfatura, user, formapgto  ) 
			VALUES( '$idCompra', '$idpgto', '$fornecedor_id', '$valorcred', '$data_validade', '$ndoc', '$user', '1' )";
				$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
				$rows_affected = mysql_affected_rows();			
			if ($rows_affected) $count++;		
		}
		if ($count) {
		//echo "{success:true, contaspagar: ".$count.", response: 'Cuenta Catastrada' }"; 
		}
		else {
			//echo '{failure: true}';
		}			