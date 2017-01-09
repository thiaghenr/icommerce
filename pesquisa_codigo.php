<?	
	require_once ("config.php");
    require_once("biblioteca.php");
	conexao();
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
	
	$query = $_POST['query'];
	$acao_nome = $_GET['acao_nome'];
	$acao = $_POST['acao'];
	$CodForn = $_POST['CodForn'];
	$user = $_POST['user'];

	$param = strtoupper($_GET['q']);
	
	$sql_grupo = "SELECT Codigo FROM produtos WHERE Codigo LIKE '%$param%'";
	$rs_grupo = mysql_query($sql_grupo);
	
	while ($linha_grupo=mysql_fetch_array($rs_grupo, MYSQL_ASSOC)){
		echo $linha_grupo['Codigo']."\n";
	}
	if(mysql_num_rows($rs_grupo) <=0){
		echo "Nao encontrado\n";
	}	


?>