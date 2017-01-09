<?php
mysql_connect("localhost", "root", "vertrigo"); 
mysql_select_db("publimar");

$selectedRows = json_decode(stripslashes($_POST['id_usuario']));
$count        = 0;		

foreach($selectedRows as $row_id)
{
	$id  = (int) $row_id;
	$sql = "DELETE FROM usuario WHERE id_usuario = %d";	
	$sql = sprintf($sql, $id);
	mysql_query($sql);
	$rows_affected = mysql_affected_rows();			
	if ($rows_affected) $count++;
}

if ($count) {
	$response = array('success'=>'true', 'del_count'=>$count);			
	echo json_encode($response);
} else {
	echo '{failure: true}';
}
?>