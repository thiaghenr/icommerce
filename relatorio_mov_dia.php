<?php
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
header("Content-Type: text/html; charset=iso-8859-1");

$_SESSION['nome'] = $nome_user;
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
$nome = $_SESSION['nome'];

$dtini = $_GET['dia'];

//$dtini = date('d/m/Y', strtotime($dtini));


//escreve o texto
//uso: Cell(largura, altura, conteudo, borda, quebra de linha, alinhamento (L = esquerdo, R = direito, C = centralizado)
//$this->SetY(12);
$this->SetFont('arial','',14);
$this->Ln(3);
$this->Cell(0,5,"HPA",0,1,'C');
$this->Ln(3);
$this->Cell(172,0,'',1,1,'L');
$this->Ln(2);


$this->SetFont('arial','',9);
$this->Cell(172,4,'Relatorio: Movimiento de caja por Fecha',0,1,'L');
$this->Cell(13,4,"Usuario:",0,0,'L');
$this->Cell(0,4,$_SESSION['nome'],0,1,'L');
$this->Cell(13,4,"Fecha:",0,0,'L');
$this->Cell(30,4,date("d-m-Y"),0,1,'L');
$this->Cell(27,4,"Movimiento del:",0,0,'L');
if($dtini == "01/01/1970"){
$this->Cell(0,4,'No informado',0,1,'L');
}
else{
$this->Cell(0,4,$dtini,0,1,'L');
}
$this->Ln(9);
$this->SetY("37");
$this->SetX("20");
$this->Cell(50,3,"Historico",0,0,'L');
$this->Cell(38,3,"Entidade",0,0,'L');
$this->Cell(20,3,"Documiento",0,0,'L');
$this->Cell(25,3,"Fecha",0,0,'L');
$this->Cell(20,3,"Salida",0,0,'R');
$this->Cell(20,3,"Entrada",0,1,'R');
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


$dtini = converte_data('2',$_GET['dia']);

  $sql_lancamentos = "SELECT l.*, date_format(l.dt_lanc_desp, '%d/%m/%Y %H:%i')AS data, e.nome FROM lanc_contas l, entidades e
		WHERE l.dt_lanc_desp LIKE '$dtini%' AND l.valor != '0' 
		AND e.controle = l.entidade_id  ORDER BY  l.dt_lanc_desp ASC ";
		$exe_lancamentos = mysql_query($sql_lancamentos) or die(mysql_error().'-'.$sql_lancamentos);
		$total = mysql_num_rows($exe_lancamentos);
		$arr = array();
		while($obj = mysql_fetch_array($exe_lancamentos, MYSQL_ASSOC)){
		
		$id = $obj['id_lanc_despesa'];
		$Historico = $obj['desc_desp'];
		$entidade = $obj['nome'];
		$doc = $obj['documento'];
		$data = $obj['data'];
		
		
		
		if($obj['receita_id'] == 1){
		$entrada =  $obj['valor'];
		$entradas +=  $obj['valor'];
		$saida = 0;
		}
		if($obj['receita_id'] == 2){
		$saida =  $obj['valor'];
		$saidas +=  $obj['valor'];
		$entrada = 0;
		}
		
		$saldo = $entrada - $saida;
		$saldos += $entrada - $saida;
		
	//	$arr[] = $obj;
		
	//echo '({"total":"'.$total.'","Entradas":"'.$Entradas.'","Saidas":"'.$Saidas.'","Trf":"'.$Trf.'","Movimento":'.json_encode($arr).'})'; 

		 $arr[] = array("id"=>$id, "dia"=>$dia, "entrada"=>$entrada, "saida"=>$saida, "Historico"=>$Historico, "entidade"=>$entidade,
						"doc"=>$doc, "data"=>$data, "saldo"=>$saldo);
	
	

	
//$pdf->Cell(15,4,$reg_lista['Codigo'],0,0,'L',$i);
$pdf->Cell(50,4,$Historico,0,0,'L');
$pdf->Cell(38,4,substr($entidade,0,21),0,0,'L');
$pdf->Cell(20,4,$doc,0,0,'L');
$pdf->Cell(25,4,$data,0,0,'L');
$pdf->Cell(20,4,$saida,0,0,'R');
$pdf->Cell(20,4,$entrada,0,1,'R');
//$pdf->Cell(172,0,'',1,1,'L');

}
$pdf->SetFont('arial','b',7);
$pdf->Cell(153,4,number_format($saidas,2,",","."),0,0,'R');
$pdf->Cell(20,4,number_format($entradas,2,",","."),0,0,'R');

$pdf->Ln(5);
$pdf->SetFont('arial','',7);
$pdf->Cell(142,4,'SALDO',1,0,'L');
$pdf->Cell(30,4,number_format($saldos,2,",","."),1,0,'R');

$pdf->Output();	

?>