<?php
require_once("biblioteca.php");
include "config.php";
conexao();

$idPgr = $_GET['idPgr'];
$_SESSION['idPgr'] = $idPgr;

//$sqla = "SELECT contas_rec_id FROM contas_recparcial WHERE  contas_rec_id

require 'fpdf17/fpdf.php';
define('FPDF_FONTPATH', 'fpdf17/font/');

//RECEBENDO VALORES DO FORMULARIO:
//$variavel = $_POST["variavel"];

/*
 * construtor da classe, que permite que seja definido o formato da pagina
 * P=Retrato, mm =tipo de medida utilizada no casso milimetros,
 * tipo de folha = A4
 */
$pdf = new FPDF("P", "mm", "A4");
//Define as margens esquerda, superior e direita.
//$pdf->SetMargins(30, 20, 30);
//define a fonte a ser usada, estilo e tamanho
$pdf->SetFont('courier', '', 8);
//define o titulo
$pdf->SetTitle("Gerar PDF com FPDF");
//assunto
$pdf->SetSubject("Gerar PDF com FPDF");
// posicao vertical no caso -1.. e o limite da margem
$pdf->SetY("-1");

//inserir o cabecalho da pagina
//include 'cabecalho.php';
//$pdf-> Rect(3,3,5,5);
//espacamento
//$pdf->Ln(30);

$pdf->SetFont('courier', 'b', 7);

//PRIMEIRO QUADRO COM LOGO
$pdf->SetY(-1);
$pdf->SetFont('arial','b',14);
$pdf->Ln(3);
$pdf->Cell(50,20,'',1,0,'R');
//$pdf->Image('logo.jpg',30,14,35,12,jpg);
$pdf->Ln(5);
$pdf->Cell(80,0,"   ",0,1,'R');
$pdf->Ln(4);
$pdf->SetFont('arial','',6);
$pdf->SetFont('helvetica','I',8);
$pdf->Cell(36,0,"NELORE",0,1,'R');
$pdf->Cell(80,0,"    ",0,1,'R');
$pdf->Ln(3);
$pdf->Cell(80,0,"   ",0,1,'R');
$pdf->Ln(3);
$pdf->Cell(74,0,"   ",0,1,'R');
$pdf->Ln(6);
$pdf->SetFont('helvetica','',8);
$pdf->SetFont('arial','b',9);
//$pdf->Ln(4);
//$pdf->Ln(4);
//$pdf->Ln(4);
$pdf->SetFont('arial','',9);

$pdf->SetY(12);
$pdf->SetX(61);
$pdf->SetFont('arial','',8);
$pdf->Cell(36,3,"NELORE",0,1,'R');
$pdf->Cell(86,3,"      ",0,1,'R');
$pdf->Cell(87,3,"Ciudad del Este - Py",0,1,'R');
$pdf->Cell(90,3,"Telefono:           ",0,1,'R');
$pdf->Cell(90,3,"                      ",0,1,'R');

$pdf->SetY(7);
$pdf->SetX(150);
$pdf->SetFont('arial','',13);
$pdf->Cell(36,5,"RECIBO DE DINERO",0,1,'R');
$pdf->Cell(160,6,"N:  $idPgr   ",0,1,'R');
$pdf->SetX(135);
$pdf->Cell(60,12,'',1,1,'R');
$pdf->SetY(18);
$pdf->SetX(135);
$pdf->SetDrawColor(128, 0, 0);
$pdf->Cell(60,5,"",1,1,'R');
$pdf->SetY(18);
$pdf->SetFont('helvetica','I',12);
$pdf->Cell(160,7,"Fecha",0,1,'R');
$pdf->Cell(163,5,date("d/m/Y"),0,1,'R');

	$sql = "SELECT crp.valorpg,crp.idctreceber, cr.id, cr.vl_parcela, cr.vl_parcela, e.nome 
	FROM contas_recparcial crp, contas_receber cr, entidades e	
	WHERE contas_rec_id = '".$_SESSION['idPgr']."' 
	AND cr.id = crp.idctreceber AND cr.clientes_id = e.controle ";
	$exe = mysql_query($sql, $base);
	$reg =  mysql_fetch_array($exe, MYSQL_ASSOC);
	$idreceber = $reg['idctreceber'];

	$sqlb = "SELECT sum(valorpg) AS total FROM contas_recparcial WHERE idctreceber = '$idreceber' "; 
	$exeb = mysql_query($sqlb, $base);
	$regb = mysql_fetch_array($exeb, MYSQL_ASSOC);
	$totalpago = $regb['total'];
	$vlparcela = $reg['vl_parcela'];
	$recebido = $reg['valorpg'];
	$nome = $reg['nome'];
	$pagare = $reg['id'];
	$saldo = $vlparcela - $totalpago;
	
	if($saldo == "0"){
		$texto = "Total";
	}
	else{
		$texto = "Parcial";
	}
	$saldoAnterior = $saldo + $recebido;


$pdf->SetX(1);	
$pdf->Ln(3);
$pdf->Cell(185,6,"",1,0,'R');
$pdf->SetX(11);	
$pdf->Cell(30,6,"Recibimos de: ",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->Cell(100,6,$nome,0,1,'L');

$pdf->Cell(185,6,"",1,0,'R');
$pdf->SetX(11);	
$pdf->SetFont('helvetica','I',12);
$pdf->Cell(30,6,"La Suma de: ",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->Cell(100,6,extensoguarani($recebido),0,1,'L');

$pdf->Cell(185,6,"",1,0,'R');
$pdf->SetX(145);	
$pdf->SetFont('helvetica','I',12);
$pdf->Cell(50,6,"G$ ",1,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetX(155);
$pdf->Cell(30,6,$recebido,0,1,'L');

$pdf->Cell(185,6,"",1,0,'R');
$pdf->SetX(11);	
$pdf->SetFont('helvetica','I',12);
$pdf->Cell(50,6,"Por Concepto de: ",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetX(46);
$pdf->Cell(30,6,"Pago $texto de Pagaré N. $pagare ",0,1,'L');
$pdf->Cell(185,6,"",1,1,'R');

$pdf->Cell(185,7,"",1,0,'R');
$pdf->SetX(10);	
$pdf->SetFont('helvetica','I',12);
$pdf->Cell(50,6,"Pagó en efectivo",0,0,'L');
$pdf->SetY(64);
$pdf->SetX(45);	
$pdf->Cell(10,4,"",1,0,'L');
$pdf->Cell(130,6,"Cheque N._____________    Banco: __________________",0,1,'R');

$pdf->Ln(2);
$pdf->Cell(70,6,"",1,0,'R');
$pdf->SetFont('helvetica','I',12);
$pdf->SetX(10);
$pdf->Cell(50,6,"Saldo Inicial:      G$ $vlparcela",0,1,'L');
$pdf->Cell(70,6,"Total de Pagos:  G$ $totalpago",1,1,'L');
$pdf->Cell(70,6,"Saldo Actual:     G$ ".number_format($saldo,2,",",".")."",1,1,'L');
$pdf->SetFont('arial','',7);
$pdf->Cell(70,4,"iCommerce - Sistema Comercial.",0,1,'L');

$pdf->SetY(80);
$pdf->SetX(120);
$pdf->SetFont('helvetica','I',12);
$pdf->Cell(50,6,"______________________________",0,1,'L');
$pdf->Cell(165,6,"Persona Autorizada",0,1,'R');



$pdf->Output();	


?>