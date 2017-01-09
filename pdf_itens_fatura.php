<?php
require_once("biblioteca.php");
include "config.php";
conexao();
header("Content-Type: text/html; charset=iso-8859-1");


$id = $_GET['id_pedido'];
$_SESSION['impressao'] = $_GET['id_pedido'];

//incluindo o arquivo do fpdf
require_once("fpdf16/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf/font/');

 	$sql = "SELECT * FROM im_impressao WHERE id_venda = '$id' ";
    $rs = mysql_query($sql) or die (mysql_error());
	$reg_lista = mysql_fetch_array($rs, MYSQL_ASSOC); 
	
	$_SESSION['impressao'] = $reg_lista['id_venda'];
	$_SESSION['id_pedido'] = $reg_lista['id_pedido'];
    


class PDF extends FPDF
{

// sobrepõe o método header
function Header()
{

//escreve o texto
//uso: Cell(largura, altura, conteudo, borda, quebra de linha, alinhamento (L = esquerdo, R = direito, C = centralizado)
//$this->SetY(12);
//$this->Cell(172,0,'',1,1,'L');
$this->SetFont('arial','',14);
$this->Ln(1);
$this->Cell(0,5,"HPA SRL",0,1,'C');
$this->Ln(4);
$this->SetFont('arial','',9);
$this->Cell(172,4,'Relatorio: Itens Facturados del Pedido',0,1,'L');

$this->SetFont('arial','',9);
$this->Cell(13,5,"Pedido:",0,0,'L');
$this->Cell(13,5,$_SESSION['id_pedido'],0,1,'L');
$this->Cell(13,5,"Fecha:",0,0,'L');
$this->Cell(30,5,date("d-m-Y"),0,0,'L');

//$this->Ln(15);
$this->SetY("32");
$this->SetX("20");
$this->SetFont('arial','',8);
//$this->Cell(172,0,'',1,1,'L');
$this->Cell(30,4,"Codigo",0,0,'L');
$this->Cell(60,4,"Descripcion",0,0,'L');
$this->Cell(15,4,"Qtd",0,0,'R');
$this->Cell(30,4,"Valor",0,1,'R');
//$this->Cell(172,0,'',1,1,'L');
$this->Ln(3);

//$this->Cell(0,10,'Página '.$this->PageNo().' ',0,0,'C');
}
function Footer() {
//Vai para 1.5 cm da parte inferior

$this->SetY(-15);

//Seleciona a fonte Arial itálico 8

$this->SetFont('Arial','I',8);

//Imprime o número da página corrente e o total de páginas

$this->Cell(0,10,'Página '.$this->PageNo().' ',0,0,'C');

}

}

//instancia a classe.. P=Retrato, mm =tipo de medida utilizada no casso milimetros, tipo de folha =A4
$pdf= new PDF("P","mm","A4");
$pdf -> SetMargins(20, 5, 15);

//define a fonte a ser usada
$pdf->SetFont('arial','',9);

//define o titulo
$pdf->SetTitle("Testando PDF com PHP !");

//assunto
$pdf->SetSubject("assunto deste artigo!");

// posicao vertical no caso -1.. e o limite da margem
$pdf->SetY("-1");

//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
//$pdf->Cell(0,5,$titulo,0,0,'L');
//$pdf->Cell(0,0,'',0,1,'R');
//$pdf->Ln(8);

//hora do conteudo do artigo
$pdf->SetFont('courier','',7);

    $sql = "SELECT * FROM im_impressao_itens WHERE idvenda =  '".$_SESSION['impressao']."' ";
    $rs = mysql_query($sql) or die (mysql_error().'-'.$sql);
	
	$num_prod = mysql_num_rows($rs);
	while ($reg_lista = mysql_fetch_array($rs, MYSQL_ASSOC)) {
			
			
				
$pdf->Cell(30,4,$reg_lista['im_ref'],0,0,'L');
$pdf->Cell(60,4,$reg_lista['im_desc'],0,0,'L');
$pdf->Cell(15,4,$reg_lista['im_qtd'],0,0,'R');
$pdf->Cell(30,4,$reg_lista['im_prvenda'],0,1,'R');

//$pdf->Cell(172,0,'',1,1,'L');
//$i++;
}
$pdf->Ln(1);




$pdf->Output();	



?>