<?php
include "../config.php";
conexao();
include_once("json/JSON.php");
$json = new Services_JSON();


$acao   = ($_POST['acao']) ;
$user = $_POST['user'];
if($acao == "Ler"){


	
	$sql_ler = "SELECT tg.nome_telagrupo, tc.tela,tc.idgrupotela,tc.menu, tcc.* 
				FROM telas_grupo tg, telas_cadastro tc, telas_controle tcc
				WHERE tg.idtelas_grupo = tc.idgrupotela
				AND tc.idtelas = tcc.telaid
				AND tcc.iduser = '$user' ";
	$exe_ler = mysql_query($sql_ler, $base);
	
	$arr = array();
	while ($reg_ler = mysql_fetch_array($exe_ler, MYSQL_ASSOC)){
	  
	$arr[] = $reg_ler;
	}
	
	echo '({"dados":'.json_encode($arr).'})'; 
}


if($acao == "Alterar"){
$dados = $json->decode($_POST["data"]);

for($i = 0; $i < count($dados); $i++){
	
    $idtelascontrole = $dados[$i]->idtelascontrole;
	$acessar  = $dados[$i]->acessar ? "TRUE" : "FALSE";
	$alterar = $dados[$i]->alterar ? "TRUE" : "FALSE";
	$inserir  = $dados[$i]->inserir ? "TRUE" : "FALSE";
	$deletar  = $dados[$i]->deletar ? "TRUE" : "FALSE";
	
	if($acessar == "TRUE"){ $acessar = 1;} else{ $acessar = 0;}
	if($alterar == "TRUE"){ $alterar = 1;} else{ $alterar = 0;}
	if($inserir == "TRUE"){ $inserir = 1;} else{ $inserir = 0;}
	if($deletar == "TRUE"){ $deletar = 1;} else{ $deletar = 0;}
	
	
	$sql_update = "UPDATE telas_controle SET acessar = '$acessar', alterar = '$alterar', inserir = '$inserir', deletar = '$deletar' 
				   WHERE idtelascontrole = '$idtelascontrole' ";
	$exe_update = mysql_query($sql_update);
	$rows_affected = mysql_affected_rows();			
	if ($rows_affected) 
	$count++;
}	
	if ($count) {
	$response = array('success'=>'true', 'del_count'=>$count);			
	echo json_encode($response);
	} else {
	echo '{failure: true}';
	}

}

if($acao == "CadTela"){
$nome = $_POST['nome_tela'];
$idgrupo = $_POST['idtelas_grupo'];
$menu = $_POST['nome_menu'];

	$sql_cadtela = "INSERT INTO telas_cadastro(tela,idgrupotela,menu)
										VALUES('$nome', '$idgrupo', '$menu') ";
	$exe_cadtela = mysql_query($sql_cadtela, $base)or die (mysql_error().'-'.$exe_cadtela);
	$idtela = mysql_insert_id();

	$sql_usu = "SELECT id_usuario FROM usuario ";
	$exe_usu = mysql_query($sql_usu);
	while ($reg_usu = mysql_fetch_array($exe_usu, MYSQL_ASSOC)){
	
	$iduser = $reg_usu['id_usuario'];
	//$id_tela = $idtela;
		$exe_controle = mysql_query("INSERT INTO telas_controle(telaid,iduser,acessar,alterar,inserir,deletar)
											VALUES('$idtela','$iduser','1','0','0','0')");

	}

}

if(isset($_GET['acao'])){
if($_GET['acao'] == 'menu'){
$r = mysql_query ("SELECT * FROM telas_grupo ORDER BY idtelas_grupo ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$id = mysql_result ($r,$i,"idtelas_grupo");
	$grupo = mysql_result ($r,$i, "nome_telagrupo");
	
	if($i == ($l-1)) {
		$grupos .= '{idtelas_grupo:'.$id.', nome_telagrupo:"'.$grupo.'"}';
	}else{
		$grupos .= '{idtelas_grupo:'.$id.', nome_telagrupo:"'.$grupo.'"},';
	}
}

echo ('{resultados: [ '.$grupos.']}');
}
}

?>