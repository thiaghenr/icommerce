<?
  require_once("verifica_login.php");
  require_once("biblioteca.php");
  include "config.php";
  conexao();
  $data= date("m"); // captura a data
  $hora= date("H:i:s"); //captura a hora
  $nome_user = $_SESSION['nome_user'];
  $controleCli = $_GET['controleCli'];
  $id_prod = $_GET['id'];
  $menu= $_GET["menu"];
  $sql = "SELECT * FROM caixa_balcao WHERE usuario_id = " . $id_usuario." AND st_caixa = 'a'";
  	$rs = mysql_query($sql) or die (mysql_error() .' '.$sql);
  	$num_rows = mysql_num_rows($rs);
  	$msg = $_GET['msg'];


  if($menu){
  	unset($_SESSION['controleCli2']);
  	unset($_SESSION['nomeCli']);
  	unset($_SESSION['enderecoCli']);
  	unset($_SESSION['telefoneCli']);
  }

    $requerente = $_POST['req'];
    if(!empty($controleCli)){
        $sql = "SELECT * FROM clientes WHERE controle = '$controleCli'" ;
        $rs = mysql_query($sql);
    	$num_reg = mysql_num_rows($rs);
    	if($num_reg > 0){
    	    $row = mysql_fetch_array($rs);
    		$_SESSION['controleCli2'] = $row['controle'];
    		$_SESSION['nomeCli'] = $row['nome'];
    		$_SESSION['enderecoCli'] = $row['endereco'];
    		$_SESSION['telefoneCli'] = $row['telefonecom'];
			$_SESSION['freteCli'] = $row['frete'];
        }
    }
	$sql_cont_itens = "SELECT COUNT(*) AS itens FROM carrinho WHERE  status = 'A' AND controle = '".$_SESSION['controleCli2']."' AND sessao = '".session_id()."' ";
				$exe_cont_itens = mysql_query($sql_cont_itens, $base) or die (mysql_error());
				$reg_cont_itens = mysql_fetch_array($exe_cont_itens, MYSQL_ASSOC);
				$tens_maximo2 =	$reg_cont_itens['itens'];
?>
<html>
<head>
<style type="text/css">
table, td{
	font:50% Arial, Helvetica, sans-serif; 
}
table{width:100%;border-collapse:collapse;margin:1em 0;}
th, td{text-align:left;padding:.5em;border:1px solid #fff;}
th{background:#328aa4 url(tr_back.gif) repeat-x;color:#fff;}
td{background:#e5f1f4;}

/* tablecloth styles */

tr.even td{background:#e5f1f4;}
tr.odd td{background:#f8fbfc;}

th.over, tr.even th.over, tr.odd th.over{background:#4a98af;}
th.down, tr.even th.down, tr.odd th.down{background:#bce774;}
th.selected, tr.even th.selected, tr.odd th.selected{}

td.over, tr.even td.over, tr.odd td.over{background:#ecfbd4;}
td.title, tr.even td.title, tr.odd td.title{background:#4796AD;}
td.down, tr.even td.down, tr.odd td.down{background:#bce774;color:#fff;}
td.selected, tr.even td.selected, tr.odd td.selected{background:#bce774;color:#555;}

/* use this if you want to apply different styleing to empty table cells*/
td.empty, tr.odd td.empty, tr.even td.empty{background:#fff;}
.Estilo2 {font-size: 14px}
.Estilo4 {font-size: 14px; font-weight: bold; }
.Estilo10 {font-size: 14}
.Estilo11 {font-size: 10px}
.Estilo12 {color: #FFFFFF}
</style>



<script type="text/javascript" src="/js/funcoes.js"></script>
<script type="text/javascript">
    function nextFocus(event,idForm,idCampo){
        document.getElementById('campoFoco').value = idCampo;
        enter(event,idForm);
    }
   function finalizar(){
        var indexSelect = document.getElementById("formaPgto").selectedIndex;
        var valueSelected = document.getElementById("formaPgto").options[indexSelect].value;
		
		var indexSelectVend = document.getElementById("vendedor").selectedIndex;
        var valueSelectedVend = document.getElementById("vendedor").options[indexSelectVend].value;
		
		var passwd = document.getElementById("passwd").value;
		
		var cliente = '<?=$_SESSION['controleCli2']?>'
        if(valueSelected==0){
            alert("Favor escolher uma forma de pagamento");
            document.getElementById("formaPgto").focus();
        }
		if(cliente == 1 && valueSelected != 1){
			
            alert("Cliente Mostrador, Solamente Venta Contado");
            document.getElementById("formaPgto").focus();
        }
		else if  (valueSelectedVend==0){
            alert("Favor Selecionar o Vendedor");
            document.getElementById("vendedor").focus();
        }
		  if(passwd === ''){
			alert(" Favor informar tu contrasenha");
			document.getElementById("passwd").focus();
				}
		
        else  {
            window.location ='pedido.php?acao=insere&formaPgto='+valueSelected+'&vendedor='+valueSelectedVend+'&zero='+passwd;
        }
    }
    function setaFoco(){
        campoSetFoco = "<?=$_POST['campoFoco']?>";
		cli = '<?=$_GET['cli']?>'
		prod = '<?=$_GET['prod']?>'
		precoId = 'prvenda_<?=$_GET['id']?>'

		if(cli.length > 0 )
			document.getElementById('ref').focus();

		if(prod.length > 0){
			document.getElementById(precoId).focus();
			document.getElementById(precoId).select();
		}
			
		if ((prod.length == 0 )&& (cli.length==0) ){
			document.getElementById('cod').focus();
		}
        if(campoSetFoco.length > 0){
            if(campoSetFoco.indexOf('qtd_') > -1){
                document.getElementById('ref').focus();
            }
            else{
                id_qtde_foco ="qtd_"+campoSetFoco.substr(8);
                document.getElementById(id_qtde_foco).focus();
				document.getElementById(id_qtde_foco).select();
            }
        }
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF" onLoad="setaFoco()">
<table width="100%" border="3" align="center">
    <tr>
	
        <td colspan="5" bgcolor="#4796AD" class="title Estilo2 Estilo12"><div align="center"><strong>PEDIDO</strong></div></td>
    </tr>
    <tr>
        <td width="6%" bgcolor="#CCCCCC" class="empty"><span class="Estilo2"><?  $data ?></span></td>
        <td colspan="3" bgcolor="#EEEEEE" class="empty">
      <div align="right" class="Estilo2"><strong>Usuario:</strong></div>      </td>
        <td width="21%" bgcolor="#CCCCCC" class="empty"><span class="Estilo4">
        <?=$nome_user?>
        </span></td>
  </tr>
    <tr>
        <td colspan="5" bgcolor="#EEEEEE" class="empty Estilo2">&nbsp;</td>
    </tr>
    <tr>
        <td bgcolor="#CCCCCC" class="selected"><span class="Estilo4"><font color="Blue"> Codigo </font> </span></td>
        <td width="34%" bgcolor="#CCCCCC" class="selected"><span class="Estilo4"><font color="#0000FF"> Nombre del cliente </font></span></td>
        <td width="23%" bgcolor="#CCCCCC" class="selected"><span class="Estilo4"><font color="#0000FF">Direcci&oacute;n</font></span></td>
        <td width="16%" bgcolor="#CCCCCC" class="selected"><span class="Estilo4"><font color="#0000FF"> Telefono</font></span></td>
        <td bgcolor="#CCCCCC" class="selected">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <form action="result_cli.php" method="POST" name="myData" class="Estilo2" >
                <input type="text" size="10" name="cod" id="cod" value="<?=$_SESSION['controleCli2']?>">
            </form>        </td>
        <td>
            <form action="result_cli.php" method="POST" name="nome" class="Estilo2">
                <input type="text" size="36" name="nom" value="<?=$_SESSION['nomeCli']?>">
            </form>        </td>
        <td>
            <form action="result_cli.php" method="POST" name="endereco" class="Estilo2">
                <input type="text" size="30" name="direc" value="<?=$_SESSION['enderecoCli']?>">
            </form>        </td>
        <td>
            <form action="result_cli.php" method="POST" name="telefono" class="Estilo2">
                <input type="text2" size="10" name="telefone" value="<?=$_SESSION['telefoneCli']?>">
            </form>        </td>
        <td align="right">
            <form action="" method="POST" name="requerente" class="Estilo2">
            </form>        </td>
    </tr>
    <tr align="right">
            <td height="29" colspan="4">
              <span class="Estilo2">
              <label></label>
              <div align="right">Forma de Pagamento
                <select name="formaPgto" id='formaPgto'>
                  <option value="0">Selecione</option>
                  <?
                $sql_forma_pgto= "SELECT * FROM forma_pagamento";
                $rs_forma_pgto = mysql_query($sql_forma_pgto);
                while($linha_forma = mysql_fetch_array($rs_forma_pgto)){
                    echo "<option value='".$linha_forma['id']."'>".$linha_forma['descricao']."</option>\n";
                }
            ?>
                </select>
              </div>
              </span></td>
            <td height="29">
            <span class="Estilo2">
            <div align="right" class="Estilo2">Vendedor
              <select name="vendedor" id='vendedor'>
                    <option value="0">Selecione</option>
                    <?
                $sql_vendedor= "SELECT * FROM usuario";
                $rs_vendedor = mysql_query($sql_vendedor);
                while($linha_vendedor = mysql_fetch_array($rs_vendedor)){
                    echo "<option value='".$linha_vendedor['id_usuario']."'>".$linha_vendedor['nome_user']."</option>\n";
                }
            ?>
                  </select>
            </div></td>
  </tr>
      <tr>
        <th colspan="4" align="center" valign="middle" bgcolor="#DAE6F8"><p class="empty Estilo11"><font face="Verdana, Arial, Helvetica, sans-serif">Pesquisa de Producto </font></p>          </th>
        <th align="center" valign="middle" bgcolor="#DAE6F8"><label>
          <div align="right">
            <input type="password" name="passwd" id="passwd">
            </div>
        </label></th>
        <th align="center" valign="middle" bgcolor="#DAE6F8">&nbsp;</th>
      </tr>
      <tr>
        <th height="82" colspan="6" align="center" valign="middle" bgcolor="#CECFCE">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="154" bordercolor="#000000" bgcolor="#CCCCCC" class="over"><div class="Estilo4">Código</div></td>
            <td width="300" bordercolor="#000000" bgcolor="#CECFCE" class="over"><div class="Estilo4">Descripci&oacute;n</div></td>
            <td width="398" bordercolor="#000000" bgcolor="#CECFCE" class="over Estilo2">&nbsp;</td>
          </tr>
          <tr>
            <td height="28" bgcolor="#CECFCE" class="over">
                <form action="res_pes_prod.php" method="POST" name="Codigo" class="Estilo10">
                    <input type="text2" name="ref" id='ref'>
                </form>            </td>
            <td bgcolor="#CECFCE" class="over">
                <form action="res_pes_prod.php" method="POST" name="Descricao" class="Estilo10">
                    <input type="text" name="desc" size="50">
                </form>            </td>
			<td class="over"><span class="Estilo10"></span></td>	
          </tr>
        </table></th>
      </tr>
      <tr>
        <td height="196" colspan="5" valign="top" bgcolor="#DAE6F8"><p>
            <?

if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "add") {
		if (isset ($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = addslashes(htmlentities($_GET['id']));
				
				$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 3 AND moeda.id = 3 GROUP BY cm.id DESC limit 0,1 ";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];

				$sql_cont = "SELECT COUNT(*) AS n_prod FROM carrinho WHERE Codigo = '$id_prod' AND status = 'A' AND controle = '".$_SESSION['controleCli2']."' AND sessao = '".session_id()."' ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
				
				$sql_cont_itens = "SELECT COUNT(*) AS itens FROM carrinho WHERE  status = 'A' AND controle = '".$_SESSION['controleCli2']."' AND sessao = '".session_id()."' ";
				$exe_cont_itens = mysql_query($sql_cont_itens, $base) or die (mysql_error());
				$reg_cont_itens = mysql_fetch_array($exe_cont_itens, MYSQL_ASSOC);
				$tens_maximo =	$reg_cont_itens['itens'];
				if ($tens_maximo < 15) {
				

				if ($reg_cont['n_prod'] == 0) {
					$sql_prod = "SELECT * FROM produtos WHERE Codigo = '$id_prod'";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {
					$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );
					$prmin = $reg_prod['pr_min'];
					$qtd_ini =  1;
				/*	 $sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 3 AND moeda.id = 3 GROUP BY cm.id DESC limit 0,1 ";
  					 $rs_cambio = mysql_query($sql_cambio);
    				 $linha_cambio = mysql_fetch_array($rs_cambio);
 					 $vl_cambio_guarani = $linha_cambio['vl_cambio'];
					*/
					 $novovalor =  $reg_prod['valor_c'];
					

					$sql_add = "INSERT INTO carrinho
								(Codigo, descricao, prvenda, qtd_produto, sessao, controle, data, status)
								VALUES
								('".mysql_escape_string($reg_prod['Codigo'])."', '".mysql_escape_string($reg_prod['Descricao'])."', '$novovalor', '$qtd_ini', '".session_id()."',".$_SESSION['controleCli2'].", NOW(),'A')";

					$exe_add = mysql_query($sql_add, $base) or die ("Selecione um cliente para esta operacao");
					
					

					}
				}
			
			}
			
			}
			
		}

	}
	if ($_GET['acao'] == "del") {
		if (isset($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = addslashes(htmlentities($_GET['id']));
				$sql_del = "DELETE FROM carrinho WHERE Codigo = '$id_prod' AND sessao = '".session_id()."'";
				$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
			}
		}
	}
	if ($_GET['acao'] == "altera") {
		if (isset($_POST['qtd'])) {
			if (is_array($_POST['qtd'])) {
				foreach ($_POST['qtd'] as $Codigo => $qtd) {
						$sql_alt = "UPDATE carrinho SET qtd_produto = '$qtd' WHERE
									 Codigo = '$Codigo' AND sessao = '".session_id()."'";
						$exe_alt = mysql_query($sql_alt, $base) or die (mysql_error()) ;
						
						
					}
				}
		}
	}

	if ($_GET['acao'] == "altera") {
		if (($_POST['prvenda'])) {
			if (is_array($_POST['prvenda'])) {
				foreach ($_POST['prvenda'] as $Codigo => $prc) {
					//if (($referencia) && is_numeric($prc)) {
					$sql_prod = "SELECT id,Codigo,pr_min FROM produtos WHERE Codigo = '$Codigo'";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
					$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );
					$prmin = $reg_prod['pr_min'];
					if($prc >= $prmin){
						$sql_per = "UPDATE carrinho SET prvenda = '$prc' WHERE
									 Codigo = '$Codigo' AND sessao = '".session_id()."'";

						$exe_per = mysql_query($sql_per) or die (mysql_error()) ;
						}
						else{
	$conteudo.="Voce nao pode vender abaixo do preco minimo";
						}
						$checkbox = $_POST['checked'];
						echo $checkbox;
						}
					}
				}
			}
		}
					
?>
<form action="\pedido.php?acao=altera" method="post" name="frmItens" id='frmItens'/>
    <input type='hidden' name='campoFoco' id='campoFoco'/>
    <div id="atualiza" style="overflow-x: scroll; height:250px; overflow:auto; overflow-y: scroll;">
    <table border="1" width="100%">
    <tr>
        <td width="7%" class="selected"><span class="Estilo4">Rem.</span></td>
        <td width="14%" class="selected"><span class="Estilo4">REF.</span></td>
        <td width="45%" class="selected"><span class="Estilo4">PRODUCTO</span></td>
        <td width="13%" class="selected"><span class="Estilo4">PRECIO</span></td>
        <td width="10%" class="selected"><span class="Estilo4">CANT.</span></td>
        <td width="11%" class="selected"><span class="Estilo4">SUBTOTAL.</span></td>
    </tr>
<?
			if(!$menu){

				$sql_lista = "SELECT * FROM carrinho WHERE controle = '".$_SESSION['controleCli2']."' AND status = 'A' AND data ='".date("Y-m-d")."' AND sessao = '".session_id()."'order by id desc";

				$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error()."- $sql_lista");
				$num_lista = mysql_num_rows($exe_lista);
				if ($num_lista > 0) {
					$total_carrinho = 0;
						while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
						$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);

						?>
						 <tr>
						  <td width="7%">
                            <a href="pedido.php?acao=del&amp;id=<?=$reg_lista['Codigo']?>" class="Estilo2"><img src="images/delete.gif" width="12" border="0"/></a>                          </td>
						  <td width="14%"><span class="Estilo2">
					      <?=$reg_lista['Codigo']?>
						  </span></td>
						  <td width="45%"><span class="Estilo2">
					      <?=substr($reg_lista['descricao'],0,45)?>
						  </span></td>
						  <td width="13%"><input name="prvenda[<?=$reg_lista['Codigo']?>]" type="text" id="prvenda_<?=$reg_lista['Codigo']?>" onKeyPress="nextFocus(event,'frmItens','prvenda_<?=$reg_lista["Codigo"]?>')" value="<?=$reg_lista['prvenda']?>" size="9" /></td>
						  <td width="10%"><input name="qtd[<?=$reg_lista['Codigo']?>]" type="text" id="qtd_<?=$reg_lista['Codigo']?>" onKeyPress="nextFocus(event,'frmItens','qtd_<?=$reg_lista["Codigo"]?>')" value="<?=$reg_lista['qtd_produto']?>" size="3" /></td>
						  <td width="11%"><span class="Estilo2">
					      <?=guarani($reg_lista['prvenda']*$reg_lista['qtd_produto'])?>
						  </span></td>
						</tr>
						<?
					}
				}
			}
			
		?>
        <tr bgcolor="#FFFFFF">
          <td><!--<a href="pedido.php?acao=insere"><img src="finaliza.jpg" width="100" height="20" border="0"></a>!--></td>
          <td colspan="5">&nbsp;</td>
		</tr>
        <tr><td height="16">&nbsp;</td></tr>
</table>
</table>

<p><link rel="stylesheet" type="text/css" href="ext2/resources/css/ext-all.css" />

    <!-- GC -->
 	<!-- LIBS -->
 	<script type="text/javascript" src="ext2/adapter/ext/ext-base.js"></script>
 	<!-- ENDLIBS -->

    <script type="text/javascript" src="ext2/ext-all.js"></script>

    <script type="text/javascript" src="array-grid.php"></script>
    <link rel="stylesheet" type="text/css" href="grid-examples.css" />

    <!-- Common Styles for the examples -->
    <link rel="stylesheet" type="text/css" href="\ext2\examples.css" />
</head>
<table width="100%" border="0">
  <tr>
 <div class="Estilo4" ><? echo $conteudo; ?> </div>
    <td width="16%" height="40" rowspan="2" class="over Estilo2"><?
                $sql_valida = "SELECT * FROM carrinho WHERE controle = '".$_SESSION['controleCli2']. "' AND status ='A' AND data ='".date("Y-m-d")."'";
                $rs_valida = mysql_query($sql_valida) or die (mysql_error().'-'.$sql_valida);
                $num_valida = mysql_num_rows($rs_valida);
                if($num_valida){
            ?>
        <!--<a href="pedido.php?acao=insere"><img src="finaliza.jpg" width="100" height="20" border="0"></a>!-->
        <input name="button2" type="button" onClick="finalizar()" value="Finalizar"/>
        <?
            }
            else{
            ?>
        <input name="button2" type="button" disabled="disabled" onClick="finalizar()" value="Finalizar"/>
        <? } ?></td>
    <td width="14%" rowspan="2" class="over Estilo2"><? if($tens_maximo2 == 15){ echo "<strong>Limite maximo de itens atingido</strong>";}?>&nbsp;</td>
    <td width="17%" rowspan="2" class="over">
      <label>
      <? if ($_SESSION['freteCli'] > 0) { $checked = "checked"; }?>
      <input type="checkbox" name="checkbox" id="checkbox" <? echo $checked; ?> >
      </label>
      <span class="Estilo2">Frete <? echo $_SESSION['freteCli']."%"; ?> </span></td>
    <td width="16%" rowspan="2" class="over"><input name="button" type="button" onClick="window.close()" value="Abandonar" /></td>
    <td width="25%" class="over Estilo2"><div align="right">TOTAL ITENS&nbsp;</div></td>
    <td width="12%" class="over"><span class="Estilo2">
      <?=guarani($total_carrinho)?>
     
    </span></td>
  </tr>
  <tr>
    <td height="32" class="over Estilo2"><div align="right">TOTAL GERAL&nbsp;</div></td>
    <td width="12%" class="over"><span class="Estilo2"><?
	  				$percentual = ($_SESSION['freteCli'] / 100) ; 
					$valor_frete = ($total_carrinho * $percentual); 
					$fret = $valor_frete;
					echo  guarani($valor_frete)."<br>";
					//number_format($valor_frete,3);
					$total_carrinho = $total_carrinho + $valor_frete;
					echo guarani($total_carrinho);
	?></td>
  </tr>
</table>
 <script type="text/javascript" src="\ext2\examples.js"></script><!-- EXAMPLES -->
<h1>
  <?

if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "insere") {
		//if (isset ($_GET['id'])) {
			//if ($_GET['id']) {
				//$id_prod = addslashes(htmlentities($_GET['id']));
				$sql_cont = "SELECT COUNT(*) AS n_prod FROM carrinho WHERE sessao = '".session_id()."' AND controle = ".$_SESSION['controleCli2']." AND status = 'A'";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);

			    if ($reg_cont['n_prod'] > 0) {
					$sql_prod = "SELECT * FROM carrinho WHERE sessao = '".session_id()."' AND controle = ".$_SESSION['controleCli2']." AND status = 'A' ";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {

					$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );
	

					$forma_pgto = $_GET['formaPgto'];
					$vendedor = $_GET['vendedor'];
					$passwd =  sha1(stripslashes($_GET['zero']));
			//echo $_GET['zero'];
			
					$sql_user = "SELECT * FROM usuario WHERE id_usuario = '$vendedor' AND senha = '$passwd' ";
					$exe_user = mysql_query($sql_user, $base) or die (mysql_error());
					$reg_user = mysql_fetch_array($exe_user, MYSQL_ASSOC);
					$row_user = mysql_num_rows($exe_user);
					 $row_user;
					
						if($row_user == 0) {
						echo "Su contrasenha no esta correcto, intente novamente";
						exit();
													}
							else
								{
					$sql_add = "INSERT INTO pedido
								(controle_cli, nome_cli, sessao_car, data_car, total_nota, situacao, usuario_id, forma_pagamento_id, frete, vendedor)
								VALUES
								('".$reg_prod['controle']."', '".$_SESSION['nomeCli']."', '".$reg_prod['sessao']."', NOW(), $total_carrinho, 'A', '$id_usuario','$forma_pgto', '$valor_frete', '$vendedor' )";
								
					$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);				
					
					$id_pedido = mysql_insert_id();
					
					$sql_prod = "SELECT * FROM carrinho WHERE sessao = '".session_id()."' AND controle = ".$_SESSION['controleCli2']." AND status = 'A' ";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {
					while	($reg_prodx = mysql_fetch_array($exe_prod, MYSQL_ASSOC )) {
					$sql_add = "INSERT INTO itens_pedido
								(id_pedido, referencia_prod, descricao_prod, prvenda, qtd_produto, sessao)
								VALUES
								($id_pedido,'".mysql_escape_string($reg_prodx['Codigo'])."', '".mysql_escape_string($reg_prodx['descricao'])."', '".$reg_prodx['prvenda']."', '".$reg_prodx['qtd_produto']."', '".$reg_prodx['sessao_car']."')";
								
								
								$qtd_prod =  $reg_prodx['qtd_produto'] ;
						
					$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);	
					
		$sql_alt_status = "UPDATE carrinho SET status = 'F' WHERE sessao = '".session_id()."' AND controle=".$_SESSION['controleCli2'];
		$exe_alt_status = mysql_query($sql_alt_status, $base) or die (mysql_error().'-'.$sql_add);				

  		$sql_qtd1 = "UPDATE produtos SET  qtd_bloq = qtd_bloq + '$qtd_prod' WHERE Codigo = '$reg_prodx[Codigo]'  ";
		$exe_qtd1 = mysql_query($sql_qtd1, $base) or die (mysql_error());
		$sql_qtd2 = "UPDATE produtos SET  Estoque = Estoque - '$qtd_prod' WHERE Codigo = '$reg_prodx[Codigo]'  ";
		$exe_qtd2 = mysql_query($sql_qtd2, $base) or die (mysql_error());
						
						}
						}
				}
			}

		}
      /* echo "<script language='javaScript'>window.location.href='pedido_ok.php?id_pedido=$id_pedido'</script>"; */
	echo "<script language='javaScript'>window.location.href='impressao.php?id_pedido=$id_pedido'</script>"; 

	}
	}
	?>
</h1>
 <div id="grid-outras-vendas" style="width:970;'"></div>
</p>
<p>&nbsp;</p>
<?php
	
	   	  
    $sql = "SELECT ip.*, p.* FROM itens_pedido ip, pedido p  WHERE ip.referencia_prod = '$id_prod' AND ip.id_pedido = p.id ORDER BY p.id DESC limit 0,20"; 
	$rs = mysql_query($sql) or die(mysql_error().''. $sql);
	$num_prod = mysql_num_rows($rs);
	if ($num_prod > 0) {

			//Pegando data e hora.
			$data4 = $sql['data_car'];
			$hora4 = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata5 = substr($data4,8,2) . "/" .substr($data4,5,2) . "/" . substr($data4,0,4);
			$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
			
    $str_dados="[";
    while($linha=mysql_fetch_array($rs)){
        $str_dados.="['".addslashes($linha['id'])."',";
        $str_dados.="'".addslashes($linha['controle_cli'])."',";
        $str_dados.="'".addslashes($linha['nome_cli'])."',";
        $str_dados.="'".addslashes($linha['data_car'])."',";
		$str_dados.="'".addslashes($linha['referencia_prod'])."',";
		$str_dados.="'".addslashes($linha['prvenda'])."'],";
    }
    $str_dados = substr($str_dados,0,strlen($str_dados)-1);
    $str_dados.= "]";
}
	else
	exit;
		
?>
<script>
Ext.onReady(function(){

    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());

    var myData =  <? echo $str_dados ?>;

    // create the data store
    var store = new Ext.data.SimpleStore({
        fields: [
           {name: 'id'},
		   {name: 'controle_cli'},
           {name: 'nome_cli'},
           {name: 'novadata5'},
		   {name: 'referencia_prod'},
		   {name: 'prvenda', type: 'float'}
           
        ]
    });
    store.loadData(myData);

    // create the Grid
    var grid = new Ext.grid.GridPanel({
        store: store,
        columns: [
            {id:'id',header: "Cod.Pedido", width: 80, sortable: true, dataIndex: 'id'},
			{id:'controle_cli',header: "Cod. Cliente", width: 100, sortable: true, dataIndex: 'controle_cli'},
			{id:'nome_cli',header: "Nome", width: 270, sortable: true, dataIndex: 'nome_cli'},
			{id:'novadata5',header: "Data", width: 100, sortable: true, dataIndex: 'novadata5'},
			{id:'referencia_prod',header: "Cod.Produto", width: 120, sortable: true, dataIndex: 'referencia_prod'},
			{id:'prvenda',header: "Valor", width: 80, sortable: true, dataIndex: 'prvenda'}
        ],
        stripeRows: true,
	    viewConfig: 
	        {
	            forceFit:true
	        },        
        height:156,
        width:960,
        title:'Outras Ventas deste produto'
    });

    grid.render('grid-outras-vendas');

   // grid.getSelectionModel().selectFirstRow();
});

</script>

</body>
</html>

