<?php
require_once("biblioteca.php");
include "config.php";
conexao();
$ide = $_GET['id_pedido'];
$_SESSION['ide'] = $_GET['id_pedido'];
$vend = $_GET['vend'];

//incluindo o arquivo do fpdf
require_once("fpdf17/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf17/font/');
		

		$sql_listaw = "SELECT p.*, cl.* FROM consignacao p, entidades cl WHERE p.csg_idconsignacao = '".$_GET['id_pedido']."' AND p.csg_entidadeid = cl.controle ";
		$exe_listaw = mysql_query($sql_listaw, $base) ; //or die (mysql_error()." - $sql_listaw");
	
			$reg_listaw = mysql_fetch_array($exe_listaw, MYSQL_ASSOC);
			$nome = $reg_listaw['nome'];
			$codigo = $reg_listaw['csg_entidadeid'];
			$endereco = $reg_listaw['endereco'];
			$cidade = $reg_listaw['cidade'];
			$ruc = $reg_listaw['ruc'];
			$celular = $reg_listaw['celular'];
			$telefone = $reg_listaw['celular1'];
			$fax = $reg_listaw['fax'];
			$total_carrinho += ($reg_listaw['prvenda']*$reg_listaw['qtd_produto']);
			
			$data2 = $reg_listaw['csg_data'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";


function Footer() {

//Vai para 1.5 cm da parte inferior




$this->SetY(-15);

//Seleciona a fonte Arial itálico 8

$this->SetFont('Arial','b',12);

//Imprime o número da página corrente e o total de páginas

$this->Cell(0,10,'Página '.$this->PageNo().' ',0,0,'C');




//$this->$pdf->Cell(172,0,guarani($total_carrinho),1,1,'L');
}
		
	
$pdf= new FPDF("P","mm","A4");

$pdf->SetMargins(10, 5, 8);
//escreve o texto
//uso: Cell(largura, altura, conteudo, borda, quebra de linha, alinhamento (L = esquerdo, R = direito, C = centralizado)

//PRIMEIRO QUADRO COM LOGO
$pdf->SetY(-1);
$pdf->SetFont('arial','b',18);
$pdf->Ln(3);
$pdf->Cell(0,0,'',0,0,'R');  // $pdf->Cell(86,40,'',1,0,'R'); faz um quadrado em volta.
//$pdf->Image('images/logo_costaa.jpg',13,6,70,22,jpg);
$pdf->Ln(5);
$pdf->Cell(77,0,"WINGS CONFECCIONES",0,1,'C');
$pdf->Ln(4);
$pdf->SetFont('arial','',6);
//$pdf->Cell(76,0,"IMPORTACIONES",0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('helvetica','I',7);
//$pdf->Cell(76,0,"REPUESTOS Y ACESSORIOS",0,1,'C');
$pdf->Ln(3);
//$pdf->Cell(80,0,"SCANIA - VOLVO - CARRETA",0,1,'C');
$pdf->Ln(3);
$pdf->Cell(80,0," ",0,1,'R');
$pdf->Ln(3);
$pdf->Cell(74,0," ",0,1,'R');
$pdf->Ln(6);
$pdf->SetFont('helvetica','',8);
//$pdf->Cell(80,0,"AV. ROJAS SILVA, TTE. ADOLFO",0,1,'C');
$pdf->SetFont('arial','b',9);
$pdf->Ln(4);
$pdf->Cell(66,0,"Tel. (  )  ",0,1,'R');
$pdf->Ln(4);
$pdf->SetFont('arial','',9);
$pdf->Cell(66,0,"San Cristobal - Paraguay",0,1,'R');


//SEGUNDO QUADRO CABEÇALHO
$pdf->SetY(5);
$pdf->SetX("97");
$pdf->Cell(0,0,'',0,0,'L');   //$pdf->Cell(106,40,'',1,0,'L');
$pdf->SetY(5);
$pdf->SetX(265);
$pdf->Cell(25,12,'',1,0,'L');
$pdf->SetY(10);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Nombre Comercial:___________________________________  Codigo:________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(10);
$pdf->SetX(123);
$pdf->Cell(0,0,substr($nome,0,24),0,0,'L');
$pdf->SetY(10);
$pdf->SetX(190);
$pdf->Cell(0,0,$codigo,0,0,'L');

$pdf->SetY(15);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Dirección:__________________________________________________________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(15);
$pdf->SetX(112);
$pdf->Cell(0,0,substr($endereco,0,40),0,0,'L');
$pdf->Cell(0,0,$_SESSION['vendedor'] ,0,0,'L');

$pdf->SetY(20);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Teléfono:__________________ Fax:_________________ Cel:________________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(20);
$pdf->SetX(110);
$pdf->Cell(0,0,$telefone,0,0,'L');
$pdf->SetY(20);
$pdf->SetX(170);
$pdf->Cell(0,0,$fax ,0,0,'L');
$pdf->SetY(20);
$pdf->SetX(230);
$pdf->Cell(0,0,$celular,0,0,'L');

$pdf->SetY(25);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Ciudad:___________________________________ Dpto.:___________________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(25);
$pdf->SetX(109);
$pdf->Cell(0,0,substr($cidade,0,25),0,0,'L');
$pdf->SetY(25);
$pdf->SetX(200);
$pdf->Cell(0,0,"",0,0,'L');

$pdf->SetY(30);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Ruc:_________________________ Forma de Pago:________________________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(30);
$pdf->SetX(105);
$pdf->Cell(0,0,$ruc,0,0,'L');
$pdf->SetY(30);
$pdf->SetX(165);
$pdf->Cell(0,0,"**CONSIGNACION**",0,0,'L');

$pdf->SetY(35);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Fecha:_______________________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(35);
$pdf->SetX(122);
$pdf->Cell(0,0,$novadata,0,0,'L');
$pdf->SetY(35);
$pdf->SetX(182);
$pdf->Cell(0,0,"",0,0,'L');
$pdf->SetY(35);
$pdf->SetX(230);
$pdf->Cell(0,0,$email,0,0,'L');

$pdf->SetY(40);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"NUMERO:_____________________________ ",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(40);
$pdf->SetX(165);
$pdf->SetFont('arial','',14);
$pdf->Cell(0,0,$ide ,0,0,'L');
$pdf->SetY(40);
$pdf->SetX(243);
$pdf->SetFont('arial','',8);
$pdf->Cell(0,0,$celular,0,0,'L');

$pdf->SetFont('arial','b',9);
$pdf->SetY(49);
$pdf->SetX(70);
$pdf->Cell(0,0,"EXTRACTO DE RECTIRADA Y LIQUIDACION DE ITENS",0,1,'L');

$pdf->Ln(6);
$pdf->SetFont('courier','b',9);
//$pdf->Cell(150,0,'',1,1,'L');
$pdf->Cell(25,6,"CODIGO",1,0,'C');
$pdf->Cell(50,6,"DESCRIPTION DEL PRODUTO",1,0,'L');
$pdf->Cell(16,6,"VALOR",1,0,'C');
$pdf->Cell(18,6,"RECTIRADO",1,0,'L');
$pdf->Cell(18,6,"DEVOLVIDO",1,0,'L');
$pdf->Cell(18,6,"FACTURADO",1,0,'L');
$pdf->Cell(18,6,"PENDENTE",1,0,'L');
$pdf->Cell(22,6,"TOTAL",1,0,'C');
//$pdf->Cell(150,0,'',1,1,'L');
$pdf->Ln(6);

//SQL PARA ITENS DO PEDIDO
	$sql_list = "SELECT ic.*  FROM itens_consig ic WHERE ic.itcsg_consigid = '".$_SESSION['ide']."'  ";
	$exe_list = mysql_query($sql_list)  or die (mysql_error());
	//$rows = mysql_num_rows($exe_list);
	while ($reg_list = mysql_fetch_array($exe_list, MYSQL_ASSOC)) {
			
			
			$desconto = $reg_list['desconto'];
			
		$pendente = $reg_list['itcsg_qtd'] - $reg_list['itcsg_fat'] - $reg_list['itcsg_dev'];
		$total_carrinho += ($reg_list['itcsg_valor']*$reg_list['itcsg_qtd']);
		$total_nota += ($reg_list['itcsg_valor']*$pendente);
		
$pdf->SetFont('courier','',8);
$pdf->Cell(25,6,substr($reg_list['itcsg_referencia'],0,14),1,0,'L');
$pdf->SetFont('arial','',8);
$pdf->Cell(50,6,substr($reg_list['itcsg_descricao'],0,26),1,0,'L');
$pdf->Cell(16,6,number_format($reg_list['itcsg_valor'],0,",","."),1,0,'R');
$pdf->Cell(18,6,$reg_list['itcsg_qtd'],1,0,'R');
$pdf->Cell(18,6,$reg_list['itcsg_dev'],1,0,'R');
$pdf->Cell(18,6,$reg_list['itcsg_fat'],1,0,'R');
$pdf->Cell(18,6,$pendente,1,0,'R');
$pdf->SetFont('arial','',8);
$pdf->Cell(22,6,number_format($reg_list['itcsg_valor']*$pendente,0,",","."),1,1,'R');
}

//$linhas = ($rows);

//$pdf->SetY(264 +rows);
$pdf->Ln(8);
$pdf->Cell(130,6,"SALDO INICIAL",1,0,'R');		
$pdf->Cell(53,6,number_format($total_carrinho,0,",","."),1,1,'R');
if($desconto > 0){
$pdf->Cell(130,6,"TOTAL DESCUENTO",1,0,'R');
$pdf->Cell(53,6,number_format($desconto,0,",","."),1,1,'R');
}
$pdf->Cell(130,6,"SALDO ATUAL",1,0,'R');	
$pdf->Cell(53,6,number_format($total_nota,0,",","."),1,1,'R');
$pdf->SetFont('arial','i',11);
$pdf->Cell(183,6,"No sirve como ducumento fiscal",0,1,'R');
$pdf->SetFont('arial','i',8);
$pdf->Cell(183,2,"iCommerce - Sistema Comercial",0,0,'R');



$pdf->Output();	

?>
