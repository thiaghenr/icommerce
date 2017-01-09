<?php
require_once("biblioteca.php");
include "config.php";
conexao();
header("Content-Type: text/html; charset=iso-8859-1");
$id = $_GET['id'];
$_SESSION['grupo'] = $_GET['id'];

//incluindo o arquivo do fpdf
require_once("fpdf17/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf17/font/');

 	$sql = "SELECT * FROM grupos WHERE id = '$id' ";
    $rs = mysql_query($sql) or die (mysql_error());
	$reg_lista = mysql_fetch_array($rs, MYSQL_ASSOC); 
	
	$_SESSION['nome_grupo'] = $reg_lista['nom_grupo'];



class PDF extends FPDF
{

// sobrepõe o método header
function Header()
{
$dtini = $_GET['dtini'];
$dtfim = $_GET['dtfim'];

$dtini = date('d/m/Y', strtotime($dtini));
$dtfim = date('d/m/Y', strtotime($dtfim));

//escreve o texto
//uso: Cell(largura, altura, conteudo, borda, quebra de linha, alinhamento (L = esquerdo, R = direito, C = centralizado)
//$this->SetY(12);
//$this->Cell(172,0,'',1,1,'L');
$this->SetFont('arial','',14);
$this->Ln(1);
$this->Cell(0,5,"NELORE",0,1,'C');
$this->Ln(4);
$this->SetFont('arial','',9);
$this->Cell(172,4,'Informe: Ventas de productos del grupo',0,1,'L');

$this->SetFont('arial','',9);
$this->Cell(13,5,"Grupo:",0,0,'L');
$this->Cell(0,5,$_SESSION['nome_grupo'],0,1,'L');
$this->Cell(13,5,"Fecha:",0,0,'L');
$this->Cell(30,5,date("d-m-Y"),0,0,'L');
$this->Cell(15,5,"Periodo:",0,0,'L');
if($dtini == "01/01/1970" || $dtfim == "01/01/1970"){
$this->Cell(0,5,'No informado',0,1,'L');
}
else{
$this->Cell(0,5,'De  '.$dtini.'  Hasta  '.$dtfim,0,1,'L');
}
//$this->Ln(15);
$this->SetY("32");
$this->SetX("20");
$this->SetFont('arial','',8);
//$this->Cell(172,0,'',1,1,'L');
$this->Cell(10,3,"Codigo",0,0,'L');
$this->Cell(32,3,"Descripcion",0,0,'L');
$this->Cell(9,3,"Stok",0,0,'R');
$this->Cell(13,3,"Vendido",0,0,'R');
$this->Cell(15,3,"Custo Atu",0,0,'R');
$this->Cell(16,3,"Custo Med",0,0,'R');
$this->Cell(18,3,"Vl Med Vend",0,0,'R');
$this->Cell(20,3,"Saldo Venta",0,0,'R');
$this->Cell(23,3,"Lucro Med",0,0,'R');
$this->Cell(21,2,"% Perc Lucro",0,1,'R');
//$this->Cell(172,0,'',1,1,'L');
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

//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
//$pdf->Cell(0,5,$titulo,0,0,'L');
//$pdf->Cell(0,0,'',0,1,'R');
//$pdf->Ln(8);

//hora do conteudo do artigo
$pdf->SetFont('courier','',6);
$dataini = date('Y-m-d', strtotime($_GET['dtini']));
$datafim = date('Y-m-d', strtotime($_GET['dtfim']));

    $sql = "SELECT g.*, p.Estoque,p.custo_anterior,p.custo,p.custo_medio,p.valor_a, 
	it.referencia_prod,it.descricao_prod,sum(it.qtd_produto) AS vendido, avg(it.prvenda) AS vlmediovend,
	sum(it.prvenda * it.qtd_produto) AS saldo, sum((it.prvenda * it.qtd_produto) - (it.qtd_produto * p.custo_medio)) AS lucro
	FROM produtos p, grupos g, itens_pedido it, pedido pd
	WHERE p.grupo = g.id AND g.id = '".$_SESSION['grupo']."' AND it.id_prod = p.id 
	AND pd.id = it.id_pedido AND pd.data_car BETWEEN '$dataini' AND '$datafim 23:59:59.999'
	GROUP BY p.id ORDER BY p.Codigo ASC  ";
    $rs = mysql_query($sql) or die (mysql_error());
	
	$num_prod = mysql_num_rows($rs);
	$i = 1;
			while ($reg_lista = mysql_fetch_array($rs, MYSQL_ASSOC)) {
			
			$total_custo += $reg_lista['custo'] * $reg_lista['Estoque'];
			$vlmediovend = $reg_lista['vlmediovend'];
			$custo_medio = $reg_lista['custo_medio'];
			$totalsaldo += $reg_lista['saldo'];
			$totallucro += $reg_lista['lucro'];
			
			$lucro = $vlmediovend -  $custo_medio;
			$media = 100 / $custo_medio * $lucro;
			
			if ($media < 0){
			$media = 0;}
			else {
			$media; }
			number_format($media,2,",",".");
			
	
$pdf->Cell(10,4,$reg_lista['referencia_prod'],0,0,'L');
$pdf->Cell(32,4,substr($reg_lista['descricao_prod'],0,20),0,0,'L');
$pdf->Cell(9,4,$reg_lista['Estoque'],0,0,'R');
$pdf->Cell(13,4,$reg_lista['vendido'],0,0,'R');
$pdf->Cell(15,4,number_format($reg_lista['custo'],2,",","."),0,0,'R');
$pdf->Cell(16,4,number_format($reg_lista['custo_medio'],2,",","."),0,0,'R');
$pdf->Cell(18,4,number_format($reg_lista['vlmediovend'],2,",","."),0,0,'R');
$pdf->Cell(20,4,number_format($reg_lista['saldo'],2,",","."),0,0,'R');
$pdf->Cell(23,4,number_format($reg_lista['lucro'],2,",","."),0,0,'R');
$pdf->Cell(21,4,number_format($media,2,",","."),0,1,'R');
//$pdf->Cell(172,0,'',1,1,'L');
//$i++;
}
$pdf->Ln(1);
$pdf->SetFont('courier', 'b', 6);
$pdf->Cell(133,4,number_format($totalsaldo,2,",","."),0,0,'R');
$pdf->Cell(23,4,number_format($totallucro,2,",","."),0,0,'R');




$pdf->Output();	



?>