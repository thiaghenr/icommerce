<?
    require_once("config.php");
    conexao();
    $cod = $_POST['cod'];
    $nom = $_POST['nom'];
  //  $sql = "SELECT controle,nome,endereco,telefonecom FROM clientes limit 0,200";
    $sql = "SELECT * FROM clientes WHERE controle LIKE '%$cod%' AND nome LIKE '%$nom%'   ORDER BY nome asc limit 0,50";
	
	    $rs = mysql_query($sql) or die (mysql_error());
		$num_cli = mysql_num_rows($rs);
    $str_dados="[";
    while($linha=mysql_fetch_array($rs)){
        $str_dados.="['".addslashes($linha['controle'])."',";
        $str_dados.="'".addslashes($linha['nome'])."',";
        $str_dados.="'".addslashes($linha['abrv'])."',";
        $str_dados.="'".addslashes($linha['telefonecom'])."',";
		$str_dados.="'".addslashes($linha['ativo'])."'],";
    }
    $str_dados = substr($str_dados,0,strlen($str_dados)-1);
    $str_dados.= "]";

?>

<html>
<div align="center" class="Estilo1">
<table width="49%" border="0">
  <tr>
    <td width="15%" bgcolor="#D4D0C8">Nombre:</td>
    <td width="85%">
	<form name="nome" method="POST" action="lista_cli.php">
	<input type="text" size="40" name="nom" value="<?=$_SESSION['nomeCli']?>"></td>
  </tr></form>
</table>
  <table width="100%" border="0">
    <tr>
      <td bgcolor="#DCE4F4"><div align="center">
          <p><strong>CLIENTES</strong></p>
      </div></td>
    </tr>
  </table>
</div>
<p>	
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title><? echo $title ?></title>
	<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />

	<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="ext/ext-all.js"></script>
	<script type="text/javascript" src="js/funcoes.js"></script>
	<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>	
	<script type="text/javascript" src="js/prototype.js"></script>	
	<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
	<script type="text/javascript">
function lista(id){
//	alert(id);
var url = 'bloqueia_cli.php';
var pars = 'cli=' + id;
var myAjax = new Ajax.Updater(
'conteudo',
url,
{
method: 'get',
parameters: pars
});
}
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
		           {name: 'Nome'},
		           {name: 'Abrv'},
				   {name: 'Fone'},
				   {name: 'Ativo'}
		        ]
		    });
		    store.loadData(myData);
		    // create the Grid
		    var grid = new Ext.grid.GridPanel({
		        store: store,
		        columns: [
						{id:'Codigo',header: "Codigo", width: 60, sortable: true, dataIndex: 'Codigo'},
						{header: "Nome", width: 150, sortable: true, dataIndex: 'Nome'},
						{header: "Abrv", width: 80, sortable: true, dataIndex: 'Abrv'},
						{header: "Fone", width: 80, sortable: true, dataIndex: 'Fone'},
						{header: "Ativo", width: 80, sortable: true, dataIndex: 'Ativo'}       
					],
		        stripeRows: true,
		        viewConfig: {forceFit:true},
		        autoExpandColumn: 'company',
		        height:350,
		        width:900,
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
			
		//	$('#ext-gen26').focus();			
		});
		
		function getItemRow(grid, event){
			key = getKey(event);
			record = grid.getSelectionModel().getSelected();
			var idName = grid.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);		
			
			if(key==13){
				var prodName = grid.getColumnModel().getDataIndex(1); // Get field name
				var prodData = record.get(prodName);
				url = "cotizacion.php?acao=addc&";
					var query = "controleCli=" + idData + "&cli=" +prodData ;
				url+=query;
				location.assign(url);
			}
			else if(key >47 && key < 58 || key >64 && key < 91 ){
				document.getElementById("nom").focus();
			}
			
		}    
	</script>
</head>
<body>
	<div id="grid"></div>
	<br/><br/>
	<div id='conteudo' style="width:1000px"></div>
</body>
</html>