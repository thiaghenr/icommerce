<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
$_SESSION['usu'] = $nome_user;

$cli = $_GET['cli'];
$_SESSION['cli'] = $cli;

$nome = $_POST['imprimir'];
$_SESSION['nome'] = $nome;

//incluindo o arquivo do fpdf
require_once("fpdf17/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf17/font/');

		$sql_listas = "SELECT cp.*, p.* FROM contas_pagar cp, proveedor p WHERE p.id = '".$_SESSION['cli']."' AND cp.fornecedor_id = p.id AND cp.status = 'A' ";
		$exe_listas = mysql_query($sql_listas, $base);
	while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)){
		
		$total_devido += $reg_listas['vl_parcela'];
		}	
		
		$sql_listas2 = "SELECT * FROM proveedor WHERE id = '".$_SESSION['cli']."' ";
		$exe_listas2 = mysql_query($sql_listas2, $base);
		$reg_listas2 = mysql_fetch_array($exe_listas2, MYSQL_ASSOC);
		$_SESSION['id'] = $reg_listas2['id'];
		$_SESSION['proveedor'] = $reg_listas2['nome'];
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
$this->Cell(100,3,$usu,0,1,'L');
$this->Cell(172,0,'',1,1,'L');
$this->Ln(1);
$this->Cell(28,3,"Codigo del Proveedor: ",0,0,'L');
$this->Cell(62,3,$_SESSION['id'],0,0,'L');
$this->Cell(8,3,"Ruc:",0,0,'L');
$this->Cell(100,3,$_SESSION['ruc'] ,0,1,'L');
$this->Cell(28,3,"Nombre del Proveedor: ",0,0,'L');
$this->Cell(102,3,$_SESSION['proveedor'] ,0,1,'L');
$this->Cell(172,0,'',1,1,'L');
$this->Ln(4);
$this->SetFont('arial','',9);
$this->Cell(0,5,"DEBITOS",0,1,'C');
$this->Ln(1);
//$this->SetY("30");
//$this->SetX("20");
$this->Cell(172,0,'',1,1,'L');
$this->Cell(8,3,"Qtd",0,0,'L');
$this->Cell(14,3,"Pagare",0,0,'L');
$this->Cell(14,3,"Compra",0,0,'L');
$this->Cell(14,3,"T.Compra",0,0,'L');
$this->Cell(22,3,"Data Compra",0,0,'R');
$this->Cell(12,3,"QTs",0,0,'R');
$this->Cell(22,3,"Vencimento",0,0,'R');
$this->Cell(10,3,"N. Qt",0,0,'R');
$this->Cell(19,3,"Valor",0,0,'R');
$this->Cell(19,3,"Interes",0,0,'R');
$this->Cell(19,3,"Total",0,1,'R');
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
$pdf->Ln(10);

	if ($_SESSION['nome'] == "todos") {	
  	$sql_listas = "SELECT * FROM contas_pagar WHERE fornecedor_id = '".$_SESSION['cli']."' AND status = 'A' ";
	$exe_listas = mysql_query($sql_listas, $base);
	}

	
	else if ($_SESSION['nome'] == "vencidos") {
	$sql_listas = "SELECT * FROM contas_pagar WHERE dt_vencimento_parcela < NOW() AND fornecedor_id = '".$_SESSION['cli']."' AND status = 'A' ORDER BY compra_id "; 
		$exe_listas = mysql_query($sql_listas, $base);
	
	}		
		$i = 1;
		while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)){
		
		$total_devido += $reg_listas['vl_parcela'];
			
		
			$data2 = $reg_listas['dt_emissao_fatura'];
			$hora2 = $reg_listas['dt_emissao_fatura'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$data3 = $reg_listas['dt_vencimento_parcela'];
			$hora3 = $reg_listas['dt_vencimento_parcela'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
			$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
		
		$total_vencido += $reg_listas['vl_parcela'];
	


//$pdf->Cell(15,4,$reg_lista['Codigo'],0,0,'L',$i);
$pdf->Cell(8,4,$i++,0,0,'L');
$pdf->Cell(14,4,$reg_listas['id'],0,0,'L');
$pdf->Cell(14,4,$reg_listas['compra_id'],0,0,'L');
$pdf->Cell(14,4,number_format($reg_listas['vl_total_fatura']),0,0,'R');
$pdf->Cell(22,4,$novadata,0,0,'R');
$pdf->Cell(12,4,$reg_listas['nm_total_parcela'],0,0,'R');
$pdf->Cell(22,4,$novadata2,0,0,'R');
$pdf->Cell(10,4,$reg_listas['nm_parcela'],0,0,'R');
$pdf->Cell(19,4,number_format($reg_listas['vl_parcela'],2,",","."),0,0,'R');
$pdf->Cell(19,4,number_format($reg_listas['juros'],2,",","."),0,0,'R');
$pdf->Cell(19,4,number_format($reg_listas['vl_parcela'],2,",","."),0,1,'R');
$pdf->Cell(172,0,'',1,1,'L');

}
$pdf->Ln(3);
$pdf->Cell(142,4,'TOTAL',1,0,'L');
$pdf->Cell(30,4,number_format($total_vencido,2,",","."),1,0,'R');

$pdf->Output();	

?>