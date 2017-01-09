<?php

$data = date("d-m-Y");
/*
 * CABECALHO DA PAGINA
 */

//CONFIGURACAO DA IMAGEM - IMAGEM 1
//posiciona horizontal 37mm da imagem
$pdf->SetX("37");
//gerando a imagem na pagina
//$pdf->Image("images/logo.jpg",jpg);
//Definir a fonte e o tamanho 6 para o texto da imagem
$pdf->SetFont('arial', '', 6);
//posiciona horizontal 35mm do texto da imagem
$pdf->SetX("35");
//TEXTO DO IMAGEM
//$textoImg = "BRASAO da {$empresa}";
/*
 * imprimir um texto com quebras de linhas
 * a largura 26.
 * a altura foi definida como 5 - dando um expasamento entre as linas,
 * vai depender de quanto vai precisar de espaco entre elas.
 * Para resolver o problema de acentuacao e/ou caracteres que serao
 * usados no pdf e aconselhavel usar utf8_decode() na saida do texto.
 */
$pdf->MultiCell(26, 5, utf8_decode($textoImg), 0, "L");

//TEXTO DO CABECALHO
$textoCabecalho = "iCommerce - Sistema Comercial \n";
$textoCabecalho .= "Empresa: "Carrera Repuestos" \n";
$textoCabecalho .= "Data: {$data} \n";
$textoCabecalho .= "User: {$nome_user} \n";
//posiciona verticalmente
$pdf->SetY("3");
//posiciona horizontalmente
$pdf->SetX("5");
/*
 * Desenha uma linha entre dois pontos.
 * cordenadas do ponto 1 e 2 para a linha
 */
//$pdf->Line(70, 33, 70, 23);
//Definir a fonte e o tamanho 12 para o texto do cabeCalho
$pdf->SetFont('courier', '', 7);
$pdf->MultiCell(90, 3, utf8_decode($textoCabecalho), 0, "L");
$pdf->SetY("55");
$pdf->Line(6, 16, 200, 16);
?>