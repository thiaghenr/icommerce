<?php
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
$_SESSION['cli'] = $_GET['cli'];
$_SESSION['usu'] = $nome_user;



$nomeprint = $_POST['imprimir'];
$_SESSION['nome'] = $nomeprint;

//incluindo o arquivo do fpdf
require_once("fpdf17/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf17/font/');

$_SESSION['cli'] = $_GET['cli'];

		$sql_listas = "SELECT ct.*, c.* FROM contas_receber ct, entidades c WHERE c.controle = '".$_SESSION['cli']."' AND ct.clientes_id = c.controle AND ct.status = 'A' ";
		$exe_listas = mysql_query($sql_listas, $base);
	while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)){
		
		$total_devido += $reg_listas['vl_parcela'];
		}	
		
		$sql_listas2 = "SELECT * FROM entidades WHERE controle = '".$_GET['cli']."' ";
		$exe_listas2 = mysql_query($sql_listas2, $base);
		$reg_listas2 = mysql_fetch_array($exe_listas2, MYSQL_ASSOC);
		$_SESSION['controle'] = $reg_listas2['controle'];
		$_SESSION['cliente'] = $reg_listas2['nome'];
		$_SESSION['ruc'] = $reg_listas2['ruc'];

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
$this->SetFont('courier','',14);
$this->Ln(3);
$this->Cell(0,5,"NELORE",0,1,'C');
$this->Ln(3);
$this->Ln(2);
$this->SetFont('courier','',8);
$this->Cell(10,3,"Data:",0,0,'L');
$this->Cell(100,3,$data,0,1,'L');
$this->Cell(15,3,"Usuario:",0,0,'L');
$this->Cell(100,3,$usu,0,1,'L');
$this->Ln(1);
$this->Cell(33,3,"Codigo del Cliente:",0,0,'L');
$this->Cell(60,3,$_SESSION['controle'],0,0,'L');
$this->Cell(8,3,"Ruc:",0,0,'L');
$this->Cell(100,3,$_SESSION['ruc'] ,0,1,'L');
$this->Cell(33,3,"Nombre del Cliente:",0,0,'L');
$this->Cell(100,3,$_SESSION['cliente'] ,0,1,'L');
$this->Cell(172,0,'',1,1,'L');
$this->Ln(4);
$this->SetFont('courier','',9);
$this->Cell(0,5,"DEBITOS DEL CLIENTE",0,1,'C');
$this->Ln(1);
//$this->SetY("30");
//$this->SetX("20");
$this->Cell(172,0,'',1,1,'L');
$this->Cell(8,3,"Qtd",0,0,'L');
$this->Cell(14,3,"Pagare",0,0,'L');
$this->Cell(14,3,"Pedido",0,0,'L');
$this->Cell(22,3,"Data Compra",0,0,'R');
$this->Cell(22,3,"Vencimento",0,0,'R');
$this->Cell(18,3,"Valor",0,0,'R');
$this->Cell(15,3,"Interes",0,0,'R');
$this->Cell(19,3,"Descuento",0,0,'R');
$this->Cell(19,3,"Pagado",0,0,'R');
$this->Cell(19,3,"Total",0,1,'R');
$this->Cell(172,0,'',1,1,'L');
$this->Ln(1);

//$this->Cell(0,10,'Página '.$this->PageNo().' ',0,0,'C');
}
function Footer() {
//Vai para 1.5 cm da parte inferior

$this->SetY(-15);

//Seleciona a fonte Arial itálico 8

$this->SetFont('courier','I',8);

//Imprime o número da página corrente e o total de páginas

$this->Cell(0,10,'Página '.$this->PageNo().' ',0,0,'C');

	}
}
//instancia a classe.. P=Retrato, mm =tipo de medida utilizada no casso milimetros, tipo de folha =A4
$pdf= new PDF("P","mm","A4");
$pdf -> SetMargins(20, 5, 15);

//define a fonte a ser usada
$pdf->SetFont('courier','',9);

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

	
  	$sql_listas = "SELECT cr.id, cr.nm_total_parcela, cr.nm_parcela, cr.vl_ntcredito, cr.clientes_id, cr.venda_id, v.pedido_id,
cr.vl_parcela, cr.vl_recebido, cr.status, cr.desconto, cr.juros, sum(round(rp.valorpg,2)) AS valor_recebido, cr.vl_restante, cr.vl_multa, cr.perc_juros, 
date_format(cr.dt_vencimento, '%d/%m/%Y') AS dt_vencimento, date_format(cr.dt_lancamento, '%d/%m/%Y') AS dt_lancamento, 
datediff( NOW(), cr.dt_vencimento) AS dias_atrazo, round((cr.vl_parcela * cr.perc_juros / 30) * (datediff( NOW(), cr.dt_vencimento) / 100),2 ) As valor_juros, 
cr.perc_juros,  cl.controle,cl.nome 
FROM  venda v, entidades cl, contas_receber cr
LEFT JOIN contas_recparcial rp ON rp.idctreceber = cr.id
WHERE cr.clientes_id = '".$_SESSION['controle']."' 
AND cr.clientes_id = cl.controle 
AND cr.status != 'Z'
AND cr.venda_id = v.id GROUP BY cr.id  ";
	$exe_listas = mysql_query($sql_listas, $base);	
		
		$i = 1;
		while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)){
		
			$compra = $reg_listas['dt_lancamento'];
			$vencimento = $reg_listas['dt_vencimento'];
				
		$deducao = $reg_listas['desconto'] + $reg_listas['valor_recebido'] + $reg_listas['vl_ntcredito'];
		$subtotal = $reg_listas['vl_parcela'] + $reg_listas['juros'];
		
		$total_parcela = $subtotal - $deducao;
		
		$total_vencido += $total_parcela;

//$pdf->Cell(15,4,$reg_lista['Codigo'],0,0,'L',$i);
$pdf->Cell(8,4,$i++,0,0,'L');
$pdf->Cell(14,4,$reg_listas['id'],0,0,'L');
$pdf->Cell(14,4,$reg_listas['pedido_id'],0,0,'L');
$pdf->Cell(22,4,$compra,0,0,'R');
$pdf->Cell(22,4,$vencimento,0,0,'R');
$pdf->Cell(18,4,number_format($reg_listas['vl_parcela'],2,',','.'),0,0,'R');
$pdf->Cell(15,4,number_format($reg_listas['juros'],2,',','.'),0,0,'R');
$pdf->Cell(19,4,number_format($reg_listas['desconto'],2,',','.'),0,0,'R');
$pdf->Cell(19,4,number_format($reg_listas['valor_recebido'],2,',','.'),0,0,'R');
$pdf->Cell(19,4,number_format($total_parcela,2,',','.'),0,1,'R');
$pdf->Cell(172,0,'',1,1,'L');

}
$pdf->Ln(3);
$pdf->Cell(142,4,'TOTAL',1,0,'L');
$pdf->Cell(30,4,number_format($total_vencido,2,',','.'),1,0,'R');

$pdf->Output();	

?>