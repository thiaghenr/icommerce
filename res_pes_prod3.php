<?
	require_once("biblioteca.php");
 	require_once("config.php");
    conexao();
	$desc = $_POST['desc']; // ORDER BY CAST(Codigo AS UNSIGNED) 
	$ref = $_POST['ref'];
	$cli = $_GET['cli'];
	$_SESSION['cliente'] = $cli;

    $sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id DESC";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
   
    $id_prod = addslashes(htmlentities($_GET['desc']));
     $sql =  "SELECT * FROM produtos WHERE ((Descricao LIKE '$desc%') AND (Codigo LIKE '$ref%')) OR ((cod_original2 LIKE '$ref%') AND (Descricao LIKE '$desc%') ) OR ((cod_original LIKE '$ref%') AND (Descricao LIKE '$desc%')) OR ((Codigo_Fabricante LIKE '$ref%') AND (Descricao LIKE '$desc%')) OR ((Codigo_Fabricante2 LIKE '$ref%') AND (Descricao LIKE '$desc%')) OR ((Codigo_Fabricante3 LIKE '$ref%') AND (Descricao LIKE '$desc%')) ORDER BY Codigo ASC limit 0,100 ";
    $rs = mysql_query($sql) or die (mysql_error());
	
	$num_prod = mysql_num_rows($rs);
	
	
	
    $str_dados="[";
    while($linha=mysql_fetch_array($rs)){
	//$novovalor = $linha['valor_c'] * $vl_cambio_guarani ;
        $str_dados.="['".addslashes($linha['id'])."',";
		$str_dados.="'".addslashes($linha['Codigo'])."',";
        $str_dados.="'".addslashes($linha['Descricao'])."',";
        $str_dados.="'".addslashes($linha['Estoque'])."',";
        $str_dados.="'".addslashes($linha['qtd_bloq'])."',";
		$str_dados.="'".addslashes(str_replace(",",".",number_format(($linha['valor_a']*$vl_cambio_guarani))))."',";
		$str_dados.="'".addslashes(str_replace(",",".",number_format(($linha['valor_b']*$vl_cambio_guarani))))."',";
		$str_dados.="'".addslashes(str_replace(",",".",number_format(($linha['valor_c']*$vl_cambio_guarani))))."'],";
    }
    $str_dados = substr($str_dados,0,strlen($str_dados)-1);
    $str_dados.= "]";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Grid</title>
	<link rel="stylesheet" type="text/css" href="ext-3.1.1/resources/css/ext-all.css" />

	<script type="text/javascript" src="ext-3.1.1/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="ext-3.1.1/ext-all.js"></script>
	<script type="text/javascript" src="js/funcoes.js"></script>
	<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>
    
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>
<script type="text/javascript" src="js/prototype.js"></script>	
<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" />
    
<div align="center" class="Estilo1">
<table width="49%" border="0">
  <tr>
    <td width="15%" bgcolor="#D4D0C8">Codigo:</td>
	<td width="85%">
	<form name="Descricao" method="POST" action="res_pes_prod.php?cli=<?=$_SESSION['cliente']?>">
	<input type="text" size="15" name="ref" id="ref"></td></form>
    <td width="15%" bgcolor="#D4D0C8">Descripcion:</td>
    <td width="85%">
	<form name="Descricao" method="POST" action="res_pes_prod.php?cli=<?=$_SESSION['cliente']?>">
	<input type="text" size="40" name="desc" id="desc"></td>
  </tr></form>
</table>
  <table width="100%" border="0">
    <tr>
      <td bgcolor="#BCD2EF"><div align="center">
          <p class="Estilo3 Estilo2 Estilo4"><strong>PRODUTOS</strong></p>
      </div></td>
    </tr>
  </table>
</div>	
	
<script type="text/javascript">

			
				
				
function lista(id){
//alert(id+"-"+ini+"--"+fim);
var url = 'fotoprod.php';
var pars = 'id=' + id;
var myAjax = new Ajax.Updater(
'conteudo',
url,
{
method: 'get',
parameters: pars
});
}		
		<?  
		if($num_prod == 0){
		$abre = "[";
		}
		else{
		$abre = "";
		}
		?>
		<? if($num_prod > 0){ ?>
		Ext.onReady(function(){
		    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
			var myData = <? echo $abre.$str_dados ?>;

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
		           {name: 'Codigo'},
		           {name: 'Descripcion'},
		           {name: 'Disp'},
		           {name: 'Bloq'},
		           {name: 'A'},
				   {name: 'B'},
				   {name: 'C'}
		        ]
		    });
		    store.loadData(myData);
		    // create the Grid
		    var grid = new Ext.grid.GridPanel({
		        store: store,
		        columns: [
						{id:'id',header: "id", width: 2, hidden: true, sortable: true, dataIndex: 'id'},
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descripcion", width: 250, sortable: true, dataIndex: 'Descripcion'},
						{header: "Disp", width: 80, sortable: true, dataIndex: 'Disp'},
						{header: "Bloq", width: 80, sortable: true, dataIndex: 'Bloq'},
						{header: "Valor A", width: 80, sortable: true, dataIndex: 'A'},
						{header: "Valor B", width: 80, sortable: true, dataIndex: 'B'},	        
						{header: "Valor C", width: 80, sortable: true, dataIndex: 'C'}	        
					],
		        stripeRows: true,
		        viewConfig: {forceFit:true},
		        autoExpandColumn: 'Codigo',
		        height:280,
		        width:1000,
		        title:'Consulta'
		    });
		
		    grid.addListener('keydown',function(event){
				getItemRow(this, event)
			});
		    
		    grid.render('grid');
		    
		    grid.getSelectionModel().selectFirstRow();
			
			grid.on('rowdblclick', function() {
			record = grid.getSelectionModel().getSelected();
			var idName = grid.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);	
			//alert("deu"+idData);
			lista(idData);
			});
			
			jQuery('#ext-gen26').focus();			
		});
		
		function getItemRow(grid, event){
			key = getKey(event);
			record = grid.getSelectionModel().getSelected();
			var idName = grid.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);
			
			var idNamez = grid.getColumnModel().getDataIndex(1); // Get field name
			var idDataz = record.get(idNamez);
			
			if(key==13){
				var prodName = grid.getColumnModel().getDataIndex(1); // Get field name
				var prodData = record.get(prodName);
				url = "pedido.php?acao=add&";
				var query = "id=" + idData + "&prod=" + prodData ;
				url+=query;
				location.assign(url);
			}
			else if(key==32){
				jQuery.ajax({
				   type: "POST",
				   data: "id_prod="+idData + "&cli=" + <?=$_SESSION['cliente']?>,
				   url: "cons_det_produto.php",
				   success: function(msg){
					 jQuery("#conteudo").html(msg);
				   }
				 });
			}
	/*		else if(key==40 || key == 38 ){
				$.ajax({
				   type: "POST",
				   data: "id_prod="+idData,
				   url: "lista_dados_prod.php",
				   success: function(msg){
					 $("#conteudo").html(msg);
				   }
				 });
			}*/
			else if(key >47 && key < 58 || key >64 && key < 91 || key >95 && key < 106 ){
				document.getElementById("ref").focus();
			}
			else if(key==119){
				jQuery.ajax({
				   type: "POST",
				   data: "id_prod="+idData,
				   url: "cons_compral.php",
				   success: function(msg){
					 jQuery("#conteudo").html(msg);
				   }
				 });
			}
			
		}    
		<?
		}
		?>
	</script>
	
</head>
<body>
	<? echo 'Produtos encontrados = '.$num_prod.'' ; 
	   echo "<br />";
	   echo "<br />";
	   echo "<br />";
	
		
	if($num_prod == '0'){
	?>
		<script type="text/javascript">
		document.getElementById("ref").focus();
		</script>
		
		<table width='100%' border='0'>
    	<tr>
        <td bgcolor='#BCD2EF'><div align='center'>
            	   
		Produto nao encontrado, Deseja cadastrar agora? <br/><br/>
		<input type='button' name="voltar" id="voltar" onclick=javascript:window.history.back() value="Voltar" style="background-color: #0000FF; color: #FFFF00; font-style: italic; font-weight: bold; border-style: double; border-width: 1"/>&nbsp;&nbsp;
		<input type='button' name='cadastrar' id='cadastrar' onClick="javascript:location.href='cadastro_prod.php?novo=<?=$_POST['ref']?>&cli=<?=$_SESSION['cliente']?>';" value='Cadastrar' style='background-color: #0000FF; color: #FFFF00; font-style: italic; font-weight: bold; border-style: double; border-width: 1' />
		</td>
		</tr>
		</table>
	<?
	}
	?>	
	
	
	
	
	
	
	
	
	<div id="grid"></div>
	<? if($num_prod > 0){ ?>
	<input type='button' name="voltar" id="voltar" onclick=javascript:window.history.back() value="Voltar" style="background-color: #0000FF; color: #FFFF00; font-style: italic; font-weight: bold; border-style: double; border-width: 1"/>
	<? } ?>
	<div id='conteudo' style="width:1000px"></div>
	<div id="pedido" style="width:1000px"></div>

<script type='text/javascript'>
	jQuery("#ref").autocomplete("pesquisa_codigo.php", {
		width: 260,
		selectFirst: false
		
	});		
	jQuery("#desc").autocomplete("pesquisa_descricao.php", {
		width: 260,
		selectFirst: false
	});		
</script>
</body>
</html>
