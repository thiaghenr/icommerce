<?php
 require_once("../biblioteca.php");
 require_once("../config.php");
 conexao();
 include("JSON.php");

$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 5 ;
$acao = isset($_POST['acao']) ? $_POST['acao'] : '';
$idpedido = $_POST['idpedido'];
$idForma = $_POST['idForma'];
$subtotalFat = $_POST['subtotalFat'];
$user = $_POST['user'];
$valor_debitar = $_POST['valor_debitar'];
$valor_entrada = $_POST['valor_entrada'];


if($acao == 'listarPedidos'){
$query = isset($_POST['query']) ? $_POST['query'] : 1;
 
 $rs    = mysql_query("SELECT cl.endereco, it.id_pedido, sum(it.prvenda * it.qtd_produto) AS totalitens, f.id AS idforma, f.descricao, u.id_usuario, u.nome_user, p.id,p.nome_cli,p.controle_cli, date_format(p.data_car, '%d/%m/%Y') AS data, p.total_nota, p.situacao, p.usuario_id, p.vendedor_id, p.status, p.forma_pagamento_id FROM itens_pedido it, pedido p, forma_pagamento f, clientes cl, usuario u WHERE p.controle_cli = cl.controle AND it.id_pedido = p.id AND p.situacao = 'A' AND u.id_usuario = p.usuario_id AND p.forma_pagamento_id = f.id  GROUP BY p.id ORDER BY p.id DESC  LIMIT $inicio, $limite ")or die (mysql_error());
 $rst    = mysql_query("SELECT id FROM pedido WHERE situacao = 'A' ");
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

    if ($num_prodp > 0) {

        $reg_prodp = mysql_fetch_array($exe_prodp, MYSQL_ASSOC );
        $vl_total_nota = $reg_prodp['total_nota'];

        $sql_alt_status = "UPDATE pedido SET situacao = 'F' WHERE id = '$id_pedido' ";
        $exe_alt_status = mysql_query($sql_alt_status) or die (mysql_error());
        
        $sql_addv = "INSERT INTO venda
    	    (data_venda, pedido_id, num_boleta, valor_venda, imposto_id, controle_cli, st_venda )
    		VALUES
    		(NOW(), '".$reg_prodp['id']."', '0', '".$reg_prodp['total_nota']."',  '10', '".$reg_prodp['controle_cli']."','".$st_venda."')";
        $exe_addv = mysql_query($sql_addv) or die (mysql_error().'-'.$sql_addv);

        $id_venda = mysql_insert_id();

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

                $qtd_prod =  $reg_prodc['qtd_produto'] ;
                $exe_addi = mysql_query($sql_addi) or die (mysql_error().'-'.$sql_addi);

                $sql_qtd1 = "UPDATE produtos SET qtd_bloq =  qtd_bloq - '$qtd_prod' WHERE id = '".$reg_prodc['id_prod']."' ";
                $exe_qtd1 = mysql_query($sql_qtd1) or die (mysql_error());
        }
      }

      $vl_total = ajustaValor($subtotalFat);
      $forma_pgto_id = $idForma;

     


      
    }
/////////////////////////////////////////////////////////////////////////////////////////////////

    function lancamentoCaixa($vl_total_nota, $id_venda){
    $id_usuario = $user;

      $sql_caixa_balcao = "SELECT * FROM caixa_balcao WHERE usuario_id = '".$_POST['user']."' AND st_caixa = 'A'";
      $rs_caixa_balcao = mysql_query($sql_caixa_balcao) or die (mysql_error().'-'.$sql_caixa_balcao);

      if(!mysql_num_rows($rs_caixa_balcao)){
          echo "{success: true,response: 'N�o h� caixa aberto para este usuario'}";
          
      }
      if(mysql_num_rows($rs_caixa_balcao)){
            $linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao);
            $caixa_id = $linha_caixa_balcao['id'];
            $sql_lancamento_caixa_balcao = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id) ";
            $sql_lancamento_caixa_balcao.= "VALUES ('1','$caixa_id',now(),'$vl_total_nota','$id_venda')";

            mysql_query($sql_lancamento_caixa_balcao) or die (mysql_error());
          //  echo "{success: true,response: 'Lancamento efetuado com sucesso'}";
      }
    }
 
    ////////////////////////////////////////////////////////////////////////////////////////////////

   function lacamentoContaReceber($vl_total,$vl_entrada,$forma_pgto_id,$clientes_id,$venda_id){
      $sql_forma_pgto = "SELECT * FROM forma_pagamento WHERE id = $forma_pgto_id";
      $rs_forma_pgto = mysql_query($sql_forma_pgto) or die(mysql_error());
      $linha_forma_pgto = mysql_fetch_array($rs_forma_pgto);

      $nm_total_parcela = $linha_forma_pgto['nm_total_parcela'];
      $nm_intervalo_parcela = $linha_forma_pgto['nm_intervalo_parcela'];
	  

      $mes_milli = 2592000;
      $data_atual = date('Y-m-d');
      $dt_atual_milli = strtotime($data_atual);

      $vl_parcela = (($vl_total - $vl_entrada) / $nm_total_parcela);

      for ($i=0; $i<$nm_total_parcela; $i++){

        $dt_atual_milli = ($dt_atual_milli + $mes_milli);
        $dt_new = date("Y-m-d",($dt_atual_milli));

        $sql_conta_receber = "INSERT INTO contas_receber (vl_total,vl_parcela,nm_total_parcela,nm_parcela,clientes_id,venda_id,status,dt_lancamento,dt_vencimento)
        VALUES ('".$vl_total."','$vl_parcela','$nm_total_parcela',".($i+1).",'$clientes_id','$venda_id','A','$data_atual','$dt_new')";

        mysql_query($sql_conta_receber) or die(mysql_error().' - '.$sql_conta_receber);
        
	//	echo "{success: true,response: 'Lancamento efetuado com sucesso'}";	
      }
   }
   
    if ($tipo_venda == '1') {
            lancamentoCaixa($vl_total_nota, $id_venda, $user);
            echo "{success: true,response: 'Lancamento efetuado com sucesso'}";	
      }
   
    else if($tipo_venda=='3' || $tipo_venda=='4'){
        $vl_entrada = ($valor_entrada);

            lacamentoContaReceber($vl_total,$vl_entrada,$forma_pgto_id,$reg_prodp['controle_cli'],$id_venda);
            lancamentoCaixa($vl_entrada, $id_venda);
            echo "{success: true,response: 'Lancamento efetuado com sucesso'}";	
      }
  
   else if($tipo_venda=='2'){

          lacamentoContaReceber($vl_total,0.00,$forma_pgto_id,$reg_prodp['controle_cli'],$id_venda);
          echo "{success: true,response: 'Lancamento efetuado com sucesso'}";	
      }
   
   
   $sql_cr = "SELECT * FROM contas_receber cr WHERE venda_id = '$id_venda'  "; 
		
		$exe_cr = mysql_query($sql_cr) or die(mysql_error().' - '.$sql_cr);
		$ese_cr= mysql_fetch_array($exe_cr);			
		$vl_parcelado = $ese_cr['vl_parcela'] * $ese_cr['nm_total_parcela'] ;
		
		
		$sql_cli = "UPDATE clientes SET saldo_devedor = saldo_devedor + '$vl_parcelado' WHERE controle = '".$ese_cr['clientes_id']."' ";
		$exe_cli = mysql_query($sql_cli) or die (mysql_error());
		
    
    
    
    
    
    
    }


?>