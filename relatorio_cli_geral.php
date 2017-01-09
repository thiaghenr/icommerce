<?php
//require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
$_SESSION['usu'] = $nome_user;

$cli = $_GET['cli'];
$_SESSION['cli'] = $cli;

$nomeprint = $_POST['imprimir'];
$_SESSION['nome'] = $nomeprint;

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
$usu = $_SESSION['usu'];

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
//$this->Cell(10,3,"Fecha:",0,0,'L');
//$this->Cell(100,3,$data,0,1,'L');
//$this->Cell(12,3,"Usuario:",0,0,'L');
//$this->Cell(100,3,$usu,0,1,'L');
$this->Cell(172,0,'',1,1,'L');
$this->Ln(1);
$this->Cell(28,3,"Relatorio Sintetico Cuentas a Recibir",0,0,'L');
$this->Ln(6);
$this->SetFont('arial','',9);
$this->Ln(1);
//$this->SetY("30");
//$this->SetX("20");
/*
$this->Cell(172,0,'',1,1,'L');
$this->Cell(8,3,"Qtd",0,0,'L');
$this->Cell(14,3,"Pedido",0,0,'L');
$this->Cell(14,3,"Venta",0,0,'L');
$this->Cell(14,3,"T.Venta",0,0,'L');
$this->Cell(22,3,"Data Compra",0,0,'R');
$this->Cell(12,3,"QTs",0,0,'R');
$this->Cell(22,3,"Vencimento",0,0,'R');
$this->Cell(12,3,"Interes",0,0,'R');
$this->Cell(19,3,"Valor",0,0,'R');
$this->Cell(19,3,"Descuento",0,0,'R');
$this->Cell(19,3,"Total",0,1,'R');
$this->Cell(172,0,'',1,1,'L');
$this->Ln(1);
*/
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
$pdf->Ln(10);

/*	
  	$sql_listas = "SELECT c.*, v.pedido_id,v.id AS idp FROM contas_receber c, venda v 
	WHERE c.status = 'A' AND c.venda_id = v.id GROUP BY c.id ";
	$exe_listas = mysql_query($sql_listas, $base);	
*/	
	$sql = "SELECT sum(rp.valorpg) AS japago, EXTRACT(MONTH FROM ct.dt_vencimento) AS MES,  EXTRACT(YEAR FROM ct.dt_vencimento) AS ANO, 
	sum((ct.vl_parcela)) AS total 
	FROM  contas_receber ct
	LEFT JOIN contas_recparcial rp ON rp.idctreceber = ct.id
	WHERE ct.status = 'A'
	GROUP BY ANO,MES ORDER BY ANO,MES ASC";
		
	$arr = array();
	
$exe = mysql_query($sql);
$ano = "";
while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
	if($ano !== $reg['ANO']){
		$arr[] = array('ANO'=>$reg['ANO'], $reg['MES'] => ($reg['total']));
		$ano = $reg['ANO'];
	}else{
		$arr[count($arr)-1][$reg['MES']] = ($reg['total']);
	}
	
	if($reg['MES'] == 1)
	$mes = 'Enero';
	if($reg['MES'] == 2)
	$mes = 'Febrero';
	if($reg['MES'] == 3)
	$mes = 'Marzo';
	if($reg['MES'] == 4)
	$mes = 'Abril';
	if($reg['MES'] == 5)
	$mes = 'Mayo';
	if($reg['MES'] == 6)
	$mes = 'Junio';
	if($reg['MES'] == 7)
	$mes = 'Julio';
	if($reg['MES'] == 8)
	$mes = 'Agosto';
    if($reg['MES'] == 9)
	$mes = 'Septiembre';
	if($reg['MES'] == 10)
	$mes = 'Octubre';
	if($reg['MES'] == 11)
	$mes = 'Noviembre';
	if($reg['MES'] == 12)
	$mes = 'Diciembre';

	$saldo += $reg['total'] - $reg['japago'];
	
$pdf->Cell(24,4,$reg['ANO'],0,0,'L');
$pdf->Cell(44,4,$mes,0,0,'L');
$pdf->Cell(24,4,number_format($reg['total'] - $reg['japago'],2,',','.'),0,1,'R');
$pdf->Cell(92,0,'',1,1,'L');

}
$pdf->Ln(3);
$pdf->Cell(62,4,'TOTAL',1,0,'L');
$pdf->Cell(30,4,number_format($saldo,2,',','.'),1,0,'R');

$pdf->Output();	

?>