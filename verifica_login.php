<?
	session_start();
	
	$logado = $_SESSION['logado'];
	$id_usuario = $_SESSION['id_usuario'];
	$usuario = $_SESSION['usuario'];
	$nome_user = $_SESSION['nome_user'];
	$perfil_id = $_SESSION['perfil_id'];
	$host = $_SESSION['host'];

	if($logado != 'logado' || empty($id_usuario)){
		$msg = 'Login ainda nao efetuado';
		header("Location: index.php?msg=".$msg);
	}
?>