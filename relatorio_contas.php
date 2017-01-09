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

$dtini = $_GET['dtini'];
$dtfim = $_GET['dtfim'];

//$dtini = date('d/m/Y', strtotime($dtini));


//escreve o texto
//uso: Cell(largura, altura, conteudo, borda, quebra de linha, alinhamento (L = esquerdo, R = direito, C = centralizado)
//$this->SetY(12);
$this->SetFont('courier','',14);
$this->Ln(3);
$this->Cell(0,5,"HPA",0,1,'C');
$this->Ln(3);
$this->Cell(172,0,'',1,1,'L');
$this->Ln(2);


$this->SetFont('courier','',9);
$this->Cell(172,4,'Informe: Lanzamientos de cuentas por periodo',0,1,'L');
$this->Cell(16,4,"Usuario:",0,0,'L');
$this->Cell(0,4,$_SESSION['nome'],0,1,'L');
$this->Cell(13,4,"Fecha:",0,0,'L');
$this->Cell(30,4,date("d-m-Y"),0,1,'L');
$this->Cell(27,4,"Periodo:",0,0,'L');
if($dtini == "01/01/1970"){
$this->Cell(0,4,'25/11/2011',0,0,'L');
}
else{
$this->Cell(22,4,converte_data('1',$dtini),0,0,'L');
}
$this->Cell(13,4,"hasta",0,0,'L');
$this->Cell(0,4,converte_data('1',$dtfim),0,1,'L');
$this->Ln(9);
$this->SetY("37");
$this->SetX("20");
$this->Cell(40,3,"Plan Cuenta",0,0,'L');
$this->Cell(28,3,"Documiento",0,0,'L');
$this->Cell(23,3,"Fecha",0,0,'L');
$this->Cell(18,3,"Usuario",0,0,'L');
$this->Cell(40,3,"Proveedor",0,0,'R');
$this->Cell(23,3,"Valor",0,1,'R');
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

$this->Cell(0,10,'Pagina '.$this->PageNo().' ',0,0,'C');

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
$pdf->SetFont('courier','',7);

//posiciona verticalmente 21mm
//$pdf->SetY("21");
//posiciona horizontalmente 30mm
//$pdf->SetX("10");
function addCaracter($var, $caracter, $lim){
	$tamanho = strlen($var);
	if($tamanho > $lim){	
		$quebra = $tamanho/$lim;
		$ini = 0;
		$fim = $lim;
	
		for($i=0; $i <= intval($quebra); $i++){
			if($i == intval($quebra))
				$nova.= substr($var, $ini, $lim);
			else
				$nova.= substr($var, $ini, $lim).$caracter;
		
			$ini = $fim;
			$fim = $fim+$lim;
		}
	
		return $nova;
		
	} else {
		return $var;
	}

}

$contaid = $_GET['idnode'];
$dtini = $_GET['dtini'];
$dtfim = $_GET['dtfim'];

  $sql = "SELECT plancodigo,plancodigopai,plantipo FROM planocontas WHERE idplanocontas = '$contaid' ";
	$exe = mysql_query($sql);
	$reg = mysql_fetch_array($exe, MYSQL_ASSOC);
	$inicio = substr($reg['plancodigo'],0,2);
	$meio = substr($reg['plancodigo'],2,9);
	$fim = substr($reg['plancodigo'],11,6);
	$codigo = str_replace('.','',$reg['plancodigo']);
	$plantipo = $reg['plantipo'];

	$meio = str_replace('.','',$meio);
	$fim = str_replace('.','',$fim);
	
	$meio = rtrim($meio, "0");
	$fim = rtrim($fim, "0");
	
	$codigo = $meio.$fim;
	$codigo = addCaracter($codigo, ".", "2");
	$codigo = $inicio.$codigo;
	
	if($plantipo == "A"){
		$sql_lancamentos = "SELECT l.*, u.nome_user, date_format(l.dt_lanc_desp, '%d/%m/%Y')AS data, e.nome FROM entidades e, lanc_contas l";
		$sql_lancamentos .=	" LEFT JOIN usuario u ON u.id_usuario = l.usuario_id ";
		$sql_lancamentos .=	" WHERE l.dt_lanc_desp BETWEEN '$dtini' AND '$dtfim 23:59:59.999' AND l.valor != '0' ";
		$sql_lancamentos .=	" AND e.controle = l.entidade_id AND l.receita_id = '2' ";
		if($contaid != ""){
		$sql_lancamentos .= " AND l.plano_id = '$contaid' ";
		}
		$sql_lancamentos .= " ORDER BY  l.id_lanc_despesa ASC ";
	}
	if($plantipo == "S"){
		$sql_lancamentos = "SELECT l.*, u.nome_user, date_format(l.dt_lanc_desp, '%d/%m/%Y')AS data, e.nome FROM entidades e, lanc_contas l";
		$sql_lancamentos .=	" LEFT JOIN usuario u ON u.id_usuario = l.usuario_id ";
		$sql_lancamentos .=	" WHERE l.dt_lanc_desp BETWEEN '$dtini' AND '$dtfim 23:59:59.999' AND l.valor != '0' ";
		$sql_lancamentos .=	" AND e.controle = l.entidade_id AND l.receita_id = '2' ";
		if($contaid != ""){
		$sql_lancamentos .= " AND l.plan_codigo LIKE '$codigo%' ";
		}
		$sql_lancamentos .= " ORDER BY  l.id_lanc_despesa ASC ";
	}
		$exe_lancamentos = mysql_query($sql_lancamentos) or die(mysql_error().'-'.$sql_lancamentos);
		$total_geral = mysql_num_rows($exe_lancamentos);
		$arr = array();
		while($obj = mysql_fetch_array($exe_lancamentos, MYSQL_ASSOC)){
	
		$desc_desp = $obj['desc_desp'];
		$documento = $obj['documento'];
		$data = $obj['data'];
		$nome_user = $obj['nome_user'];
		$nome = $obj['nome'];
		$valor =  $obj['valor'];
		$saldos +=  $obj['valor'];

	
//$pdf->Cell(15,4,$reg_lista['Codigo'],0,0,'L',$i);
$pdf->Cell(40,4,substr($desc_desp,0,27),0,0,'L');
$pdf->Cell(28,4,$documento,0,0,'L');
$pdf->Cell(23,4,$data,0,0,'L');
$pdf->Cell(18,4,substr($nome_user,0,8),0,0,'L');
$pdf->Cell(40,4,substr($nome,0,28),0,0,'R');
$pdf->Cell(23,4,$valor,0,1,'R');
//$pdf->Cell(172,0,'',1,1,'L');
}

$pdf->Ln(5);
$pdf->SetFont('courier','',7);
$pdf->Cell(142,4,'TOTAL',1,0,'R');
$pdf->Cell(30,4,number_format($saldos,2,",","."),1,0,'R');

$pdf->Output();	

?>