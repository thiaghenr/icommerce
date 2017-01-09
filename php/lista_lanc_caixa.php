<?php
include "../config.php";
conexao();


 $idcaixa = $_POST['caixaid'];

		$sql_lancamentos = "SELECT l.id AS idl,l.*,date_format(l.dt_lancamento, '%d/%m/%Y')AS dt_lancamento, v.pedido_id
		FROM caixa_balcao c, lancamento_caixa_balcao l
		LEFT JOIN venda v ON v.id = l.venda_id 
		WHERE l.caixa_id = '$idcaixa' AND l.caixa_id = c.id AND l.vl_pago != '0' ORDER BY l.id desc ";
		$exe_lancamentos = mysql_query($sql_lancamentos) or die(mysql_error().'-'.$sql_lancamentos);
		$total = mysql_num_rows($exe_lancamentos);
		$arr = array();
		while($obj = mysql_fetch_array($exe_lancamentos, MYSQL_ASSOC)){
		
		if($obj['receita_id'] == 1){
		$Entradas +=  $obj['vl_pago'];
		}
		if($obj['receita_id'] == 2){
		$Saidas +=  $obj['vl_pago'];
		}
		if($obj['receita_id'] == 3){
		$Devs +=  $obj['vl_pago'];
		}
		if($obj['receita_id'] == 7){
		$Trf +=  $obj['vl_pago'];
		}
		
		$arr[] = $obj;
		}
	echo '({"total":"'.$total.'","Entradas":"'.$Entradas.'","Saidas":"'.$Saidas.'","Devs":"'.$Devs.'","Trf":"'.$Trf.'","result":'.json_encode($arr).'})'; 
?>

