<?php
require_once("biblioteca.php");
include "config.php";
conexao();
$ide = $_GET['id_pedido'];
//$vend = $_GET['vend'];

//incluindo o arquivo do fpdf
require_once("fpdf17/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf17/font/');
		

		$sql_listaw = "SELECT p.nome,p.endereco,p.telefone,p.celular,p.ruc, c.nomecidade, r.* FROM requisicao r, proveedor p
		LEFT JOIN cidades c ON c.idcidade = p.cidade
		WHERE r.idrequisicao = '$ide' AND p.id = r.idprovedor  ";
		$exe_listaw = mysql_query($sql_listaw, $base) ; //or die (mysql_error()." - $sql_listaw");
		$reg_listaw = mysql_fetch_array($exe_listaw, MYSQL_ASSOC);
			//$_SESSION['vendedor'] = $reg_listaw['vendedor'];
			
			$total_carrinho += ($reg_listaw['prvenda']*$reg_listaw['qtd_produto']);
		
		
			
			$nome = $reg_listaw['nome'];
			$requisicao = $reg_listaw['idrequisicao'];
			$endereco = $reg_listaw['endereco'];
			$telefone = $reg_listaw['telefone'];
			$celular = $reg_listaw['celular'];
			$ruc = $reg_listaw['ruc'];
			$nomecidade = $reg_listaw['nomecidade'];
			$idvendedor = $reg_listaw['vendedor'];
			
		// Pegando data e hora.
      	$data2 = $reg_listaw['datareq'];
		//Formatando data e hora para formatos Brasileiros.
      	$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
      	$novahora = substr($hora2,11,2) . ":" .substr($hora2,14,2) . " min";
		
	
$pdf= new FPDF("P","mm","A4");
$pdf->SetMargins(10, 5, 8);
//escreve o texto
//uso: Cell(largura, altura, conteudo, borda, quebra de linha, alinhamento (L = esquerdo, R = direito, C = centralizado)

//PRIMEIRO QUADRO COM LOGO
$pdf->SetY(-1);
$pdf->SetFont('arial','b',14);
$pdf->Ln(3);
$pdf->Cell(86,44,'',1,0,'R');
$pdf->Image('logo.jpg',30,14,35,12,jpg);
$pdf->Ln(5);
$pdf->Cell(80,0,"   ",0,1,'R');
$pdf->Ln(4);
$pdf->SetFont('arial','',6);
$pdf->Cell(76,0,"  ",0,0,'R');
$pdf->Ln(5);
$pdf->SetFont('helvetica','I',8);
$pdf->Cell(76,0,"   ",0,1,'R');
$pdf->Ln(3);
$pdf->Cell(80,0,"    ",0,1,'R');
$pdf->Ln(3);
$pdf->Cell(80,0,"   ",0,1,'R');
$pdf->Ln(3);
$pdf->Cell(74,0,"   ",0,1,'R');
$pdf->Ln(6);
$pdf->SetFont('helvetica','',8);
$pdf->Cell(80,0,"Calle: ****************************************************** ",0,1,'R');
$pdf->SetFont('arial','b',9);
$pdf->Ln(4);
$pdf->Cell(66,0,"Tel./Fax (61) ******* / *******",0,1,'R');
$pdf->Ln(4);
$pdf->Cell(68,0,"Celular (0973) ******* / (0983) *******",0,1,'R');
$pdf->Ln(4);
$pdf->SetFont('arial','',9);
$pdf->Cell(55,0,"Ciudad del Este - Paraguay",0,1,'R');


//SEGUNDO QUADRO CABEÇALHO
$pdf->SetY(5);
$pdf->SetX("97");
$pdf->Cell(105,44,'',1,0,'L');
$pdf->SetY(5);
$pdf->SetX(265);
$pdf->Cell(25,12,'',1,0,'L');
$pdf->Ln(4);
$pdf->SetFont('arial','b',8);
$pdf->Cell(274,0,"PEDIDO",0,0,'R');
$pdf->Ln(36);
$pdf->SetFont('arial','b',9);
$pdf->Cell(120,0,$requisicao,0,0,'R');
$pdf->SetY(10);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Nombre Proveedor:______________________________________________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(10);
$pdf->SetX(123);
$pdf->Cell(0,0,$nome,0,0,'L');
$pdf->SetY(10);
$pdf->SetX(226);


$pdf->SetY(15);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Dirección:______________________________________________________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(15);
$pdf->SetX(112);
$pdf->Cell(0,0,$endereco ,0,0,'L');

$pdf->SetY(20);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Teléfono:___________________ Cel.:_______________________________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(20);
$pdf->SetX(110);
$pdf->Cell(0,0,$telefone,0,0,'L');
$pdf->SetY(20);
$pdf->SetX(170);
$pdf->SetY(20);
$pdf->SetX(150);
$pdf->Cell(0,0,$celular,0,0,'L');

$pdf->SetY(25);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Ciudad:________________________________________________________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(25);
$pdf->SetX(109);
$pdf->Cell(0,0,$nomecidade,0,0,'L');
$pdf->SetY(25);
$pdf->SetX(200);
$pdf->Cell(0,0,"",0,0,'L');

$pdf->SetY(30);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Ruc:__________________________________________________________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(30);
$pdf->SetX(105);
$pdf->Cell(0,0,$ruc,0,0,'L');
$pdf->SetY(30);
$pdf->SetX(193);
$pdf->Cell(0,0,"",0,0,'L');

$pdf->SetY(35);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Fecha del Pedido:_______________________________________________",0,0,'L');
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
$pdf->Cell(50,0,"Comprador:____________________________________________________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(40);
$pdf->SetX(115);
$pdf->Cell(0,0,$solicitante ,0,0,'L');
$pdf->SetY(40);
$pdf->SetX(243);
$pdf->Cell(0,0,$celular,0,0,'L');

$pdf->SetY(45);
$pdf->SetX(97);
$pdf->SetFont('arial','',8);
$pdf->Cell(50,0,"Requisicion N:___________________",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->SetY(45);
$pdf->SetX(105);
$pdf->Cell(0,0,"",0,1,'L');

$pdf->Ln(6);
$pdf->Cell(192,10,'',1,1,'L');
$pdf->Cell(192,102,'',1,1,'L');
$pdf->SetY(56);
$pdf->SetX(12);
$pdf->SetFont('arial','b',9);
$pdf->Cell(0,0,"CANT.",0,0,'L');

$pdf->SetY(56);
$pdf->SetX(26);
$pdf->Cell(0,0,"CODIGO",0,0,'L');
$pdf->SetY(51);
$pdf->SetX(32);

$pdf->SetY(56);
$pdf->SetX(120);
$pdf->Cell(0,0,"DESCRIPCION",0,0,'L');


$pdf->SetY(56);
$pdf->SetX(263);
$pdf->Cell(0,0,"SUB TOTALES",0,0,'L');  //AND p.cor = c.id_cor
$pdf->SetY(51);
$pdf->SetX(25);
$pdf->Cell(23,106,'',1,0,'L');
$pdf->SetY(51);
$pdf->SetX(230);
$pdf->Cell(30,106,'',1,0,'L');
$pdf->Ln(11);

//SQL PARA ITENS DO PEDIDO
  //  $sql_itens_pedido = "";
   
   
   $sql_itens_pedido = "SELECT * FROM itens_requisicao WHERE id_requisicao = '$requisicao' ";
      $exe_itens_pedido = mysql_query($sql_itens_pedido) or die (mysql_error().'-'.$sql_itens_pedido);
      $num_itens_pedido = mysql_num_rows($exe_itens_pedido);

      while ($reg_itens_pedido = mysql_fetch_array($exe_itens_pedido, MYSQL_ASSOC)) {
      
	  $total_carrinho += ($reg_itens_pedido['prvenda']*$reg_itens_pedido['qtd_produto']);
  	  $subtotal = $reg_itens_pedido['prvenda']*$reg_itens_pedido['qtd_produto'] ;
	   
	    
	  
	
/*	  if ($reg_itens_pedido['aba'] == 0){
	  $aba =  "";
	   }
	  else {
	  $aba = "ABA ". $reg_itens_pedido['nom_aba'];}
	  
	  if (empty($reg_itens_pedido['cor'])){
	  $cor =  ""; 
	   }
		else{ 
*/
	  
	  $obs = $reg_itens_pedido['obs'];
	  
	  
$pdf->SetFont('arial','',10);
$pdf->Cell(16,6,$reg_itens_pedido['qtdproduto'],0,0,'L');
$pdf->Cell(22,6,substr($reg_itens_pedido['refproduto'],0,10),0,0,'L');
$pdf->Cell(95,6,$reg_itens_pedido['descproduto']." ".$mat." ".$cor." ".$per." ".$aba." ".$reg,0,0,'L');
$pdf->Cell(115,6,guarani($reg_itens_pedido['prvenda']),0,0,'R');
$pdf->Cell(30,6,guarani($subtotal),0,1,'R');
if(!empty($reg_itens_pedido['obs'])){
$pdf->Cell(39,6,"",0,0,'R');		  
$pdf->MultiCell(180,6,substr($obs,0,200),0,1,'L');
}
}

$pdf->SetY(67);
$pdf->SetX(10);
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->Cell(192,6,'',1,1,'L');
$pdf->SetFont('arial','b',12);
$pdf->Cell(240,6,"TOTAL:",0,0,'R');
$pdf->Cell(40,6,guarani($total_carrinho),0,0,'R');
$pdf->SetFont('arial','',8);
$pdf->Ln(9);
//$pdf->SetY(159);
//
$pdf->Cell(110,23,'',1,1,'L');
$pdf->SetY(167);
$pdf->SetX(11);
$pdf->SetFont('arial','',9);

$pdf->SetY(180);
$pdf->SetX(20);
$pdf->SetFont('arial','',9);
$pdf->Cell(0,4,'__________________________________________',0,1,'L');
$pdf->SetY(186);
$pdf->SetX(40);
$pdf->Cell(0,0,'Responsable',0,1,'L');





$pdf->Output();	

?>