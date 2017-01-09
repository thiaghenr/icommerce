<?
	require_once("verifica_login.php");
	require_once("config.php");
	require_once("biblioteca.php");
	conexao();

	$operacao = $_POST['op'];
	if($operacao == 'a'){
		$sql = "SELECT * FROM caixa_balcao WHERE usuario_id = " . $id_usuario." AND st_caixa = 'a'";
		$rs = mysql_query($sql) or die (mysql_error() .' '.$sql);
		$num_rows = mysql_num_rows($rs);
		if($num_rows){
			$msg = "Caixa ja esta Aberto. Feche-o primeiro";
			header("Location: caixa.php?msg=".$msg);
		}
		else{
			$sql = "SELECT *, max(id) FROM caixa_balcao WHERE usuario_id = " . $id_usuario." AND st_caixa = 'F' GROUP BY id DESC";
			$rs = mysql_query($sql) or die (mysql_error() .' '.$sql);
			$num_rows = mysql_num_rows($rs);		
			$vl_abertura = 0.00;
			if($num_rows>0){
				$linha = mysql_fetch_array($rs);
				if($linha['st_transferencia']=='0')
					$vl_abertura = $linha['vl_fechamento'];
				else if($linha['st_transferencia']=='1')  			
					$vl_abertura = $linha['vl_transferido_fin'] - $linha['vl_fechamento'];
				$vl_anterior = $linha['vl_anterior'];
			}

			$sql = "INSERT INTO caixa_balcao (dt_abertura,vl_abertura,usuario_id,st_caixa,st_transferencia)";
			$sql.="VALUES(now(),".$vl_abertura.",".$id_usuario.","."'A','0')";
			$rs = mysql_query($sql) or die(mysql_error().''.$sql);
			header("Location: caixa.php");
		}
	}
	else if($operacao == 'f'){
		$sql_caixa = "SELECT * FROM caixa_balcao WHERE usuario_id = " . $id_usuario." AND st_caixa = 'A'";
		$rs = mysql_query($sql_caixa) or die (mysql_error() .' '.$sql);
		$num_rows = mysql_num_rows($rs);
		if($num_rows){
			$linha_caixa = mysql_fetch_array($rs);
			$id_caixa = $linha_caixa['id'];
			$transferido = $linha_caixa['vl_transferido_fin'];
			
			$sql_lancamentos = "SELECT * FROM lancamento_caixa_balcao WHERE caixa_id =".$id_caixa;
			$rs = mysql_query($sql_lancamentos);
			$total_entradas=0.00;
			$total_saidas=0.00;
			$total_creditos=0.00;
			$total_devolvidos_cl=0.00;
			while($linha_lancamentos=mysql_fetch_array($rs)){
				$receita_id = $linha_lancamentos['receita_id'];
				$vl_pago = $linha_lancamentos['vl_pago'];
				if($receita_id==1){
					$total_entradas+=$vl_pago;	
				}
				else if($receita_id==2){
					$total_saidas+=$vl_pago;	
				}
				else if($receita_id==6){
					$total_creditos+=$vl_pago;	
				}
				else if($receita_id==3){
					$total_devolvidos_cl+=$vl_pago;
			    }
			}
			$saidas_geral = $total_saidas + $transferido;
			$dt_abertura = $linha_caixa['dt_abertura'];
			$saldo_abertura = $linha_caixa['vl_abertura'];
			$saldo_fechamento = ($saldo_abertura+$total_entradas+$total_creditos) - $saidas_geral;
			
			require_once("caixa_fechamento.php");
		}
		else{
			$msg = "Não há caixa aberto para este usuario";
			header("Location: caixa.php?msg=".$msg);				
		}
	}
	else if($operacao == 'cf'){
		$sql_caixa = "SELECT * FROM caixa_balcao WHERE usuario_id = " . $id_usuario." AND st_caixa = 'A'";
		$rs = mysql_query($sql_caixa) or die (mysql_error() .' '.$sql);
		$num_rows = mysql_num_rows($rs);
		if($num_rows){
			$linha_caixa = mysql_fetch_array($rs);
			$id_caixa = $linha_caixa['id'];

			$vl_fechamento = $_POST['vl_fechamento'];
			$vl_mov_entrada = $_POST['vl_mov_entrada'];
			$vl_mov_saida = $_POST['vl_mov_saida'];
			
			$sql = "UPDATE caixa_balcao SET dt_fechamento=now(), vl_fechamento=".$vl_fechamento;
			$sql.= ", vl_mov_entrada=".$vl_mov_entrada.", vl_mov_saida=".$vl_mov_saida.", st_caixa='F' WHERE id=".$id_caixa;
			
			$rs = mysql_query($sql) or die (mysql_error().'-'.$sql);
			header('Location: caixa.php');
		}
	}
?>