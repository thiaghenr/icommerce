<?php
require_once("biblioteca.php");
include "config.php";
conexao();
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');
//incluindo o arquivo do fpdf
require_once("fpdf17/fpdf.php");

$id_pedido = $_GET['id_pedido'];

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf17/font/');


		$sql_listaw = "SELECT * FROM pedido WHERE id = '".$_GET['id_pedido']."' ";
		$exe_listaw = mysql_query($sql_listaw, $base) ; //or die (mysql_error()." - $sql_listaw");
	
			$reg_listaw = mysql_fetch_array($exe_listaw, MYSQL_ASSOC);
			$total_carrinho += ($reg_listaw['prvenda']*$reg_listaw['qtd_produto']);



class PDF extends FPDF
{

// sobrep�e o m�todo header
function Header()
{

$this->SetY("52");
$this->SetX("18");

//escreve o texto
//uso: Cell(largura, altura, conteudo, borda, quebra de linha, alinhamento (L = esquerdo, R = direito, C = centralizado)
//$this->SetY(12);
$this->SetFont('arial','b',24);

}
function Footer() {

//Vai para 1.5 cm da parte inferior

//$this->$pdf->Cell(172,0,guarani($total_carrinho),1,1,'L');
}

}

//instancia a classe.. P=Retrato, mm =tipo de medida utilizada no casso milimetros, tipo de folha =A4
//$pdf= new PDF("P","mm",array(215,230));
//$pdf= new PDF("P","mm",array(260,270));
$pdf= new PDF("P","mm","A4");
$pdf -> SetMargins(-1, 0, 0);

//define a fonte a ser usada
$pdf->SetFont('courier','b',12);

$sql_listaw = "SELECT im.*, e.nome,e.controle,e.ruc, v.pedido_id, e.endereco
		FROM entidades e, im_impressao im, venda v 
		WHERE idim_impressao = '".$_GET['id_pedido']."' AND e.controle = v.controle_cli AND im.id_venda = v.id ";
		$exe_listaw = mysql_query($sql_listaw, $base);// or die (mysql_error()." - $sql_listaw");
		$reg_listaw = mysql_fetch_array($exe_listaw, MYSQL_ASSOC);
		
		$idimp = $reg_listaw['idim_impressao'];
		$nome = $reg_listaw['nome'];
		$codigo = $reg_listaw['controle'];
		$endereco = $reg_listaw['endereco'];
		$ruc = $reg_listaw['ruc'];
		$forma = $reg_listaw['id_forma_pago'];
			if($forma > "1"){
				$tam = 152;
			}
			else{
				$tam = 129;  //diferenca 23
			}
			$forma = "X";

$pdf->SetY(-1);
//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
//$pdf->SetFont('courier','',12,'b');
$pdf->Ln(25);  //42
$pdf->Cell(50,5,'',0,0,'L');
$pdf->Cell($tam,5,date("d/m/Y"),0,0,'L');
$pdf->Cell(10,5,$forma,0,1,'L');
$pdf->Ln(2);
$pdf->Cell(48,5,'',0,0,'L');
$pdf->Cell(115,5,$nome,0,0,'L');
$pdf->Cell(62,8,$ruc,0,1,'L');
$pdf->Cell(38,6,'',0,0,'L');
$pdf->Cell(60,6,$endereco,0,1,'L');
$pdf->Ln(6);
$pdf->Ln(6);
$pdf->SetY(86);  // padrao 86
//$pdf->SetX(3);

	$rs = mysql_query("SELECT * FROM im_impressao_itens WHERE id_impressao = '$idimp' ") or die (mysql_error());
	$arr = array();
	while($obj = mysql_fetch_array($rs, MYSQL_ASSOC)){

	$qtd = $obj['im_qtd'];
	$cod = $obj['im_ref'];
	$desc = $obj['im_desc'];
	$prvenda = $obj['im_prvenda'];
	
	$totalnota += $qtd * $prvenda;
	$iva = $totalnota / 11;

$pdf->SetFont('courier','b',10);
$pdf->Cell(21,4,$qtd,0,0,'R');
$pdf->Cell(24,4,substr($cod,0,10),0,0,'R');
$pdf->Cell(110,4,substr($desc,0,51),0,0,'L');
$pdf->Cell(23,4,number_format($prvenda,0,".","."),0,0,'R');
//$pdf->Cell(59,4,number_format($prvenda*$qtd,0,".","."),0,1,'R');
$pdf->Cell(28,4,number_format($prvenda*$qtd,0,".",""),0,1,'R');

}

$pdf->SetY(185); // 189
$pdf->Cell(206,4,number_format($totalnota,0,".","."),0,1,'R');	
$pdf->SetY(186);
$pdf->SetFont('courier','b',9);
$pdf->Cell(32,5,'',0,0,'L');
$pdf->Cell(88,3,extensoguarani($totalnota,2,".","."),0,1,'L');	
$pdf->Ln(4);
$pdf->Cell(105,5,'',0,0,'L');
$pdf->Cell(60,3,number_format($iva,0,".","."),0,0,'L');
$pdf->Cell(40,3,number_format($iva,0,".","."),0,1,'L');	
$pdf->SetFont('arial','i',11);
//$pdf->Cell(183,6,"VALPAR IMPORTACIONES",0,0,'R');

$randval = mt_rand();
$name_file = $_SERVER['REMOTE_ADDR']."_".microtime()."".$randval.".pdf";
$name_file = str_replace(" ","",$name_file);

$pdf->Output('facturas/'.$name_file);	
exec("lpr -P facturapdf facturas/$name_file");
echo "{success:true, response: 'Enviado com Sucesso' }"; 

?>