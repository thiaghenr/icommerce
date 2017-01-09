<?php
include "../config.php";
conexao();
header("Content-Type: text/html; charset=iso-8859-1");

 mysql_query("SET NAMES 'utf8'");
 mysql_query('SET character_set_connection=utf8');
 mysql_query('SET character_set_client=utf8');
 mysql_query('SET character_set_results=utf8');

	
		$id = $_POST['id'];
		$Codigo = $_POST['Codigo'];
	    $Descricao = $_POST['Descricao'];
		$Descricaoes = $_POST['Descricaoes'];
		$part_number = $_POST['part_number'];
		$cod_original = $_POST['cod_original'];
		$Codigo_Fabricante = $_POST['Codigo_Fabricante'];
		$Codigo_Fabricante2 = $_POST['Codigo_Fabricante2'];
		$Codigo_Fabricante3 = $_POST['Codigo_Fabricante3'];
		$pr_mina = str_replace('', '',$_POST['pr_min']);
		$pr_min = str_replace(',', '',$pr_mina);
		$margen_a = $_POST['margen_a'];
		if (empty($_POST['margen_b']) && empty($_POST['margen_c'])) {
		$margen_b = $margen_a;
		$margen_c = $margen_a;}
		else{
		$margen_b = $_POST['margen_b'];
		$margen_c = $_POST['margen_c'];}
		$custoa = str_replace('.', '',$_POST['custo']);
		$custo = str_replace(',', '.',$custoa);
		$valor_a = $_POST['valor_a'];
		$valor_b = $_POST['valor_b'];
		$valor_c = $_POST['valor_c'];
		$Estoque = $_POST['Estoque'];
		$qtd_min = $_POST['qtd_min'];
		$iva = $_POST['iva'];
		$local = $_POST['local'];
		$embalagem = $_POST['embalagem'];
		$user = $_POST['nome_user'];
		$obs = $_POST['obs'];
		$id = $_POST['id'];
		$cod_original2 = $_POST['cod_original2'];
		$vlaa = str_replace('.', '',$_POST['vla']);
		$vla = str_replace(',', '.',$vlaa);
		
		$vlbb = str_replace('.', '',$_POST['vlb']);
		$vlb = str_replace(',', '.',$vlbb);
		
		$vlcc = str_replace('.', '',$_POST['vlc']);
		$vlc = str_replace(',', '.',$vlcc);
		
		$marca = $_POST['idmarca'];
		$grupo = $_POST['idgrupo'];
		
		//PEGANDO O VALOR DO CAMBIO
		$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 3 AND moeda.id = 3 GROUP BY cm.id DESC limit 0,1 ";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
			
		
		if (empty($vla)){
		$percentual_a = $margen_a / 100;
		$valor_a = $custo + ($percentual_a * $custo);
		}
		else{
		$valor_a = $vla;// /  $vl_cambio_guarani;
		//$diferenca = $valor_a - $custo;
		//$margen_aa = $diferenca * 100;
		//$margen_a = $margen_aa / $custo;
		}
		
		if (empty($vlb)){
		$percentual_b = $margen_b / 100;
		$valor_b = $custo + ($percentual_b * $custo);
		}
		else{
		$valor_b = $vlb;// /  $vl_cambio_guarani;
		//$diferenca = $valor_b - $custo;
		//$margen_bb = $diferenca * 100;
		//$margen_b = $margen_bb / $custo;
		}
		if (empty($vlc)){
		$percentual_c = $margen_c / 100;
		$valor_c = $custo + ($percentual_c * $custo);
		}
		else{
		$valor_c = $vlc;// /  $vl_cambio_guarani;
		//$diferenca = $valor_c - $custo;
		//$margen_cc = $diferenca * 100;
		//$margen_c = $margen_cc / $custo;
		}
		
    // verifica se tem imagem sendo cadastrada
    if (trim($_FILES['foto']['tmp_name']) != "") {

        // o arquivo é gerado com um nome que nunca se repetirá para evitar que um arquivo existente seja perdido
        // no exemplo, as fotos ficarão dentro do diretório "fotos", é necessário que o mesmo dê permissão total de gravação
        // para o usuário que roda o Servidor web(nobody, wwwrun são os mais comuns)
    echo    $foto = '../fotos/' . md5(md5($_FILES["name"]) . date("YmdHis")) . strstr(basename($_FILES["foto"]["name"]), '.');

        // arquivo com o local de origem
       $orig = $_FILES["foto"]["tmp_name"];
		
        // copia o arquivo para o destino
        if (!copy($orig, "$foto")) {
            echo "<br><br><center>Problemas no upload do arquivo: " . $_FILES["foto"]["name"] . "...</font><br>";
            $erro = "yes";
            $foto = "";
        } 
    }
	
		$sql_per = "UPDATE produtos SET Codigo = UCASE('$Codigo'), obs = '$obs', Descricao = UCASE('$Descricao'), Descricaoes = UCASE('$Descricaoes'), custo = '$custo', cod_original = UCASE('$cod_original'), Codigo_fabricante = UCASE('$Codigo_Fabricante'), Codigo_fabricante2 = UCASE('$Codigo_Fabricante2'), Codigo_fabricante3 = UCASE('$Codigo_Fabricante3'), pr_min = '$pr_min', margen_a = '$margen_a', margen_b = '$margen_b', margen_c = '$margen_c', valor_a = '$valor_a', valor_b = '$valor_b', valor_c = '$valor_c', 	Estoque = '$Estoque', qtd_min = '$qtd_min', iva = '$iva', qtd_bloq = '$qtd_bloq', local = UCASE('$local'), embalagem = UCASE('$embalagem'), user = UCASE('$nome_user'), data = NOW(), marca = '$marca', grupo = '$grupo', cod_original2 = UCASE('$cod_original2'), imagem = '$foto' where id = '$id' "; 
		$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	
    echo "{success: true,msg: 'Produto Alterado: $id'}";
	
	
	
		
	
		//echo "{failure: true,msg: 'Produto com esse Codigo ja cadastrado! $Codigo'}";

?>