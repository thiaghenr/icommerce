<?php
require_once("biblioteca.php");
include "config.php";
conexao();

//incluindo o arquivo do fpdf
require_once("fpdf/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf/font/');


		$sql_listaw = "SELECT * FROM pedido WHERE id = '16' ";
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
$this->SetFont('arial','b',24);
$this->Ln(5);

}
function Footer() {


}



}


//instancia a classe.. P=Retrato, mm =tipo de medida utilizada no casso milimetros, tipo de folha =A4
$pdf= new PDF("P","mm",array(220,157));
$pdf -> SetMargins(10, 5, 12);
$pdf->Ln(5);


 
$sql_lista = "SELECT v.id AS ide,v.data_car,v.total_nota, cl.endereco, cl.telefonecom,nome,ruc,endereco FROM pedido v, clientes cl WHERE v.id = '".$_GET['pedido']."' AND v.controle_cli = cl.controle  ";

	$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error()." - $sql_lista");
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		//$total_carrinho = 0;
			$reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC);
			//$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			$ide3 = $reg_lista['controle_cli'];
			// Pegando data e hora.
			$data2 = $reg_lista['data_car'];
			//Formatando data e hora para formatos Brasileiros.
			$dia = substr($data2,8,2) ; //. "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$mes = substr($data2,5,2) ;
			$ano = substr($data2,0,4) ;
			
			if ($mes == '01') {
			$mes = " Enero  de";}
			else if ($mes == '02' ){
			$mes = "Febrero  de";}
			else if ($mes == '03' ){
			$mes = "marzo  de";}
			else if ($mes == '04' ){
			$mes = "Abril  de";}
			else if ($mes == '05' ){
			$mes = "Mayo  de";}
			else if ($mes == '06' ){
			$mes = "Junio  de";}
			else if ($mes == '07' ){
			$mes = "Julio  de";}
			else if ($mes == '08' ){
			$mes = "Agosto  de";}
			else if ($mes == '09' ){
			$mes = "Septiembre  de";}
			else if ($mes == '10' ){
			$mes = "Octubre  de";}
			else if ($mes == '11' ){
			$mes = "Noviembre  de";}
			else if ($mes == '12' ){
			$mes = "Diciembre  de";}
			
			$data_vence = $data2;
			$data_vence = strftime("%Y-%m-%d", strtotime(" +30 days")); // Hoje mais 30 dias			
			//$data_vence = $reg_lista['dt_lancamento'];
			$diab = substr($data_vence,8,2) ; //. "/" .substr($data_vence,5,2) . "/" . substr($data_vence,0,4);
			$mesb = substr($data_vence,5,2) ;
			$anob = substr($data_vence,0,4) ;
			
			if ($mesb == '01') {
			$mesb = " Enero  de";}
			else if ($mesb == '02' ){
			$mesb = "Febrero  de";}
			else if ($mesb == '03' ){
			$mesb = "Marzo  de";}
			else if ($mesb == '04' ){
			$mesb = "Abril  de";}
			else if ($mesb == '05' ){
			$mesb = "Mayo  de";}
			else if ($mesb == '06' ){
			$mesb = "Junio  de";}
			else if ($mesb == '07' ){
			$mesb = "Julio  de";}
			else if ($mesb == '08' ){
			$mesb = "Agosto  de";}
			else if ($mesb == '09' ){
			$mesb = "Septiembre  de";}
			else if ($mesb == '10' ){
			$mesb = "Octubre  de";}
			else if ($mesb == '11' ){
			$mesb = "Noviembre  de";}
			else if ($mesb == '12' ){
			$mesb = "Diciembre  de";}
			
			

$pdf->SetY("-1");


//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento

$pdf->SetFont('arial','',12,'');
$pdf->Cell(200,3,"===================================================================================================",0,1,'C');
$pdf->Cell(200,3,"P   A   G   A   R   E     A     L   A     O   R   D   E   M",0,1,'C');
$pdf->Cell(200,3,"===================================================================================================",0,1,'C');
$pdf->Ln(5);
$pdf->Cell(7,5,"N.:",0,0,'R');
$pdf->Cell(13,5,$reg_lista['ide'],0,0,'R');
$pdf->Cell(2,5,"/",0,0,'R');
$pdf->Cell(3,5,$reg_lista['nm_parcela'],0,0,'L');
$pdf->Cell(146,5,"G$.:",0,0,'R');
$pdf->Cell(24,5,guarani($reg_lista['total_nota']),0,0,'R');
$pdf->Ln(7);
$pdf->Cell(33,5,"Vencimento  en ",0,0,'L');
$pdf->Cell(6,5,$diab,0,0,'L');
$pdf->Cell(8,5," de ",0,0,'L');
$pdf->Cell(26,5,$mesb,0,0,'L');
$pdf->Cell(12,5,$anob,0,0,'L');
$pdf->Cell(2,5,"Pagare(mos)  a  la  ordem  de: ",0,1,'L');
$pdf->Ln(2);
$pdf->Cell(7,5,"_________________________________________________________________________",0,1,'L');
$pdf->Cell(7,5,"_________________________________________________________________________________________",0,1,'L');
$pdf->Ln(2);
$pdf->SetFont('arial','',10,'');
$pdf->Cell(27,5,"Sin  protesto  la  cantidad  de  guaranies ",0,1,'L');
$pdf->Cell(0,5,($reg_lista['total_nota']),0,0,'L');
$pdf->Ln(3);
$pdf->SetFont('arial','',10,'');
$pdf->Ln(4);
$pdf->Cell(0,3,"La falta de pago del documento a su presentacion, y desde la constitucion en mora del deudor, originara automaticamente un  interes ",0,1,'L');
$pdf->Cell(0,3,"del ______ por ciento mensual, y ademas un interes punitorio del ______ por ciento mensual, sin que ello implique novacion prorroga",0,1,'L');
$pdf->Cell(0,3,"o espera.  La  falta  de pago  de un  pagare a su  vencimiento, producira  la  caducidad  de los demas plazos  no fenecidos por el solo",0,1,'L');
$pdf->Cell(0,3,"transcurso   del   tiempo,  sin   necessidad  de interpelacion  judicial o  extrajudicial  alguna. A  los efectos  de la reclamacion  judicial,",0,1,'L');
$pdf->Cell(0,3,"autorizo(amos) desde  ya  al  acreedor a  ejecutar los  pagares seguientes  que  correspondan  a esta operacion, que importa el saldo",0,1,'L');
$pdf->Cell(0,3,"total de la  deuda. El simples  vencimiento  estabelecera la  mora, autorizando a  la  consulta  como a la  inclusion a la  base de datos",0,1,'L');
$pdf->Cell(0,3,"de  INFORCONF  conforme  a lo  estabelecido  en la  ley 1682.  Todas las partes intervinientes  en este documento se someten  a  la",0,1,'L');
$pdf->Cell(0,3,"jurisdiccion  y  competencia  de  los  jueces  y  Tribunales  de  la Republica  del  Paraguay y declaran prorrogadas desde ya cualquier",0,1,'L');
$pdf->Cell(0,3,"otra  que  pudiera  corresponder.  El  o  los  libradores  de  este  documento  fijan  domicilio  especial  (Art. 62 C.C.)  a  los efectos  de",0,1,'L');
$pdf->Cell(0,3,"cumplimiento del mismo en:",0,1,'L');
$pdf->Ln(3);
$pdf->SetFont('arial','',10,'');
$pdf->Cell(56,5,"Pagadero en San Cristobal, ",0,0,'L');
$pdf->Cell(6,5,$dia,0,0,'L');
$pdf->Cell(8,5," de ",0,0,'L');
$pdf->Cell(26,5,$mes,0,0,'L');
$pdf->Cell(12,3,$ano,0,1,'L');
$pdf->Cell(200,4,"__________________________________",0,1,'R');
$pdf->Cell(180,3,"ACLARACION",0,1,'R');
$pdf->Cell(18,5,"Deudor....:",0,0,'L');
$pdf->Cell(0,5,$reg_lista['nome'],0,1,'L');
$pdf->Cell(18,5,"Domicilio.:",0,0,'L');
$pdf->Cell(0,5,$reg_lista['endereco'],0,1,'L');
$pdf->Cell(18,5,"Telefono..:",0,0,'L');
$pdf->Cell(0,5,$reg_lista['telefone1'],0,0,'L');
$pdf->Cell(2,5,"__________________________________",0,1,'R');
$pdf->Cell(18,5,"RUC / C.I.:",0,0,'L');
$pdf->Cell(0,5,$reg_lista['ruc'],0,0,'L');
$pdf->Cell(-20,3,"FIRMA",0,1,'R');
$pdf->Ln(3);
$pdf->SetFont('arial','',12,'');
$pdf->Cell(200,3,"==============================================================================================================",0,1,'C');

$pdf->Output();	

?>