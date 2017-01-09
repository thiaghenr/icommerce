<?php
// Include the information needed for the connection to
// MySQL data base server. 
include "../config.php";
conexao();
//since we want to use a JSON data we should include
//encoder and decoder for JSON notation
//If you use a php >= 5 this file is not needed
include("JSON.php");
require_once("../verifica_login.php");
// create a JSON service
$json = new Services_JSON();
require_once("../biblioteca.php");
// to the url parameter are added 4 parameter
// we shuld get these parameter to construct the needed query
// for the pager



// calculate the number of rows for the query. We need this to paging the result
$result = mysql_query("SELECT COUNT(*) AS count FROM caixa_balcao ");
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['id'];

 $caixa = $_GET['caixa'];
 $usu = $_GET['usu'];
 $data_ini = converte_data('2',$_GET['data_ini']);
 $data_fim = converte_data('2',$_GET['data_fim']);  

if($caixa != '') {
$limit = 50; }
else{ $limit = 60; }


if(empty($caixa) && empty($usu) && empty($_GET['data_ini']) && empty($_GET['data_fim'])){
$SQL = "SELECT cb.*,date_format(dt_abertura, '%d/%m/%Y') AS dt_abertura, date_format(dt_fechamento, '%d/%m/%Y') AS dt_fechamento, u.nome_user,u.id_usuario  FROM caixa_balcao cb, usuario u WHERE  cb.usuario_id = u.id_usuario ORDER BY cb.id DESC limit $limit ";
$result = mysql_query( $SQL ) or die (mysql_error() .' '.$SQL);
}
else if($caixa  != '' && $usu == ''){
$limit = 300;
$SQL = "SELECT cb.*,date_format(dt_abertura, '%d/%m/%Y') AS dt_abertura, date_format(dt_fechamento, '%d/%m/%Y') AS dt_fechamento, u.nome_user,u.id_usuario  FROM caixa_balcao cb, usuario u WHERE cb.id = '$caixa' AND cb.usuario_id = u.id_usuario ORDER BY cb.id DESC limit $limit ";
$result = mysql_query( $SQL ) or die (mysql_error() .' '.$SQL);
}
else if($caixa == '' && $usu != ''){
$limit = 300;
$SQL = "SELECT cb.*,date_format(dt_abertura, '%d/%m/%Y') AS dt_abertura, date_format(dt_fechamento, '%d/%m/%Y') AS dt_fechamento, u.nome_user,u.id_usuario  FROM caixa_balcao cb, usuario u WHERE cb.usuario_id = '$usu' AND cb.usuario_id = u.id_usuario ORDER BY cb.id DESC limit $limit ";
$result = mysql_query( $SQL ) or die (mysql_error() .' '.$SQL);
}
else if(!empty($_GET['data_ini']) && !empty($_GET['data_fim'])){
$limit = 300;
$SQL = "SELECT cb.*,date_format(dt_abertura, '%d/%m/%Y') AS dt_abertura, date_format(dt_fechamento, '%d/%m/%Y') AS dt_fechamento, u.nome_user,u.id_usuario  FROM caixa_balcao cb, usuario u WHERE cb.dt_abertura BETWEEN '$data_ini' AND '$data_fim' AND cb.usuario_id = u.id_usuario ORDER BY cb.id DESC limit $limit ";
$result = mysql_query( $SQL ) or die (mysql_error() .' '.$SQL);
}

// constructing a JSON

$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    $responce->rows[$i]['id']=$row[id];
    $responce->rows[$i]['cell']=array($row[id],$row[dt_abertura],$row[dt_fechamento],$row[vl_abertura],$row[vl_fechamento],$row[vl_transferido_fin],$row[st_caixa],$row[nome_user]);
    $i++;
}
// return the formated data
echo $json->encode($responce);
?>
