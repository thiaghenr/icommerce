<?php
include "../config.php";
conexao();
header("Content-Type: text/html; charset=iso-8859-1");
 mysql_query("SET NAMES 'utf8'");
 mysql_query('SET character_set_connection=utf8');
 mysql_query('SET character_set_client=utf8');
 mysql_query('SET character_set_results=utf8');

function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; }          $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
 		$acao = $_POST['acao'];

		$idProd = $_POST['idProd'];
		$Codigo = $_POST['Codigo'];
		$Descricao = $_POST['Descricao'];
		$Descricaoes = $_POST['Descricaoes'];
		$obsprod = $_POST['obsprod'];
		$cod_original = $_POST['cod_original'];
		$Codigo_Fabricante = $_POST['Codigo_Fabricante'];
		$Codigo_Fabricante2 = $_POST['Codigo_Fabricante2'];
		$Codigo_Fabricante3 = $_POST['Codigo_Fabricante3'];
		$pr_mina = str_replace('.', '',$_POST['pr_min']);
		$pr_min = str_replace(',', '.',$pr_mina);
		$margen_a = $_POST['margen_a'];
		if (empty($_POST['margen_b']) && empty($_POST['margen_c'])) {
		$margen_b = $margen_a;
		$margen_c = $margen_a;}
		else{
		$margen_b = $_POST['margen_b'];
		$margen_c = $_POST['margen_c'];}
		$custoa = str_replace(',', '.',$_POST['custo']);
		$custo = str_replace('.', '',$custoa);
		$custo = str_replace('.', '',$custo);
		$custo = str_replace('.', '',$custo);
		$custo = str_replace('.', '',$custo);
		$Estoque = $_POST['Estoque'];
		$qtd_min = $_POST['qtd_min'];
		$iva = $_POST['iva'];
		$local = $_POST['local'];
		$embalagem = $_POST['embalagem'];
		$user = $_POST['user'];
		$id = $_POST['id'];
		$cod_original2 = $_POST['cod_original2'];
		
		$vlaa = str_replace('.', '',$_POST['vla']);
		$vla = str_replace(',', '.',$vlaa);
		
		$vlbb = str_replace('.', '',$_POST['vlb']);
		$vlb = str_replace(',', '.',$vlbb);
		
		$vlcc = str_replace('.', '',$_POST['vlc']);
		$vlc = str_replace(',', '.',$vlcc);
		
		$marca = $_POST['marcaid'];
		$grupo = $_POST['grupoid'];
		
		
		/*
		//PEGANDO O VALOR DO CAMBIO
		$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 3 AND moeda.id = 3 GROUP BY cm.id DESC limit 0,1 ";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
	*/
		$re = mysql_query("select count(*) as total from produtos where Codigo = '".$_POST['Codigo']."' ");
		$total = mysql_result($re, 0, "total");
		
		

		if (empty($vla)){
		$percentual_a = $margen_a / 100;
		$valor_a = $custo + ($percentual_a * $custo);
		}
		else{
		$valor_a = $vla ;
		$diferenca = $valor_a - $custo;
		$margen_aa = $diferenca * 100;
		$margen_a = $margen_aa / $custo;
		}
		
		if (empty($vlb)){
		$percentual_b = $margen_b / 100;
		$valor_b = $custo + ($percentual_b * $custo);
		}
		else{
		$valor_b = $vlb ;
		$diferenca = $valor_b - $custo;
		$margen_bb = $diferenca * 100;
		$margen_b = $margen_bb / $custo;
		}
		if (empty($vlc)){
		$percentual_c = $margen_c / 100;
		$valor_c = $custo + ($percentual_c * $custo);
		}
		else{
		$valor_c = $vlc ;
		$diferenca = $valor_c - $custo;
		$margen_cc = $diferenca * 100;
		$margen_c = $margen_cc / $custo;
		}
		
		
		
    // verifica se tem imagem sendo cadastrada
    if (trim($_FILES['foto']['tmp_name']) != "") {
/*
        // o arquivo é gerado com um nome que nunca se repetirá para evitar que um arquivo existente seja perdido
        // no exemplo, as fotos ficarão dentro do diretório "fotos", é necessário que o mesmo dê permissão total de gravação
        // para o usuário que roda o Servidor web(nobody, wwwrun são os mais comuns)
        $foto = 'fotos/' . md5(md5($_FILES["name"]) . date("YmdHis")) . strstr(basename($_FILES["foto"]["name"]), '.');

        // arquivo com o local de origem
       $orig = $_FILES["foto"]["tmp_name"];
		
        // copia o arquivo para o destino
        if (!copy($orig, "$foto")) {
            echo "<br><br><center>Problemas no upload do arquivo: " . $_FILES["foto"]["name"] . "...</font><br>";
            $erro = "yes";
            $foto = "";
        } 
    } */
	
 define ("MAX_SIZE","400");

 $errors=0;
 
 if($_SERVER["REQUEST_METHOD"] == "POST")
 {
        $image =$_FILES["foto"]["tmp_name"];
 $uploadedfile = $_FILES['foto']['tmp_name'];

  if ($image) 
  {
  $filename = stripslashes($_FILES['foto']['name']);
        $extension = getExtension($filename);
  $extension = strtolower($extension);
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
  {
echo ' Tipo de arquivo de imagem invalido, Produto nao cadastrado ';
exit();
$errors=1;
  }
 else
{
   $size=filesize($_FILES['file']['tmp_name']);
 
if ($size > MAX_SIZE*1024)
{
 echo "Tamanho de arquivo alem do permitido, Produto nao cadastrado.";
 exit();
 $errors=1;
}
 
if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['foto']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);
}
else if($extension=="png")
{
$uploadedfile = $_FILES['foto']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);
}
else 
{
$src = imagecreatefromgif($uploadedfile);
}
 
list($width,$height)=getimagesize($uploadedfile);

$newwidth=400;
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);

//CRIAR THUMBNAIL
//$newwidth1=25;
//$newheight1=($height/$width)*$newwidth1;
//$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);

//imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1, $width,$height);

		// o arquivo é gerado com um nome que nunca se repetirá para evitar que um arquivo existente seja perdido
        // no exemplo, as fotos ficarão dentro do diretório "fotos", é necessário que o mesmo dê permissão total de gravação
        // para o usuário que roda o Servidor web(nobody, wwwrun são os mais comuns)
$filename = '../fotos/' . md5(md5($_FILES["name"]) . date("YmdHis")) . strstr(basename($_FILES["foto"]["name"]), '.');
//$filename1 = "fotos/small". $_FILES['foto']['name'];

imagejpeg($tmp,$filename,100);
//imagejpeg($tmp1,$filename1,100);

imagedestroy($src);
imagedestroy($tmp);
//imagedestroy($tmp1);
}
}
}
//If no errors registred, print the success message

 if(isset($_POST['Submit']) && !$errors) 
 {
   // mysql_query("update SQL statement ");
  echo "Image Uploaded Successfully!";

 }

}

if ($total == 0) {

if($acao == 'Cadastra'){
	
		$sql_per = "INSERT INTO produtos (Codigo, Descricao, Descricaoes, custo, part_number,  serial, 
					cod_original, Codigo_fabricante, Codigo_fabricante2, Codigo_fabricante3, pr_min, 
					margen_a, margen_b, margen_c, valor_a, valor_b, valor_c, Estoque, qtd_min, iva, 
					qtd_bloq, local, embalagem, user, data, marca, grupo, cod_original2, custo_medio, 
					custo_anterior, imagem, obs) 
		VALUES(UCASE('$Codigo'), UCASE('$Descricao'), UCASE('$Descricaoes'), '$custo', UCASE('$part_number'), 
		UCASE('$serial'), UCASE('$cod_original'), UCASE('$Codigo_Fabricante'), UCASE('$Codigo_Fabricante2'), 
		UCASE('$Codigo_Fabricante3'), '$pr_min', '$margen_a', '$margen_b', '$margen_c', '$valor_a', '$valor_b', '$valor_c', 
		'$Estoque', '$qtd_min', '$iva', '$qtd_bloq', UCASE('$local'), UCASE('$embalagem'), UCASE('$user'), NOW(), 
		'$marca', '$grupo', UCASE('$cod_original2'), UCASE('$custo'), UCASE('$custo'), '$filename', '$obsprod')";
		$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	
	
    echo "{success: true,msg: 'O Codigo do Produto Cadatrado e: $Codigo'}";
	exit();
	}
	
	}
	
		
	if ($total > 0 && $acao == 'Cadastra') {
		echo "{failure: true,msg: 'Produto com esse Codigo ja cadastrado! $id'}";
		exit();
}

if($acao == 'Update'){

	$sql_per = "UPDATE produtos SET Codigo=UCASE('$Codigo'), Descricao=UCASE('$Descricao'),  Descricaoes=UCASE('$Descricaoes'), custo='$custo',  marca=UCASE('$marca'), grupo='$grupo', cod_original=UCASE('$cod_original'), Codigo_Fabricante=UCASE('$Codigo_Fabricante'), Codigo_Fabricante2=UCASE('$Codigo_Fabricante2'), Codigo_Fabricante3=UCASE('$Codigo_Fabricante3'), pr_min='$pr_min', margen_a='$margen_a', margen_b='$margen_b', margen_c='$margen_c', valor_a='$valor_a', valor_b='$valor_b', valor_c='$valor_c', qtd_min='$qtd_min', iva='$iva',  embalagem=UCASE('$embalagem'), data=NOW(), user=UCASE('$nome_user'), local=UCASE('$local'), marca='$marca', grupo='$grupo', cod_original2=UCASE('$cod_original2'), imagem='$filename' WHERE id = '".$idProd."' ";
$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);

	echo "{success: true,msg: 'Cadastro Alterado com Sucesso'}";

}

if($acao == "excluirProd"){
$idProd = $_POST['idProd'];
	
	$rs    = mysql_query("SELECT id_prod FROM itens_pedido WHERE id_prod = $idProd  ")or die (mysql_error().'-'.$rs);
	$totalProdutos = mysql_num_rows($rs);
	
	if($totalProdutos == 0){
	$sql_del = "DELETE FROM produtos WHERE id = $idProd ";
	$exe_del = mysql_query($sql_del, $base)or die (mysql_error().'-'.$sql_del);
	echo "{success:true, response: 'ProdutoExcluido' }"; 
	}
	else{
	echo "{success:true, response: 'LancamentoExistente' }"; 
	}
	exit();
}

?>