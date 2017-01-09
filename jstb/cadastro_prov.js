// JavaScript Document


CadProv = function(){
	
//if(perm.cadastro_clientes.acessar == 0){
//return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
//}


Ext.QuickTips.init();

Ext.form.Field.prototype.msgTarget = 'side';
Ext.form.FormPanel.prototype.bodyStyle = 'padding:5px';
Ext.form.FormPanel.prototype.labelAlign = 'right';


//////// INICIO DA GRID DOS VENDIDOS ////////
var dsProvs= new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/cadastro_prov.php',
			method: 'POST'
		}), 
		listeners:{
   				load:function(){
				//imagem = dsProvs.getAt(0).get('imagem');
				// console.info(imagem);
  			 }
			},  
		reader:  new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'nome'},
		           {name: 'telefone'},
				   {name: 'celular'},
		           {name: 'fax'},
		           {name: 'cedula'},
		           {name: 'razao_social'},
				   {name: 'cidade'},
				   {name: 'nomecidade'},
				   {name: 'cgc'},
		           {name: 'email'},
		           {name: 'obs'},
		           {name: 'endereco'},
				   {name: 'ruc'}
				
			]
		),
		autoLoad: true,
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		remoteSort: true		
	});
	
 var gridProvs = new Ext.grid.GridPanel({
	        store: dsProvs, // use the datasource
	        columns:[
						{id:'id',header: "Codigo", width: 50, sortable: true, dataIndex: 'id'},
						{header: 'Nombre', width:230, sortable: true, dataIndex: 'nome'},
						{header: "Ruc", width: 80, sortable: true, dataIndex: 'ruc'},
						{header: "Cidade", width: 90, align: 'left', sortable: true, dataIndex: 'nomecidade'},
						{header: "email", width: 230,  align: 'left',  sortable: true, dataIndex: 'email'}
			 ],
	        viewConfig:{
	            forceFit:true
	        },
			width:'100%',
			id: 'id',
			height: 250,
			ds: dsProvs,
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			autoScroll: true
		});
 ////////FIM GRID DOS DETALHES ///////////////////////////////////////////////////


    var FormCadastraProv = new Ext.FormPanel({
        labelAlign: 'left',
		ds: dsProvs,
        frame:true,
        title: 'Cadastro de Proveedores',
       // bodyStyle:'padding:5px 5px 0',
       // autoWidth: true,
		split: true,
		closable: true,
		layout: 'form',
		autoScroll:true,
        items: [{
                    xtype:'textfield',
                    fieldLabel: 'Nombre',
					id: 'nomeprov',
                    name: 'nomeprov',
                    width: 250,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('rucCad').focus();
                            }}

                }, 
					{
                    xtype:'textfield',
                    fieldLabel: 'Ruc',
					//labelWidth: 30, 
                    name: 'rucCad',
					id: 'rucCad',
					col: true,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('cedulaCad').focus();
                            }}
                },
				{
                    xtype:'textfield',
                    fieldLabel: 'Cedula',
					//labelWidth: 40, 
					id: 'cedulaCad',
                    name: 'cedulaCad',
                    col: true,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('enderecoCad').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Endereco',
					id: 'enderecoCad',
                    name: 'enderecoCad',
                    width: 250,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('telefonecomCad').focus();
                            }}
                },
                    new Ext.ux.MaskedTextField({
					mask:'phone',
					col: true,
                    fieldLabel: 'Fone',
					id: 'telefonecomCad',
                    name: 'telefonecomCad',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('celularCad').focus();
                            }}
                }),
					
                    new Ext.ux.MaskedTextField({
					mask:'phone',
                    fieldLabel: 'Celular',
					col: true,
					id: 'celularCad',
                    name: 'celularCad',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('razaoCad').focus();
                            }}
                }),
					
					{
                    xtype:'textfield',
                    fieldLabel: 'Razao Social',
					width: 250,
					id: 'razaoCad',
                    name: 'razaoCad',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('faxCad').focus();
                            }}
                },
				 new Ext.ux.MaskedTextField({
					mask:'phone',
                    fieldLabel: 'Fax',
					id: 'faxCad',
                    name: 'faxCad',
					col: true,
                    width: true,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('emailCad').focus();
                            }}
                }),
				{
                    xtype:'textfield',
                    fieldLabel: 'Codigo',
					id: 'Codigo',
                    name: 'Codigo',
					//disabled: true,
					col: true,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('rucCad').focus();
                            }}
                },
					
					{
                    xtype:'textfield',
                    fieldLabel: 'Email',
					id: 'emailCad',
                    name: 'emailCad',
					width: 250,
                    //vtype:'email',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('idCidades').focus();
                            }}
                },
				{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['idcidade','nomecidade'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Cidade',
				id: 'idCidades',
				minChars: 2,
				name: 'idCidades',
                resizable: true,
                listWidth: 300,
				col: true,
				store: new Ext.data.JsonStore({
				url: 'php/pesquisa_cidade.php',
				root: 'resultados',
				fields: [ 'idcidade', 'nomecidade' ]
				}),
					hiddenName: 'idcidade',
					valueField: 'idcidade',
					displayField: 'nomecidade',
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						  document.getElementById('cgc').focus();
						}
					}
							
                },	
			{
            xtype:'textfield',
            id:'cgc',
			name: 'cgc',
            fieldLabel:'CNPJ',
			width: 250,
			fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						  document.getElementById('obsprovCad').focus();
						}
					}
			},
				
			{
            xtype:'textfield',
            id:'obsprovCad',
			name: 'obsprovCad',
            fieldLabel:'Observacion',
			col: true,
			width: 250,
			fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						  document.getElementById('cadastrar').focus();
						}
					}
			},
					
			{
			xtype: 'button',
			id: 'cadastrar',
            text: 'Gravar',
			//col: true,
			//width: 20,
			handler: function(){
			FormCadastraProv.getForm().submit({
				url: "php/cadastro_prov.php"
				, waitMsg: 'Cadastrando'
				, waitTitle : 'Aguarde....'
				, scope: this
				, success: OnSuccess
				, failure: OnFailure
				,params:{acao:'cadastra'}
			}); 
			function OnSuccess(form,action){
				alert(action.result.msg);
				dsProvs.reload();
			}
			
			function OnFailure(form,action){
				alert(action.result.msg);
			}
			}
        },
		{	xtype: 'button',
            text: 'Limpiar',
			col:true,
			handler: function(){ // Fun??o executada quando o Button ? clicado
			FormCadastraProv.getForm().reset();
			Ext.get('nomeprov').focus();
  			 }

        },
		{
		style: 'margin-bottom:6px'
		},
		gridProvs
		]
    });
	
	
	gridProvs.on('rowdblclick', function(grid, row, e, col) {
	idprod = dsProvs.getAt(row).data.id;
	var record = grid.getSelectionModel().getSelected();
	Ext.getCmp('nomeprov').setValue(record.json.nome);	
	Ext.getCmp('rucCad').setValue(record.json.ruc);
	Ext.getCmp('cedulaCad').setValue(record.json.cedula);
	Ext.getCmp('enderecoCad').setValue(record.json.endereco);	
	Ext.getCmp('telefonecomCad').setValue(record.json.telefone);
	Ext.getCmp('celularCad').setValue(record.json.celular);	
	Ext.getCmp('razaoCad').setValue(record.json.razao_social);	
	Ext.getCmp('faxCad').setValue(record.json.fax);	
	Ext.getCmp('emailCad').setValue(record.json.email);	
	Ext.getCmp('idCidades').setValue(record.json.nomecidade);	
	Ext.getCmp('cgc').setValue(record.json.cgc);	
	Ext.getCmp('obsprovCad').setValue(record.json.obs);	
	Ext.getCmp('Codigo').setValue(record.json.id);	
	
}); 



Ext.getCmp('tabss').add(FormCadastraProv);
Ext.getCmp('tabss').setActiveTab(FormCadastraProv);
FormCadastraProv.doLayout();	
Ext.get('nomeprov').focus();

}