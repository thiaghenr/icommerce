<?
	require_once ("config.php");
	require_once("verifica_login.php");
    require_once("biblioteca.php");
	conexao();
	$prod_id = $_POST['id_prod'];
	
	
	echo "<style>";
	echo  ".coluna{font-size:11px;  font-family:Verdana, Arial, Helvetica, sans-serif;}";
	echo  ".linha{background-color: #CDDEF3; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold}";
	echo "</style>";
	
	 $sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 3 AND moeda.id = 3 GROUP BY cm.id DESC limit 0,1 ";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
			
	$sql_prod= "SELECT * FROM produtos WHERE id = '".$prod_id."' ";
	$rs_prod = mysql_query($sql_prod);
	$linha_prod = mysql_fetch_array($rs_prod, MYSQL_ASSOC);
	
	$sql_prodm= "SELECT * FROM marcas WHERE id = '".$linha_prod['marca']."' ";
	$rs_prodm = mysql_query($sql_prodm);
	$linha_prodm = mysql_fetch_array($rs_prodm, MYSQL_ASSOC);
	
	$conteudo = "<table width='100%'  style='border: 1px solid #C6D9F1'>";
	$conteudo.="<tr><td colspan='7' align='center'>Detalhes Produto</td></tr>";
	$conteudo.= "<tr class='linha'>";
	$conteudo.="<td>Codigo</td>";
	$conteudo.="<td colspan='6'>Descripcion</td>";
	$conteudo.="</tr>";

	$conteudo.="<tr>";
	$conteudo.="<td class='coluna'>&nbsp;".$linha_prod['Codigo']."</td>";
	$conteudo.="<td class='coluna'>&nbsp;".$linha_prod['Codigo']."</td>";
	$conteudo.="<td class='coluna' colspan='6'>&nbsp;".$linha_prod['Descricao']."</td>";
	$conteudo.="</tr>";
	
	$conteudo.="<tr class='linha'>";
	$conteudo.="<td>Marca</td>";
	$conteudo.="<td>Ultimo Custo</td>";
	$conteudo.="<td>Valor A</td>";
	$conteudo.="<td>Valor B</td>";
	$conteudo.="<td>%Margem C</td>";
	$conteudo.="<td>Codigo Fabricante</td>";
	$conteudo.="<td>Codigo Original</td>";
	$conteudo.="</tr>";
	
	$conteudo.="<tr>";
	$conteudo.="<td class='coluna'>&nbsp;".$linha_prodm['nom_marca']."</td>";
	if($perfil_id <= 2){
	$conteudo.="<td class='coluna'>&nbsp;".number_format($linha_prod['custo'],2,",",".")."</td>";
	$conteudo.="<td class='coluna'>&nbsp;".str_replace(",",".",number_format($linha_prod['valor_a']*$vl_cambio_guarani))."</td>";
	$conteudo.="<td class='coluna'>&nbsp;".str_replace(",",".",number_format($linha_prod['valor_b']*$vl_cambio_guarani))."</td>";
	$conteudo.="<td class='coluna'>&nbsp;".$linha_prod['margen_c']."</td>";
	}
	else {
	/*$conteudo.="<td  class='coluna'>&nbsp;".number_format($linha_prod['custo'],2,",",".")."</td>";
	$conteudo.="<td  class='coluna'>&nbsp;".$linha_prod['margen_a']."</td>";
	$conteudo.="<td  class='coluna'>&nbsp;".$linha_prod['margen_b']."</td>";
	$conteudo.="<td  class='coluna'>&nbsp;".$linha_prod['margen_c']."</td>";
	*/
	}
	$conteudo.="<td class='coluna'>&nbsp;".$linha_prod['Codigo_Fabricante']."</td>";
	$conteudo.="<td class='coluna'>&nbsp;".$linha_prod['cod_original']."</td>";
	$conteudo.="</tr>";		
	
	$conteudo.="</table>";		
	
	
	echo $conteudo;
	
	echo "<style>";
	echo  ".coluna{font-size:11px;  font-family:Verdana, Arial, Helvetica, sans-serif;}";
	echo  ".linha{background-color: #CDDEF3; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold}";
	echo "</style>";

$conteudo = "<table width='100%' style='border: 1px solid #C6D9F1'>";
  $conteudo.="<tr>";
    $conteudo.="<td width='48%' height='58'><table width='97%' border='1'>";
      $conteudo.="<tr class='linha'>";
        $conteudo.="<td width='11%'>Compra</td>";
        $conteudo.="<td width='13%'>Cod.</td>";
        $conteudo.="<td width='36%'>Forn.</td>";
        $conteudo.="<td width='20%'>Data</td>";
        $conteudo.="<td width='20%'>Custo</td>";
      $conteudo.="</tr>";

      $sql = "SELECT ic.id AS ide,ic.referencia_prod,ic.compra_id,ic.prcompra, c.*, p.controle AS ides,p.nome FROM itens_compra ic, compras c, entidades p  WHERE ic.referencia_prod = '".$linha_prod['Codigo']."' AND ic.compra_id = c.id_compra AND c.fornecedor_id = p.controle GROUP BY c.id_compra ORDER BY c.id_compra DESC limit 0,07 ";
	$rs = mysql_query($sql) or die(mysql_error().''. $sql);
//echo	$num_prod = mysql_num_rows($rs);
//echo 	$linha_prod['Codigo'];
	while ($linha = mysql_fetch_array($rs, MYSQL_ASSOC)){
	 
			//Pegando data e hora.
			$data4 = $linha['dt_emissao_fatura'];
			$hora4 = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata5 = substr($data4,8,2) . "/" .substr($data4,5,2) . "/" . substr($data4,0,4);
			$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";

      
      
      $conteudo.="<tr>";
        $conteudo.="<td class='coluna'>&nbsp;".$linha['id']."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".$linha['fornecedor_id']."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".substr($linha['nome'],0,20)."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".$novadata5."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".guarani($linha['prcompra'])."</td>";
      $conteudo.="</tr>";
     
	  }
	  
  /*    
    $conteudo.="</table></td>";
    $conteudo.="<td width='48%'><table width='98%' border='1'>";
      $conteudo.="<tr class='linha'>";
        $conteudo.="<td width='13%'>Cotacao</td>";
        $conteudo.="<td width='9%'>Cod.</td>";
        $conteudo.="<td width='38%'>Cliente</td>";
        $conteudo.="<td width='20%'>Data</td>";
        $conteudo.="<td width='20%'>Valor</td>";
      $conteudo.="</tr>";

	
		$sqlc = "SELECT icc.*, cc.* FROM itens_cotacao icc, cotacao cc  WHERE icc.referencia_prod = '".$linha_prod['Codigo']."' AND icc.id_cotacao = cc.id ORDER BY cc.id DESC limit 0,07";
	$rsc = mysql_query($sqlc) or die(mysql_error().''. $sqlc);
	$num_prodc = mysql_num_rows($rsc);
	
	while ($linhac = mysql_fetch_array($rsc, MYSQL_ASSOC)){
	 
			//Pegando data e hora.
			$data6 = $linhac['data_car'];
			$hora6 = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata7 = substr($data6,8,2) . "/" .substr($data6,5,2) . "/" . substr($data6,0,4);
			$novahora7 = substr($hora6,0,2) . "h" .substr($hora6,3,2) . "min";		

      $conteudo.="<tr>";
        $conteudo.="<td class='coluna'>&nbsp;".$linhac['id']."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".$linhac['controle_cli']."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".substr($linhac['nome_cli'],0,20)."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".$novadata7."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".guarani($linhac['prvenda'])."</td>";
      $conteudo.="</tr>";

}

      
      
    $conteudo.="</table></td>"; */
  $conteudo.="</tr>";
$conteudo.="</table>";

echo $conteudo;
	
	
?>