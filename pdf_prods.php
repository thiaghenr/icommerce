<?php
require_once("biblioteca.php");
require_once("verifica_login.php");
include "config.php";
conexao();
header("Content-Type: text/html; charset=iso-8859-1");
$id = $_GET['id'];
$_SESSION['grupo'] = $_GET['id'];

//incluindo o arquivo do fpdf
require_once("fpdf16/fpdf.php");

//defininfo a fonte !
define('FPDF_FONTPATH','fpdf16/font/');


class PDF extends FPDF
{

// sobrepõe o método header
function Header()
{

//escreve o texto
//uso: Cell(largura, altura, conteudo, borda, quebra de linha, alinhamento (L = esquerdo, R = direito, C = centralizado)
//$this->SetY(12);
//$this->Cell(172,0,'',1,1,'L');
$this->SetFont('arial','',14);
$this->Ln(1);
$this->Cell(0,5,"NELORE",0,1,'C');
$this->Ln(4);
$this->SetFont('arial','',9);
$this->Cell(172,4,'Relatorio: Productos ',0,1,'L');

$this->SetFont('arial','',9);
//$this->Cell(13,5,"Grupo:",0,0,'L');
//$this->Cell(0,5,$_SESSION['nome_grupo'],0,1,'L');
$this->Cell(13,5,"Fecha:",0,0,'L');
$this->Cell(30,5,date("d-m-Y"),0,0,'L');
$this->Cell(15,5,"Usuario:",0,0,'L');
$this->Cell(0,5,$_SESSION['nome_user'],0,1,'L');
//$this->Ln(15);
$this->SetY("32");
$this->SetX("20");
$this->SetFont('arial','',8);
//$this->Cell(172,0,'',1,1,'L');



if($_GET['cod'] == "true"){
$this->Cell(18,3,"Codigo",0,0,'L');
}
if($_GET['ori'] == "true"){
$this->Cell(27,3,"Original",0,0,'L');
}
if($_GET['desc'] == "true"){
$this->Cell(45,3,"Descripcion",0,0,'L');
}
if($_GET['ref'] == "true"){
$this->Cell(18,3,"Ref",0,0,'L');
}
if($_GET['pes'] == "true"){
$this->Cell(18,3,"Peso",0,0,'L');
}

if($_GET['stk'] == "true"){
$this->Cell(9,3,"Stok",0,0,'R');
}
if($_GET['custo'] == "true"){
$this->Cell(15,3,"Custo",0,0,'R');
}
if($_GET['vla'] == "true"){
$this->Cell(17,3,"Valor",0,0,'R');
}
if($_GET['custo'] == "true" && $_GET['stk'] == "true"){	
$this->Cell(17,3,"T. Custo",0,0,'R');
}
if($_GET['vla'] == "true" && $_GET['stk'] == "true"){
$this->Cell(17,3,"T. Stok",0,1,'R');
}
$this->Cell(26,3,"",0,1,'L');
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

$pdf->SetFont('courier','',7);

    $sql = "SELECT id";
	if($_GET['cod'] == "true"){
	$sql .= ",p.Codigo";
	}
	if($_GET['ori'] == "true"){
	$sql .= ",p.Codigo_Fabricante";
	}
	if($_GET['ref'] == "true"){
	$sql .= ",p.ref";
	}
	if($_GET['pes'] == "true"){
	$sql .= ",p.peso";
	}
	if($_GET['desc'] == "true"){
	$sql .= ",p.Descricao";
	}
	if($_GET['stk'] == "true"){
	$sql .= ",p.Estoque";
	}
	if($_GET['custo'] == "true"){
	$sql .= ",p.custo";
	}
	if($_GET['vla'] == "true"){
	$sql .= ",round(p.valor_a,0) AS valor_a ";
	}	
	$sql .= " FROM produtos p WHERE 1=1    ";
	if($_GET['sme'] == "true"){
	$sql .= " AND p.Estoque > '0' ";
	}
	$sql .= " ORDER BY p.Descricao ASC  ";
	$rs = mysql_query($sql) or die (mysql_error());
	
	$num_prod = mysql_num_rows($rs);
	$i = 1;
			while ($reg_lista = mysql_fetch_array($rs, MYSQL_ASSOC)) {
									
if($_GET['cod'] == "true"){	
$pdf->Cell(18,4,$reg_lista['Codigo'],0,0,'L');
}
if($_GET['ori'] == "true"){	
$pdf->Cell(27,4,substr($reg_lista['Codigo_Fabricante'],0,16),0,0,'L');
}
if($_GET['desc'] == "true"){
$pdf->Cell(45,4,substr($reg_lista['Descricao'],0,27),0,0,'L');
}
if($_GET['ref'] == "true"){	
$totalRef +=  $reg_lista['ref'];
$pdf->Cell(18,4,$reg_lista['ref'],0,0,'L');
}
if($_GET['pes'] == "true"){	
$totalPeso +=  $reg_lista['peso'];
$pdf->Cell(18,4,$reg_lista['peso'],0,0,'L');
}

if($_GET['stk'] == "true"){
$pdf->Cell(9,4,$reg_lista['Estoque'],0,0,'R');
}
if($_GET['custo'] == "true"){
$pdf->Cell(15,4,number_format($reg_lista['custo'],0,",","."),0,0,'R');
}
if($_GET['vla'] == "true"){
$pdf->Cell(17,4,number_format($reg_lista['valor_a'],0,",","."),0,0,'R');
}
if($_GET['custo'] == "true" && $_GET['stk'] == "true"){	
$totalCusto =  $reg_lista['custo'] * $reg_lista['Estoque'];
$totalGeralCusto +=  $reg_lista['custo'] * $reg_lista['Estoque'];
$pdf->Cell(18,4,number_format($totalCusto,0,",","."),0,0,'R');
}
if($_GET['vla'] == "true" && $_GET['stk'] == "true"){	
$totalCusto =  $reg_lista['valor_a'] * $reg_lista['Estoque'];
$totalGeralValor +=  $reg_lista['valor_a'] * $reg_lista['Estoque'];
$pdf->Cell(18,4,number_format($totalCusto,0,",","."),0,0,'R');
}
$pdf->Cell(10,4,$a,0,1,'L');
//$i++;
}
$pdf->Ln(2);
$pdf->SetFont('courier', 'b', 7);
$pdf->Cell(20,3,'Total Custo:',0,0,'L');
$pdf->Cell(47,3,number_format($totalGeralCusto,0,",","."),0,1,'L');
$pdf->Cell(20,3,'Total Valor:',0,0,'L');
$pdf->Cell(47,3,number_format($totalGeralValor,0,",","."),0,1,'L');



$pdf->Output();	



?>