<?
	require_once ("config.php");
	require_once("verifica_login.php");
    require_once("biblioteca.php");
	conexao();
	$prod_id = $_POST['id_prod'];
	$cli = $_POST['cli'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>


<style type="text/css">

	.coluna{
	font-size:11px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	}
	
	.linha{
	background-color: #CDDEF3;
	font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold;
	}
	#geral{
	border:1px solid;
	border-color:#0099FF;
	width:992px;
	height:400px;
	}
	#col_menor{
	width:190px;
	font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	background-color: #CDDEF3;
	margin-right:5px;
	float:left;
	}
	#col_menor_php{
	width:190px;
	height:18px;
	font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;
	float:left;
	margin-right:5px;
	}
	
	#col_maior{
	width:276px;
	font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	background-color: #CDDEF3;
	float:left;
	margin-right:5px;
	}
	#col_maior_php{
	width:276px;
	height:18px;
	font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;
	float:left;
	margin-right:5px;
	}
	
	#imagem{
	width:305px;
	margin-left: 5px;
	font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold;
	background-color: #CDDEF3;
	float:left;
	}
	#imagem_php{
	border:1px solid;
	border-color:#0099FF;
	width:305px;
	height:127px;
	float:right;
	margin-right: 8px;
	}
	
</style>
<script language="javascript">
function mostra(idn){
var url = 'vis_pedido.php';
var pars = 'ide=' + idn;
var myAjax = new Ajax.Updater(
'pedido',
url,
{
method: 'get',
parameters: pars
});
document.getElementById("ext-gen26").focus();	
}

function mostrac(idn){
var url = 'vis_cotizacion.php';
var pars = 'ide=' + idn;
var myAjax = new Ajax.Updater(
'pedido',
url,
{
method: 'get',
parameters: pars
});
document.getElementById("ext-gen26").focus();	
}
</script>
<body>
<?
	
	 $sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 3 AND moeda.id = 3 GROUP BY cm.id DESC limit 0,1 ";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
			
	$sql_prod= "SELECT * FROM produtos WHERE id = '".$prod_id."' ";
	$rs_prod = mysql_query($sql_prod);
	$linha_prod = mysql_fetch_array($rs_prod, MYSQL_ASSOC);
	
	if(empty($linha_prod['imagem'])){ $linha_prod['imagem'] = "fotos/ndisp.jpg"; }
	
	$sql_prodm= "SELECT * FROM marcas WHERE id = '".$linha_prod['marca']."' ";
	$rs_prodm = mysql_query($sql_prodm);
	$linha_prodm = mysql_fetch_array($rs_prodm, MYSQL_ASSOC);
	
	$sql_prodg= "SELECT * FROM grupos WHERE id = '".$linha_prod['grupo']."' ";
	$rs_prodg = mysql_query($sql_prodg);
	$linha_prodg = mysql_fetch_array($rs_prodg, MYSQL_ASSOC);
?>

<div id="geral">
<div id="col_menor">Codigo</div>
<div id="col_maior">Descricao</div>
<div id="col_menor">Codigo Original</div>
<div id="imagem"><div align="center">Imagem</div></div>
<div id="col_menor_php"><?=$linha_prod['Codigo']?></div>
<div id="col_maior_php"><?=substr($linha_prod['Descricao'],0,35)?></div>
<div id="col_menor_php"><?=$linha_prod['cod_original']?></div>
<div id="imagem_php"> <div align="center"><img src="<?=$linha_prod['imagem']?>" width="130" height="123"/></div></div>
<div id="col_menor">Marca</div>
<div id="col_maior">Codigo Fabricante 1</div>
<div id="col_menor">Codigo Original 2</div>
<div id="col_menor_php"><?=$linha_prodm['nom_marca']?></div>
<div id="col_maior_php"><?=$linha_prod['Codigo_Fabricante']?></div>
<div id="col_menor_php"><?=$linha_prod['cod_original2']?></div>
<div id="col_menor">Grupo</div>
<div id="col_maior">Codigo Fabricante 2</div>
<div id="col_menor">Codigo Fabricante 3</div>
<div id="col_menor_php"><?=$linha_prodg['nom_grupo']?></div>
<div id="col_maior_php"><?=$linha_prod['Codigo_Fabricante2']?></div>
<div id="col_menor_php"><?=$linha_prod['Codigo_Fabricante3']?></div>

<?php
	
	
	echo $conteudo;
	
	echo "<style>";
	echo  ".coluna{font-size:11px;  font-family:Verdana, Arial, Helvetica, sans-serif;}";
	echo  ".linha{background-color: #CDDEF3; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold}";
	echo "</style>";

$conteudo = "<table width='100%' style='border: 1px solid #C6D9F1'>";
  $conteudo.="<tr>";
    $conteudo.="<td width='48%' height='58'><table width='97%' border='1'>";
      $conteudo.="<tr class='linha'>";
        $conteudo.="<td width='11%'>Pedido</td>";
        $conteudo.="<td width='13%'>Cod.</td>";
        $conteudo.="<td width='36%'>Cliente</td>";
        $conteudo.="<td width='20%'>Data</td>";
        $conteudo.="<td width='20%'>Valor</td>";
      $conteudo.="</tr>";
	  
	  $sqlx = "SELECT ic.*, c.*, cl.* FROM itens_pedido ic, pedido c, clientes cl  WHERE ic.referencia_prod = '".$linha_prod['Codigo']."' AND ic.id_pedido = c.id AND cl.controle = c.controle_cli AND cl.controle = '$cli' GROUP BY  c.id order by cl.controle DESC  limit 0,01 ";
	$rsx = mysql_query($sqlx) or die(mysql_error().''. $sqlx);
	
	$linhax = mysql_fetch_array($rsx, MYSQL_ASSOC);
	 		$id = $linhax['id'];
			//Pegando data e hora.
			$data10 = $linhax['data_car'];
			$hora10 = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata11 = substr($data10,8,2) . "/" .substr($data10,5,2) . "/" . substr($data10,0,4);
			$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
			
	$conteudo.="<tr>";
       $conteudo.="<td class='coluna'>&nbsp;<a href='javascript:void(0);'  onclick=mostra($id); >".$linhax['id']."</a></td>";
        $conteudo.="<td class='coluna'>&nbsp;".$linhax['controle_cli']."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".substr($linhax['nome_cli'],0,20)."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".$novadata11."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".number_format($linhax['prvenda'],2,",",".")."</td>";
      $conteudo.="</tr>";
	  

      $sql = "SELECT ic.*, c.*, cl.* FROM itens_pedido ic, pedido c, clientes cl  WHERE ic.referencia_prod = '".$linha_prod['Codigo']."' AND ic.id_pedido = c.id AND cl.controle = c.controle_cli ORDER BY  c.id DESC  limit 0,07 ";
	$rs = mysql_query($sql) or die(mysql_error().''. $sql);
	$num_prod = mysql_num_rows($rs);
	
	while ($linha = mysql_fetch_array($rs, MYSQL_ASSOC)){
	 		$id = $linha['id'];
			//Pegando data e hora.
			$data4 = $linha['data_car'];
			$hora4 = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata5 = substr($data4,8,2) . "/" .substr($data4,5,2) . "/" . substr($data4,0,4);
			$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
      
      $conteudo.="<tr>";
         $conteudo.="<td class='coluna'>&nbsp;<a href='javascript:void(0);'  onclick=mostra($id); >".$linha['id']."</a></td>";
        $conteudo.="<td class='coluna'>&nbsp;".$linha['controle_cli']."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".substr($linha['nome_cli'],0,20)."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".$novadata5."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".number_format($linha['prvenda'],2,",",".")."</td>";
      $conteudo.="</tr>";
     
	  }
	  
      
    $conteudo.="</table></td>";
    $conteudo.="<td width='48%'><table width='98%' border='1'>";
      $conteudo.="<tr class='linha'>";
        $conteudo.="<td width='13%'>Cotacao</td>";
        $conteudo.="<td width='9%'>Cod.</td>";
        $conteudo.="<td width='38%'>Cliente</td>";
        $conteudo.="<td width='20%'>Data</td>";
        $conteudo.="<td width='20%'>Valor</td>";
      $conteudo.="</tr>";


		$sqlcs = "SELECT icc.*, cc.*, cll.* FROM itens_cotacao icc, cotacao cc, clientes cll  WHERE icc.referencia_prod = '".$linha_prod['Codigo']."' AND icc.id_cotacao = cc.id AND cll.controle = cc.controle_cli AND cc.controle_cli = '$cli' group by cc.id limit 0,01";
	$rscs = mysql_query($sqlcs) or die(mysql_error().''. $sqlcs);
	
	$linhacs = mysql_fetch_array($rscs, MYSQL_ASSOC);
			$idc = $linhacs['id'];
			//Pegando data e hora.
			$data7 = $linhacs['data_car'];
			$hora7 = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata8 = substr($data7,8,2) . "/" .substr($data7,5,2) . "/" . substr($data7,0,4);
			$novahora8 = substr($hora7,0,2) . "h" .substr($hora7,3,2) . "min";
			
	$conteudo.="<tr>";
        $conteudo.="<td class='coluna'>&nbsp;<a href='javascript:void(0);'  onclick=mostrac($idc); >".$linhacs['id']."</a></td>";
        $conteudo.="<td class='coluna'>&nbsp;".$linhacs['controle_cli']."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".substr($linhacs['nome_cli'],0,20)."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".$novadata8."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".number_format($linhacs['prvenda'],2,",",".")."</td>";
	$conteudo.="</tr>";		
	
		$sqlc = "SELECT icc.*, cc.*, cll.* FROM itens_cotacao icc, cotacao cc, clientes cll  WHERE icc.referencia_prod = '".$linha_prod['Codigo']."' AND icc.id_cotacao = cc.id AND cll.controle = cc.controle_cli group BY cc.id order by cc.id DESC limit 0,07";
	$rsc = mysql_query($sqlc) or die(mysql_error().''. $sqlc);
	$num_prodc = mysql_num_rows($rsc);
	
	
	while ($linhac = mysql_fetch_array($rsc, MYSQL_ASSOC)){
	 		$idc = $linhac['id'];
			//Pegando data e hora.
			$data6 = $linhac['data_car'];
			$hora6 = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata7 = substr($data6,8,2) . "/" .substr($data6,5,2) . "/" . substr($data6,0,4);
			$novahora7 = substr($hora6,0,2) . "h" .substr($hora6,3,2) . "min";		

     
	$conteudo.="<tr>";
		$conteudo.="<td class='coluna'>&nbsp;<a href='javascript:void(0);'  onclick=mostrac($idc); >".$linhac['id']."</a></td>";
        $conteudo.="<td class='coluna'>&nbsp;".$linhac['controle_cli']."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".substr($linhac['nome_cli'],0,20)."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".$novadata7."</td>";
        $conteudo.="<td class='coluna'>&nbsp;".number_format($linhac['prvenda'],2,",",".")."</td>";
      $conteudo.="</tr>";

}
      
      
    $conteudo.="</table></td>";
  $conteudo.="</tr>";
$conteudo.="</table>";

echo $conteudo;
	
	
?>
</body>
</html>