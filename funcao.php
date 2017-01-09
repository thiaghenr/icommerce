<?php



function extenso($valor = 0, $maiusculas = false) { 

$singular = array("centavo", "guarani", "mil", "millon", "billon", "trillon", "quatrillon"); 
$plural = array("centavos", "guaranies", "mil", "millones", "billnes", "trillones", 
"quatrillones"); 

$c = array("", "cein", "doscientos", "trescientos", "quatrocientos", 
"quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos"); 
$d = array("", "diez", "veinte", "treinta", "cuarenta", "cincuenta", 
"sesenta", "setenta", "ochenta", "noventa"); 
$d10 = array("diez", "once", "doce", "trece", "catorce", "quince", 
"dieciseis", "diecisiete", "dieciocho", "diecinueve"); 
$u = array("", "uno", "dos", "tres", "cuatro", "cinco", "seis", 
"siete", "ocho", "nueve"); 

$z = 0; 
$rt = "";

$valor = number_format($valor, 2, ".", "."); 
$inteiro = explode(".", $valor); 
for($i=0;$i<count($inteiro);$i++) 
for($ii=strlen($inteiro[$i]);$ii<3;$ii++) 
$inteiro[$i] = "0".$inteiro[$i]; 

$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2); 
for ($i=0;$i<count($inteiro);$i++) { 
$valor = $inteiro[$i]; 
$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]]; 
$rd = ($valor[1] < 2) ? "" : $d[$valor[1]]; 
$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : ""; 

$r = $rc.(($rc && ($rd || $ru)) ? " y " : "").$rd.(($rd && 
$ru) ? " y " : "").$ru; 
$t = count($inteiro)-1-$i; 
$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : ""; 
if ($valor == "000")$z++; elseif ($z > 0) $z--; 
if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && 
($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? " " : " y ") : " ") . $r; 
} 

if(!$maiusculas){ 
return($rt ? $rt : "zero"); 
} else { 

if ($rt) $rt=ereg_replace(" Y "," y ",ucwords($rt));
return (($rt) ? ($rt) : "Zero"); 
} 

} 

$valor = 112344;
$dim = extenso($valor);
$dim = ereg_replace(" E "," e ",ucwords($dim));

$valor = number_format($valor, 2, ",", ".");

//echo "R$ $valor 
//$dim";

?>