<?	
	require_once ("config.php");
    require_once("biblioteca.php");
	conexao();
	$param = htmlentities(stripslashes(addslashes(strtoupper($_GET['q']))));
	
	$sql_marca = "SELECT total_nota FROM pedido WHERE id = '".$reg_lista['id']."' ";
	$rs_marca = mysql_query($sql_marca) or die (mysql_error());
	
	while ($linha_marca=mysql_fetch_array($rs_marca, MYSQL_ASSOC)){
		echo $linha_marca['total_nota']."\n";
	}
	if(mysql_num_rows($rs_marca) <=0){
		echo "Nao encontrado\n";
	}
?>