<?php
 require_once("../biblioteca.php");
 require_once("../config.php");
 conexao();
include_once("json/JSON.php");
$json = new Services_JSON();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 20 ;
$acao = isset($_POST['acao']) ? $_POST['acao'] : '';
$idVenda = $_POST['idVenda'];
$condicao = $_POST['condicao'];
$idForma = $_POST['idForma'];
$nform = $_POST['nform'];
$subtotalFat = $_POST['subtotalFat'];
$user = $_POST['user'];
$valor_debitar = $_POST['valor_debitar'];
$valor_entrada = $_POST['valor_entrada'];


if($acao == 'listarVendas'){
$query = $_POST['theQueryPed'];

 $sql = "SELECT cl.endereco, v.id AS idVenda, p.id AS idPedido, it.id_venda, sum(it.prvenda * it.qtd_produto) AS totalitens, f.id AS idforma, 
						f.descricao, u.id_usuario, u.nome_user, v.id, v.desconto, v.num_form, v.imp, v.controle_cli, cl.nome, date_format(p.data_car, '%d/%m/%Y') AS datapedido,	
						p.vendedor_id, p.forma_pagamento_id, it.impsn
						FROM itens_venda it, pedido p, venda v, forma_pagamento f, entidades cl, usuario u
						WHERE v.controle_cli = cl.controle AND it.id_venda = v.id AND it.qtd_produto > it.qtd_imp 
						AND u.id_usuario = p.usuario_id AND p.forma_pagamento_id = f.id AND v.pedido_id = p.id  "; 
 if($query != ""){
 $sql .= " AND p.id = '$query' "; 
 }
 $sql .= " GROUP BY p.id ORDER BY p.id DESC  LIMIT $inicio, $limite";						
 $rs    = mysql_query($sql)or die (mysql_error());
 $rst    = mysql_query("SELECT id FROM venda WHERE imp != '1' ");
 $total  = mysql_num_rows($rst);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '{"total":'.$total.',"results":'.json_encode($arr).'}'; 
} 

if($acao == 'ListaForm'){
 
 $rs    = mysql_query("SELECT *, date_format(data_imp,'%d/%m/%Y - %H:%m') AS data_imp FROM im_impressao WHERE id_venda = '$idVenda' ORDER BY idim_impressao DESC  LIMIT $inicio, $limite ")or die (mysql_error());
 $total  = mysql_num_rows($rs);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '{"totalProperty":'.$total.',"results":'.json_encode($arr).'}'; 
} 

if($acao == "AlterarForm"){
$campo = $_POST['campo'];
if($campo == "3"){
$campo = "nform";
}
$valor = $_POST['valor'];
$idImp = $_POST['idImp'];
	
	$sql_per = "UPDATE im_impressao SET $campo = '$valor' WHERE idim_impressao = '$idImp' ";
	$exe_per = mysql_query($sql_per) or die (mysql_error()) ;

	
	}

if($acao == 'listarItensVenda'){   //LEFT JOIN im_impressao im on im.idvenda = '$idVenda'
						//LEFT JOIN im_impressao_itens iti on iti.id_impressao = im.idim_impressao

	$rs = mysql_query("SELECT p.id, p.Estoque,p.Codigo, v.desconto, ip.id_prod,ip.id_pedido,pd.id AS idp, iv.*, p.Estoque AS fisico
						FROM  pedido pd,  venda v, produtos p
						LEFT JOIN itens_pedido ip on ip.id_prod = p.id
						LEFT JOIN itens_venda iv on iv.idproduto = p.id
						WHERE ip.id_pedido = pd.id AND v.pedido_id = pd.id AND v.id = '$idVenda' AND iv.id_venda = v.id
						GROUP BY iv.id  " ) or die (mysql_error());
	$arr = array();
	while($obj = mysql_fetch_array($rs, MYSQL_ASSOC)){
	//$arr[] = $obj;
	$id = $obj['id'];
	$Estoque = $obj['Estoque'];
	$Codigo = $obj['Codigo'];
	$id_prod = $obj['id_prod'];
	$id_pedido = $obj['id_pedido'];
	$idp = $obj['idp'];
	$desconto = $obj['desconto'];
	$id_venda = $obj['id_venda'];
	$referencia_prod = $obj['referencia_prod'];
	$descricao_prod = $obj['descricao_prod'];
	$prvenda = $obj['prvenda'];
	$qtd_produto = $obj['qtd_produto'];
	$idproduto = $obj['idproduto'];
	$qtd_imp = $obj['qtd_imp'];
	$impsn = $obj['impsn'];
	$fisico = $obj['fisico'];
	// 0981 809118
	 
	
	$arr[] = array("id"=>$id, "Estoque"=>$Estoque, "Codigo"=>$Codigo, "id_prod"=>$id_prod, "id_pedido"=>$id_pedido, "idp"=>$idp,
						"id_venda"=>$id_venda, "referencia_prod"=>$referencia_prod, "descricao_prod"=>$descricao_prod, "prvenda"=>$prvenda,
						"qtd_produto"=>$qtd_produto, "idproduto"=>$idproduto, "qtd_imp"=>$qtd_imp, "impsn"=>$impsn, "fisico"=>$fisico);
	
	
	}
	
	
	echo '{"Itens":'.json_encode($arr).'}'; 

}

if($acao == 'listarItensVendas'){   //LEFT JOIN im_impressao im on im.idvenda = '$idVenda'
$pedido_id = $_POST['pedido_id'];						//LEFT JOIN im_impressao_itens iti on iti.id_impressao = im.idim_impressao

	$rs = mysql_query("SELECT p.id, p.Estoque,p.Codigo, v.desconto, ip.id_prod,ip.id_pedido,pd.id AS idp, iv.*, p.Estoque AS fisico
						FROM  pedido pd,  venda v, produtos p
						LEFT JOIN itens_pedido ip on ip.id_prod = p.id
						LEFT JOIN itens_venda iv on iv.idproduto = p.id
						WHERE ip.id_pedido = pd.id AND v.pedido_id = pd.id AND v.pedido_id = '$pedido_id' AND iv.id_venda = v.id
						GROUP BY iv.id  " ) or die (mysql_error());
	$arr = array();
	while($obj = mysql_fetch_array($rs, MYSQL_ASSOC)){
	//$arr[] = $obj;
	$id = $obj['id'];
	$Estoque = $obj['Estoque'];
	$Codigo = $obj['Codigo'];
	$id_prod = $obj['id_prod'];
	$id_pedido = $obj['id_pedido'];
	$idp = $obj['idp'];
	$desconto = $obj['desconto'];
	$id_venda = $obj['id_venda'];
	$referencia_prod = $obj['referencia_prod'];
	$descricao_prod = $obj['descricao_prod'];
	$prvenda = $obj['prvenda'];
	$qtd_produto = $obj['qtd_produto'];
	$idproduto = $obj['idproduto'];
	$qtd_imp = $obj['qtd_imp'];
	$impsn = $obj['impsn'];
	$fisico = $obj['fisico'];
	// 0981 809118
	 
	
	$arr[] = array("id"=>$id, "Estoque"=>$Estoque, "Codigo"=>$Codigo, "id_prod"=>$id_prod, "id_pedido"=>$id_pedido, "idp"=>$idp,
						"id_venda"=>$id_venda, "referencia_prod"=>$referencia_prod, "descricao_prod"=>$descricao_prod, "prvenda"=>$prvenda,
						"qtd_produto"=>$qtd_produto, "idproduto"=>$idproduto, "qtd_imp"=>$qtd_imp, "impsn"=>$impsn, "fisico"=>$fisico);
	
	
	}
	
	
	echo json_encode($arr); 

}
///////////////////////////////////////////////////////////////////////////////////////////////////
if($acao == 'Faturar'){
        
    $tipo_venda = $idForma;

    if($tipo_venda=='1')
            $st_venda = 'F';
    else if($tipo_venda >= '2')
            $st_venda = 'A';

      $vl_total = ajustaValor($subtotalFat);
      $forma_pgto_id = $idForma;

	$dados = $json->decode($_POST["data"]);
	
	for($i = 0; $i < count($dados); $i++){
	$impsn  = $dados[$i]->impsn;
	$qtd  = $dados[$i]->qtd_produto;
	$qtd_imp  = $dados[$i]->qtd_imp;
	if($qtd_imp > $qtd){
	echo "{success:true, response: 'Algunos itens ya facturados' }"; 
	exit();
	}
	if($qtd == 0){
	echo "{success:true, response: 'Itens con cantidad zero !!!' }"; 
	exit();
	}
	if($i > 22){
	echo "{success:true, response: 'El limite de itens es 22 !!!' }"; 
	exit();
	}
	}

	$sql = mysql_query("SELECT pedido_id,desconto FROM venda WHERE id = '$idVenda'");
	$reg = mysql_fetch_array($sql, MYSQL_ASSOC);
	$idPedido = $reg['pedido_id'];
	$desconto = $reg['desconto'];
	
	$sql_ins = "INSERT INTO im_impressao (id_venda,id_pedido,id_forma_pago,condicao,data_imp,situacao_imp,total_imp,desconto,nform)
								   VALUES( '$idVenda', '$idPedido', '$idForma', '$condicao', NOW(), '1', '$total', '$desconto', '$nform') ";
	$exe_ins = mysql_query($sql_ins) or die (mysql_error().'-'.$sql_ins);
    
	$idImp = mysql_insert_id();
	
 for($i = 0; $i < count($dados); $i++){
	
	$idprod  = $dados[$i]->idproduto;
	$iditen  = $dados[$i]->id;
	$ref = $dados[$i]->Codigo;
	$desc  = $dados[$i]->desc_prod;
	$prvenda  = $dados[$i]->pr_venda;
	$qtd  = $dados[$i]->qtd_produto;
	$id_venda = $dados[$i]->id_venda;
	$prvenda = number_format($prvenda,0,".","");
	$prvenda = ajustaValor($prvenda);

	$total += ($prvenda * $qtd);
	$total = ajustaValor($total);  
	
	$sql_esp = "SELECT Descricaoes FROM produtos WHERE id = '$idprod' ";
	$sql_exe = mysql_query($sql_esp);
	$sql_reg = mysql_fetch_array($sql_exe, MYSQL_ASSOC);
	$descesp = $sql_reg['Descricaoes'];
	
	$sql_ins = "INSERT INTO im_impressao_itens (im_ref,im_desc,im_prvenda,im_qtd,id_impressao,idproduto,idvenda,idpedido)
											VALUES('$ref', '$descesp', '$prvenda', '$qtd', '$idImp', '$idprod','$idVenda', '$idPedido')";
	$exe_ins = mysql_query($sql_ins)or die (mysql_error().'-'.$sql_ins);
	
	$sql_qtd1 = "UPDATE estoque SET  Estoque = Estoque - '$qtd' WHERE id = '$idprod'  ";
	//	$exe_qtd1 = mysql_query($sql_qtd1, $base) or die (mysql_error());
		
	$sql_venda = "UPDATE venda SET imp = '1', num_form = '$nform' WHERE id = '$idVenda'  ";
	//	$exe_venda = mysql_query($sql_venda, $base) or die (mysql_error());
	
	$sql_itvenda = "UPDATE itens_venda SET qtd_imp = '$qtd' WHERE idproduto = '$idprod' AND id_venda = '$id_venda' ";
		$exe_itvenda = mysql_query($sql_itvenda) or die (mysql_error());
		
	}  
	header("Location: ../factura.php?id_pedido=".$idImp);
    echo "{success:true, response: 'Enviado com Sucesso' }"; 
    
}

///////////////////////////////////////////////////////////////////////////////////////////////////
if($acao == 'TrocaNome'){
        
$idVendaFat = $_POST['idVendaFat'];
$nomeCliente = $_POST['nomeCliente'];
$enderecoCliente = $_POST['enderecoCliente'];
$rucCliente = $_POST['rucCliente'];

	$sqlp = mysql_query("SELECT pedido_id,valor_venda,desconto FROM venda WHERE id = '$idVendaFat' ");
	$regp = mysql_fetch_array($sqlp, MYSQL_ASSOC);
	$idpedido = $regp['pedido_id'];
	$desconto = $regp['desconto'];
	$totalVenda = $regp['valor_venda'];
	
	$sql = "SELECT e.controle,e.ruc,e.nome FROM entidades e WHERE e.ruc = '$rucCliente' ";
	$exe = mysql_query($sql);
	$rows = mysql_num_rows($exe);
	$reg = mysql_fetch_array($exe, MYSQL_ASSOC);
	
	$nome = $reg['nome'];
	$ruc = $reg['ruc'];
	$controle = $reg['controle'];
	
	function cadastraCli($nomeCliente,$rucCliente,$enderecoCliente,$desconto){
		$sqlins = "INSERT INTO entidades (nome,ruc,data,razao_social,endereco)
									VALUES('$nomeCliente', '$rucCliente', NOW(), '$nomeCliente', '$enderecoCliente' ) ";
		$exeins = mysql_query($sqlins);
		global $controle;
		$controle = mysql_insert_id();
		
			updateCli($controle,$nome,$idpedido,$idVendaFat);
	}
	
	function updateCli($controle,$nome,$idpedido,$idVendaFat){
		$sqlup = "UPDATE pedido SET controle_cli = '$controle', nome_cli = '$nome' WHERE id = '$idpedido' ";
		$exeup = mysql_query($sqlup);
		$sqluv = "UPDATE venda SET controle_cli = '$controle' WHERE id = '$idVendaFat' ";
		$exeuv = mysql_query($sqluv);
	}
	
	if($rows == 0){
		cadastraCli($nomeCliente,$rucCliente,$enderecoCliente,$desconto);	
		
		$arr[] = array("idVenda"=>$idVendaFat, "CodCli"=>$controle, "nome"=>$nomeCliente, "endereco"=>$enderecoCliente, "totalitens"=>$totalVenda, "desconto"=>$desconto);
		echo '{"results":'.json_encode($arr).'}'; 
	}
	
	if($rows > 0){
		updateCli($controle,$nome,$idpedido,$idVendaFat);
		
		$arr[] = array("idVenda"=>$idVendaFat, "CodCli"=>$controle, "nome"=>$nome, "endereco"=>$enderecoCliente, "totalitens"=>$totalVenda, "desconto"=>$desconto);
		echo '{"results":'.json_encode($arr).'}'; 
	}
	
	
	
}


?>