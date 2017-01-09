<?php
require_once("biblioteca.php");
include "config.php";
conexao();
header("Content-Type: text/html; charset=iso-8859-1");

$_SESSION['grupo'] = $_GET['grupo'];

//incluindo o arquivo do fpdf
require_once("fpdf17/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf17/font/');

 	$sql = "SELECT * FROM grupos WHERE id = '".$_GET['grupo']."' ";
    $rs = mysql_query($sql) or die (mysql_error());
	$reg_lista = mysql_fetch_array($rs, MYSQL_ASSOC); 
	
	$_SESSION['nome_grupo'] = $reg_lista['nom_grupo'];



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
$this->Cell(0,5,"WINGS",0,1,'C');
$this->Ln(4);
$this->Cell(172,0,'',1,1,'L');

$this->SetFont('arial','',9);
$this->Cell(13,5,"Grupo:",0,0,'L');
$this->Cell(0,5,$_SESSION['nome_grupo'],0,1,'L');
$this->Ln(8);
$this->SetY("30");
$this->SetX("20");
//$this->Cell(172,0,'',1,1,'L');
$this->Cell(12,3,"Iten",0,0,'L');
$this->Cell(30,3,"Codigo",0,0,'L');
$this->Cell(88,3,"Descripcion",0,0,'L');
$this->Cell(12,3,"Cant",0,0,'L');
$this->Cell(20,3,"Valor",0,1,'R');
$this->Cell(172,0,'',1,1,'L');
$this->Ln(1);

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
$titulo="Lista de Precos";

//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
//$pdf->Cell(0,5,$titulo,0,0,'L');
//$pdf->Cell(0,0,'',0,1,'R');
//$pdf->Ln(8);

//hora do conteudo do artigo
$pdf->SetFont('arial','',7);

//posiciona verticalmente 21mm
//$pdf->SetY("21");
//posiciona horizontalmente 30mm
//$pdf->SetX("10");

//escreve o conteudo de novo.. parametros posicao inicial,altura,conteudo(*texto),borda,quebra de linha,alinhamento
//$pdf->SetY("5");
//$pdf->SetX("10");
//$pdf->Cell(15,3,"Codigo",1,0,'L');
//$pdf->Cell(110,3,"Descricao",1,0,'L');
//$pdf->Cell(15,3,"Preco",1,1,'R');
//$pdf->Ln(1);


    $sql = "SELECT g.*, p.id,Codigo,Descricao,Estoque,grupo,valor_a 
	FROM produtos p, grupos g WHERE p.grupo = g.id AND g.id = '".$_SESSION['grupo']."' ORDER BY p.Codigo ASC ";
    $rs = mysql_query($sql) or die (mysql_error());
	
	$num_prod = mysql_num_rows($rs);
	$i = 1;
			while ($reg_lista = mysql_fetch_array($rs, MYSQL_ASSOC)) {
			
			$total_custo += $reg_lista['custo'] * $reg_lista['Estoque'];
			
	
$pdf->Cell(12,4,$i++,0,0,'L');
$pdf->Cell(30,4,$reg_lista['Codigo'],0,0,'L');
$pdf->Cell(88,4,$reg_lista['Descricao'],0,0,'L');
$pdf->Cell(12,4,$reg_lista['Estoque'],0,0,'L');
$pdf->Cell(20,4,number_format($reg_lista['valor_a'],2,",","."),0,1,'R');
//$pdf->Cell(172,0,'',1,1,'L');
//$i++;
}
$pdf->Ln(5);
$pdf->SetFont('arial','b',9);




$pdf->Output();	

?>
