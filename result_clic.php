<?
    require_once("config.php");
    conexao();
    $cod = isset($_POST['cod']) ? $_POST['cod'] : "1";
    $nom = isset($_POST['nom']) ? $_POST['nom'] : 'a';
	if(empty($nom) or empty($cod)){
	$cod = '1';
	$nom = 'a';
	}
	
?>

<html>
<div align="center" class="Estilo1">
<table width="49%" border="0">
  <tr>
    
    <td width="85%">
	<form name="nome" method="POST" action="result_clic.php">
	
  </tr></form>
</table>
  <table width="100%" border="0">
    <tr>
      <td bgcolor="#DCE4F4"><div align="center">
      </div></td>
    </tr>
  </table>
</div>
<p>	
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title><? echo $title ?></title>
	<link rel="stylesheet" type="text/css" href="ext-3.1.1/resources/css/ext-all.css" />
 	<script type="text/javascript" src="ext-3.1.1/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="ext-3.1.1/ext-all.js"></script>
	<link rel="stylesheet" type="text/css" href="ext-3.1.1/resources/css/xtheme-access.css" />
	<link rel="stylesheet" type="text/css" href="css/forms.css"/>
	<script type="text/javascript" src="jss/override.js"></script>
	
	
	<script type="text/javascript">
	function getKey(e){
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
  window.location.href='cotizacion.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}

		Ext.onReady(function(){
		    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
			

		    // example of custom renderer function
		    function change(val){
		        if(val > 0){
		            return '<span style="color:green;">' + val + '</span>';
		        }else if(val < 0){
		            return '<span style="color:red;">' + val + '</span>';
		        }
		        return val;
		    }
		   
			
			var store = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/Result_Cli.php?cod='+<?=$cod?>+"&nom="+'<?=$nom?>',
			method: 'POST'
		}),
		baseParams:{
			acao: 'ListaCli'
			},
		reader:  new Ext.data.JsonReader({
			root: 'Clientes',
			id: 'controle'
		},
			[		
				   {name: 'controle'},
				   {name: 'nome'},
		           {name: 'ativo'},
		           {name: 'ruc'},
		           {name: 'telefonecom'}
				
			]
		),
		sortInfo: {field: 'controle', direction: 'DESC'},
		remoteSort: true,
		autoLoad: true
	});
		  
		    // create the Grid
		    var gridCli = new Ext.grid.GridPanel({
		        store: store,
		        columns: [
						{id:'controle', width: 60, sortable: true, dataIndex: 'controle'},
						{header: "Nome", width: 150, sortable: true, dataIndex: 'nome'},
						{header: "Ativo", width: 80, sortable: true, dataIndex: 'ativo'},
						{header: "Ruc", width: 80, sortable: true, dataIndex: 'ruc'},
						{header: "Fone", width: 80, sortable: true, dataIndex: 'telefonecom'}
						   
					],
		        stripeRows: true,
		        viewConfig: {forceFit:true},
		        autoExpandColumn: 'Nome',
		        height:350,
				renderTo:'grid',
		        autoWidth:true,
		        title:'Clientes',
				tbar: [
				'Nome: ',
				{
				xtype: 'textfield',
				fieldLabel: 'Nome',
				id: 'NomCli',
				name: 'NomCli',
				allowBlank: true,
				width: 250,
				fireKey: function(e,type){
					if(e.getKey() == e.ENTER ) {
							     nomeCl = Ext.getCmp('NomCli').getValue();
									store.load({params: {nomeCl: nomeCl, acao: 'pesquisa'}});
									Ext.getCmp('NomCli').setValue();
				}
				if(e.getKey() == 40) {
							   gridCli.getSelectionModel().selectFirstRow();
							   gridCli.getView().focusEl.focus();
                            }
				}
				}
				],
				bbar:[
				{
				iconCls: 'icon-user',
				text: 'Cadastrar Nuevo',
				handler: function(){ // fechar				
					Novo();
				}
				},
				'-',
				{
				iconCls: 'icon-undo',
				text: 'Tela Anterior',
				handler: function(){ // fechar				
					navegacao('Nueva');
				}
				},
				'-'
				
				]
				
		    });
		
		    gridCli.addListener('keydown',function(event){
				getItemRow(this, event)
			});
			
			store.on('load',function(){
            gridCli.getSelectionModel().selectFirstRow();
            gridCli.getView().focusEl.focus();
        },this);
		   		
		
		
		function getItemRow(grid, event){
			key = getKey(event);
			record = gridCli.getSelectionModel().getSelected();
			var idName = gridCli.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);		
			
			if(key==13){
				var prodName = gridCli.getColumnModel().getDataIndex(0); // Get field name
				var prodData = record.get(prodName);
				url = "cotizacion.php?acao=addc&";
					var query = "controleCli=" + idData + "&cli=" +prodData ;
				url+=query;
				location.assign(url);
			}
			else if(key >47 && key < 58 || key >64 && key < 91 ){
				document.getElementById("NomCli").focus();
			}
			
		}

		
		
var cadastronovo;
  cadastronovo = Ext.get('cadastroNovo');
//cadastronovo.on('click', function(e){ 

Novo = function(){
var FormCadastraCliNovo = new Ext.FormPanel({
        labelAlign: 'left',
        frame:true,
        autoWidth: true,
		labelWidth: 60,
        items: [
				{
                    xtype:'textfield',
                    fieldLabel: 'Nombre',
					anchor:'95%',
					id: 'nomeCad',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('razaoCad').focus();
                            }}

                },
				{
                    xtype:'textfield',
                    fieldLabel: 'Direccion',
					id: 'enderecoCad',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('emailCad').focus();
                            }}
                },
				{
					xtype:'textfield',
                    fieldLabel: 'Telefone',
					id: 'telefonecomCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('faxCad').focus();
                            }}
                },
				{
                    xtype:'textfield',
                    fieldLabel: 'Ruc',
					id: 'rucCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('cedulaCad').focus();
                            }}
                }
		]
		
});

				Mywin_cadnovoUi = Ext.extend(Ext.Window, {
					id: 'Wincadnovo'
					, border 	: false
					, title: "Cadastro de cliente"
	                , layout: 'form'
	                , width: 350
					, height: 200
	                , closeAction :'close'
	                , plain: true
					, modal: true
					, initComponent: function() {
					  this.items = [FormCadastraCliNovo];
					  Mywin_cadnovoUi.superclass.initComponent.call(this);
						}
					,buttons: [
           						
					{
			xtype: 'button',
			id: 'cadastrar',
            text: 'Cadastrar',
			iconCls: 'icon-save',
			width: 20,
			handler: function(){
			FormCadastraCliNovo.getForm().submit({
				url: "php/cadastra_cliente.php"
				, waitMsg: 'Cadastrando'
				, waitTitle : 'Aguarde....'
				, scope: this
				, success: OnSuccess
				, failure: OnFailure
			}); 
			function OnSuccess(form,action){
				alert(action.result.msg);
			}
			
			function OnFailure(form,action){
				alert(action.result.msg);
			}
			}
        },
		{	xtype: 'button',
            text: 'Limpar',
			col:true,
			handler: function(){ // Fun??o executada quando o Button ? clicado
			FormCadastraCliNovo.getForm().reset();
			Ext.get('nomeCad').focus();
  			 }

        },
		{
            text: 'Cerrar',
            handler: function(){ // fechar	
				FormCadastraCliNovo.getForm().reset();
     	    	Wincadnovo.close();
  			 		}
		}
					]
					,focus: function(){
 	   					 Ext.get('nomeCad').focus();
						}

				});
				Wincadnovo = new Mywin_cadnovoUi();
				Wincadnovo.show();

//});		
}
});

		function setaFoco(){
			document.getElementById('grid').focus()
		}
	</script>
</head>
<body>
	<div id="divnom"></div>
	<div id="grid"></div>
	<br/><br/>
	<div id='conteudo' style="width:1000px"></div>
	<p><font face="Arial">
<!--  <input name="button" type="button" onClick="window.close()" value="Abandonar" /> -->
</font>
<!--  <input type="button" value="Volver" name="LINK12" onClick="navegacao('Nueva')" /> -->
<!-- <input type="button" value="Cadastrar Nuevo" id="cadastroNovo" /></p></p> -->
</body>
</html>