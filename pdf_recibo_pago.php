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
//$pdf->Cell(80,0,"   ",0,1,'R');
$pdf->Ln(4);
$pdf->SetFont('arial','',6);
$pdf->SetFont('helvetica','I',8);
$pdf->Cell(36,0,"HPA",0,1,'R');
//$pdf->Cell(80,0,"    ",0,1,'R');
//$pdf->Ln(3);
//$pdf->Cell(80,0,"   ",0,1,'R');
//$pdf->Ln(3);
//$pdf->Cell(74,0,"   ",0,1,'R');
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
//$pdf->Cell(36,3,"Fagues Joyas SRL",0,1,'R');
//$pdf->Cell(86,3,"Ruc N. 4245717-3",0,1,'R');
//$pdf->Cell(87,3,"Santo Domingo - Py",0,1,'R');
//$pdf->Cell(90,3,"Telefono: (0983) 888-979",0,1,'R');

$pdf->SetY(7);
$pdf->SetX(150);
$pdf->SetFont('arial','',13);
$pdf->Cell(36,5,"COMPROBANTE DE PAGO",0,1,'R');
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

	$sql = "SELECT lc.id_lanc_despesa,lc.desc_desp,lc.valor,lc.dt_lanc_desp, e.nome, tp.tipo_pgto_descricao
	FROM lanc_contas lc, entidades e, tipo_pagamento tp
	WHERE lc.id_lanc_despesa = '".$_SESSION['idPgr']."' 
	AND lc.entidade_id = e.controle AND lc.tipo_pgto_id = tp.idtipo_pagamento ";
	$exe = mysql_query($sql, $base);
	$reg =  mysql_fetch_array($exe, MYSQL_ASSOC);
	$idreceber = $reg['idctreceber'];
	$nome = $reg['nome'];
	$valor = $reg['valor'];
	$desc_desp = $reg['desc_desp'];
	$dt_lanc_desp = $reg['dt_lanc_desp'];
	$tipo_pgto_descricao = $reg['tipo_pgto_descricao'];
	if($tipo_pgto_descricao == "Especie")
		$tipo_pgto_descricao = "Efectivo";

$pdf->SetX(1);	
$pdf->Ln(3);
$pdf->Cell(185,6,"",0,0,'R');
$pdf->SetX(11);	
$pdf->Cell(20,6,"Nombre: ",0,0,'L');
//$pdf->Ln(3);
$pdf->Cell(.1,6,$nome,0,1,'L');
$pdf->Cell(30,6,"Recibimos de: ",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->Cell(100,6,"HPA",0,1,'L');

$pdf->Cell(185,6,"",1,0,'R');
$pdf->SetX(11);	
$pdf->SetFont('helvetica','I',12);
$pdf->Cell(30,6,"La Suma de: ",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->Cell(100,6,extensoguarani($valor),0,1,'L');

$pdf->Cell(185,6,"",1,0,'R');
$pdf->SetX(145);	
$pdf->SetFont('helvetica','I',12);
$pdf->Cell(50,6,"Gs ",1,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetX(155);
$pdf->Cell(30,6,number_format($valor,0,",","."),0,1,'L');

$pdf->Cell(185,6,"",1,0,'R');
$pdf->SetX(11);	
$pdf->SetFont('helvetica','I',12);
$pdf->Cell(50,6,"Por Concepto de: ",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetX(46);
$pdf->Cell(30,6,$desc_desp,0,1,'L');

$pdf->Cell(185,6,"En Forma de:  $tipo_pgto_descricao",1,1,'L');
$pdf->Cell(185,6,"Fecha del movimento:  $dt_lanc_desp",1,1,'L');
$pdf->Ln(6);
$pdf->Cell(185,6,"",1,0,'R');
//$pdf->SetFont('helvetica','I',12);
$pdf->SetX(10);
$pdf->Cell(10,6,"Obs:     ",0,1,'L');
$pdf->Cell(185,6,"",1,1,'L');
$pdf->SetFont('arial','',7);
//$pdf->Cell(70,4,"iCommerce - Sistema Comercial ",0,1,'L');

$pdf->SetY(95);
$pdf->SetX(20);
$pdf->SetFont('helvetica','I',12);
$pdf->Cell(50,6,"______________________________",0,1,'L');
$pdf->Cell(50,6,"ACLARACION",0,1,'R');
$pdf->SetY(95);
$pdf->SetX(120);
$pdf->Cell(150,6,"______________________________",0,1,'L');
$pdf->Cell(140,6,"FIRMA",0,1,'R');


$pdf->Output();	


?>