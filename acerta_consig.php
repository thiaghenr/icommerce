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
			
	$sql_venda = "SELECT * from itens_consig";		
		  
	$exe_venda = mysql_query($sql_venda) or die(mysql_error());
	while ($reg_venda = mysql_fetch_array($exe_venda, MYSQL_ASSOC)){
	
	echo $id = $reg_venda['itcsg_iditensconsig']."&nbsp;";
	echo $qtd = $reg_venda['itcsg_qtd']."&nbsp;";
	echo $idprod = $reg_venda['itcsg_produtoid']."<br>";
//	echo $reg_venda['valorvenda']."<br>";
	
	$idpedido = $reg_venda['idp'];
	$prvenda = $reg_venda['valor_b'];
	$codigo = $reg_venda['Codigo'];

    $sql_pedido = "UPDATE itens_consig SET itcsg_transf = (itcsg_transf + '$qtd') WHERE itcsg_iditensconsig = '$id' ";	
//	$exe_pedido = mysql_query($sql_pedido)or die(mysql_error());
	
	$sql_prod = "UPDATE produtos SET Estoque = (Estoque + '$qtd') WHERE id = '$idprod' ";	
//	$exe_prod = mysql_query($sql_prod)or die(mysql_error());
	
	}
	
?>



</body>
</html>