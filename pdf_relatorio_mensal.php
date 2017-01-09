<?php
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$ano = $_GET['ano'];
$mes = $_GET['mes'];

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
$pdf->SetMargins(30, 20, 30);
//define a fonte a ser usada, estilo e tamanho
$pdf->SetFont('courier', '', 8);
//define o titulo
$pdf->SetTitle("Gerar PDF com FPDF");
//assunto
$pdf->SetSubject("Gerar PDF com FPDF");
// posicao vertical no caso -1.. e o limite da margem
$pdf->SetY("-1");

//inserir o cabecalho da pagina
include 'cabecalho.php';
//$pdf-> Rect(3,3,5,5);
//espacamento
$pdf->Ln(30);

$pdf->SetFont('courier', 'b', 7);

//margens do texto principal
//medidas das margens
$pdf->SetMargins(30, 20, 30);
//posiciona verticalmente 41mm
$pdf->SetY("12");
//posiciona horizontalmente 10mm
$pdf->SetX("80");
$pdf->Cell(8,3,"Movimentos de Caixa",0,0,'L');
//espacamento

$pdf->Ln(5);
$pdf->SetX("5");
$pdf->SetFont('courier', 'b', 7);
$pdf->Cell(8,3,"Periodo: ".gmstrftime("$mes/$ano"),0,1,'L');
$pdf->Ln(5);
$pdf->SetX("5");
$pdf->Cell(8,3,"Entradas",0,0,'L');
$pdf->SetFont('courier', '', 7);
$pdf->Ln(5);
$pdf->SetX("10");
$pdf->Cell(8,3,"Ventas Al Contado",0,0,'L');
$pdf->Ln(5);
$pdf->SetX("10");
$pdf->Cell(8,3,"Qtd",0,0,'L');
$pdf->Cell(15,3,"Pedido",0,0,'L');
$pdf->Cell(20,3,"Data",0,0,'L');
$pdf->Cell(30,3,"Cliente",0,0,'L');
$pdf->Cell(20,3,"Valor",0,1,'R');
//$this->Cell(172,0,'',1,1,'L');
$pdf->Ln(1);

$sql_listas = "SELECT lc.vl_pago,lc.dt_lancamento, p.id AS pedido,p.nome_cli 
FROM lancamento_caixa_balcao lc, venda v, pedido p 
WHERE YEAR(lc.dt_lancamento) = '$ano' AND MONTH(lc.dt_lancamento) = '$mes' AND lc.venda_id = v.id AND p.id = v.pedido_id AND lc.contas_receber_id = '0' ";
		$exe_listas = mysql_query($sql_listas, $base);
		$i = 1;
	    while($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)){

			$data2 = $reg_listas['dt_lancamento'];
			$hora2 = $reg_listas['dt_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$total_vencido += $reg_listas['vl_pago'];


$pdf->SetX("10");
$pdf->Cell(8,4,$i++,0,0,'L');	
$pdf->Cell(15,4,$reg_listas['pedido'],0,0,'L');
$pdf->Cell(20,4,$novadata,0,0,'L');
$pdf->Cell(30,4,substr($reg_listas['nome_cli'],0,18),0,0,'L');
$pdf->Cell(20,4,number_format($reg_listas['vl_pago'],2,",","."),0,1,'R');
//$pdf->Cell(172,0,'',1,1,'L');
}
$pdf->SetFont('courier', 'b', 7);
$pdf->Cell(48,4,'Subtotal',0,0,'R');
$pdf->Cell(25,4,number_format($total_vencido,2,",","."),0,0,'R');


$pdf->Ln(3);
$pdf->SetX("5");

$pdf->SetFont('courier', '', 7);
$pdf->Ln(5);
$pdf->SetX("10");
$pdf->Cell(8,3,"Cartera a Recibir",0,0,'L');
$pdf->Ln(5);
$pdf->SetX("10");
$pdf->Cell(8,3,"Qtd",0,0,'L');
$pdf->Cell(15,3,"Pedido",0,0,'L');
$pdf->Cell(20,3,"Data",0,0,'L');
$pdf->Cell(30,3,"Cliente",0,0,'L');
$pdf->Cell(20,3,"Valor",0,1,'R');
//$this->Cell(172,0,'',1,1,'L');
$pdf->Ln(1);

$sql_caixa = "SELECT lc.vl_pago,lc.dt_lancamento, p.id AS pedido,p.nome_cli 
FROM lancamento_caixa_balcao lc, venda v, pedido p, contas_receber cr  
WHERE YEAR(lc.dt_lancamento) = '$ano' AND MONTH(lc.dt_lancamento) = '$mes' AND lc.venda_id = v.id AND p.id = v.pedido_id AND lc.contas_receber_id = cr.id  ";
		$exe_caixa = mysql_query($sql_caixa, $base);
		$i = 1;
	    while($reg_caixa = mysql_fetch_array($exe_caixa, MYSQL_ASSOC)){

			$data2 = $reg_caixa['dt_lancamento'];
			$hora2 = $reg_caixa['dt_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$CartReceber += $reg_caixa['vl_pago'];


$pdf->SetX("10");
$pdf->Cell(8,4,$i++,0,0,'L');	
$pdf->Cell(15,4,$reg_caixa['pedido'],0,0,'L');
$pdf->Cell(20,4,$novadata,0,0,'L');
$pdf->Cell(30,4,substr($reg_caixa['nome_cli'],0,18),0,0,'L');
$pdf->Cell(20,4,number_format($reg_caixa['vl_pago'],2,",","."),0,1,'R');
//$pdf->Cell(172,0,'',1,1,'L');
}
$pdf->SetFont('courier', 'b', 7);
$pdf->Cell(48,4,'Subtotal',0,0,'R');
$pdf->Cell(25,4,number_format($CartReceber,2,",","."),0,0,'R');



$pdf->Ln(5);
$pdf->SetX("5");
$pdf->Cell(8,3,"Salidas",0,0,'L');
$pdf->SetFont('courier', '', 7);
$pdf->Ln(5);
$pdf->SetX("10");
$pdf->Cell(8,3,"Pago a Proveedores",0,0,'L');
$pdf->Ln(5);
$pdf->SetX("10");
$pdf->Cell(8,3,"Qtd",0,0,'L');
$pdf->Cell(15,3,"Compra",0,0,'L');
$pdf->Cell(20,3,"Data",0,0,'L');
$pdf->Cell(30,3,"Proveedor",0,0,'L');
$pdf->Cell(20,3,"Valor",0,1,'R');
//$this->Cell(172,0,'',1,1,'L');
$pdf->Ln(1);

$sql_listas = "SELECT valor,lb.data_lancamento, cp.compra_id, p.nome
FROM lancamento_caixa lb, contas_pagar cp, proveedor p
WHERE YEAR(lb.data_lancamento) = '$ano' AND MONTH(lb.data_lancamento) = '$mes' 
AND lb.contas_pagar_id = cp.id AND lb.despesa_cod = '0' AND cp.compra_id != '0' AND lb.fornecedor_id = p.id ";
		$exe_listas = mysql_query($sql_listas, $base);
		$i = 1;
	    while($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)){

			$data2 = $reg_listas['data_lancamento'];
			$hora2 = $reg_listas['data_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$TotalForn += $reg_listas['valor'];


$pdf->SetX("10");
$pdf->Cell(8,4,$i++,0,0,'L');	
$pdf->Cell(15,4,$reg_listas['compra_id'],0,0,'L');
$pdf->Cell(20,4,$novadata,0,0,'L');
$pdf->Cell(30,4,substr($reg_listas['nome'],0,18),0,0,'L');
$pdf->Cell(20,4,number_format($reg_listas['valor'],2,",","."),0,1,'R');
//$pdf->Cell(172,0,'',1,1,'L');
}
$pdf->SetFont('courier', 'b', 7);
$pdf->Cell(48,4,'Subtotal',0,0,'R');
$pdf->Cell(25,4,number_format($TotalForn,2,",","."),0,0,'R');

$pdf->Ln(3);
$pdf->SetX("5");

$pdf->SetFont('courier', '', 7);
$pdf->Ln(5);
$pdf->SetX("10");
$pdf->Cell(8,3,"Pago Despesas",0,0,'L');
$pdf->Ln(5);
$pdf->SetX("10");
$pdf->Cell(8,3,"Qtd",0,0,'L');
$pdf->Cell(15,3,"Despesa",0,0,'L');
$pdf->Cell(20,3,"Data",0,0,'L');
$pdf->Cell(30,3,"Tipo",0,0,'L');
$pdf->Cell(20,3,"Valor",0,1,'R');
//$this->Cell(172,0,'',1,1,'L');
$pdf->Ln(1);

$sql_caixa = "SELECT lc.valor,lc.data_lancamento, ld.id_lanc_despesa, d.nome_despesa 
FROM lancamento_caixa lc, lanc_despesa ld, contas_pagar cp, despesa d 
WHERE YEAR(lc.data_lancamento) = '$ano' AND MONTH(lc.data_lancamento) = '$mes' AND lc.contas_pagar_id = cp.id 
AND cp.lanc_desp_id = ld.id_lanc_despesa AND ld.despesa_id = d.despesa_id ";
		$exe_caixa = mysql_query($sql_caixa, $base);
		$i = 1;
	    while($reg_caixa = mysql_fetch_array($exe_caixa, MYSQL_ASSOC)){

			$data2 = $reg_caixa['data_lancamento'];
			$hora2 = $reg_caixa['data_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$PagoDesp += $reg_caixa['valor'];


$pdf->SetX("10");
$pdf->Cell(8,4,$i++,0,0,'L');	
$pdf->Cell(15,4,$reg_caixa['id_lanc_despesa'],0,0,'L');
$pdf->Cell(20,4,$novadata,0,0,'L');
$pdf->Cell(30,4,substr($reg_caixa['nome_despesa'],0,18),0,0,'L');
$pdf->Cell(20,4,number_format($reg_caixa['valor'],2,",","."),0,1,'R');
//$pdf->Cell(172,0,'',1,1,'L');
}
$pdf->SetFont('courier', 'b', 7);
$pdf->Cell(48,4,'Subtotal',0,0,'R');
$pdf->Cell(25,4,number_format($PagoDesp,2,",","."),0,0,'R');

$pdf->SetFont('courier', '', 7);
$pdf->Ln(5);
$pdf->SetX("10");
$pdf->Cell(8,3,"Retiradas",0,0,'L');
$pdf->Ln(5);
$pdf->SetX("10");
$pdf->Cell(8,3,"Qtd",0,0,'L');
$pdf->Cell(15,3,"ID",0,0,'L');
$pdf->Cell(20,3,"Data",0,0,'L');
$pdf->Cell(30,3,"Historico",0,0,'L');
$pdf->Cell(20,3,"Valor",0,1,'R');
//$this->Cell(172,0,'',1,1,'L');
$pdf->Ln(1);

$sql_caixa = "SELECT id,valor,historico,data_lancamento 
FROM lancamento_caixa 
WHERE YEAR(data_lancamento) = '$ano' AND MONTH(data_lancamento) = '$mes' AND historico = 'Retirada Socio' ";
		$exe_caixa = mysql_query($sql_caixa, $base);
		$i = 1;
	    while($reg_caixa = mysql_fetch_array($exe_caixa, MYSQL_ASSOC)){

			$data2 = $reg_caixa['data_lancamento'];
			$hora2 = $reg_caixa['data_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$TotalRet += $reg_caixa['valor'];


$pdf->SetX("10");
$pdf->Cell(8,4,$i++,0,0,'L');	
$pdf->Cell(15,4,$reg_caixa['id'],0,0,'L');
$pdf->Cell(20,4,$novadata,0,0,'L');
$pdf->Cell(30,4,substr($reg_caixa['historico'],0,18),0,0,'L');
$pdf->Cell(20,4,number_format($reg_caixa['valor'],2,",","."),0,1,'R');
//$pdf->Cell(172,0,'',1,1,'L');
}
$pdf->SetFont('courier', 'b', 7);
$pdf->Cell(48,4,'Subtotal',0,0,'R');
$pdf->Cell(25,4,number_format($TotalRet,2,",","."),0,0,'R');

$pdf->Output();
?>