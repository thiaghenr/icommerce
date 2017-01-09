<?	
	require_once ("../config.php");
	conexao();

$acao = $_POST['acao'];	
$pesquisa = $_POST['pesquisa'];

if($acao == 'ListarEqvlas'){
	
$r = mysql_query ("SELECT e.*, p.id,p.Descricao,p.Estoque,p.stok,p.Codigo FROM prod_eqvla e, produtos p WHERE e.id_produtos = '$pesquisa' 
					 AND e.id_prod_eqvla = p.id AND e.legal = '1' GROUP BY p.id  ORDER BY p.stok DESC ");
$l = mysql_num_rows ($r);

$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($r))
	{
		$arr[] = $obj;
		
	}
	echo '({"total":"'.$l.'","Eqvlas":'.json_encode($arr).'})'; 
}	
	
if($acao == 'Equivaler'){
$idProd = $_POST['idProd'];
$idEqvla = $_POST['idEqvla'];
$user = $_POST['user'];

	$sql_v = "SELECT id_produtos, id_prod_eqvla FROM prod_eqvla WHERE id_produtos = '$idProd' AND id_prod_eqvla = '$idEqvla' ";
	$exe_v = mysql_query($sql_v);
	$row = mysql_num_rows($exe_v);

	if($row == 0){
	$sql = "INSERT INTO prod_eqvla (id_produtos, id_prod_eqvla, legal, user)
									VALUES('$idProd', '$idEqvla', '1', '$user')";
	$exe = mysql_query($sql);
	
	echo "{success:true, msg: 'Incluido com Sucesso'}";	
	}
}

?>