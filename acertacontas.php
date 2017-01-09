<?
	require_once("biblioteca.php");
 	require_once("config.php");
    conexao();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>





<?	
	//$sql_venda = "SELECT v.id AS idvenda,v.pedido_id, iv.id,iv.id_venda,iv.referencia_prod,iv.prvenda FROM venda v, itens_venda iv
	//              WHERE v.id = iv.id_venda ";
	
//	$sql_venda = "SELECT c.id AS idcar,c.controle,c.sessao,c.Codigo,c.prvenda AS valorvenda, p.id AS idp, p.controle_cli,p.sessao_car, it.id_pedido,it.referencia_prod FROM carrinho c, pedido p, itens_pedido it WHERE c.sessao = p.sessao_car AND p.id = it.id_pedido AND c.controle = p.controle_cli AND c.Codigo = it.referencia_prod order by p.id";
			
	$sql_venda = "SELECT * from lancamento_caixa where historico = 'Retirada Socio' ";				  
	$exe_venda = mysql_query($sql_venda) or die(mysql_error());
	while ($reg_venda = mysql_fetch_array($exe_venda, MYSQL_ASSOC)){
	
	 $dt_lancamento = $reg_venda['data_lancamento'];
echo	 $valor = $reg_venda['valor'];
	 $id = $reg_venda['id'];

	$sql_pedido = "INSERT INTO lanc_contas (plano_id, plan_codigo, documento, dt_lanc_desp, desc_desp, valor, usuario_id, receita_id, entidade_id )
	VALUES('61', '2.01.02.01.000.00', '$id', '$dt_lancamento', 'Retirada Socio', '$valor', '$id_usuario', '2', '3' )";	
	$exe_pedido = mysql_query($sql_pedido)or die(mysql_error());
	
	}
	
?>



</body>
</html>