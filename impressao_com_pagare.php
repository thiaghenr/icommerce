<?
    //require_once("verifica_login.php");
    require_once ("config.php");

    require_once("biblioteca.php");
		
    //$pedido_id = $_GET['id_pedido'];
    $pedido_id = 14126;

	$hostname = ($_SERVER['REMOTE_ADDR']);
  
	echo $hostname;


     function createCabecalhoPedido($pedido_id){
        //SQL PARA PEDIDO
        $sql_pedido = "SELECT p.*, p.nome_cli,cl.telefone1,cl.ruc,cl.endereco,cl.nome FROM pedido p, clientes cl WHERE p.id = '$pedido_id' AND p.controle_cli = cl.controle ";
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
        $nome_cli = $reg_pedido['nome'];
		$_SESSION['nome_cli'] = $nome_cli;
		$_SESSION['endereco'] = $reg_pedido['endereco'];
		$_SESSION['telefone1']= $reg_pedido['telefone1'];
		$_SESSION['ruc']= $reg_pedido['ruc'];
        $usuario_id = $reg_pedido['usuario_id'];
      	$hora2 = $reg_pedido['data_car'];

      	//Formatando data e hora para formatos Brasileiros.
      	$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
      	$novahora = substr($hora2,11,2) . ":" .substr($hora2,14,2) . " min";
		
		    $_SESSION['dia'] = substr($data2,8,2) ; //. "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$_SESSION['mes'] = substr($data2,5,2) ;
			$_SESSION['ano'] = substr($data2,0,4) ;
			
			if ($_SESSION['dia'] == '01') {
			$_SESSION['mes'] = " Enero de";}
			else if ($_SESSION['mes'] == '02' ){
			$_SESSION['mes'] = "Febrero de";}
			else if ($_SESSION['mes'] == '03' ){
			$_SESSION['mes'] = "marzo de";}
			else if ($_SESSION['mes'] == '04' ){
			$_SESSION['mes'] = "Abril de";}
			else if ($_SESSION['mes'] == '05' ){
			$_SESSION['mes'] = "Mayo de";}
			else if ($_SESSION['mes'] == '06' ){
			$_SESSION['mes'] = "Junio de";}
			else if ($_SESSION['mes'] == '07' ){
			$_SESSION['mes'] = "Julio de";}
			else if ($_SESSION['mes'] == '08' ){
			$_SESSION['mes'] = "Agosto de";}
			else if ($_SESSION['mes'] == '09' ){
			$_SESSION['mes'] = "Septiembre de";}
			else if ($_SESSION['mes'] == '10' ){
			$_SESSION['mes'] = "Octubre de";}
			else if ($_SESSION['mes'] == '11' ){
			$_SESSION['mes'] = "Noviembre de";}
			else if ($_SESSION['mes'] == '12' ){
			$_SESSION['mes'] = "Diciembre de";}
			
			$data_vence = $data2;
			$data_vence = strftime("%Y-%m-%d", strtotime(" +30 days")); // Hoje mais 30 dias

			$_SESSION['diab'] = substr($data_vence,8,2) ; //. "/" .substr($data_vence,5,2) . "/" . substr($data_vence,0,4);
			$_SESSION['mesb'] = substr($data_vence,5,2) ;
			$_SESSION['anob'] = substr($data_vence,0,4) ;
			
			if ($_SESSION['mesb'] == '01') {
			$_SESSION['mesb'] = " Enero de";}
			else if ($_SESSION['mesb'] == '02' ){
			$_SESSION['mesb'] = "Febrero de";}
			else if ($_SESSION['mesb'] == '03' ){
			$_SESSION['mesb'] = "Marzo de";}
			else if ($_SESSION['mesb'] == '04' ){
			$_SESSION['mesb'] = "Abril de";}
			else if ($_SESSION['mesb'] == '05' ){
			$_SESSION['mesb'] = "Mayo de";}
			else if ($_SESSION['mesb'] == '06' ){
			$_SESSION['mesb'] = "Junio de";}
			else if ($_SESSION['mesb'] == '07' ){
			$_SESSION['mesb'] = "Julio de";}
			else if ($_SESSION['mesb'] == '08' ){
			$_SESSION['mesb'] = "Agosto de";}
			else if ($_SESSION['mesb'] == '09' ){
			$_SESSION['mesb'] = "Septiembre de";}
			else if ($_SESSION['mesb'] == '10' ){
			$_SESSION['mesb'] = "Octubre de";}
			else if ($_SESSION['mesb'] == '11' ){
			$_SESSION['mesb'] = "Noviembre de";}
			else if ($_SESSION['mesb'] == '12' ){
			$mesb = "Diciembre  de";}

$cabecalho_nota = "
 ===============================================================================
  ".str_pad("WINGS",30," ",STR_PAD_RIGHT)."Fecha:".str_pad($novadata,24," ",STR_PAD_RIGHT)."Hr: ".str_pad($novahora,12," ",STR_PAD_RIGHT)."
  ".str_pad("Pedido:",6," ",STR_PAD_RIGHT)." ".trim($pedido_id)."".str_pad("",50," ",STR_PAD_RIGHT)."
  ".str_pad("Nombre:",5," ",STR_PAD_RIGHT)." ".trim($nome_cli)."".str_pad("",40," ",STR_PAD_RIGHT)."
  ".str_pad("Vendedor:",10," ",STR_PAD_RIGHT)." ".trim($usuario_id)."".str_pad("",64," ",STR_PAD_RIGHT)."
 ===============================================================================
 |".str_pad("Cant",5," ",STR_PAD_RIGHT)."|".str_pad("Descripcion",33," ",STR_PAD_RIGHT)."|".str_pad('Cod.',11," ",STR_PAD_LEFT)."|".str_pad('Valor',11," ",STR_PAD_LEFT)."|".str_pad('Total',13," ",STR_PAD_LEFT)."|
 -------------------------------------------------------------------------------";
 return $cabecalho_nota;
    }

    function createCorpoItensPedido($pedido_id,&$inicio,$limitNotas,$totalValorNota){
       //SQL PARA ITENS DO PEDIDO
      $sql_itens_pedido = "SELECT * FROM itens_pedido WHERE id_pedido = '$pedido_id' LIMIT $inicio,$limitNotas";
      $exe_itens_pedido = mysql_query($sql_itens_pedido) or die (mysql_error().'-'.$sql_itens_pedido);
      $num_itens_pedido = mysql_num_rows($exe_itens_pedido);

      $inicio+= $num_itens_pedido;

$corpo_nota = "";

      while ($reg_itens_pedido = mysql_fetch_array($exe_itens_pedido, MYSQL_ASSOC)) {
              $total_carrinho += ($reg_itens_pedido['prvenda']*$reg_itens_pedido['qtd_produto']);
  			$subtotal = $reg_itens_pedido['prvenda']*$reg_itens_pedido['qtd_produto'] ;

$corpo_nota.= "
 |".str_pad($reg_itens_pedido['qtd_produto'],5," ",STR_PAD_RIGHT)."|".str_pad(substr($reg_itens_pedido['descricao_prod'],0,32),33," ",STR_PAD_RIGHT)."|".
 str_pad(substr($reg_itens_pedido['referencia_prod'],0,11),11," ",STR_PAD_LEFT)."|".str_pad(guarani($reg_itens_pedido['prvenda']),11," ",STR_PAD_LEFT).
 "|".str_pad(guarani($subtotal),13," ",STR_PAD_LEFT)."|";
      }

      //CONTROLE DE&nbs
$MAX_ITENS_NOTA = 15;
if($num_itens_pedido < $MAX_ITENS_NOTA){
$total_completar = $MAX_ITENS_NOTA - $num_itens_pedido;
while($total_completar>0){
$corpo_nota.="\n"
 .str_pad("|",2," ",STR_PAD_LEFT)."".str_pad("|",6," ",STR_PAD_LEFT)."".str_pad("|",34," ",STR_PAD_LEFT).
 "".str_pad("|",12," ",STR_PAD_LEFT)."".str_pad("|",12," ",STR_PAD_LEFT)."".str_pad("|",14," ",STR_PAD_LEFT);
$total_completar--;
          }
      }


$rodape_nota = "
 ===============================================================================
   GRACIAS POR LA PREFERENCIA                        ".str_pad("Total:",3," ",STR_PAD_RIGHT)." ".trim(guarani($total_carrinho))."   
   WINGS                                                    
   SANTO DOMINGO - ALTO PARANA                                      
                      VERIFIQUE SU MERCADERIA                                 
 ===============================================================================

 
 ===============================================================================
          P   A   G   A   R   E     A     L   A     O   R   D   E   M
 ===============================================================================
  N.: ".trim(($pedido_id))."                                                   G$.: ".trim(($total_carrinho))."
  Vencimento  en ".trim($_SESSION['diab'])." de ".$_SESSION['mesb']."  ".$_SESSION['anob']."  Pagare(mos)  a  la  ordem  de:
  La falta  de pago del documento a su presentacion, y  desde la constitucion en 
  mora  del deudor, originara automaticamente un  interes  del ______ por ciento 
  mensual, y  ademas un interes punitorio del ______ por  ciento mensual,sin que
  ello  implique novacion prorroga o espera.  La  falta  de  pago  de un  pagare 
  a  su  vencimiento, producira  la caducidad  de los demas  plazos no fenecidos 
  por  el solo transcurso del tiempo, sin necessidad  de interpelacion  judicial 
  o extrajudicial alguna.A los efectos de la reclamacion judicial autorizo(amos) 
  desde  ya  al  acreedor a  ejecutar los  pagares seguientes  que  correspondan  
  a esta operacion,que importa el saldo total de la deuda.El simples vencimiento  
  estabelecera la mora, autorizando a  la consulta como a la inclusion a la base 
  de de datos de INFORCONF conforme a lo estabelecido en la ley 1682. Todas  las 
  partes  intervinientes  en  este documento se  someten  a  la  jurisdiccion  y  
  competencia de los jueces y Tribunales de la Republica del Paraguay y declaran 
  prorrogadas desde  ya cualquier  otra  que  pudiera  corresponder.  El  o  los
  libradores  de  este  documento  fijan  domicilio  especial  (Art. 62 C.C.)  a
  los efectos  de cumplimiento del mismo en:
  
  Pagadero en SANTO DOMINGO, ".$_SESSION['dia']." de ".$_SESSION['mes']." ".$_SESSION['ano']."
                                                         _______________________
                                                              ACLARACION
  Deudor....: ".trim($_SESSION['nome_cli'])."
  Domicilio.: ".trim($_SESSION['endereco'])."
  Telefono..: ".str_pad(substr($_SESSION['telefone1'],0,15),15," ",STR_PAD_RIGHT)."                            _______________________
  RUC / C.I.: ".str_pad(substr($_SESSION['ruc'],0,15),15," ",STR_PAD_RIGHT)."                                     FIRMA
 =============================================================================== 
 
 
 
 








 
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
            $corpo_nota = createCorpoItensPedido($pedido_id,&$totalNotas,$limitNotas,$totalValorNota);

            //$name_file = "print_pedido_".microtime()."".$randval.".txt";
			$name_file = $_SERVER['REMOTE_ADDR']."_".microtime()."".$randval.".txt";
			
            $name_file = str_replace(" ","",$name_file);
            $fp = fopen($name_file,"w+");

            $conteudo_nota = $cabecalho_nota."".$corpo_nota;
            fwrite($fp,$conteudo_nota);

            fclose($fp);
            $limitNotas+=$MAX_ITENS_NOTA;
			
			if($_SERVER['REMOTE_ADDR'] == "10.1.1.32"){
		    exec("lpr -P texto $name_file");
			}
			else if($_SERVER['REMOTE_ADDR'] == "10.1.1.30"){
			exec("lpr -P texto2 $name_file");
			}
			else if($_SERVER['REMOTE_ADDR'] == "10.1.1.16"){
			exec("lpr -P texto2 $name_file");
			}
			
			
			//system("print $name_file");

          /*  echo "<script language='javascript'>window.open('$name_file','_blank')</script>"; */
        }
    }

function totalValorNota($pedido_id){
$sql = "";
$totalNota = "";

return  $totalNota;
    }
    conexao();
    createNota($pedido_id);
	
	echo 'Caso desejar imprimir novamente pressione F5 ';
	
	
?>
<p>&nbsp;</p>
<p>
  <input name="button" type="button" onclick="window.close()" value="Cerrar" />
</p>
