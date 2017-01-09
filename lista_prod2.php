<?
	require_once("biblioteca.php");
 	require_once("config.php");
    conexao();
	$desc = $_POST['desc'];
	$ref = $_POST['ref'];

    $sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id DESC";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
   
    $id_prod = addslashes(htmlentities($_GET['desc']));
    $sql = "SELECT * FROM produtos WHERE ((Descricao LIKE '%$desc%') AND (Codigo LIKE '$ref%')) OR ((cod_original2 LIKE '$ref%') AND (Descricao LIKE '$desc%') ) OR ((cod_original LIKE '$ref%') AND (Descricao LIKE '$desc%')) OR ((Codigo_Fabricante LIKE '$ref%') AND (Descricao LIKE '$desc%')) OR ((Codigo_Fabricante2 LIKE '$ref%') AND (Descricao LIKE '$desc%')) OR ((Codigo_Fabricante3 LIKE '$ref%') AND (Descricao LIKE '$desc%')) ORDER BY Codigo ASC limit 0,100 ";
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
		$str_dados.="'".addslashes(str_replace(",",".",number_format(($linha['valor_a']))))."',";
		$str_dados.="'".addslashes(str_replace(",",".",number_format(($linha['valor_b']))))."',";
		$str_dados.="'".addslashes(str_replace(",",".",number_format(($linha['valor_c']))))."'],";
    }
    $str_dados = substr($str_dados,0,strlen($str_dados)-1);
    $str_dados.= "]";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>LISTA DE PRODUTOS - Todo Camiones</title>
	<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />

	<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="ext/ext-all.js"></script>
	<script type="text/javascript" src="js/funcoes.js"></script>
	<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>	
    
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>





<link rel="stylesheet" type="text/css" href="js/jquery/autcomplete/jquery.autocomplete.css" />
	<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #EFEFEF;
border-width:2px;
border-style:solid;
border-color:#a2bfe9;
}
#pedido{
	width:800px;
	height:auto;
	float:left;
	}

</style> <script type="text/javascript" src="js/prototype.js"></script>	
</head>
<div align="center" class="Estilo1">
<table width="49%" border="0">
  <tr>
    <td width="15%" bgcolor="#DCE4F4">Codigo:</td>
	<td width="85%">
	<form name="Descricao" method="POST" action="lista_prod.php">
	<input type="text" size="15" id="ref" name="ref"></td></form>
    <td width="15%" bgcolor="#DCE4F4">Descripcion:</td>
    <td width="85%">
	<form name="Descricao" method="POST" action="lista_prod.php">
	<input type="text" size="40" name="desc" id="desc"></td>
  </tr></form>


</table>
  <table width="100%" border="0">
    <tr>
      <td bgcolor="#OEEAEO"><div align="center">
          <p><strong>LISTA GERAL DE PRODUTOS</strong></p>
      </div></td>
    </tr>
  </table>
</div>
<p>
<head>
<script>
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

function pegaKey(e){
	var tecla;
	if(!e)
		e = window.event;
	if(e.keyCode)
		tecla = e.keyCode;
	else if(e.which)
		tecla = e.which;
	return tecla;
}


function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='';
 }
 else if(lugar=='Nueva'){
  window.location.href='';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}


		function setaFoco(){
			document.getElementById('ref').focus()
		}


</script>
	
	<script type="text/javascript">
		Ext.onReady(function(){
		    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
			var myData = <? echo $str_dados ?>;

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
						{id:'id',header: "id", width: 2, sortable: true, dataIndex: 'id'},
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
		        autoExpandColumn: 'company',
		        height:280,
		        width:995,
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
			
			if(key==13){
				var prodName = grid.getColumnModel().getDataIndex(1); // Get field name
				var prodData = record.get(prodName);
				url = "lista_prod.php?acao=add&"; 
				var query = "id=" + idData + "&prod=" + prodData;
				url+=query;
				location.assign(url);
			}
			else if(key==32){
				jQuery.ajax({
				   type: "POST",
				   data: "id_prod="+idData,
				   url: "cons_det_produtol.php",
				   success: function(msg){
					 jQuery("#conteudo").html(msg);
				   }
				 });
			}
						
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
/*	$(document).ready(function(){ 
	function mostra(id){
	alert("deu"); /*
				$.ajax({
				   type: "POST",
				   data: "ide="+id,
				   url: "cons_det_produtol.php",
				   success: function(msg){
					 $("#conteudo").html(msg);
				   }
				 });
			} }) */
	jQuery(document).ready(function() {    
    jQuery('mostra').click(function(){           
        alert('Ola Mundo');
    });
});

	
	
	</script>
</head>
<body onLoad="setaFoco()">
	<? echo 'Produtos encontrados = '.$num_prod.'' ; ?>
	<div id="grid"></div>
	<br/><br/>
	<div id="conteudo" style="width:1000px"></div>
	<div id="pedido" style="width:1000px"></div>
    <script type='text/javascript'>
	</script>
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