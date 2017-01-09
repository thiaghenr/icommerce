<?
    //require_once("verifica_login.php");
    require_once ("config.php");

    require_once("biblioteca.php");
		
   $pedido_id = $_GET['id_pedido'];
//   $pedido_id = 12;

     function createCabecalhoPedido($pedido_id){
        //SQL PARA PEDIDO
        $sql_pedido = "SELECT cs.*, c.* FROM consignacao cs, entidades c WHERE cs.csg_idconsignacaoo = '$pedido_id' 
		AND cs.csg_entidadeid = c.controle ";
      	$exe_pedido = mysql_query($sql_pedido);
      	$num_pedido = mysql_num_rows($exe_pedido);

        if($num_pedido!=1){
            echo "<script type='text/javascript'>alert('Entrada Invalida');window.close()</script>";
            exit;
        }
		
		$reg_pedido = mysql_fetch_array($exe_pedido, MYSQL_ASSOC);
        //$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
      	// Pegando data e hora.
      	$data2 = $reg_pedido['csg_data'];
        $nome_cli = $reg_pedido['csg_entidadenome'];
        $usuario_id = $reg_pedido['csg_usuarioid'];
      	$hora2 = $reg_pedido['csg_data'];
		$ruc = $reg_pedido['ruc'];
		$endereco = $reg_pedido['endereco'];
		$fone = $reg_pedido['telefone1'];
		$_SESSION['frete'] = $reg_pedido['frete'];
		
		$movimento = $reg_pedido['movimento'];
		
		
      	//Formatando data e hora para formatos Brasileiros.
      	$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
      	$novahora = substr($hora2,11,2) . ":" .substr($hora2,14,2) . " min";

$cabecalho_nota = "
 ===============================================================================
   ".str_pad("WINGS    -    Movimiento de ".$movimento." por Consignacion",7," ",STR_PAD_RIGHT)."
   ".str_pad("Pedido:",7," ",STR_PAD_RIGHT)." ".trim($pedido_id)." ".str_pad("Fecha:",30," ",STR_PAD_LEFT)." ".str_pad($novadata,10," ",STR_PAD_RIGHT)."       Hr: ".str_pad($novahora,12," ",STR_PAD_RIGHT)."
   ".str_pad("Cliente:",6," ",STR_PAD_RIGHT)." ".str_pad("$nome_cli",30," ",STR_PAD_RIGHT)."".str_pad("",38," ",STR_PAD_RIGHT)."
   ".str_pad("Direccion:",6," ",STR_PAD_RIGHT)." ".str_pad("$endereco",30," ",STR_PAD_RIGHT)."".str_pad("",3," ",STR_PAD_RIGHT)." 
   ".str_pad("Ruc:",6," ",STR_PAD_RIGHT)." ".str_pad("$ruc",30," ",STR_PAD_RIGHT)."".str_pad("Fone:",5," ",STR_PAD_RIGHT)." ".trim($fone)."
 ===============================================================================
 |".str_pad("Cod",8," ",STR_PAD_RIGHT)."|".str_pad("Descripcion",33," ",STR_PAD_RIGHT)."|".str_pad('Cant',10," ",STR_PAD_LEFT)."|".str_pad('Valor',11," ",STR_PAD_LEFT)."|".str_pad('Total',11," ",STR_PAD_LEFT)."|
 -------------------------------------------------------------------------------";
 return $cabecalho_nota;
    }

    function createCorpoItensPedido($pedido_id,&$inicio,$limitNotas,$totalValorNota){
       //SQL PARA ITENS DO PEDIDO
      $sql_itens_pedido = "SELECT it.* FROM itens_consig it, consignacao p WHERE it.itcsg_consigid = '$pedido_id' AND p.csg_idconsignacao = it.itcsg_consigid LIMIT $inicio,$limitNotas";
      $exe_itens_pedido = mysql_query($sql_itens_pedido) or die (mysql_error().'-'.$sql_itens_pedido);
      $num_itens_pedido = mysql_num_rows($exe_itens_pedido);

      $inicio+= $num_itens_pedido;
		
$corpo_nota = "";

	$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 1 AND moeda.id = 1 GROUP BY cm.id DESC limit 0,1 ";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];

      while ($reg_itens_pedido = mysql_fetch_array($exe_itens_pedido, MYSQL_ASSOC)) {
              $total_carrinho += ($reg_itens_pedido['prvenda']*$reg_itens_pedido['qtd_produto']);
  			$subtotal = $reg_itens_pedido['prvenda']*$reg_itens_pedido['qtd_produto'] ;
			$dolar = $total_carrinho / $vl_cambio_guarani;
			
			if ( $reg_itens_pedido['forma_pagamento_id'] != 1){
				$forma = 'CREDITO';
				}
		else {
				$forma = 'CONTADO';
				}
    $desconto = $reg_itens_pedido['desconto'];
			
$corpo_nota.= "
 |".str_pad(substr($reg_itens_pedido['referencia_prod'],0,12),8," ",STR_PAD_RIGHT)."|".str_pad(substr($reg_itens_pedido['descricao_prod'],0,32),33," ",STR_PAD_RIGHT)."|".
 str_pad(($reg_itens_pedido['qtd_produto']),10," ",STR_PAD_LEFT)."|".str_pad(number_format($reg_itens_pedido['prvenda'],0,",","."),11," ",STR_PAD_LEFT).
 "|".str_pad(number_format($subtotal,0,"'","."),11," ",STR_PAD_LEFT)."|";
      }

      //CONTROLE DE&nbs
$MAX_ITENS_NOTA = 15;
if($num_itens_pedido < $MAX_ITENS_NOTA){
$total_completar = $MAX_ITENS_NOTA - $num_itens_pedido;
while($total_completar>0){
$corpo_nota.="\n"
 .str_pad("|",2," ",STR_PAD_LEFT)."".str_pad("|",9," ",STR_PAD_LEFT)."".str_pad("|",34," ",STR_PAD_LEFT).
 "".str_pad("|",11," ",STR_PAD_LEFT)."".str_pad("|",12," ",STR_PAD_LEFT)."".str_pad("|",12," ",STR_PAD_LEFT);
$total_completar--;
          }
      }
$percentual = 0.00;	  
$percentual = ($_SESSION['frete'] / 100) ; 
$valor_frete = ($total_carrinho * $percentual); 
number_format($valor_frete,3);
$total = $total_carrinho - $desconto;
$rodape_nota = "
 ===============================================================================
    ".str_pad("GRACIAS POR LA PREFERENCIA",35," ",STR_PAD_RIGHT)." ".str_pad(" ",2," ",STR_PAD_RIGHT)." ".trim(guarani(" ",2,".","."))."  ".str_pad("Subtotal: GR$",24," ",STR_PAD_LEFT)." ".str_pad(number_format("$total_carrinho",0,",","."),9," ",STR_PAD_LEFT)."
    *** CONTROL INTERNO *** ".str_pad("Descuento: GR$",41," ",STR_PAD_LEFT)." ".str_pad(number_format("$desconto",0,",","."),9," ",STR_PAD_LEFT)."
    FONE:                              ".str_pad("TOTAL: GR$",30," ",STR_PAD_LEFT)." ".str_pad(number_format("$total",0,",","."),9," ",STR_PAD_LEFT)."
	                                
 












";
return $corpo_nota."".$rodape_nota;
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
            $corpo_nota = createCorpoItensPedido($pedido_id,$totalNotas,$limitNotas,$totalValorNota);

            //$name_file = "print_pedido_".microtime()."".$randval.".txt";
			$name_file = $_SERVER['REMOTE_ADDR']."_".microtime()."".$randval.".txt";
			
            $name_file = str_replace(" ","",$name_file);
            $fp = fopen($name_file,"w+");

            $conteudo_nota = $cabecalho_nota."".$corpo_nota;
            fwrite($fp,$conteudo_nota);

            fclose($fp);
            $limitNotas+=$MAX_ITENS_NOTA;
	    //	exec("lpr -P epson $name_file");
			
		//system("net use LPT1  \\192.168.0.102\epson");	
		system("print $name_file");

         echo "<script language='javascript'>window.open('$name_file','_blank')</script>";  
        }
    }

function totalValorNota($pedido_id){
$sql = "";
$totalNota = "";

return  $totalNota;
    }
    conexao();
    createNota($pedido_id);
	
	echo 'Caso desejar imprimir novamente pressione F5';
	
	
?>
<p>&nbsp;</p>
<p>
  <input name="button" type="button" onclick="window.close()" value="Cerrar" />
</p>