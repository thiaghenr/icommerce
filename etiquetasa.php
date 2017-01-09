<?php
require 'fpdf16/fpdf.php';
define('FPDF_FONTPATH', 'fpdf16/font/');

require_once("config.php");
conexao();



// Variaveis de Tamanho

$pdf = new FPDF("P", "mm", "A4");
//Define as margens esquerda, superior e direita.
$pdf->SetMargins(5, 5, 30);
//define a fonte a ser usada, estilo e tamanho
$pdf->SetFont('courier', 'b', 6);
//define o titulo
$pdf->SetTitle("Gerar PDF com FPDF");
//assunto
$pdf->SetSubject("Gerar PDF com FPDF");
// posicao vertical no caso -1.. e o limite da margem
$pdf->SetY("-1");

$busca = mysql_query("SELECT * FROM produtos where id > '283' ");

$x = 0;

while($dados = mysql_fetch_array($busca)) {
$Codigo = $dados["Codigo"];
$Descricao = $dados["Descricao"];
$ref = $dados["ref"];
$vlref = $dados["valor_a"]."      -      ".$ref;

if($x % 2 == 0){
$y = "par";
}
else{
$y = "impar";
}

if($y == "par"){
$inicio = 60;
$recuo = 0;
}
else{
$inicio = 0;
$recuo = 0;
}


$pdf->SetX($inicio);
$pdf->Cell(8,2,$Codigo,0,1,'L');
//$pdf->SetY($recuo);
$pdf->SetX($inicio);
$pdf->Cell(8,2,substr($Descricao,0,15),0,1,'L');
//$pdf->SetY($recuo);
$pdf->SetX($inicio);
$pdf->Cell(8,2,$vlref,0,1,'L');
//$pdf->SetY($recuo);
//$pdf->Cell($inicio,$inicio,$inicio,0,1,'L');


//$pdf->SetY('40');
//$pdf->SetY("35");
$x++;

}


$pdf->Output();



?>