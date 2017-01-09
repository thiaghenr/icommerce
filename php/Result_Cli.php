<?php
    include "../config.php";
	conexao();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

    $cod = $_GET['cod'];
    $nom = $_GET['nom'];
	$nomeCl = $_POST['nomeCl'];
	$acao = $_POST['acao'];
  
	if($acao != "pesquisa"){
    $sql = "SELECT nome,controle,ruc,telefonecom,ativo FROM clientes WHERE ";
	if ($cod != "0"){
     $sql.= " controle LIKE '$cod%' ";
    }
	if ($nom != "a"){
     $sql.= " nome LIKE '%$nom%' ";
    }
	
	    $rs = mysql_query($sql) or die (mysql_error());
		$num_cli = mysql_num_rows($rs);
  
  	$arr = array();
    while($linha=mysql_fetch_array($rs)){
	
	$arr[] = $linha;
	}
	
	echo '({ "Clientes":'.json_encode($arr).'})'; 
	}
	
	if($acao == "pesquisa" ){
	
	$sql = "SELECT nome,controle,ruc,telefonecom,ativo FROM entidades WHERE  nome LIKE '%$nomeCl%'  ORDER BY nome asc limit 0,100";
	
	    $rs = mysql_query($sql) or die (mysql_error());
		$num_cli = mysql_num_rows($rs);
  
  	$arr = array();
    while($linha=mysql_fetch_array($rs)){
	
	$arr[] = $linha;
	}
	
	echo '({ "Clientes":'.json_encode($arr).'})'; 
	
	}
	
?>