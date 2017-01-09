<?
//require_once("verifica_login.php");
include "config.php";
require_once("biblioteca.php");
conexao();


/*
$tela = cadastro_prod;

	$sql_tela = "SELECT * FROM telas WHERE tela = '$tela' ";
	$exe_tela = mysql_query($sql_tela);
	$reg_tela = mysql_fetch_array($exe_tela);
	
	$perfil_tela = $reg_tela['perfil_tela'];
	
	if ($perfil_tela < $perfil_id) {
	echo "Acesso nao Autorizado";
	exit;
	}

echo $_GET['cadastrado'];

*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Comissoes</title>
<link rel="stylesheet" type="text/css" href="ext-3.2.1/resources/css/ext-all.css" />
<script type="text/javascript" src="ext-3.2.1/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext-3.2.1/ext-all.js"></script>
<script type="text/javascript" src="js/MaskedTextField-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="css/forms.css"/>




<style type="text/css">

body {
	color: #ACB9D0;
	padding:3px 5px 3px 8px;
	background:#ACB9D0;
	border-width:5px;
	border-style:solid;
	border-color:#939afb6;
	}
#esquerda {
	width: 280px;
	height: 600px;
	float: left;
	margin-top:20px;
	
}
#direita {
	width:630px;
	height:600px;
	float:right;
	margin-top: 20px;
	margin-right:5px;
}
#grid{
	width:300px;
	height:auto;
	color:#006600;
	float: left;
	background:#FFFFFF;
	border-right-color:#0000FF;
	padding-right:1px;
	padding-bottom:1px;
	padding-left:1px;
	padding-top:1px;
	margin-top:30px;
	clear:left;
	}
	#gridb{
	width:629px;
	height:496px;
	color:#006600;
	float: left;
	background:#FFFFFF;
	border-right-color:#0000FF;
	padding-right:1px;
	padding-bottom:1px;
	padding-left:1px;
	padding-top:1px;
	margin-top:30px;
	clear:left;
	}
</style>

 <? 
  	
	
  	$sql = "SELECT u.nome, u.id_usuario,u.usuario, e.nome FROM usuario u, entidades e WHERE e.controle = u.entidadeid order by id_usuario asc ";
	$exe = mysql_query($sql)or die (mysql_error());
	
	//echo "oi";
	//exit();
	$str_dados="[";
	while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
		//$total += $reg['valor'];

		$str_dados.="['".addslashes($reg['id_usuario'])."',";
		$str_dados.="'".addslashes($reg['nome'])."',";
		$str_dados.="'".addslashes($reg['usuario'])."'],";
		
		}
    $str_dados = substr($str_dados,0,strlen($str_dados)-1);
    $str_dados.= "]";
	
	//	echo $str_dados;
?>  
 <script type="text/javascript">
		Ext.onReady(function(){
		Ext.QuickTips.init();
		    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
			var myData = <? echo $str_dados ?>;

       var xgCom = Ext.grid;
	   
	   var relatorioPeriodo = function(){
var dtini = Ext.get('dataini').getValue();
var dtfim = Ext.get('datafim').getValue();
if(dtini.length > 0){		

var win_relatorio_periodo = new Ext.Window({
					id: 'win_relatorio_comissoes',
					title: 'Relatorio no Periodo',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='relatorio_com.php?dtini="+dtini+"&dtfim="+dtfim+"&vendedor="+idData+"' > </iframe>"},
					buttons: [
           						{
            					text: 'Sair',
            					handler: function(){ // fechar	
     	    					win_relatorio_periodo.destroy();
  			 					}
			 
        					}]
				});
win_relatorio_periodo.show();
}
else{
//selecione();
}			
}

	   
	   
	   simplePedidos = new Ext.FormPanel({
		    autoWidth: true,
			id: 'simplePedidos',
	       // labelWidth: 75,
		    height: 70,
			renderTo: 'grid',
	        frame:true,
	        bodyStyle:'padding:5px 5px 0',
	       // defaultType: 'textfield',
			items:[
					{
					xtype: 'datefield',
	                fieldLabel: 'Data inicial',
	                name: 'dataini',
					id: 'dataini',
					format: 'd/m/Y',
					width: 120,
	                allowBlank:false
					},
					{
					xtype: 'datefield',
	                fieldLabel: 'Data Final',
	                name: 'datafim',
					id: 'datafim',
					format: 'd/m/Y',
					width: 120,
	                allowBlank:false
					}
					]
					});
 

		    // create the data store
		    var store = new Ext.data.SimpleStore({
		        fields: [
		           {name: 'Codigo'},		           
				   {name: 'Nome'},
				   {name: 'Usuario'}
				   
		        ]
		    });
		    store.loadData(myData);
		    // create the Grid
		    var grid = new Ext.grid.GridPanel({
		        store: store,
		        columns: [
						{id:'Codigo',header: "Codigo", width: 30, sortable: true, dataIndex: 'Codigo'},        
						{header: "Nome", width: 110, sortable: true, dataIndex: 'Nome'},
						{header: "Usuario", width: 70, sortable: true, dataIndex: 'Usuario'}
						
					],
		        stripeRows: true,
		        viewConfig: {forceFit:true},
		        autoExpandColumn: 'Codigo',
				renderTo: 'grid',
		        height:402,
		        width:300,
		        title:'Funcionarios'
		    });
		
		//    grid.addListener('keydown',function(event){
		//		getItemRow(this, event)
		//	});
		    
		    //grid.render('grid');	
			
			//grid.getSelectionModel().selectFirstRow();
			grid.on('rowclick', function(){
			record = grid.getSelectionModel().getSelected();
			var idName = grid.getColumnModel().getDataIndex(0); // Get field name
			    idData = record.get(idName);	
			var dtini = Ext.getCmp('dataini').getValue();
			var dtfim = Ext.getCmp('datafim').getValue();
				if(dtini.length != '' || dtfim.length != ''){
	 				//Ext.MessageBox.alert('Aviso','Entre com as Datas corretamente.');
			dsUser.removeAll();
			dsUser.reload(({params:{'acao':'listaUser', 'vendedor': idData, 'dtini': dtini, 'dtfim': dtfim, 'start':0, 'limit':200}}));
			}
			});
			
			
		    
			
		//////////INICIO DA STORE ////////////////////
		var dsUser = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/comissoes_vend.php',
			method: 'POST'
		}),  
		 
		reader:  new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'id',
			fields:[
					{name: 'id'},
					{name: 'nome_cli'},
					{name: 'data_car', dateFormat: 'd-m-Y'},
					{name: 'st_venda'},
					{name: 'nome_user'},
					{name: 'custo_total'},
					{name: 'custo_grn'},
					{name: 'valor_venda'},
					{name: 'comissao'}
					]
		}),
		sortInfo: {field: 'id', direction: 'DESC'},
		remoteSort: true
	});
//////// FIM STORE //////////////
//////// INICIO DA GRID  ////////
 var grid_Comissoes = new Ext.grid.GridPanel(
	    {
	        store: dsUser, // use the datasource
	        
	         cm: new xgCom.ColumnModel(
		        [
						{id:'id',header: "Pedido", width: 40, sortable: true, dataIndex: 'id'},	        
						{id:'nome_cli',header: "Nome", width: 90, dataIndex: 'nome_cli'},
						{id:'data_car',header: "Data", width: 50, dateFormat: 'd-m-Y', dataIndex: 'data_car'},
						{header: "Status",  width: 40, align: 'center', dataIndex: 'st_venda'},
						{id:'nome_user',header: "Vendedor", hidden: true,  width: 50, dataIndex: 'nome_user'},
						{header: "Total Nota", width: 65, dataIndex: 'valor_venda', align: 'right', renderer: 'usMoney'},
						{header: "Comissao", width: 65, dataIndex: 'comissao', align: 'right', renderer: 'usMoney'}
			 ]),
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			width:'100%',
			title:'Vendas',
			autoExpandColumn: 'nome_cli',
			renderTo: 'gridb',
			height: 430,
			ds: dsUser,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dsUser,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Nao tem dados",
				pageSize: 200,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				//items:[],
				refreshText : "Atualizar",
				paramNames : {start: 'start', limit: 'limit'},
				items:[ /*{
                    xtype:'button',
					text: 'Imprimir',
					style: 'margin-left:7px',
					iconCls: 'icon-print',
					handler: function(){
						relatorioPeriodo();
					}
					}*/]
			})
});			
		
		dsUser.on('load', function(ds){
			var totalVendas = ds.reader.jsonData.totalNotas;
			Ext.getCmp('TotalNota').setValue(Ext.util.Format.usMoney(totalVendas));
			
			var totalComissao = ds.reader.jsonData.totalComissao;
			Ext.getCmp('TotalComissao').setValue(Ext.util.Format.usMoney(totalComissao));
			
			
			var TPercentual = ds.reader.jsonData.Percentual;
			Ext.getCmp('Percentual').setValue(Ext.util.Format.usMoney(TPercentual));
			
			});
		
		var totais = new Ext.FormPanel({
        //labelAlign: 'top',
        frame:true,
        bodyStyle:'padding:5px 5px 0',
        autowidth: true,
		renderTo: 'gridb',
		autoHeight: true,
        items: [
		 {  // ABRE A1
				   layout:'column',
				   border: false,
            	items:[		// ABRE B
					   {   // ABRE B1
                columnWidth:.4,
				layout: 'form',
				border: true,
                items: [
				 	{
					xtype:'textfield',
                    fieldLabel: 'Total Notas',
					readOnly: true,
					renderer: 'usMoney',
					id: 'TotalNota',
                    name: 'TotalNota'
				},
				
				 	
				{
				 	xtype:'textfield',
                    fieldLabel: 'Percentual',
					readOnly: true,
					id: 'Percentual',
                    name: 'Percentual'
				}
				]},
				{   // ABRE B1
                columnWidth:.4,
				layout: 'form',
				border: true,
                items: [
				{
					xtype:'textfield',
					fieldLabel: 100,
                    fieldLabel: 'Valor Comissao',
					readOnly: true,
					id: 'TotalComissao',
                    name: 'TotalComissao'
				}
				]
				}
				
				
				]}
				
				]
				});
		
});       	
	</script> 
<body>
<div id="esquerda">
<div id="grid"></div>
</div>

<div id="direita">
<div id="gridb"></div>
</div>


<p>&nbsp;</p>
</body>
</head>
</html>
