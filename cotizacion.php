<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
$data= date("d/m/Y"); // captura a data
$hora= date("H:i:s"); //captura a hora
$nome_user = $_SESSION['nome_user'];

$controleCli = $_GET['controleCli'];
$num_pedido = $_GET['num_pedido'];

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
?>
<html>
<head>
<style type="text/css">
	
	.style { 
	border: 1px solid #D8E1EF;
	}
	
	body {
	color: #006;
	padding:3px 0px 3px 8px;
	background-color: #EBEADE;
	border-width:2px;
	border-style:solid;
	border-color:#a2bfe9;
	}
	.Estilo16 {
	color: #000000;
	font-weight: bold;
	font-family: "Courier New", Courier, monospace;
}
.Estilo17 {
	color: #0000FF;
	font-weight: bold;
}
.Estilo18 {
	color: #FFFFFF;
	font-weight: bold;
}
</style>

<script type="text/javascript" src="/js/funcoes.js"></script>
<script type="text/javascript">
    function nextFocus(event,idForm,idCampo){
        document.getElementById('campoFoco').value = idCampo;
        enter(event,idForm);
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
			document.getElementById('cod').select();
		}
        if(campoSetFoco.length > 0){
            if(campoSetFoco.indexOf('qtd_') > -1){
                document.getElementById('ref').focus();
				document.getElementById('ref').select();
            }
            else{
                id_qtde_foco ="qtd_"+campoSetFoco.substr(8);
                document.getElementById(id_qtde_foco).focus();
				document.getElementById(id_qtde_foco).select();
            }
        }
	}
</script>
</head>
<body onLoad="setaFoco()">
<tr>
        <td width="633"><table width="100%" bgcolor="##EBEADE">  
            <tr>
              <td bgcolor="##EBEADE"><div align="center" class="Estilo18"><font size="5">Cotizacion</font></div></td>
            </tr>
          </table>
  </td>
</tr>
  <tr>
    <td height="21" colspan="2" valign="bottom"><!--<p>--><!-- </p>--></td>
  </tr>
  <tr>
    <td height="32" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="144" colspan="2"><table width="100%" height="327" border="0" color="#EBEADE" cellpadding="0" cellspacing="0">
      <tr>
       
        <td height="19" bgcolor="#EBEADE"><? echo $data ?> &nbsp;</td>
        <td bgcolor="#EBEADE"><div align="right"></div></td>
        <td bgcolor="#EBEADE"><div align="left"></div></td>
        <td width="51" bgcolor="#EBEADE"><div align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Usuario:</strong></div></td>
        <td bgcolor="#EBEADE" width="90"><?=$nome_user?>&nbsp;</td>
      </tr>
      <tr>
        <td width="134" height="19">&nbsp;</td>
        <td width="262"><p> <font color="Blue"></font></td>
        <td width="213">&nbsp;</td>
        <td width="120">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td height="19" bgcolor="#EBEADE"><strong><font color="Blue"> Codigo </font><font color="Blue"> </font></strong></td>
        <td bgcolor="#EBEADE"><strong><font color="#0000FF"> Nombre del cliente </font></strong></td>
        <td bgcolor="#EBEADE"><strong><font color="#0000FF">Direcci&oacute;n</font></strong></td>
        <td bgcolor="#EBEADE"><font color="#0000FF"><strong> Telefono</strong></font></td>
        <td colspan="2" bgcolor="#EBEADE"><div align="center"><strong><font color="#0000FF">Solicitante:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
      </tr>
        <tr><?
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
				
				
			}
		}

		?>
        <td height="25" bgcolor="#EBEADE">
            <form name="formClientes" method="POST" action="result_clic.php" >
                <input type="text" size="10" name="cod" id="cod" value="<?=$_SESSION['controleCli2']?>">
            </form>
        </td>
        <td bgcolor="#EBEADE">
            <form name="nome" method="POST" action="result_clic.php">
                <label><input type="text" size="36" name="nom" value="<?=$_SESSION['nomeCli']?>">
				</label>
            </form>
        </td>
        <td bgcolor="#EBEADE">
            <form name="endereco" method="POST" action="result_clic.php">
                <input type="text" size="30" name="direc" value="<?=$_SESSION['enderecoCli']?>">
            </form>
        </td>
        <td bgcolor="#EBEADE"><form name="telefono" method="POST" action="result_clic.php">
                <label>
                <input type="text2" size="10" name="telefone" value="<?=$_SESSION['telefoneCli']?>">
          <label></form></td>
        <td colspan="2" bgcolor="#EBEADE"><form name="requerente" method="POST" action="">
                <label>
                <div align="center">
                <input type="text2" name="requerente" value="<?=$_SESSION['req']?>">
                <label></label>
        </form></td>
      </tr>
      
      <tr>
        <th height="18" colspan="6" align="center" valign="middle" bordercolor="#EBEADB" bgcolor="#E7E7E7"><p class="Estilo16">Pesquisa de Producto </p>          </th>
      </tr>
      <tr>
        <th height="44" colspan="6" align="center" valign="middle" bgcolor="#CECFCE"><table width="100%" height="44" border="0" cellpadding="0" cellspacing="0">
          <tr>
            
            <td width="154" bordercolor="#000000" bgcolor="#EBEADE"><div align="center" class="Estilo17">Referencia</div></td>
            <td width="300" bordercolor="#000000" bgcolor="#EBEADE"><div align="center" class="Estilo17">Descripci&oacute;n</div></td>
            <td width="398" bordercolor="#000000" bgcolor="#EBEADE">&nbsp;</td>
			
          </tr>
          <tr>
            
            
            <td height="22" bgcolor="#EBEADE"><form name="Codigo" method="POST" action="res_pes_prodc.php">
                <label>
                <input type="text2" name="ref" id='ref'>
                </label>
            </form></td>
            <td bgcolor="#EBEADE"><form name="Descricao" method="POST" action="res_pes_prodc.php">
                <label>
                <input type="text" name="desc" size="50">
                </label>
            </form></td>
            <td  bgcolor="#EBEADE"></td>
          </tr>
           </table>
      </tr>
      <tr>
        <td height="183" colspan="6" valign="top" bgcolor="#d8e1ef"><p>
<?
			
	if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "edita") {
		if (isset ($_GET['num_pedido'])) {
			if ($_GET['num_pedido']) {
				$id_pedido = addslashes(htmlentities($_GET['num_pedido']));

					$sql_listae = "UPDATE carrinho SET status = 'A' WHERE num_pedido = '$id_pedido' order by id desc ";

					$exe_listae = mysql_query($sql_listae, $base) or die (mysql_error()."- $sql_listae");
					
					}
				}
			}
		}
	
if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "add") {
		if (isset ($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = addslashes(htmlentities($_GET['id']));
				
				$sql_cont = "SELECT COUNT(*) AS n_prod FROM carrinho WHERE Codigo = '$id_prod' AND status = 'A' AND controle = '".$_SESSION['controleCli2']."'  AND sessao = '".session_id()."' ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
			echo $reg_cont['n_prod'] ;
				
				if ($reg_cont['n_prod'] == 0) {
					$sql_prod = "SELECT * FROM produtos WHERE Codigo = '$id_prod'" ;
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {
					$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );

					$qtd_ini =  1;
					
					$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 3 AND moeda.id = 3 GROUP BY cm.id DESC limit 0,1 ";
  					 $rs_cambio = mysql_query($sql_cambio);
    				 $linha_cambio = mysql_fetch_array($rs_cambio);
 					 $vl_cambio_guarani = $linha_cambio['vl_cambio'];
					
					 $novovalor = $reg_prod['valor_c'];
					
										
					$sql_add = "INSERT INTO carrinho
								(Codigo, descricao, prvenda, qtd_produto, sessao, controle, data, status)
								VALUES
								('".mysql_escape_string($reg_prod['Codigo'])."', '".mysql_escape_string($reg_prod['Descricao'])."', '$novovalor', '$qtd_ini', '".session_id()."',".$_SESSION['controleCli2'].", NOW(),'A')";

					$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);

					}
				}
			}
		}

	}
	if ($_GET['acao'] == "del") {
		if (isset($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = addslashes(htmlentities($_GET['id']));
				$sql_del = "DELETE FROM carrinho WHERE id = '$id_prod' AND sessao = '".session_id()."'";
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
						$sql_per = "UPDATE carrinho SET prvenda = '$prc' WHERE
									 Codigo = '$Codigo' AND sessao = '".session_id()."'";

						$exe_per = mysql_query($sql_per) or die (mysql_error()) ;
						}
					}
				}
			}
		}
?>
<form action="cotizacion.php?acao=altera" method="post" name="frmItens" id='frmItens'/>
    <input type='hidden' name='campoFoco' id='campoFoco'/>
		<div id="atualiza" style="overflow-x: scroll; height:150px; overflow:auto; overflow-y: scroll;">
          <table border="1" width="100%" class="style" >
            <tr>
              <td width="5%" bgcolor="#EBEADE"><strong>Rem.</strong></td>
              <td width="13%" bgcolor="#EBEADE"><strong>REF.<strong></strong></strong></td>
              <td width="48%"  bgcolor="#EBEADE"><strong>PRODUCTO<strong></strong></strong></td>
              <td width="12%" bgcolor="#EBEADE"><strong>PRECIO</strong></td>
              <td width="9%" bgcolor="#EBEADE"><strong>CANT.<strong></strong></strong></td>
              <td width="13%" bgcolor="#EBEADE"><strong>SUBTOTAL.<strong></strong></strong></td>
            </tr>

        <?
			if(!$menu){

				$sql_lista = "SELECT * FROM carrinho WHERE controle = '".$_SESSION['controleCli2']."' AND status = 'A' AND data ='".date("Y-m-d")."' order by id desc";

				$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error()."- $sql_lista");
				$num_lista = mysql_num_rows($exe_lista);
				if ($num_lista > 0) {
					$total_carrinho = 0;
						while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
						$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);

						?>
						 <tr>
						  <td width="5%">
                            <a href="cotizacion.php?acao=del&id=<?=$reg_lista['id']?>"><img src="images/delete.gif" width="12" height="14" border="0"/></a>                          </td>
						  <td width="13%"><?=$reg_lista['Codigo']?></td>
						  <td width="48%"><?=substr($reg_lista['descricao'],0,38)?></td>
						  <td width="12%"><input type="text" size="9" name="prvenda[<?=$reg_lista['Codigo']?>]" id="prvenda_<?=$reg_lista['Codigo']?>" value="<?=$reg_lista['prvenda']?>" onKeyPress="nextFocus(event,'frmItens','prvenda_<?=$reg_lista["Codigo"]?>')" /></td>
						  <td width="9%"><input type="text" size="5" name="qtd[<?=$reg_lista['Codigo']?>]" id="qtd_<?=$reg_lista['Codigo']?>" value="<?=$reg_lista['qtd_produto']?>" onKeyPress="nextFocus(event,'frmItens','qtd_<?=$reg_lista["Codigo"]?>')" /></td>
						  <td width="13%"><?=guarani($reg_lista['prvenda']*$reg_lista['qtd_produto'])?></td>
						</tr>

						<?
					}
				}
			}
		?>
          </table>
          <p>&nbsp;</p>
      </table>
      <table width="100%" border="0">
        <tr>
          <td width="24%"><a href="cotizacion.php?acao=insere"><img src="finaliza.jpg" width="100" height="20" border="0"></a></td>
          <td width="13%"><font face="Arial">
            <input name="button" type="button" onClick="window.close()" value="Abandonar" />
          </font
	  ></td>
          <td width="19%">&nbsp;</td>
          <td width="18%">&nbsp;</td>
          <td width="10%">&nbsp;</td>
          <td width="16%"><div align="right">
            <strong>Total:&nbsp;&nbsp;
            <?=guarani($total_carrinho)?></strong>
          </div></td>
        </tr>
      </table>

	  <p>
	    <?

if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "insere") {
		//if (isset ($_GET['id'])) {
			//if ($_GET['id']) {
				//$id_prod = addslashes(htmlentities($_GET['id']));
				
				$sql_cont = "SELECT COUNT(*) AS n_prod FROM carrinho WHERE sessao = '".session_id()."' AND controle = ".$_SESSION['controleCli2']." AND status = 'A' ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
							
			    if ($reg_cont['n_prod'] > 0) {
					$sql_prod = "SELECT * FROM carrinho WHERE sessao = '".session_id()."' AND controle = ".$_SESSION['controleCli2']." AND status = 'A' ";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {
						
					$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );
													
										
					$sql_add = "INSERT INTO cotacao
								(controle_cli, nome_cli, sessao_car, data_car, total_nota, situacao, vendedor )
								VALUES
								('".$reg_prod['controle']."', '".mysql_escape_string($_SESSION['nomeCli'])."', '".$reg_prod['sessao']."', NOW(), $total_carrinho, 'A', '$id_usuario' )";
								
					$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);				
					
					$id_cotacao = mysql_insert_id();
					
					$sql_prod = "SELECT * FROM carrinho WHERE sessao = '".session_id()."' AND controle = ".$_SESSION['controleCli2']." AND status = 'A' ";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {			
					while	($reg_prodx = mysql_fetch_array($exe_prod, MYSQL_ASSOC )) {			
					$sql_add = "INSERT INTO itens_cotacao
								(id_cotacao, referencia_prod, descricao_prod, prvenda, qtd_produto, sessao)
								VALUES
								('$id_cotacao', '".mysql_escape_string($reg_prodx['Codigo'])."', '".mysql_escape_string($reg_prodx['descricao'])."', '".$reg_prodx['prvenda']."', '".$reg_prodx['qtd_produto']."', '".$reg_prodx['sessao_car']."')";			
					
								
								$qtd_prod =  $reg_prodx['qtd_produto'] ;
						
					$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);	
					
					
					$sql_alt_status = "UPDATE carrinho SET status = 'F', num_cotacao = '$id_cotacao' WHERE sessao = '".session_id()."' AND controle = ".$_SESSION['controleCli2']." AND status = 'A' ";
					$exe_alt_status = mysql_query($sql_alt_status, $base) or die (mysql_error().'-'.$sql_alt_status);		
					
				//	$sql_alt_cotacao = "UPDATE carrinho SET num_pedido = '$id_cotacao' WHERE sessao = '$sessao' AND controle = ".$_SESSION['controleCli2']." ";
				//	$exe_alt_cotacao = mysql_query($sql_alt_cotacao, $base) or die (mysql_error().'-'.$sql_alt_cotacao);		

					}
				}
			}

		}
		echo "<script language='javaScript'>window.location.href='impressaoc.php?id_cotacao=$id_cotacao'</script>";
	
	}
	}
	?>
    	 
<link rel="stylesheet" type="text/css" href="ext2/resources/css/ext-all.css" />

    <!-- GC -->
 	<!-- LIBS -->
 	<script type="text/javascript" src="ext2/adapter/ext/ext-base.js"></script>
 	<!-- ENDLIBS -->

    <script type="text/javascript" src="ext2/ext-all.js"></script>

    <script type="text/javascript" src="array-grid.php"></script>
    <link rel="stylesheet" type="text/css" href="grid-examples.css" />

    <!-- Common Styles for the examples -->
    <link rel="stylesheet" type="text/css" href="\ext2\examples.css" />
<script type="text/javascript" src="\ext2\examples.js"></script><!-- EXAMPLES -->
	  <div id="grid-example"></div>
</p>
<p>
  <?php
	
	   	  
    $sql = "SELECT ic.*, c.* FROM itens_cotacao ic, cotacao c  WHERE ic.referencia_prod = '$id_prod' AND ic.id_cotacao = c.id ORDER BY c.id ASC limit 0,05"; 
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
       
    

    // example of custom renderer function
    function change(val){
        if(val > 0){
            return '<span style="color:green;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;">' + val + '</span>';
        }
        return val;
    }

    // example of custom renderer function
    function pctChange(val){
        if(val > 0){
            return '<span style="color:green;">' + val + '%</span>';
        }else if(val < 0){
            return '<span style="color:red;">' + val + '%</span>';
        }
        return val;
    }

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
        
        height:156,
        width:754,
        title:'Outras Ventas deste produto'
    });

    grid.render('grid-example');

    grid.getSelectionModel().selectFirstRow();
});

  </script>
</body>
</html>