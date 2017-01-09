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
			
	$sql_usu = "SELECT * FROM telas_cadastro ";
	$exe_usu = mysql_query($sql_usu);
	while ($reg_usu = mysql_fetch_array($exe_usu, MYSQL_ASSOC)){
		
		$idtela = $reg_usu['idtelas'];
		
			$sql_tela = "SELECT * FROM usuario ";
			$exe_tela = mysql_query($sql_tela);
			while ($reg_tela = mysql_fetch_array($exe_tela, MYSQL_ASSOC)){

				$iduser = $reg_tela['id_usuario'];
					
						$exe_controle = mysql_query("INSERT INTO telas_controle2(telaid,iduser,acessar,alterar,inserir,deletar)
													VALUES('$idtela','$iduser','1','0','0','0')");
			}
	}

 // $sql_pedido = "UPDATE itens_pedido SET prvenda = '$prvenda' WHERE referencia_prod = '$codigo' AND prvenda = '130000' ";	
//	$exe_pedido = mysql_query($sql_pedido)or die(mysql_error());
	
	
	
?>



</body>
</html>