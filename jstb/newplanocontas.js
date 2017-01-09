
	
	NewPlanoContas = function(){
	
	Ext.form.Field.prototype.msgTarget = 'side';
	Ext.QuickTips.init();
     	 
    Ext.ns('Ext.ux.tree');
     
    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
	
	var formCrear = new Ext.FormPanel({
			id: 'formCrear',
			labelAlign: 'top',
			height: 180,
			frame       :true,
            layout:'form',
            items:[
				new Ext.ux.MaskedTextField({
				fieldLabel: '<b>Cuenta Base<b>',
				labelWidth: 100,
				mask:'planoconta',
				textReverse : false,
				width: 120,
				readOnly: true,
				name: 'contapai',
				id: 'contapai'
				}),{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: false,
				mode: 'local',
				triggerAction: 'all',
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Acepta Lanzamiento',
				labelWidth: 100,
				id: 'tipo',
				col: true,
				minChars: 2,
				name: 'tipo',
            //    emptyText: 'Codigo',
				width: 120,
				forceSelection: true,
				store: [
                         ['s', 'SI acepta'],
                         ['n', 'NO acepta']
                         ]
                },
				new Ext.ux.MaskedTextField({
				fieldLabel: 'Codigo de Cuenta',
				mask:'planoconta',
				textReverse : false,
				width: 120,
				allowBlank: false,
				name: 'codplan'
			//	id: 'codplan'
				}),
				{
				xtype:'textfield',
				fieldLabel: 'Descripcion',
				allowBlank: false,
				labelWidth: 70,
				col: true,
				width: 300,
				name: 'NomePlan'
				},
				{
				xtype:'button',
           		text: '<b>Crear</b>',
				name: 'Enviar',
				id: 'Enviar',
				scale: 'large',
				col: true,
				iconCls: 'icon-save',
            	handler: function(){
					if(formCrear.getForm().findField('NomePlan').getValue() != '' ){	
					selectedKeys = treePlanoContas.getSelectionModel().selNode.id;
					Ext.Ajax.request({
           					url: 'php/PlanoContas.php',
							method: 'POST',
							remoteSort: true,
           					params: {
							acao: 'CadPlan', 
							NomePlan: formCrear.getForm().findField('NomePlan').getValue(),
							codplan: formCrear.getForm().findField('codplan').getValue(),
							contapai: '1',
							tipo: formCrear.getForm().findField('tipo').getValue(),
							user: id_usuario,
							idpai: selectedKeys
							},
							callback: function (options, success, response) {
										if (success) { 
											var jsonData = Ext.util.JSON.decode(response.responseText);									
												 if(jsonData.response == 'Operacao realizada com sucesso'){ 
													setTimeout(function(){
													treePlanoContas.getSelectionModel().selNode.reload();
													 }, 600);
												}
												 if(jsonData.response == ' Esta conta solamente lanzamientos'){ 
													setTimeout(function(){
													Ext.MessageBox.alert('Sorry',jsonData.response);
													 }, 600);
												}
											
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										
										}
					});
					}
					}
				},
				{
				xtype:'button',
           		text: '<b>Editar</b>',
				name: 'Grabar',
				id: 'Grabar',
				scale: 'large',
				iconCls: 'icon-save',
				hidden: true,
            	handler: function(){
					if(formCrear.getForm().findField('codplan').getValue() != '' ){	
					selectedKeys = treePlanoContas.getSelectionModel().selNode.id;
					Ext.Ajax.request({
           					url: 'php/PlanoContas.php',
							method: 'POST',
							remoteSort: true,
           					params: {
							acao: 'EditPlan', 
							NomePlan: formCrear.getForm().findField('NomePlan').getValue(),
							codplan: formCrear.getForm().findField('codplan').getValue(),
							contapai: formCrear.getForm().findField('contapai').getValue(),
							tipo: formCrear.getForm().findField('tipo').getValue(),
							user: id_usuario,
							idplan: idnode
							},
							callback: function (options, success, response) {
										if (success) { 
											var jsonData = Ext.util.JSON.decode(response.responseText);									
												 if(jsonData.response == 'Operacao realizada com sucesso'){ 
													setTimeout(function(){
													 treePlanoContas.getLoader().load(treePlanoContas.root); 
													 formCrear.getForm().reset();
													 }, 600);
												}
												 if(jsonData.response == ' Esta conta solamente lanzamientos'){ 
													setTimeout(function(){
													Ext.MessageBox.alert('Sorry',jsonData.response);
													 }, 600);
												}
											
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										
										}
					});
					}
				}						
  			 	}				
  			 	
				]
	  }); 

	  
var editarPlan = function(){

var selectednode = treePlanoContas.getSelectionModel().getSelectedNode();
								
selectedKeys = treePlanoContas.getSelectionModel().selNode.id;
	if(selectedKeys.length > 0){	

	formCrear.getForm().findField('contapai').setValue(pnodeID);
	formCrear.getForm().findField('codplan').setValue(cod);
	formCrear.getForm().findField('NomePlan').setValue(desc);
	Ext.getCmp('contapai').getEl().dom.removeAttribute('readOnly');
	
	Ext.getCmp('Enviar').setVisible(false);
	Ext.getCmp('Grabar').setVisible(true);
			}
	
else{
selecione();
}

}
	     
    var treePlanoContas = new Ext.tree.TreePanel({
    id:'treePlanoContas'
    ,autoScroll:true
    ,rootVisible:false
    ,root:{
    nodeType:'async'
    ,id:'root'
    ,text:'Plano de Contas'
    ,expanded:true
    }
    ,loader: {
    url:'php/PlanoContas.php'
    ,baseParams:{
    cmd:'getChildren'
    ,treeTable:'tree2'
    ,treeID:1
    }
    },
	listeners: {
            click: function(n) {
                //Ext.Msg.alert('Navigation Tree Click', 'You clicked: "' + n.attributes.text + '"');
				if(n.attributes.leaf === false){
				formCrear.getForm().findField('contapai').setValue(n.attributes.cod);
				}
				else{
				formCrear.getForm().findField('contapai').setValue("");
				}
				idnode = n.attributes.id;
				cod = n.attributes.cod;
				pnodeID = n.attributes.pnodeID;
				desc = n.attributes.desc;
            }
        },
	tbar : new Ext.Toolbar({
			align:'left',
         	buttons: [	
           				{
           			    text: 'Crear Plan',
						align: 'left',
						iconCls: 'icon-folder_add',
            			handler: function(){ // fechar	
						Ext.getCmp('plano').expand();
						Ext.getCmp('Enviar').setVisible(true);
						Ext.getCmp('Grabar').setVisible(false);
						formCrear.getForm().findField('contapai').setValue();
						formCrear.getForm().findField('codplan').setValue();
						formCrear.getForm().findField('NomePlan').setValue();
						Ext.getCmp('contapai').getEl().dom.setAttribute('readOnly', true);
						}
						},
						'-',
						{
           			    text: 'Editar',
						align: 'left',
						iconCls: 'icon-edit',
            			handler: function(){ // fechar	
							Ext.getCmp('plano').expand();
							editarPlan();
						}
						},
						'-',
						{
           			    text: 'Eliminar',
						align: 'left',
						iconCls: 'icon-excluir',
            			handler: function(){ // fechar	
						Ext.Ajax.request({
							url: 'php/PlanoContas.php',
							params: {
							   idplan: idnode,
							   cod: cod,
							   acao: 'Eliminar'
							},
							callback: function (options, success, response) {
										if (success) { 
											var jsonData = Ext.util.JSON.decode(response.responseText);									
												 if(jsonData.response == 'Operacao realizada com sucesso'){ 
													setTimeout(function(){
													treePlanoContas.getSelectionModel().selNode.remove();
													 }, 600);
												}
												 if(jsonData.response == 'Nao foi possivel'){ 
													setTimeout(function(){
													Ext.MessageBox.alert('Sorry',jsonData.response);
													 }, 600);
												}
												if(jsonData.response == 'Cuentas Filhos Existentes'){ 
													setTimeout(function(){
													Ext.MessageBox.alert('Sorry',jsonData.response);
													 }, 600);
												}
											
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										
										}
						 });
     	    		
						}
						}]
						})
    ,plugins:[new Ext.ux.state.TreePanel()]
    }); // eo tree
	
	treePlanoContas.on('dblclick', function(e) {
	idplano = treePlanoContas.getSelectionModel().selNode.id;
	//console.info(idplano);
	dsContas.load({params: {'idplano': idplano}});
	
		});
	
				
			var dsContas = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/PlanoContas.php',
			method: 'POST'
		}),
		baseParams:{
			acao: 'ListarContas'
			},
		reader:  new Ext.data.JsonReader({
			root: 'Conta',
			id: 'idplanocontas'
		},
			[		
				   {name: 'idplanocontas'},
				   {name: 'plancodigo'},
				   {name: 'plandescricao'},
		           {name: 'plantipo'},
		           {name: 'saldo'}
				
			]
		),
		sortInfo: {field: 'idplanocontas', direction: 'DESC'},
		remoteSort: true,
		autoLoad: true
	});
	
		 var gridContas = new Ext.grid.GridPanel({
	        store: dsContas, 
	        columns:
		        [
						{id:'idplanocontas', hidden: true, width: 2, sortable: true, dataIndex: 'idplanocontas'},
						{header:'Conta', width: 100, sortable: true, dataIndex: 'plancodigo'},
						{header: "Descripcion", width: 200, sortable: true, dataIndex: 'plandescricao'},
						{header: "Tipo", width: 90, align: 'left', sortable: true, dataIndex: 'plantipo'},
						{header: "saldo", width: 100, align: 'right', sortable: true, dataIndex: 'saldo', renderer: 'usMoney'}
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				autoExpandColumn: true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
		//	plugins: [action],
		//	id: 'gridCompras',
			stripeRows : true,
			height: 150,
			ds: dsContas,
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			closable: true,
			title: 'Saldos'
	});
     
	var panel = new Ext.Panel({
		title: 'Plano de Contas'
		,id:'simplestbl'
		,closable: true
		,layout:'border'
		,width:600
		,height:400
		,items:[{
				region:'center'
				,layout:'border'
				,frame:true
				,border:false
				,items:[{
				region:'center'
				,layout:'fit'
				,height: 200
				,frame:true
				,border:false
				,items:[gridContas]
				},{
				region:'south'
				,title: 'Plano de Contas'
				,id: 'plano'
				,collapsible: true
				,collapsed: true
				,layout:'form'
				,border:false
				,height: 200
				,frame:true
				,items:[formCrear]
				}]
				},{
				region:'west'
				,layout:'fit'
				,frame:true
				,border:false
				,width:320
				,split:true
				,title: 'Cuentas'
				,collapsible:true
				,collapseMode:'mini'
				,items:[treePlanoContas]
			}]
		});
		


     
Ext.getCmp('tabss').add(panel);
Ext.getCmp('tabss').setActiveTab(panel);
panel.doLayout();	

Ext.getCmp('plano').collapse();
	
	}
