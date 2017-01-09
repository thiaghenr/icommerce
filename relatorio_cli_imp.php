<?php
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
//$nome = $nome_user;
$_SESSION['nome'] = $nome_user;
//incluindo o arquivo do fpdf
require_once("fpdf17/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf17/font/');

class PDF extends FPDF
{

// sobrepõe o método header
function Header()
{
$data = date("d-m-Y");
$nome = $_SESSION['nome'];

//echo $data;

//escreve o texto
//uso: Cell(largura, altura, conteudo, borda, quebra de linha, alinhamento (L = esquerdo, R = direito, C = centralizado)
//$this->SetY(12);
$this->Cell(172,0,'',1,1,'L');
$this->SetFont('arial','',14);
$this->Ln(3);
$this->Cell(0,5,"NELORE",0,1,'C');
$this->Ln(3);
$this->Cell(172,0,'',1,1,'L');
$this->Ln(2);
$this->SetFont('arial','',8);
$this->Cell(10,3,"Data:",0,0,'L');
$this->Cell(100,3,$data,0,1,'L');
$this->Cell(12,3,"Usuario:",0,0,'L');
$this->Cell(100,3,$nome,0,1,'L');
$this->Ln(1);
$this->SetFont('arial','',9);
$this->Cell(0,5,"CLIENTES CON DEBITOS VENCIDOS",0,1,'C');
$this->Ln(9);
$this->SetY("30");
$this->SetX("20");
$this->Cell(172,0,'',1,1,'L');
$this->Cell(8,3,"Qtd",0,0,'L');
$this->Cell(14,3,"Pagare",0,0,'L');
$this->Cell(14,3,"Venda",0,0,'L');
$this->Cell(14,3,"Cliente",0,0,'L');
$this->Cell(60,3,"Nome",0,0,'L');
$this->Cell(22,3,"Lancamento",0,0,'R');
$this->Cell(22,3,"Vencimento",0,0,'R');
$this->Cell(19,3,"Valor",0,1,'R');
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

//posiciona verticalmente 21mm
//$pdf->SetY("21");
//posiciona horizontalmente 30mm
//$pdf->SetX("10");

//escreve o conteudo de novo.. parametros posicao inicial,altura,conteudo(*texto),borda,quebra de linha,alinhamento
//$pdf->SetY("5");
//$pdf->SetX("10");
//$pdf->Cell(15,3,"Codigo",1,0,'L');
//$pdf->Ln(1);

   $sql_vencido = "SELECT ct.*, cl.* FROM contas_receber ct, clientes cl WHERE ct.dt_vencimento < NOW() AND ct.status = 'A' AND ct.clientes_id = cl.controle ORDER BY ct.venda_id "; 
		$exe_vencido = mysql_query($sql_vencido, $base);
		$i = 1;
		while  ($reg_vencido = mysql_fetch_array($exe_vencido)){
		
			$data2 = $reg_vencido['dt_lancamento'];
			$hora2 = $reg_vencido['dt_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$data3 = $reg_vencido['dt_vencimento'];
			$hora3 = $reg_vencido['dt_vencimento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
			$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
		
		$total_vencido += $reg_vencido['vl_parcela'];
	

	
//$pdf->Cell(15,4,$reg_lista['Codigo'],0,0,'L',$i);
$pdf->Cell(8,4,$i++,0,0,'L');
$pdf->Cell(14,4,$reg_vencido['id'],0,0,'L');
$pdf->Cell(14,4,$reg_vencido['venda_id'],0,0,'L');
$pdf->Cell(14,4,$reg_vencido['clientes_id'],0,0,'L');
$pdf->Cell(60,4,substr($reg_vencido['nome'],0,30),0,0,'L');
$pdf->Cell(22,4,$novadata,0,0,'R');
$pdf->Cell(22,4,$novadata2,0,0,'R');
$pdf->Cell(19,4,guarani($reg_vencido['vl_parcela']),0,1,'R');
$pdf->Cell(172,0,'',1,1,'L');

}
$pdf->Ln(3);
$pdf->Cell(142,4,'TOTAL',1,0,'L');
$pdf->Cell(30,4,guarani($total_vencido),1,0,'R');

$pdf->Output();	

?>