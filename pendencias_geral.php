<?
	require_once("biblioteca.php");
 	require_once("config.php");
    conexao();
	$desc = $_POST['desc'];
	$ref = $_POST['ref'];
	
	$sql_lista = "SELECT DISTINCT it.*, p.custo,Estoque,Descricao,valor_a,valor_b,valor_c, pd.cotacao_id  FROM itens_pendencias it, produtos p, pendencias pd WHERE it.produtos_codigo = p.Codigo AND it.pendencias_id = pd.id GROUP BY it.produtos_codigo ASC ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	
		//	while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			
	
	
	

      $sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id";
      $rs_cambio = mysql_query($sql_cambio);
      $linha_cambio = mysql_fetch_array($rs_cambio);
      $vl_cambio_guarani = $linha_cambio['vl_cambio'];
   
    //$id_prod = addslashes(htmlentities($_GET['desc']));
    
//	$sql = "SELECT Descricao,Codigo FROM produtos WHERE Codigo = '".$reg_lista['produtos_codigo']."' ";
 //   $rs = mysql_query($sql) or die (mysql_error());
//	$num_prod = mysql_num_rows($rs);
	
//	while ($reg_listas = mysql_fetch_array($rs, MYSQL_ASSOC)) {
	
		
    $str_dados="[";
    while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
	
			$data2 = $reg_lista['dt_item'];
			$hora2 = $reg_lista['dt_item'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			//$novovalor = $linha['valor_c'] * $vl_cambio_guarani ;
        $str_dados.="['".addslashes($reg_lista['produtos_codigo'])."',";
        $str_dados.="'".addslashes($reg_lista['Descricao'])."',";
		$str_dados.="'".addslashes($reg_lista['custo'])."',";
        $str_dados.="'".addslashes($reg_lista['Estoque'])."',";
        $str_dados.="'".addslashes($reg_lista['qtd'])."',";
		$str_dados.="'".addslashes(str_replace(",",".",guarani(($reg_lista['vl_preco']))))."',";
		$str_dados.="'".addslashes($novadata)."',";
		$str_dados.="'".addslashes($reg_lista['cotacao_id'])."'],";
    }
	//}
//	}
    $str_dados = substr($str_dados,0,strlen($str_dados)-1);
    $str_dados.= "]";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>PRODUTOS PENDENTES AO CLIENTE - <? echo $title ?></title>
	<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />

	<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="ext/ext-all.js"></script>
	<script type="text/javascript" src="js/funcoes.js"></script>
	<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>	
	
<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #FFFFFF;
border-width:2px;
border-style:solid;
border-color:#a2bfe9;
}


</style>
</head>
<div align="center" class="Estilo1">

  <table width="100%" border="0">
    <tr>
      <td bgcolor="#OEEAEO"><div align="center">
          <p><strong>PRODUTOS PENDENTES AO CLIENTE</strong></p>
      </div></td>
    </tr>
  </table>
</div>
<p>
<head>
<script>
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
  window.location.href='pendencias_cli.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='pendencias_cli.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
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
		           {name: 'Codigo'},
		           {name: 'Descripcion'},
				   {name: 'Custo'},
		           {name: 'Estoque'},
		           {name: 'Qt Pendente'},
		           {name: 'Valor Negociado'},
				   {name: 'Data'},
				   {name: 'Pedido'}
		        ]
		    });
		    store.loadData(myData);
		    // create the Grid
		    var grid = new Ext.grid.GridPanel({
		        store: store,
		        columns: [
						{id:'Codigo',header: "Codigo", width: 70, sortable: true, dataIndex: 'Codigo'},
						{header: "Descripcion", width: 250, sortable: true, dataIndex: 'Descripcion'},
						{header: "Custo", width: 70, sortable: true, dataIndex: 'Custo'},
						{header: "Estoque", width: 50, sortable: true, dataIndex: 'Estoque'},
						{header: "Qt Pendente", width: 50, sortable: true, dataIndex: 'Qt Pendente'},
						{header: "Valor Negociado", width: 80, sortable: true, dataIndex: 'Valor Negociado'},
						{header: "Data", width: 80, sortable: true, dataIndex: 'Data'},	        
						{header: "Pedido", width: 80, sortable: true, dataIndex: 'Pedido'}	        
					],
		        stripeRows: true,
		        viewConfig: {forceFit:true},
		        autoExpandColumn: 'company',
		        height:450,
		        width:995,
		        title:'Consulta'
		    });
		
		    grid.addListener('keydown',function(event){
				getItemRow(this, event)
			});
		    
		    grid.render('grid');
		    
		    grid.getSelectionModel().selectFirstRow();
			
			$('#ext-gen26').focus();			
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
				$.ajax({
				   type: "POST",
				   data: "id_prod="+idData,
				   url: "cons_det_produtol.php",
				   success: function(msg){
					 $("#conteudo").html(msg);
				   }
				 });
			}
		}    
	</script>
</head>
<body>
	<? echo 'Produtos encontrados = '.$num_lista.'' ; ?>
	<div id="grid"></div>
	<span style="width:1000px">
	<input type="button" value="Voltar" name="LINK12" onClick="navegacao('Nueva')" />
	</span><br/>
	<br/>
	<div id='conteudo' style="width:1000px"></div>
</body>
</html>