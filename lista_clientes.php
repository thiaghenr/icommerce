<?php
require_once("biblioteca.php");
include "config.php";
conexao();

//incluindo o arquivo do fpdf
require_once("fpdf17/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf17/font/');

class PDF extends FPDF
{

// sobrepõe o método header
function Header()
{


//escreve o texto
//uso: Cell(largura, altura, conteudo, borda, quebra de linha, alinhamento (L = esquerdo, R = direito, C = centralizado)
//$this->SetY(12);
$this->Cell(172,0,'',1,1,'L');
$this->SetFont('arial','',14);
$this->Ln(1);
$this->Cell(0,5,"HPA",0,1,'C');
$this->Ln(4);
$this->Cell(172,0,'',1,1,'L');

$this->SetFont('arial','',9);
$this->Cell(0,5,"LISTADO DE ENTIDADES",0,1,'C');
$this->Ln(8);
$this->SetY("30");
$this->SetX("20");
$this->Cell(172,0,'',1,1,'L');
$this->Cell(12,3,"Item",0,0,'L');
$this->Cell(20,3,"Codigo",0,0,'L');
$this->Cell(80,3,"Nombre",0,0,'L');
$this->Cell(20,3,"Ruc",0,0,'R');
$this->Cell(20,3,"Ativo",0,1,'R');
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

/*
	$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
 */      
    $sql = "SELECT controle,nome,ruc,ativo FROM entidades ORDER BY nome ASC ";
    $rs = mysql_query($sql) or die (mysql_error());
	
	$num_prod = mysql_num_rows($rs);
	$i = 1;
			while ($reg_lista = mysql_fetch_array($rs, MYSQL_ASSOC)) {
			
	//$i++;
	
		//if($i%2){
  		//$pdf->SetFillColor(240,100,100);
	//	}
		//else { 
		// $pdf->SetFillColor(255,0,0);
	//	}
//$pdf->Cell(15,4,$reg_lista['Codigo'],0,0,'L',$i);
$pdf->Cell(12,4,$i++,0,0,'L');
$pdf->Cell(20,4,$reg_lista['controle'],0,0,'L');
$pdf->Cell(80,4,$reg_lista['nome'],0,0,'L');
$pdf->Cell(20,4,($reg_lista['ruc']),0,0,'R');
$pdf->Cell(20,4,($reg_lista['ativo']),0,1,'R');
$pdf->Cell(172,0,'',1,1,'L');

//$i++;
}



$pdf->Output();	

?>