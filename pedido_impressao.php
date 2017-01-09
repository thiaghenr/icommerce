<?
  require_once("verifica_login.php");
  require_once("biblioteca.php");
  include "config.php";
  conexao();
  $data= date("d/m/Y"); // captura a data
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
        }
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" >
<title>Pedido</title>
<style type="text/css">
body {
font-family: "Trebuchet MS", Verdana, Arial;
font-size: 10px;
color: #006;
background-color: #FFF;
}
a:link, a:visited {
color: #00F;
text-decoration: underline overline;
}
a:hover, a:active {
color: #F00;
text-decoration: none;
}
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
        if(valueSelected==0){
            alert("Favor escolher uma forma de pagamento");
            document.getElementById("formaPgto").focus();
        }
        else{
            window.location ='pedido.php?acao=insere&formaPgto='+valueSelected;
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

		if ((prod.length == 0 )&& (cli.length==0) )
			document.getElementById('cod').focus();
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>
<body bgcolor="#FFFFFF" onLoad="setaFoco()">
<table width="100%" border="0" align="center">
    <tr>
        <td bgcolor="#FF0000" colspan="5"><div align="center">
            <font color="#FFFFFF" size="5"><strong>Pedido</strong></font>
        </div></td>
    </tr>
    <tr>
        <td bgcolor="#CCCCCC"><? echo $data ?></td>
        <td width="80%" bgcolor="#FFFFFF" colspan="3">
            <div align="right"><strong>Usuario:</strong></div>
        </td>
        <td bgcolor="#CCCCCC"><?=$nome_user?></td>
    </tr>
    <tr>
        <td colspan="5" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
        <td bgcolor="#CCCCCC"><strong><font color="Blue"> Codigo </font><font color="Blue"> </font></strong></td>
        <td bgcolor="#CCCCCC"><strong><font color="#0000FF"> Nombre del cliente </font></strong></td>
        <td bgcolor="#CCCCCC"><strong><font color="#0000FF">Direcci&oacute;n</font></strong></td>
        <td bgcolor="#CCCCCC"><font color="#0000FF"><strong> Telefono</strong></font></td>
        <td bgcolor="#CCCCCC">
            <div align="right"><strong><font color="#0000FF">Solicitante:</font></strong></div>
        </td>
    </tr>
    <tr>
        <td>
            <form name="myData" method="POST" action="result_cli.php" >
                <input type="text" size="10" name="cod" id="cod" value="<?=$_SESSION['controleCli2']?>" onKeyPress="return somenteNumero(event)">
            </form>
        </td>
        <td>
            <form name="nome" method="POST" action="result_cli.php">
                <input type="text" size="36" name="nom" value="<?=$_SESSION['nomeCli']?>">
            </form>
        </td>
        <td>
            <form name="endereco" method="POST" action="result_cli.php">
                <input type="text" size="30" name="direc" value="<?=$_SESSION['enderecoCli']?>">
            </form>
        </td>
        <td>
            <form name="telefono" method="POST" action="result_cli.php">
                <input type="text2" size="10" name="telefone" value="<?=$_SESSION['telefoneCli']?>">
            </form>
        </td>
        <td align="right">
            <form name="requerente" method="POST" action="">
                <input type="text2" name="requerente" value="<?=$_SESSION['req']?>">
            </form>
        </td>
    </tr>
    <tr align="right">
            <td colspan="5">
            <label>Forma de Pagamento:</label>
            <select name="formaPgto" id='formaPgto'>
                <option value="0">Selecione</option>
            <?
                $sql_forma_pgto= "SELECT * FROM braspar.forma_pagamento";
                $rs_forma_pgto = mysql_query($sql_forma_pgto);
                while($linha_forma = mysql_fetch_array($rs_forma_pgto)){
                    echo "<option value='".$linha_forma['id']."'>".$linha_forma['descricao']."</option>\n";
                }
            ?>
            </select>
        </td>
  </tr>
      <tr>
        <th colspan="6" align="center" valign="middle" bgcolor="#DAE6F8"><p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Pesquisa de Producto </font></strong></p>          </th>
      </tr>
      <tr>
        <th colspan="6" align="center" valign="middle" bgcolor="#CECFCE"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="154" bordercolor="#000000" bgcolor="#CCCCCC"><div><strong>Código</strong></div></td>
            <td width="300" bordercolor="#000000" bgcolor="#CECFCE"><div><strong>Descripci&oacute;n</strong></div></td>
            <td width="398" bordercolor="#000000" bgcolor="#CECFCE">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#CECFCE">
                <form name="Codigo" method="POST" action="res_pes_prod.php">
                    <input type="text2" name="ref" id='ref'/>
                </form>
            </td>
            <td bgcolor="#CECFCE">
                <form name="Descricao" method="POST" action="res_pes_prod.php">
                    <input type="text" name="desc" size="50">
                </form>
            </td>
          </tr>
        </table></th>
      </tr>
      <tr>
        <td colspan="5" valign="top" bgcolor="#DAE6F8"><p>
            <?
mysql_select_db('braspar');
if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "add") {
		if (isset ($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = addslashes(htmlentities($_GET['id']));

				$sql_cont = "SELECT COUNT(*) AS n_prod FROM carrinho WHERE Codigo = '$id_prod' AND status = 'A' AND controle = '".$_SESSION['controleCli2']."' AND sessao = '".session_id()."' ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);


				if ($reg_cont['n_prod'] == 0) {
					$sql_prod = "SELECT * FROM produtos WHERE Codigo = '$id_prod'";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {
					$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );

					$qtd_ini =  1;
					
					 $sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 3 AND moeda.id = 3 GROUP BY cm.id DESC limit 0,1 ";
  					 $rs_cambio = mysql_query($sql_cambio);
    				 $linha_cambio = mysql_fetch_array($rs_cambio);
 					 $vl_cambio_guarani = $linha_cambio['vl_cambio'];
					
					 guarani($novovalor = $vl_cambio_guarani * $reg_prod['valor_c']) ;
				

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
						$sql_per = "UPDATE carrinho SET prvenda = '$prc' WHERE
									 Codigo = '$Codigo' AND sessao = '".session_id()."'";

						$exe_per = mysql_query($sql_per) or die (mysql_error()) ;
						}
					}
				}
			}
		}
?>
<form action="\pedido.php?acao=altera" method="post" name="frmItens" id='frmItens'/>
    <input type='hidden' name='campoFoco' id='campoFoco'/>
    <table border="1" width="100%">
    <tr>
        <td width="7%"><strong>Rem.</strong></td>
        <td width="14%"><strong>REF.<strong></strong></strong></td>
        <td width="45%"><strong>PRODUCTO<strong></strong></strong></td>
        <td width="13%"><strong>PRECIO</strong></td>
        <td width="10%"><strong>CANT.<strong></strong></strong></td>
        <td width="11%"><strong>SUBTOTAL.<strong></strong></strong></td>
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
                            <a href="pedido.php?acao=del&amp;id=<?=$reg_lista['Codigo']?>"><img src="images/delete.gif" width="12" border="0"/></a>                          </td>
						  <td width="14%"><?=$reg_lista['Codigo']?></td>
						  <td width="45%"><?=$reg_lista['descricao']?></td>
						  <td width="13%"><input type="text" size="9" name="prvenda[<?=$reg_lista['Codigo']?>]" id="prvenda_<?=$reg_lista['Codigo']?>" value="<?=$reg_lista['prvenda']?>" onKeyPress="nextFocus(event,'frmItens','prvenda_<?=$reg_lista["Codigo"]?>')" /></td>
						  <td width="10%"><input type="text" size="3" name="qtd[<?=$reg_lista['Codigo']?>]" id="qtd_<?=$reg_lista['Codigo']?>" value="<?=$reg_lista['qtd_produto']?>" onKeyPress="nextFocus(event,'frmItens','qtd_<?=$reg_lista["Codigo"]?>')" /></td>
						  <td width="11%"><?=guarani($reg_lista['prvenda']*$reg_lista['qtd_produto'],2,",",".")?></td>
						</tr>
						<?
					}
				}
			}
		?>
        <tr bgcolor="#FFFFFF" >
            <td colspan="5"><div align="right">Total&nbsp;</div></td>
            <td><?=guarani($total_carrinho)?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>
            <?
                $sql_valida = "SELECT * FROM carrinho WHERE controle = '".$_SESSION['controleCli2']. "' AND status ='A' AND data ='".date("Y-m-d")."'";
                $rs_valida = mysql_query($sql_valida) or die (mysql_error().'-'.$sql_valida);
                $num_valida = mysql_num_rows($rs_valida);
                if($num_valida){
            ?>
				<!--<a href="pedido.php?acao=insere"><img src="finaliza.jpg" width="100" height="20" border="0"></a>!-->
                <input type="button" onClick="finalizar()" value="Finalizar"/>
            <?
            }
            else{
            ?>
                <input type="button" onClick="finalizar()" value="Finalizar" disabled="disabled"/>
            <? } ?>          </td>
          <td colspan="5"> <input name="button" type="button" onClick="window.close()" value="Abandonar" /></td>
		</tr>
        <tr><td>
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

					$sql_add = "INSERT INTO pedido
								(controle_cli, nome_cli, sessao_car, data_car, total_nota, situacao, usuario_id, forma_pagamento_id)
								VALUES
								('".$reg_prod['controle']."', '".$_SESSION['nomeCli']."', '".$reg_prod['sessao']."', NOW(), $total_carrinho, 'A', '$id_usuario','$forma_pgto')";
								
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
								($id_pedido,'".$reg_prodx['Codigo']."', '".$reg_prodx['descricao']."', '".$reg_prodx['prvenda']."', '".$reg_prodx['qtd_produto']."', '".$reg_prodx['sessao_car']."')";
								
								
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
        /*echo "<script language='javaScript'>window.location.href='impressao.php?id_pedido=$id_pedido'</script>"; */
	    echo "<script language='javaScript'>window.location.href='impressao.php?id_pedido=$id_pedido'</script>";

	}
	
	}
	?>
</td></tr>
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
<body>
<script type="text/javascript" src="\ext2\examples.js"></script><!-- EXAMPLES -->
<p></p>
<table width="80%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<h1></h1>
 <div id="grid-example"></div>
</p>
<p>&nbsp;</p>
<?php
	
	   	  
    $sql = "SELECT ip.*, p.* FROM itens_pedido ip, pedido p  WHERE ip.referencia_prod = '$id_prod' AND ip.id_pedido = p.id ORDER BY p.id ASC limit 0,05"; 
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

