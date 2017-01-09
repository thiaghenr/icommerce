<?
    ini_set('display_errors', 1);
    //require_once("verifica_login.php");
    require_once ("config.php");

    require_once("biblioteca.php");
		
    $pedido_id = $_POST['id_pedido'];
    if($pedido_id == ""){
		$pedido_id = $_GET['id_pedido'];
	}

	$hostname = ($_SERVER['REMOTE_ADDR']);

     function createCabecalhoPedido($pedido_id){
        //SQL PARA PEDIDO
        $sql_pedido = "SELECT p.*,c.ruc,c.telefone1 FROM pedido p, entidades c WHERE p.id = '$pedido_id' AND p.controle_cli = c.controle";
      	$exe_pedido = mysql_query($sql_pedido);
      	$num_pedido = mysql_num_rows($exe_pedido);

        if($num_pedido!=1){
            echo "<script type='text/javascript'>alert('Pedido Invalido');window.close()</script>";
            exit;
        }

      	$reg_pedido = mysql_fetch_array($exe_pedido, MYSQL_ASSOC);
        //$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
      	// Pegando data e hora.
      	$data2 = $reg_pedido['data_car'];
        $nome_cli = $reg_pedido['nome_cli'];
		$ruc = $reg_pedido['ruc'];
		$fone = $reg_pedido['telefonecom'];
		if($reg_pedido['forma_pagamento_id'] == '1'){
		$_SESSION['fpago'] = "AL CONTADO";
		}
		else{
		$_SESSION['fpago'] = "CREDITO";
		}
        $usuario_id = $reg_pedido['vendedor_id'];
      	$hora2 = $reg_pedido['data_car'];
		$_SESSION['desconto_imp'] = round($reg_pedido['desconto'],2);

      	//Formatando data e hora para formatos Brasileiros.
      	$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
      	$novahora = substr($hora2,11,2) . ":" .substr($hora2,14,2) . " min";

$cabecalho_nota = "
 =============================================================================
  ".str_pad("WINGS",30," ",STR_PAD_RIGHT)."Fecha:".str_pad($novadata,24," ",STR_PAD_RIGHT)."Hr: ".str_pad($novahora,12," ",STR_PAD_RIGHT)."
  ".str_pad("Presupuesto:",6," ",STR_PAD_RIGHT)." ".trim($pedido_id)."".str_pad("",20," ",STR_PAD_LEFT)." "."RUC:".str_pad($ruc,4," ",STR_PAD_RIGHT)."
  ".str_pad("Nombre:",5," ",STR_PAD_RIGHT)." ".trim($nome_cli)."".str_pad("",40," ",STR_PAD_RIGHT)."
  ".str_pad("Vendedor:",10," ",STR_PAD_RIGHT)." ".trim($usuario_id)."".str_pad("Telefono:",24," ",STR_PAD_LEFT)."".str_pad($fone,15," ",STR_PAD_LEFT)."
 =============================================================================
 |".str_pad("Cant",5," ",STR_PAD_RIGHT)."|".str_pad("Descripcion",33," ",STR_PAD_RIGHT)."|".str_pad('Cod.',11," ",STR_PAD_LEFT)."|".str_pad('Valor',11," ",STR_PAD_LEFT)."|".str_pad('Total',11," ",STR_PAD_LEFT)."|
 -----------------------------------------------------------------------------";
 return $cabecalho_nota;
    }

    function createCorpoItensPedido($pedido_id,&$inicio,$limitNotas,$totalValorNota){
       //SQL PARA ITENS DO PEDIDO
      $sql_itens_pedido = "SELECT * FROM itens_pedido WHERE id_pedido = '$pedido_id' LIMIT $inicio,$limitNotas";
      $exe_itens_pedido = mysql_query($sql_itens_pedido) or die (mysql_error().'-'.$sql_itens_pedido);
      $num_itens_pedido = mysql_num_rows($exe_itens_pedido);
      $inicio+= $num_itens_pedido;
	
	$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 1 AND moeda.id = 1 GROUP BY cm.id DESC limit 0,1 ";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $cambio_dolar = $linha_cambio['vl_cambio'];
	
	$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 2 AND moeda.id = 2 GROUP BY cm.id DESC limit 0,1 ";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $cambio_real = $linha_cambio['vl_cambio'];
	
$corpo_nota = "";

      while ($reg_itens_pedido = mysql_fetch_array($exe_itens_pedido, MYSQL_ASSOC)) {
              $total_carrinho += ($reg_itens_pedido['prvenda']*$reg_itens_pedido['qtd_produto']);
  			$subtotal += $reg_itens_pedido['prvenda']*$reg_itens_pedido['qtd_produto'] ;
			$subtotal_iten = $reg_itens_pedido['prvenda']*$reg_itens_pedido['qtd_produto'] ;

$corpo_nota.= "
 |".str_pad(round($reg_itens_pedido['qtd_produto'],0),5," ",STR_PAD_RIGHT)."|".str_pad(substr($reg_itens_pedido['descricao_prod'],0,32),33," ",STR_PAD_RIGHT)."|".
 str_pad(substr($reg_itens_pedido['id'],0,11),11," ",STR_PAD_LEFT)."|".str_pad(($reg_itens_pedido['prvenda']),11," ",STR_PAD_LEFT).
 "|".str_pad(guarani($subtotal_iten),11," ",STR_PAD_LEFT)."|";
      }
	  $total_carrinho = $total_carrinho - $_SESSION['desconto_imp'];

      //CONTROLE DE&nbs
$MAX_ITENS_NOTA = 15;
if($num_itens_pedido < $MAX_ITENS_NOTA){
$total_completar = $MAX_ITENS_NOTA - $num_itens_pedido;
while($total_completar>0){
$corpo_nota.="\n"
 .str_pad("|",2," ",STR_PAD_LEFT)."".str_pad("|",6," ",STR_PAD_LEFT)."".str_pad("|",34," ",STR_PAD_LEFT).
 "".str_pad("|",12," ",STR_PAD_LEFT)."".str_pad("|",12," ",STR_PAD_LEFT)."".str_pad("|",12," ",STR_PAD_LEFT);
$total_completar--;
          }
      }

$rodape_nota = "
 =============================================================================
   GRACIAS POR LA PREFERENCIA                           ".str_pad("SubTotal:",3," ",STR_PAD_RIGHT)." ".trim(guarani($subtotal))."   
   ".str_pad("Dolares:",3," ",STR_PAD_LEFT)." ".trim(round($subtotal/$cambio_dolar,2))."  ".str_pad("Reales:",3," ",STR_PAD_LEFT)." ".trim(round($subtotal/$cambio_real,2))."                         ".str_pad("Descuento:",3," ",STR_PAD_RIGHT)." ".trim(guarani($_SESSION['desconto_imp']))."
   SAN CRISTOBAL, ALTO PARANA                          ".str_pad("Guaranies:",3," ",STR_PAD_RIGHT)." ".trim(guarani($total_carrinho))."
   Forma de Pago: ".$_SESSION['fpago']."    -   VERIFIQUE SU MERCADERIA
 =============================================================================";
 
 if(20 > 15){
$linhas = "



";
}
else{
$linhas = "













";
}			
 
return $corpo_nota."".$rodape_nota."".$linhas;
    }

    function getTotalItensNota($pedido_id){

        $sql_tot_itens_pedido = "SELECT * FROM itens_pedido WHERE id_pedido = '$pedido_id'";
        $exe_tot_itens_pedido = mysql_query($sql_tot_itens_pedido) or die (mysql_error().'-'.$sql_tot_itens_pedido);
        $num_tot_itens_pedido = mysql_num_rows($exe_tot_itens_pedido);
        return $num_tot_itens_pedido;

    }

    function createNota($pedido_id){
        $totalItensNota = getTotalItensNota($pedido_id);
        $totalValorNota =  totalValorNota($pedido_id);
        $MAX_ITENS_NOTA = 15;

        $totalNotas = 0;
        $limitNotas = $MAX_ITENS_NOTA;

        while($totalNotas < $totalItensNota){
          //  mt_srand(make_seed());
            $randval = mt_rand();
            $cabecalho_nota = createCabecalhoPedido($pedido_id);
            $corpo_nota = createCorpoItensPedido($pedido_id,&$totalNotas,$limitNotas,$totalValorNota);

            //$name_file = "print_pedido_".microtime()."".$randval.".txt";
			$name_file = $_SERVER['REMOTE_ADDR']."_".microtime()."".$randval.".txt";
			
            $name_file = str_replace(" ","",$name_file);
            $fp = fopen($name_file,"w+");

            $conteudo_nota = $cabecalho_nota."".$corpo_nota."".$cabecalho_nota."".$corpo_nota;
            fwrite($fp,$conteudo_nota);

            fclose($fp);
            $limitNotas+=$MAX_ITENS_NOTA;
			
		    exec("lpr -P SCX-3400 $name_file");
			

			//system("print $name_file");

         //   echo "<script language='javascript'>window.open('$name_file','_blank')</script>"; 
        }
    }

function totalValorNota($pedido_id){
$sql = "";
$totalNota = "";

return  $totalNota;
    }
    conexao();
    createNota($pedido_id);
	
//	echo 'Caso desejar imprimir novamente pressione F5 ';
	
	
?>
<p>&nbsp;</p>
<script language="javascript">
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='';
 }
 else if(lugar=='Nueva'){
  window.location.href='pagare.php?pedido=<?=$pedido_id?>';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>
<!--
<table width="100%" border="0">
  <tr>
    <td width="27%"><input name="button" type="button" onclick="window.close()" value="Cerrar" /></td>
    <td width="60%"><a href="pagare.php">
      <input type="button" value="Imprimir Pagare" name="LINK12" onclick="navegacao('Nueva')" />
    </a></td>
    <td width="13%">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
-->