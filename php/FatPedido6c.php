<?php
 require_once("../biblioteca.php");
 require_once("../config.php");
 conexao();
 include_once("json/JSON.php");
 $json = new Services_JSON();


 mysql_query("SET NAMES 'utf8'");
 mysql_query('SET character_set_connection=utf8');
 mysql_query('SET character_set_client=utf8');
 mysql_query('SET character_set_results=utf8');

$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 5 ;
$acao = isset($_POST['acao']) ? $_POST['acao'] : '';
$idpedido = $_POST['idpedido'];
$idForma = $_POST['idForma'];
$subtotalFat = $_POST['subtotalFat'];
$user = $_POST['user'];
$valor_debitar = $_POST['valor_debitar'];
$valor_entrada = str_replace(',', '.',$_POST['valor_entrada']);

$sql_prodp = "SELECT * FROM pedido WHERE id =  '$idpedido' ";
    $exe_prodp = mysql_query($sql_prodp, $base) or die (mysql_error());
    $reg_prodp = mysql_fetch_array($exe_prodp, MYSQL_ASSOC );
    $vl_total_nota = $reg_prodp['total_nota'];
    $entidade = $reg_prodp['controle_cli'];
  

if($acao == 'listarPedidos'){
$query = isset($_POST['query']) ? $_POST['query'] : 1;
 
 $rs    = mysql_query("SELECT cl.endereco, it.id_pedido, sum(it.prvenda * it.qtd_produto) AS totalitens, f.id AS idforma, f.descricao, 
 u.id_usuario, u.nome_user, p.id,p.nome_cli,p.controle_cli, date_format(p.data_car, '%d/%m/%Y') AS data, p.total_nota, p.situacao, 
 p.usuario_id, p.vendedor_id, p.status, p.forma_pagamento_id FROM itens_pedido it, pedido p, forma_pagamento f, entidades cl, usuario u 
 WHERE p.controle_cli = cl.controle AND it.id_pedido = p.id AND p.situacao = 'A' AND u.id_usuario = p.usuario_id 
 AND p.forma_pagamento_id = f.id AND status != 'C'  GROUP BY p.id ORDER BY p.id DESC  LIMIT $inicio, $limite ")or die (mysql_error());
 $rst    = mysql_query("SELECT id FROM pedido WHERE situacao = 'A' AND status != 'C' ");
 $total  = mysql_num_rows($rst);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '{"total":'.$total.',"results":'.json_encode($arr).'}'; 
} 

if($acao == 'listarItens'){

	$rs = mysql_query("SELECT * FROM itens_pedido WHERE id_pedido = '$idpedido' " ) or die (mysql_error());
	$arr = array();
	while($obj = mysql_fetch_object($rs)){
	$arr[] = $obj;
	}
	echo '{"Itens":'.json_encode($arr).'}'; 

}
///////////////////////////////////////////////////////////////////////////////////////////////////
if($acao == 'Faturar'){
    
     $sql_caixa_balcao = "SELECT id FROM caixa_balcao WHERE usuario_id = '".$_POST['user']."' AND st_caixa = 'A'";
     $rs_caixa_balcao = mysql_query($sql_caixa_balcao) or die (mysql_error().'-'.$sql_caixa_balcao);
	 $reg_caixa_balcao = mysql_fetch_array($rs_caixa_balcao, MYSQL_ASSOC );
	 $caixa_id = $reg_caixa_balcao['id'];
	 
      if(!	($rs_caixa_balcao)){
          echo "{success: true,response: 'Não há caixa aberto para este usuario'}";
          exit();
      }
    
   $tipo_venda = $idForma;

    if($tipo_venda=='1')
            $st_venda = 'F';
    else if($tipo_venda >= '2')
            $st_venda = 'A';


    $id_pedido = $idpedido;



  	$sql_prodp = "SELECT * FROM pedido WHERE id =  '$id_pedido' ";
    $exe_prodp = mysql_query($sql_prodp, $base) or die (mysql_error());
  	$num_prodp = mysql_num_rows($exe_prodp);
    $vl_total_nota;
	$entidade;

    if ($num_prodp > 0) {

        $reg_prodp = mysql_fetch_array($exe_prodp, MYSQL_ASSOC );
        $vl_total_nota = ($reg_prodp['total_nota'] - $reg_prodp['desconto']);
        $entidade = $reg_prodp['controle_cli'];
		$tipo_venda = $reg_prodp['forma_pagamento_id'];
		$desconto = $reg_prodp['desconto'];
		$_POST['idForma'] = $reg_prodp['forma_pagamento_id'];
		
		if($tipo_venda=='1')
            $st_venda = 'F';
		else if($tipo_venda >= '2')
            $st_venda = 'A';
			
		if(isset($_POST['ncredito'])){
		$idcredito = $_POST['ncredito'];
		
		$sql_prodc = "SELECT vlcredito AS valorcrd FROM nota_credito
		WHERE status = 'A' AND idnota_credito = '$idcredito' ";
		$exe_prodc = mysql_query($sql_prodc, $base) or die (mysql_error());
		$reg_prodc = mysql_fetch_array($exe_prodc, MYSQL_ASSOC );
		$valorcrd = $reg_prodc['valorcrd'];
		
		$sql_proda = "SELECT sum(valor_abat) AS valor_abatido FROM nc_abatimento
		WHERE idntcredito = '$idcredito' ";
		$exe_proda = mysql_query($sql_proda, $base);
		$reg_proda = mysql_fetch_array($exe_proda, MYSQL_ASSOC );
		$valor_abatido = $reg_proda['valor_abatido'];
		
		$valorcrd = $valorcrd - $valor_abatido;
		
			if($valorcrd <=  $vl_total_nota){
					$_POST['valor_entrada'] = $valorcrd;
					$vl_abat = $valorcrd;
			}
			if($valorcrd >  $vl_total_nota){
					$valorcrd = $valorcrd - $vl_total_nota;
					$vl_abat =  $vl_total_nota;
					$_POST['valor_entrada'] = $vl_total_nota;
			}
			
			
			if($vl_abat == $valorcrd){
			$sql = "UPDATE nota_credito SET status = 'F' WHERE idnota_credito = '$idcredito' ";
			$exe = mysql_query($sql,$base);			
			}
			
			
			$sql_lancamento_caixa_balcao = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,descricao) ";
            $sql_lancamento_caixa_balcao.= "VALUES ('3','$caixa_id',now(),'$vl_abat', 'Devolucion')";
            mysql_query($sql_lancamento_caixa_balcao) or die (mysql_error());
			$caixaid = mysql_insert_id();
			
		$sql = "INSERT INTO nc_abatimento (idntcredito,identidade,valor_abat,data_abat,user_abat,idpedido,idlcto_caixa)
							VALUES('$idcredito', '$entidade', '$vl_abat', NOW(), '$user', '$id_pedido', '$caixaid' )";
		$exe = mysql_query($sql, $base) or die (mysql_error());
		$devolvido = mysql_insert_id();
		
		$sql_plan = "INSERT INTO lanc_contas (plano_id,plan_codigo,documento,dt_lanc_desp,desc_desp,valor,usuario_id,receita_id,valor_total,entidade_id,caixaid) ";
		$sql_plan.= "VALUES ('161', '2.01.05.05.000.00', '$devolvido', NOW(), 'Devolucion a Cliente', '$vl_abat', '$user', '2', '$vl_abat', '$entidade', '$caixaid' )";
		mysql_query($sql_plan) or die (mysql_error());
		
		}
		
        $sql_alt_status = "UPDATE pedido SET situacao = 'F', entrada = '".str_replace(',', '.',$_POST['valor_entrada'])."' WHERE id = '$id_pedido' ";
        $exe_alt_status = mysql_query($sql_alt_status) or die (mysql_error());
        
        $sql_addv = "INSERT INTO venda
    	    (data_venda, pedido_id, num_boleta, valor_venda, imposto_id, controle_cli, st_venda, entrada, desconto )
    		VALUES
    		(NOW(), '".$reg_prodp['id']."', '0', '".$reg_prodp['total_nota']."',  '10', '".$reg_prodp['controle_cli']."','".$st_venda."',
			'".$reg_prodp['entrada']."', '".$reg_prodp['desconto']."')";
        $exe_addv = mysql_query($sql_addv) or die (mysql_error().'-'.$sql_addv);

        $id_venda = mysql_insert_id();
		
		if(isset($devolvido)){
		$idcredito = $_POST['ncredito'];
			$sql_lancamento_caixa_balcao = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id) ";
            $sql_lancamento_caixa_balcao.= "VALUES ('1','$caixa_id',now(),'$vl_abat','$id_venda')";
            mysql_query($sql_lancamento_caixa_balcao) or die (mysql_error());
		
		}

        $sql_prodc = "SELECT it.*, p.id AS idPedido FROM itens_pedido it, pedido p WHERE p.id = it.id_pedido
		AND it.id_pedido = '$id_pedido' AND it.id_prod != ''  " ;
        $exe_prodc = mysql_query($sql_prodc) or die (mysql_error());
    	$num_prodc = mysql_num_rows($exe_prodc);
       // echo $num_prodc;
        if($num_prodc == '0'){
        $exe_alt_status = mysql_query("UPDATE pedido SET situacao = 'A' WHERE id = '$id_pedido' ") or die (mysql_error());
        $exe_del_venda = mysql_query("DELETE FROM venda WHERE id = '$id_venda' ");
        echo "{success: true,response: 'Este pedido nao pode ser faturado'}";
        exit(); 
        }
      if ($num_prodc > 0) {
      	while ($reg_prodc = mysql_fetch_array($exe_prodc, MYSQL_ASSOC )) {
              $sql_addi = "INSERT INTO itens_venda
        	            (id_venda, referencia_prod, descricao_prod, prvenda, qtd_produto, idproduto)
        				VALUES
        				('$id_venda','".$reg_prodc['referencia_prod']."', '".strtoupper(mysql_escape_string($reg_prodc['descricao_prod']))."',
                            '".$reg_prodc['prvenda']."', '".$reg_prodc['qtd_produto']."', '".$reg_prodc['id_prod']."')";

                $qtd_prod =  $reg_prodc['qtd_produto'];
                $exe_addi = mysql_query($sql_addi) or die (mysql_error().'-'.$sql_addi);

                $sql_qtd1 = "UPDATE produtos SET qtd_bloq =  qtd_bloq - '$qtd_prod' WHERE id = '".$reg_prodc['id_prod']."' ";
                $exe_qtd1 = mysql_query($sql_qtd1) or die (mysql_error());
        }
      }

      $vl_total = ajustaValor($subtotalFat);
      $forma_pgto_id = $_POST['idForma'];

     


      
    }
/////////////////////////////////////////////////////////////////////////////////////////////////
$sql_prodp = "SELECT total_nota,desconto FROM pedido WHERE id =  '$id_pedido' ";
    $exe_prodp = mysql_query($sql_prodp, $base) or die (mysql_error());
    $reg_prodp = mysql_fetch_array($exe_prodp, MYSQL_ASSOC );
    $vl_total_nota = $reg_prodp['total_nota'];
	$desconto = $reg_prodp['desconto'];
	$vl_total_nota =  $vl_total_nota - $vl_abat - $desconto;
	
    function lancamentoCaixa($vl_total_nota, $id_venda, $user){
//echo   $user."user ";
//echo    $vl_total_nota."total ";
//echo    $id_venda."idvenda ";
//echo    $entidade."entidade ";	
	if($vl_total_nota > 0){

      $sql_caixa_balcao = "SELECT * FROM caixa_balcao WHERE usuario_id = '".$_POST['user']."' AND st_caixa = 'A'";
      $rs_caixa_balcao = mysql_query($sql_caixa_balcao) or die (mysql_error().'-'.$sql_caixa_balcao);

      if(!mysql_num_rows($rs_caixa_balcao)){
          echo "{success: true,response: 'Não há caixa aberto para este usuario'}";
          
      }
      if(mysql_num_rows($rs_caixa_balcao)){
            $linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao);
            $caixa_id = $linha_caixa_balcao['id'];
            $sql_lancamento_caixa_balcao = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id) ";
            $sql_lancamento_caixa_balcao.= "VALUES ('1','$caixa_id',now(),'$vl_total_nota','$id_venda')";
            mysql_query($sql_lancamento_caixa_balcao) or die (mysql_error());
			$caixaid = mysql_insert_id();
		$sql = mysql_query("SELECT controle_cli FROM venda WHERE id = '$id_venda' ");
		$reg = mysql_fetch_array($sql);
		$entidade = $reg['controle_cli'];
			
		$sql_plan = "INSERT INTO lanc_contas (plano_id,plan_codigo,documento,dt_lanc_desp,desc_desp,valor,usuario_id,receita_id,valor_total,entidade_id,caixaid) ";
		$sql_plan.= "VALUES ('24', '1.01.01.00.000.00', '$vendaid', NOW(), 'Venta Contado', '$vl_total_nota', '".$_POST['user']."', '1', '$vl_total_nota', '$entidade', '$caixaid' )";
		mysql_query($sql_plan) or die (mysql_error());	
			
          //  echo "{success: true,response: 'Lancamento efetuado com sucesso'}";
      }
    }
	}
 
    ////////////////////////////////////////////////////////////////////////////////////////////////

   function lacamentoContaReceber($vl_total_nota,$vl_entrada,$forma_pgto_id,$entidade, $id_venda, $user){
	
      $sql_forma_pgto = "SELECT * FROM forma_pagamento WHERE id = '$forma_pgto_id' ";
      $rs_forma_pgto = mysql_query($sql_forma_pgto) or die(mysql_error());
      $linha_forma_pgto = mysql_fetch_array($rs_forma_pgto);

      $nm_total_parcela = $linha_forma_pgto['nm_total_parcela'];
      $nm_intervalo_parcela = $linha_forma_pgto['nm_intervalo_parcela'];
	  $datavencimento = $linha_forma_pgto['dt_vencimento'];
	  

      $mes_milli = 2592000;
      $data_atual = date('Y-m-d');
      $dt_atual_milli = strtotime($data_atual);
	  
	  $sql = mysql_query("SELECT valor_venda,desconto FROM venda WHERE id = '$id_venda' ");
	  $reg = mysql_fetch_array($sql);
	  $desconto = $reg['desconto'];
	  $vl_total_nota = $reg['valor_venda'];
	  $vl_total_nota = $vl_total_nota - $desconto;

      $vl_parcela = (($vl_total_nota - $vl_entrada) / $nm_total_parcela);
	  
	  if($vl_parcela == 0)
	  exit();

      for ($i=0; $i<$nm_total_parcela; $i++){
	  
		if($datavencimento == "0000-00-00"){

        $dt_atual_milli = ($dt_atual_milli + $mes_milli);
        $dt_new = date("Y-m-d",($dt_atual_milli));
		}
		else{
		$dt_new = $datavencimento;
		}
		
        $sql_conta_receber = "INSERT INTO contas_receber (vl_total,vl_parcela,nm_total_parcela,nm_parcela,clientes_id,venda_id,status,dt_lancamento,dt_vencimento)
        VALUES ('".$vl_total_nota."','$vl_parcela','$nm_total_parcela',".($i+1).",'$entidade','$id_venda','A','$data_atual','$dt_new')";

        mysql_query($sql_conta_receber) or die(mysql_error().' - '.$sql_conta_receber);
        
	//	echo "{success: true,response: 'Lancamento efetuado com sucesso'}";	
      }
   }
   
    if ($tipo_venda == '1') {
            lancamentoCaixa($vl_total_nota, $id_venda, $user, $entidade);
            echo "{success: true,response: 'Lancamento efetuado com sucesso'}";	
        }
   
    else if($tipo_venda=='3'){
        $vl_entrada = str_replace(',', '.',$_POST['valor_entrada']);

            lacamentoContaReceber($vl_total_nota,$vl_entrada,$forma_pgto_id,$entidade,$id_venda, $user);
            lancamentoCaixa($vl_entrada, $id_venda, $user);
            echo "{success: true,response: 'Lancamento efetuado com sucesso'}";	
      }
	  
	   else if($tipo_venda > '3'){
        $vl_entrada = str_replace(',', '.',$_POST['valor_entrada']);

            lacamentoContaReceber($vl_total_nota,$vl_entrada,$forma_pgto_id,$entidade,$id_venda, $user);
            echo "{success: true,response: 'Lancamento efetuado com sucesso'}";	
      }
	  
	 else if($vl_entrada > 0.00){
        $vl_entrada = str_replace(',', '.',$_POST['valor_entrada']);

            lancamentoCaixa($vl_entrada, $id_venda);
            echo "{success: true,response: 'Lancamento efetuado com sucesso'}";	
			
      }
  
   else if($tipo_venda=='2'){

          lacamentoContaReceber($vl_total_nota,$vl_entrada,$forma_pgto_id,$entidade,$id_venda, $user);
          echo "{success: true,response: 'Lancamento efetuado com sucesso'}";	
      }
   
   
   $sql_cr = "SELECT * FROM contas_receber cr WHERE venda_id = '$id_venda'  "; 
		
		$exe_cr = mysql_query($sql_cr) or die(mysql_error().' - '.$sql_cr);
		$ese_cr= mysql_fetch_array($exe_cr);			
		$vl_parcelado = $ese_cr['vl_parcela'] * $ese_cr['nm_total_parcela'] ;
		
		/*
		$sql_cli = "UPDATE entidades SET saldo_devedor = saldo_devedor + '$vl_parcelado' WHERE controle = '".$ese_cr['clientes_id']."' ";
		$exe_cli = mysql_query($sql_cli) or die (mysql_error());
		*/
    
    
    
    
    
    
    }


?>