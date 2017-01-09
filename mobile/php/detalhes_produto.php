<?
require_once ("../../config.php");
conexao();
require_once ("../../biblioteca.php");
$query = $_GET['query'];

$sql = "SELECT oi.id,oi.Codigo,oi.Descricao,oi.Estoque,oi.valor_a,m.nom_marca FROM produtos oi, marcas m
		WHERE oi.id = '$query' AND oi.marca = m.id";	
$r = mysql_query ($sql)or die(print_r(mysql_error()));
while ($reg = mysql_fetch_array($r, MYSQL_ASSOC)){

$codigo = $reg['Codigo'];
$descricao = $reg['Descricao'];
$imagem = "/imagens/produtos/".$reg['PicturName'];
$valor = number_format($reg['valor_a'],0,".","");
$qtd = $reg['Estoque'];
$marca = $reg['nom_marca'];
$pack = $reg['ValidComm'];
$Estoque = $reg['Estoque'];

if($imagem == "/imagens/produtos/"){
	$imagem = "/imagens/produtos/imgndisp.gif";
}

	echo "<style>";
	echo  ".coluna{font-size:11px;  font-family:Verdana, Arial, Helvetica, sans-serif;}";
	echo  ".linha{background-color: #006699; color: #ffffff; border:1px solid #888; -moz-border-radius:10px; -webkit-border-radius:10px; 
	border-radius:10px; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold}";
	echo  ".linhadep{background-color: #00C5CD; color: #FFFF00; border:1px solid #888; -moz-border-radius:10px; -webkit-border-radius:10px; 
	border-radius:10px; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold}";
	echo "</style>";

$conteudo = "<table width='100%' style='border: 1px solid #C6D9F1'>";
  $conteudo.="<tr width='11%'>";
    $conteudo.="<td width='48%' height='58'><table width='97%' border='1'>";
      $conteudo.="<tr class='linha'>";
        $conteudo.="<td width='11%'>Codigo:</td>";
		$conteudo.="<td width='20%'>".$codigo."</td>";
		$conteudo.="</tr>";
		$conteudo.="<tr class='linha'>";
        $conteudo.="<td width='13%'>Descripcion:</td>";
		$conteudo.="<td width='20%'>".$descricao."</td>";
		$conteudo.="</tr>";
		$conteudo.="<tr class='linha'>";
        $conteudo.="<td width='13%'>Marca:</td>";
		$conteudo.="<td width='20%'>".$marca."</td>";
		$conteudo.="</tr>";
		$conteudo.="<tr class='linha'>";
        $conteudo.="<td width='13%'>Pack:</td>";
		$conteudo.="<td width='20%'>".$pack."</td>";
		$conteudo.="</tr>";
		$conteudo.="<tr class='linha'>";
        $conteudo.="<td width='13%'>Estoque:</td>";
		$conteudo.="<td width='20%'>".$Estoque."</td>";
		$conteudo.="</tr>";
		$conteudo.="<tr class='linha'>";
        $conteudo.="<td width='13%'>Valor:</td>";
		$conteudo.="<td width='20%'>".guarani($valor)."</td>";
		$conteudo.="</tr>";
		
		$conteudo.="<tr class='linha'>";
        $conteudo.="<td width='13%'></td>";
		$conteudo.="<td width='20%'><img src=".$imagem." /></td>";
		$conteudo.="<tr class='linha'>";
        
		$conteudo.="</tr>";
	    $conteudo.="</tr>";
$conteudo.="</table>";
}
echo $conteudo;


?>