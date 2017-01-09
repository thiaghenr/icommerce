<?
    require_once("verifica_login.php");
    require_once("biblioteca.php");
    include "config.php";
    conexao();
	 $data= date("Y/m/d");
	 	
    $tipo_venda = $_POST['tipo_venda'];

    if($tipo_venda=='VA')
    echo    $st_venda = 'F';
    else if($tipo_venda=='PCE' || $tipo_venda=='PSE')
        $st_venda = 'A';


    $id_pedido = $_POST['id_pedido'];


  	$sql_prodp = "SELECT * FROM pedido WHERE id =  '$id_pedido' ";
    $exe_prodp = mysql_query($sql_prodp, $base) or die (mysql_error());
  	$num_prodp = mysql_num_rows($exe_prodp);
    $vl_total_nota;

    if ($num_prodp > 0) {

        $reg_prodp = mysql_fetch_array($exe_prodp, MYSQL_ASSOC );
        $vl_total_nota = $reg_prodp['total_nota'];
		$forma_pago = $reg_prodp['forma_pagamento_id'];
		if ($forma_pago == 1) {
		$forma = $data; }
			
		
		

        $sql_alt_status = "UPDATE pedido SET situacao = 'F' WHERE id = '$id_pedido' ";

        $exe_alt_status = mysql_query($sql_alt_status) or die (mysql_error());
        $sql_addv = "INSERT INTO venda
    	    (data_venda, pedido_id, num_boleta, valor_venda, imposto_id, controle_cli, st_venda )
    		VALUES
    		(NOW(), '".$reg_prodp['id']."', '0', '".$reg_prodp['total_nota']."',  '10', '".$reg_prodp['controle_cli']."','".$st_venda."')";

        $exe_addv = mysql_query($sql_addv) or die (mysql_error().'-'.$sql_addv);

        $id_venda = mysql_insert_id();

        $sql_prodc = "SELECT * FROM itens_pedido WHERE  id_pedido = '$id_pedido'  " ;
        $exe_prodc = mysql_query($sql_prodc) or die (mysql_error());
    	$num_prodc = mysql_num_rows($exe_prodc);

      if ($num_prodc > 0) {
      	while ($reg_prodc = mysql_fetch_array($exe_prodc, MYSQL_ASSOC )) {
              $sql_addi = "INSERT INTO itens_venda
        	            (id_venda, referencia_prod, descricao_prod, prvenda, qtd_produto)
        				VALUES
        				('$id_venda','".$reg_prodc['referencia_prod']."', '".strtoupper(mysql_escape_string($reg_prodc['descricao_prod']))."',
                            '".$reg_prodc['prvenda']."', '".$reg_prodc['qtd_produto']."')";

                $qtd_prod =  $reg_prodc['qtd_produto'] ;
                $exe_addi = mysql_query($sql_addi) or die (mysql_error().'-'.$sql_addi);

                $sql_qtd1 = "UPDATE produtos SET qtd_bloq =  qtd_bloq - '$qtd_prod' WHERE Codigo = '$reg_prodc[referencia_prod]' ";
                $exe_qtd1 = mysql_query($sql_qtd1) or die (mysql_error());
        }
      }

      $vl_total = ajustaValor($_POST['vl_total'],2,",",".");
 

      $forma_pgto_id = $_POST['forma_pgto_id'];

      if ($tipo_venda == 'VA') {
            lancamentoCaixa($vl_total_nota, $id_venda);
      }

      else if($tipo_venda=='PCE'){
             $vl_entrada = ajustaValor($_POST['vl_entrada']);

            lacamentoContaReceber($vl_total,$vl_entrada,$forma_pgto_id,$reg_prodp['controle_cli'],$id_venda);
            lancamentoCaixa($vl_entrada, $id_venda);
      }
      else if($tipo_venda=='PSE'){

          lacamentoContaReceber($vl_total,0.00,$forma_pgto_id,$reg_prodp['controle_cli'],$id_venda);
          header("Location: caixa.php?msg=".$msg);
          header("Location:pesquisa_pedido_venda.php");
      }
    }

    function lancamentoCaixa($vl_total_nota, $id_venda){
      $id_usuario = $_SESSION['id_usuario'];

      $sql_caixa_balcao = "SELECT * FROM caixa_balcao WHERE usuario_id = " .$id_usuario." AND st_caixa = 'A'";
      $rs_caixa_balcao = mysql_query($sql_caixa_balcao) or die (mysql_error().'-'.$sql_caixa_balcao);

      if(!mysql_num_rows($rs_caixa_balcao)){
            $msg = "Não há caixa aberto para este usuario";
			header("Location: caixa.php?msg=".$msg);
      }
      if(mysql_num_rows($rs_caixa_balcao)){
            $linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao);
            $caixa_id = $linha_caixa_balcao['id'];
            $sql_lancamento_caixa_balcao = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id) ";
            $sql_lancamento_caixa_balcao.= "VALUES (1,$caixa_id,now(),$vl_total_nota,$id_venda)";

            mysql_query($sql_lancamento_caixa_balcao) or die (mysql_error());
            header("Location: caixa.php?msg=".$msg);
            header("Location:pesquisa_pedido_venda.php");
      }
    }

   function lacamentoContaReceber($vl_total,$vl_entrada,$forma_pgto_id,$clientes_id,$venda_id){
      $sql_forma_pgto = "SELECT * FROM forma_pagamento WHERE id = $forma_pgto_id";
      $rs_forma_pgto = mysql_query($sql_forma_pgto) or die(mysql_error());
      $linha_forma_pgto = mysql_fetch_array($rs_forma_pgto);

      $nm_total_parcela = $linha_forma_pgto['nm_total_parcela'];
      $nm_intervalo_parcela = $linha_forma_pgto['nm_intervalo_parcela'];
	  

      $mes_milli = 2592000;
      $data_atual = date('Y-m-d');
      $dt_atual_milli = strtotime($data_atual);

      $vl_parcela = ($vl_total - $vl_entrada / $nm_total_parcela);

      for ($i=0; $i<$nm_total_parcela; $i++){

        $dt_atual_milli = ($dt_atual_milli + $mes_milli);
        $dt_new = date("Y-m-d",($dt_atual_milli));

        $sql_conta_receber = "INSERT INTO contas_receber (vl_total,vl_parcela,nm_total_parcela,nm_parcela,clientes_id,venda_id,status,dt_lancamento,dt_vencimento)";
        $sql_conta_receber.=" VALUES ($vl_total,$vl_parcela,$nm_total_parcela,".($i+1).",$clientes_id,$venda_id,'A','$data_atual','$dt_new')";

        mysql_query($sql_conta_receber) or die(mysql_error().' - '.$sql_conta_receber);
			
      }
   }
   
   $sql_cr = "SELECT * FROM contas_receber cr WHERE venda_id = '$id_venda'  "; 
		
		$exe_cr = mysql_query($sql_cr) or die(mysql_error().' - '.$sql_cr);
		$ese_cr= mysql_fetch_array($exe_cr);			
		$vl_parcelado = $ese_cr['vl_parcela'] * $ese_cr['nm_total_parcela'] ;
		
		
		$sql_cli = "UPDATE clientes SET saldo_devedor = saldo_devedor + '$vl_parcelado' WHERE controle = '".$ese_cr['clientes_id']."' ";
		$exe_cli = mysql_query($sql_cli) or die (mysql_error());
		
   
   
?>