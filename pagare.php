<?php
require_once("biblioteca.php");
include "config.php";
conexao();

$pedido = $_GET['id_pedido'];
//$pedido = '9';
//incluindo o arquivo do fpdf
require_once("fpdf17/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf17/font/');


		$sql_listaw = "SELECT * FROM pedido WHERE id = '$pedido' ";
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
$pdf= new PDF("P","mm","A4" );
$pdf -> SetMargins(10, 5, 12);
$pdf->Ln(5);


 /*
$sql_lista = "SELECT v.id AS ide,v.data_car,v.total_nota,v.desconto,v.entrada, cl.endereco,
cl.telefone1,cl.nome,cl.ruc,cl.endereco, f.nm_total_parcela
FROM pedido v, entidades cl, forma_pagamento f 
WHERE v.id = '$pedido'  AND v.controle_cli = cl.controle AND v.forma_pagamento_id = f.id ";
*/

$sql_lista = "SELECT cr.vl_total,cr.vl_parcela,cr.nm_total_parcela,cr.nm_parcela, cr.dt_vencimento, cr.dt_lancamento,
cl.endereco,cl.telefone1,cl.nome,cl.ruc,cl.endereco, v.pedido_id
FROM contas_receber cr, entidades cl, venda v, pedido p
WHERE cr.venda_id = v.id AND v.pedido_id = p.id AND p.id = '$pedido' AND p.controle_cli = cl.controle";

	$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error()." - $sql_lista");
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		//$total_carrinho = 0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)){
			
			$entrada = $reg_lista['entrada'];
			$desconto = $reg_lista['desconto'];
			$total_nota = $reg_lista['vl_total'];
			$totalparcelas = $reg_lista['nm_total_parcela'];
			
			$total = $total_nota - $entrada;
			$ide3 = $reg_lista['controle_cli'];
			// Pegando data e hora.
			$data2 = $reg_lista['dt_vencimento'];
			//Formatando data e hora para formatos Brasileiros.
			$dia = substr($data2,8,2) ; //. "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$mes = substr($data2,5,2) ;
			$ano = substr($data2,0,4) ;
			
			
			
			$data_vence = $data2;
			$data_vence = strftime("%Y-%m-%d", strtotime(" +30 days")); // Hoje mais 30 dias			
			//$data_vence = $reg_lista['dt_lancamento'];
			$diab = substr($data_vence,8,2) ; //. "/" .substr($data_vence,5,2) . "/" . substr($data_vence,0,4);
			$mesb = substr($data_vence,5,2) ;
			$anob = substr($data_vence,0,4) ;
			
			
			

$pdf->SetY("-1");


//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento


//for($w = 0; $w < $totalparcelas; ){


$pdf->SetFont('arial','',12,'');
$pdf->Cell(200,3,"===================================================================================================",0,1,'C');
$pdf->Cell(200,3,"P   A   G   A   R   E     A     L   A     O   R   D   E   M",0,1,'C');
$pdf->Cell(200,3,"===================================================================================================",0,1,'C');
$pdf->Ln(5);
$pdf->Cell(130,5,"San Cristobal ",0,0,'R');
$pdf->Cell(26,5,formata_data_extenso($reg_lista['dt_lancamento']),0,1,'L');
$pdf->Cell(7,5,"N.:",0,0,'R');
$pdf->Cell(13,5,$reg_lista['pedido_id']." /",0,0,'R');
$pdf->Cell(2,5,"",0,0,'R');
$pdf->Cell(3,5,$reg_lista['nm_parcela'],0,0,'L');
$pdf->Cell(146,5,"G$.:",0,0,'R');
$pdf->Cell(24,5,number_format($reg_lista['vl_parcela'],2,',','.'),0,0,'R');
$pdf->Ln(7);

//$pdf->Cell(8,5," de ",0,0,'L');
//$pdf->Cell(29,5,$mesb,0,0,'L');
//$pdf->Cell(12,5,$anob,0,0,'L');
$pdf->Cell(126,5,"Pagaré(mos) SOLIDARIAMENTE y sin protestos, en Vencimiento: ",0,0,'L');
$pdf->Cell(2,5,formata_data_extensob($reg_lista['dt_vencimento']),0,1,'L');
$pdf->Cell(2,5,"a WINGS, o a su orden la cantidade de Guaranies: ",0,1,'L');
$pdf->SetFont('arial','U',10,'');
$pdf->Cell(0,5,extensoguarani($reg_lista['vl_parcela']),0,1,'L');
$pdf->SetFont('arial','',10,'');
//$pdf->Cell(7,5,"_________________________________________________________________________",0,1,'L');
//$pdf->Cell(7,5,"_________________________________________________________________________________________",0,1,'L');
//$pdf->Cell(0,3,"Pagaré/mos,  a FAGUES JOYERIA, o a su orden, en su domicilio legal de San Cristobal",0,1,'L');

$pdf->SetFont('arial','',10,'');
//$pdf->Ln(4);
$pdf->Cell(0,3,"La falta de pago del documento a su presentación, y desde la constitución en mora del deudor, originara automaticamente un",0,1,'L');
$pdf->Cell(0,3,"interes del  1,5  por ciento mensual, y ademas un interes punitorio del  10,00  por  ciento  mensual, sin que ello implique",0,1,'L');
$pdf->Cell(0,3,"novacion prorroga o espera. La falta de pago de un  pagare a  su  vencimiento, producira  la  caducidad  de los demas plazos",0,1,'L');
$pdf->Cell(0,3,"no fenecidos por el solo transcurso del tiempo, sin   necessidad de interpelacion  judicial o  extrajudicial alguna.",0,1,'L');
$pdf->Cell(0,3,"A los  efectos  de la  reclamacion  judicial, autorizo(amos) desde  ya  al  acreedor a  ejecutar los  pagares seguientes que cor-",0,1,'L');
$pdf->Cell(0,3,"respondan a esta operacion,que importa el saldo total de la deuda. El simples vencimiento estabelecera la mora, autorizando",0,1,'L');
$pdf->Cell(0,3,"a  la consulta como a la  inclusion a la  base de datosde  INFORCONF  conforme  a lo estabelecido en la ley 1682. Todas las",0,1,'L');
$pdf->Cell(0,3,"partes intervinientes en este documento se someten a lajurisdiccion y competencia de los jueces y Tribunales de la Republica",0,1,'L');
$pdf->Cell(0,3,"del Paraguay y declaran prorrogadas desde ya cualquierotra que pudiera corresponder. El o los libradores de este documento",0,1,'L');
$pdf->Cell(0,3,"fijan domicilio especial (Art. 62 C.C.) a los efectos decumplimiento del mismo en:",0,1,'L');
$pdf->Ln(3);
$pdf->SetFont('arial','',10,'');
$pdf->Cell(56,5,"Pagadero en San Cristobal. ",0,0,'L');
$pdf->Cell(26,5,formata_data_extenso($reg_lista['dt_vencimento']),0,1,'L');
$pdf->Cell(180,4,"__________________________________",0,1,'R');
$pdf->Cell(160,3,"ACLARACION",0,1,'R');
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

$w++;
}

$pdf->Output();	

?>