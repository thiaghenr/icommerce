<?
	session_start();
	$acao = $_GET['acao'];
	if($acao == 'login'){
		require_once("config.php");
		conexao();
		$usuario = stripslashes($_POST['usuario']);
		$senha = sha1(stripslashes($_POST['senha']));	
		$sql = "SELECT * FROM usuario WHERE usuario = '$usuario' AND senha = '$senha'";
		$rs = mysql_query($sql) or die (mysql_error() .'-'.$sql);
		$num_rows = mysql_num_rows($rs);
		if($num_rows >= 1){
			$linha = mysql_fetch_array($rs);
			$_SESSION['logado'] = 'logado';
			$_SESSION['id_usuario'] = $linha['id_usuario'];
			$_SESSION['usuario'] = $linha['usuario'];
			$_SESSION['nome_user'] = $linha['nome_user'];
			$_SESSION['perfil_id'] = $linha['perfil_id'];
			header("Location: principal.php");
		}
		else{
			$msg = "Login ou senha invalida";
			header("Location: index.php?msg=".$msg);
		}
	}
	else if($acao == 'logoff'){
		unset($_SESSION['logado']);
		unset($_SESSION['id_usuario']);
		unset($_SESSION['nm_usuario']);
		session_destroy();
		header("Location: index.php");
	}
	else
		header("Location: index.php");
	
?>