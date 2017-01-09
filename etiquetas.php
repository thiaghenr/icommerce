<?php
require 'fpdf16/fpdf.php';
define('FPDF_FONTPATH', 'fpdf16/font/');

require_once("config.php");
conexao();

$busca = mysql_query("SELECT * FROM produtos where id > '281' ");

// Variaveis de Tamanho

$mesq = "4"; // Margem Esquerda (mm)
$mdir = "5"; // Margem Direita (mm)
$msup = "12"; // Margem Superior (mm)
$leti = "62"; // Largura da Etiqueta (mm)
$aeti = "40"; // Altura da Etiqueta (mm)
$ehet = "4.9"; // Espa�o horizontal entre as Etiquetas (mm)
$pdf=new FPDF('P','mm','Letter'); // Cria um arquivo novo tipo carta, na vertical.
$pdf->Open(); // inicia documento
$pdf->AddPage(); // adiciona a primeira pagina
$pdf->SetMargins('5','12,7'); // Define as margens do documento
$pdf->SetAuthor("Jonas Ferreira"); // Define o autor
$pdf->SetFont('helvetica','b',8); // Define a fonte
$pdf->SetDisplayMode('fullwidth');

$coluna = 0;
$linha = 0;
//MONTA A ARRAY PARA ETIQUETAS
while($dados = mysql_fetch_array($busca)) {
$Codigo = $dados["Codigo"];
//$pdf->SetFont('courier','',8); // Define a fonte
$Descricao = substr($dados["Descricao"],0,15);
$ref = $dados["ref"];
$valor_a = $dados["valor_a"]."   -    ".$ref;

if($linha == "10") {
$pdf->AddPage();
$linha = 0;
}

if($coluna == "2") { // Se for a terceira coluna
$coluna = 0; // $coluna volta para o valor inicial
$linha = $linha +1; // $linha � igual ela mesma +1

}

if($linha == "10") { // Se for a �ltima linha da p�gina
$pdf->AddPage(); // Adiciona uma nova p�gina
$linha = 0; // $linha volta ao seu valor inicial
}

$posicaoV = $linha*$aeti;
$posicaoH = $coluna*$leti;

if($coluna == "0") { // Se a coluna for 0
$somaH = $mesq; // Soma Horizontal � apenas a margem da esquerda inicial
} else { // Sen�o
$somaH = $mesq+$posicaoH; // Soma Horizontal � a margem inicial mais a posi��oH

}

if($linha =="0") { // Se a linha for 0
$somaV = $msup; // Soma Vertical � apenas a margem superior inicial

} else { // Sen�o
$somaV = $msup+$posicaoV; // Soma Vertical � a margem superior inicial mais a posi��oV
$pdf->SetY("40");

}

$pdf->Text($somaH,$somaV,$Codigo); // Imprime o nome da pessoa de acordo com as coordenadas
$pdf->Text($somaH,$somaV+2,$Descricao); // Imprime o endere�o da pessoa de acordo com as coordenadas
$pdf->Text($somaH,$somaV+4,$valor_a); // Imprime a localidade da pessoa de acordo com as coordenadas

//$pdf->SetY("40");

$coluna = $coluna+1;
}

$pdf->Output();
?>