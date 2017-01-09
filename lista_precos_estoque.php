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
$this->Cell(0,5,"PRODUTOS EM ESTOQUE",0,1,'C');
$this->Ln(8);
$this->SetY("30");
$this->SetX("20");
$this->Cell(172,0,'',1,1,'L');
$this->Cell(12,3,"Item",0,0,'L');
$this->Cell(20,3,"Codigo",0,0,'L');
$this->Cell(43,3,"Descricao",0,0,'L');
$this->Cell(17,3,"Qtd",0,0,'R');
$this->Cell(17,3,"Custo",0,0,'R');
$this->Cell(17,3,"T.Custo",0,0,'R');
$this->Cell(17,3,"Valor",0,0,'R');
$this->Cell(17,3,"T.Valor",0,1,'R');
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

//hora do conteudo do artigo
$pdf->SetFont('arial','',7);

	$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
       
    $sql = "SELECT * FROM produtos WHERE Estoque >= 1 ORDER BY Codigo ASC ";
    $rs = mysql_query($sql) or die (mysql_error());
	
	$num_prod = mysql_num_rows($rs);
	$i = 1;
			while ($reg_lista = mysql_fetch_array($rs, MYSQL_ASSOC)){ 
			
			$total_carrinho += ($reg_lista['custo']*$reg_lista['Estoque']);
			
			$total_custo += $reg_lista['custo'] * $reg_lista['Estoque'];
			$total_preco += $reg_lista['valor_a'] * $reg_lista['Estoque'];
	//$i++;
	
		//if($i%2){
  		//$pdf->SetFillColor(240,100,100);
	//	}
		//else { 
		// $pdf->SetFillColor(255,0,0);
	//	}
//$pdf->Cell(15,4,$reg_lista['Codigo'],0,0,'L',$i);
$pdf->Cell(12,4,$i++,0,0,'L');
$pdf->Cell(20,4,$reg_lista['Codigo'],0,0,'L');
$pdf->Cell(43,4,substr($reg_lista['Descricao'],0,33),0,0,'L');
$pdf->Cell(17,4,$reg_lista['Estoque'],0,0,'R');
$pdf->Cell(17,4,$reg_lista['custo'],0,0,'R');
$pdf->Cell(17,4,number_format($reg_lista['Estoque']*$reg_lista['custo'],2,",","."),0,0,'R');
$pdf->Cell(17,4,$reg_lista['valor_a'],0,0,'R');
$pdf->Cell(17,4,number_format($reg_lista['valor_a']*$reg_lista['Estoque'],2,",","."),0,1,'R');
$pdf->Cell(172,0,'',1,1,'L');

//$i++;
}
$pdf->Ln(5);
$pdf->SetFont('arial','b',9);
$pdf->Cell(172,5,"TOTAL GENERAL",1,0,'C');
$pdf->Ln(1);
$pdf->Cell(148,4,number_format($total_custo,2,",","."),0,0,'R');
$pdf->Cell(22,4,number_format($total_preco,2,",","."),0,1,'R');


$pdf->Output();	

?>