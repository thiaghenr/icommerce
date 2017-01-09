<?php
require_once("biblioteca.php");
include "config.php";
conexao();

//incluindo o arquivo do fpdf
require_once("fpdf17/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf17/font/');


		$sql_listaw = "SELECT * FROM pedido WHERE id = '".$_GET['id_pedido']."' ";
		$exe_listaw = mysql_query($sql_listaw, $base) ; //or die (mysql_error()." - $sql_listaw");
	
			$reg_listaw = mysql_fetch_array($exe_listaw, MYSQL_ASSOC);
			$total_carrinho += ($reg_listaw['prvenda']*$reg_listaw['qtd_produto']);



class PDF extends FPDF
{

// sobrepõe o método header
function Header()
{


//escreve o texto
//uso: Cell(largura, altura, conteudo, borda, quebra de linha, alinhamento (L = esquerdo, R = direito, C = centralizado)
//$this->SetY(12);
$this->SetFont('arial','b',18);
$this->Ln(1);
$this->Cell(0,5,"WINGS",0,1,'C');
$this->Ln(4);
/*
$this->SetFont('arial','',9);
$this->Ln(8);
$this->SetY("30");
$this->SetX("20");
$this->Cell(172,0,'',1,1,'L');
$this->Cell(12,3,"Item",0,0,'L');
$this->Cell(20,3,"Codigo",0,0,'L');
$this->Cell(120,3,"Descricao",0,0,'L');
$this->Cell(20,3,"Preco",0,1,'R');
$this->Cell(172,0,'',1,1,'L');
$this->Ln(1);
*/
//$this->Cell(0,10,'Página '.$this->PageNo().' ',0,0,'C');
}
function Footer() {

//Vai para 1.5 cm da parte inferior




//$this->SetY(-15);

//Seleciona a fonte Arial itálico 8

//$this->SetFont('Arial','b',12);

//Imprime o número da página corrente e o total de páginas

//$this->Cell(0,10,'Página '.$this->PageNo().' ',0,0,'C');




//$this->$pdf->Cell(172,0,guarani($total_carrinho),1,1,'L');
}



}


//instancia a classe.. P=Retrato, mm =tipo de medida utilizada no casso milimetros, tipo de folha =A4
$pdf= new PDF("P","mm","A4");
$pdf -> SetMargins(17, 5, 12);

//define a fonte a ser usada
$pdf->SetFont('arial','b',12);
$pdf->SetFillColor(255 ,255, 255); 
$sql_lista = "SELECT ct.*, cl.endereco, cl.celular,nome FROM pedido ct, entidades cl WHERE ct.id = '".$_GET['id_pedido']."' AND ct.controle_cli = cl.controle ";

	$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error()." - $sql_lista");
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		//$total_carrinho = 0;
			$reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC);
			//$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			$ide3 = $reg_lista['controle_cli'];
			// Pegando data e hora.
			$data2 = $reg_lista['data_car'];
			$hora2 = $reg_lista['data_car'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";


$pdf->SetY("-1");

//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
//$pdf->SetFont('arial','',12,'b');
$pdf->Cell(10,5,"PEDIDO - Nº",0,0,'L');
$pdf->Cell(38,5,$reg_lista['id'],0,0,'R');
$pdf->Cell(103,5,"FECHA:",0,0,'R');
$pdf->Cell(30,5,$novadata,0,1,'R');
$pdf->Ln(2);
$pdf->Cell(25,5,"CLIENTE:",0,0,'L');
$pdf->Cell(48,5,$reg_lista['nome'],0,1,'L');
$pdf->Ln(6);

$pdf->SetFont('arial','b',14);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(183,8,"RELACION DEL PEDIDO",0,1,'C','1');
$pdf->SetTextColor(0);
$pdf->Ln(6);

$pdf->SetFont('arial','b',11);
//$pdf->Cell(150,0,'',1,1,'L');
$pdf->Cell(12,6,"CT",1,0,'L');
$pdf->Cell(25,6,"CODIGO",1,0,'C');
$pdf->Cell(93,6,"DESCRIPTION DEL PRODUTO",1,0,'C');
$pdf->Cell(23,6,"UNITARIO",1,0,'C');
$pdf->Cell(30,6,"TOTAL",1,0,'C');
//$pdf->Cell(150,0,'',1,1,'L');
$pdf->Ln(6);

$sql_list = "SELECT c.*, ic.*  FROM pedido c, itens_pedido ic WHERE c.id = '".$reg_lista['id']."' AND ic.id_pedido = '".$reg_lista['id']."' ORDER BY referencia_prod ASC";
	$exe_list = mysql_query($sql_list)  or die (mysql_error());
	
	while ($reg_list = mysql_fetch_array($exe_list, MYSQL_ASSOC)) {
			$total_carrinho += ($reg_list['prvenda']*$reg_list['qtd_produto']);
			
			$frete = $reg_list['frete'];
			$total_nota  = $reg_list['total_nota'];


//escreve o conteudo de novo.. parametros posicao inicial,altura,conteudo(*texto),borda,quebra de linha,alinhamento
//$pdf->SetY("5");

//$pdf->SetX("10");
//$pdf->Cell(15,3,"Codigo",1,0,'L');
$pdf->SetFont('arial','b',11);
$pdf->Cell(12,6,$reg_list['qtd_produto'],1,0,'L');
$pdf->Cell(25,6,substr($reg_list['referencia_prod'],0,10),1,0,'L');
$pdf->SetFont('arial','',11);
$pdf->Cell(93,6,substr($reg_list['descricao_prod'],0,35),1,0,'L');
$pdf->SetFont('arial','b',11);
$pdf->Cell(23,6,number_format($reg_list['prvenda'],2,",","."),1,0,'R');
$pdf->Cell(30,6,number_format($reg_list['prvenda']*$reg_list['qtd_produto'],2,",","."),1,1,'R');
//$pdf->Cell(15,3,"Preco",1,1,'R');
//$pdf->Ln(1);


		}
$pdf->SetY(250);
$pdf->Cell(130,6,"TOTAL ITENS",1,0,'C');		
$pdf->Cell(53,6,number_format($total_carrinho,2,",","."),1,1,'R');
$pdf->Cell(130,6,"TOTAL FRETE",1,0,'C');
$pdf->Cell(53,6,number_format($frete,2,",","."),1,1,'R');
$pdf->Cell(130,6,"TOTAL GENERAL",1,0,'C');	
$pdf->Cell(53,6,number_format($total_nota,2,",","."),1,1,'R');
$pdf->SetFont('arial','i',11);
$pdf->Cell(183,6,"WINGS",0,0,'R');




$pdf->Output();	

?>