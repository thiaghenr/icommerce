<?	
	require_once ("config.php");
    require_once("biblioteca.php");
	conexao();
	$param = strtoupper($_GET['q']);
	
	$sql_grupo = "SELECT Descricao FROM produtos WHERE Descricao LIKE '%$param%'";
	$rs_grupo = mysql_query($sql_grupo);
	
	while ($linha_grupo=mysql_fetch_array($rs_grupo, MYSQL_ASSOC)){
		echo $linha_grupo['Descricao']."\n";
	}
	if(mysql_num_rows($rs_grupo) <=0){
		echo "Nao encontrado\n";
	}	
?>