// JavaScript Document

Ext.onReady(function(){   
  Ext.BLANK_IMAGE_URL = '../ext2.2./resources/images/default/s.gif';
  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  Ext.QuickTips.init();








var  CadProdutos= Ext.get('CadProdutos');
CadProdutos.on('click', function(e){


var NovoProdWindowa;

//////////////////////////////////////////////////////////////////////////////
storeSearchProd = new Ext.data.SimpleStore({
        fields: ['sitCodigo','sitDescricao'],
        data: [
            ['Codigo', 'Codigo'],
            ['Descricao', 'Descricao'],
			['cod_original', 'Codigo Original'],
			['cod_original2', 'Codigo Original 2'],
			['Codigo_Fabricante', 'Codigo Fabricante'],
			['Codigo_Fabricante2', 'Codigo Fabricante 2'],
			['Codigo_Fabricante3', 'Codigo Fabricante 3']
        ]
    });

var dslistaProds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'Codigo'},
		           {name: 'Descricao'},
		           {name: 'Estoque'},
		           {name: 'qtd_bloq'},
		           {name: 'valorA'},
				   {name: 'valorB'},
				   {name: 'valorC'}
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: true		
	});
//////// FIM STORE DOS PRODUTOS //////////////
//////// INICIO DA GRID DOS PRODUTOS ////////
 var grid_listaProds = new Ext.grid.EditorGridPanel(
	    {
	        store: dslistaProds, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 250, sortable: true, dataIndex: 'Descricao'},
						{header: "Disponivel", width: 55, align: 'right', sortable: true, dataIndex: 'Estoque', renderer: change},
						{header: "Bloqueados", width: 55,  align: 'right',  sortable: true, dataIndex: 'qtd_bloq'},
						{header: "Valor A", width: 80, align: 'right', sortable: true, dataIndex: 'valorA',renderer: 'usMoney'},
						{header: "Valor B", width: 80, align: 'right', sortable: true, dataIndex: 'valorB',renderer: 'usMoney'},	        
						{header: "Valor C", width: 80, align: 'right', sortable: true, dataIndex: 'valorC',renderer: 'usMoney'}	 
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			width:'100%',
			id: 'prods',
			height: 300,
			ds: dslistaProds,
			selModel: new Ext.grid.RowSelectionModel(),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dslistaProds,
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
				items:[{
                    xtype:'button',
					text: 'Imprimir',
					style: 'margin-left:7px',
					iconCls: 'icon-pdf',
					handler: function(){
						//basic_printGrid();
						
						/*	
						Ext.Ajax.request(
							{
								url:'print_produtos.php',
								params:{data: Ext.encode(dslistaProd.reader.jsonData.Produtos)}
						function popup(){
						window.open('../impressao.php?id_pedido='+1 +'','popup','width=750,height=500,scrolling=auto,top=0,left=0')
								}
						popup();
					*/					
					
					}
					}],
				refreshText : "Atualizar",
				paramNames : {start: 'start', limit: 'limit'}
			}),
			tbar: [
			   {
				text: 'Novo',
				iconCls:'icon-add',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
						addnovoProduto();
												
					} 
					},
				{
				text: 'Editar',
				iconCls:'icon-edit',
				tooltip: 'Clique para alterar um registro',
				handler: function(){
					    Ext.MessageBox.alert('Aviso','Em Desenvolvimento, Para esta funcao use outra tela!');
												
					} 
					},
				{
				text: 'Excluir',
				iconCls:'icon-delete',
				tooltip: 'Clique para excluir um registro',
				handler: function(){
					    Ext.MessageBox.alert('Aviso','Em Desenvolvimento, Para esta funcao use outra tela!');
												
					} 
					},
					{
						bodyStyle:'padding:0px 35px 0'
					},
					comboSearchProd = new Ext.form.ComboBox({
                    name: 'sitCodigo',
                    id: 'sitCodigo',
					readOnly:true,
                    store: storeSearchProd,//origem dos dados
                    fieldLabel: 'Pesquisar por',
                    allowBlank: false, //permitir ou não branco, será validado ao sair do campo.
                    displayField: 'sitDescricao', //campo a ser exibido, de acordo com o mapemanto feito no objeto store
                    hiddenName: 'sitCodigoVal', //nome do campo Hidden que será criado automaticamente para receber o valor do item selecionado no combobox
                    typeAhead: true, //auto-selecionar o combo de acordo com o texto digitado
                    valueField: 'sitCodigo',
                    mode: 'local', //localização da origem dos dados.
                    forceSelection: true,//forçar que só digite texto que exista em um dos itens. False para permitir qualquer texto.
                    triggerAction: 'all',
                    emptyText: 'Codigo', //texto a ser exibido quando não possuir item selecionado
                    selectOnFocus: true, //selecionar o texto ao receber foco
	                blankText : 'Codigo', 
                    width: 120,
					listeners:{select:{fn:function(combo, value) {
						 combos = combo.getValue();
          }}}

                }),
					{
						bodyStyle:'padding:0px 15px 0'
					},
					{
					xtype: 'textfield',
	                fieldLabel: 'Pesquisa',
	                name: 'queryProdutoSearch',
					id: 'queryProdutoSearch',
					autoWidth: true,
	                allowBlank:true,
					emptyText : 'Pesquise aqui',
					listeners:{
						keyup: function(el,type){
							if(e.getKey() == 40  ){//seta pra baixo  
							   grid_listaProds.getSelectionModel().selectFirstRow();
							   grid_listaProds.getView().focusEl.focus();
                            }
							var theQuery=el.getValue();
							if(theQuery.length > 2)
							dslistaProds.load({
								params:{	
									pesquisa: theQuery,
									campo: comboSearchProd.getValue()
								}
																
							});
							
						}				
					}
	            }
			],
			listeners:{ 
        	afteredit:function(e){
			dslistaProds.load(({params:{pesquisa: e.value, campo: e.column,  'start':0, 'limit':200}}));
	  		},
			afterrender: function(e){
			//focus: function(){
   			grid_listaProds.focus();
   			grid_listaProds.getSelectionModel().selectFirstCell();
			
			}//}
			}
		
});

dslistaProds.load(({params:{'Codigo':12, 'start':0, 'limit':200}}));


/////////////////INICIO DO FORM //////////////////////////////
		var listaProdsP = new Ext.FormPanel({
			labelAlign: 'top',
            region      : 'north',
			frame		: true,
			border      : true,
            split       : true,
            autoWidth   : true,
			height	    : 55,
            collapsible : false,
			items:[{
            layout:'column',
            items:[
				   {
                columnWidth:.2,
				border: false,
                layout: 'form',
                items: [{
                    xtype:'combo',
					hideTrigger: false,
					emptyText: 'Selecione',
					allowBlank: true,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idmarca','marca'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					fieldLabel: 'Marca',
					id: 'marcaProd',
					minChars: 2,
					name: 'marcaProd',
					anchor:'90%',
					forceSelection: false,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_marca.php?acao=1',
					root: 'resultados',
					fields: [ 'idmarca', 'marca' ]
					}),
						hiddenName: 'idmarca',
						valueField: 'idmarca',
						displayField: 'marca',
						fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('grupo').focus();
                            }}

                }]
      
	  
				   },
				   {
                columnWidth:.2,
				border: false,
                layout: 'form',
                items: [{
                    xtype:'combo',
					emptyText: 'Selecione',
					hideTrigger: false,
					allowBlank: true,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['id','grupo'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
                    fieldLabel: 'Grupo	',
					id: 'grupoProd',
					minChars: 2,
                    name: 'grupoProd',
                    anchor:'90%',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_grupo.php?acao=1',
					root: 'resultados',
					fields: [ 'idgrupo', 'grupo' ]
			}),
						hiddenName: 'idgrupo',
						valueField: 'idgrupo',
						displayField: 'grupo',
						fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('margen_a').focus();
                            }}


							
                }]
      
	  
				   },
				   
				  
			{
                columnWidth:.2,
				style: 'margin-top:19px',
				//float:'left'
                layout: 'form',
				border: false,
                items: [{
				xtype:'button',
            	text: 'Pesquisar',
				iconCls	    : 'icon-search',
           	 	handler: function(){
     	    	pgrupo = Ext.get('idgrupo').getValue(),
				pmarca = Ext.get('idmarca').getValue(),
     	    	dslistaProds.load(({params:{pesquisa: e.value, campo: e.column, grupo: pgrupo, marca: pmarca, 'start':0, 'limit':200}}));
				Ext.getCmp('marca').clearValue();
				Ext.getCmp('grupo').clearValue();
  			 	}
        		}]
			 }
			 
				   
				   ]
					}]		
        }); 

        var FormCadProdutos= new Ext.FormPanel({
            title       : 'Produtos',
			labelAlign: 'top',
            region      : 'center',
            split       : true,
            autoWidth   : true,
			autoHeight	: true,
            collapsible : false,
           // margins     : '3 3 3 0',
			//bodyStyle:'padding:5px 5px 0',
            //cmargins    : '3 3 3 3',
			items:[grid_listaProds]		
        }); 
	
		var listaDtProdsD = new Ext.FormPanel({
			id: 'sul',
            //title       : 'Detalhes',
			labelAlign: 'top',
            region      : 'south',
			//layout      : 'column',
           // split       : false,
           // width       : false,
			//autoHeight		: true,
			height		:180,
			frame       :true,
            //collapsible : true,
			//msgTarget: 'side',
			//autoScroll: true,
			//html: 'teste.html'
            // margins     : '3 3 3 0',
			//bodyStyle:'padding:0px 5px 0',
            //cmargins    : '3 3 3 3',
			items: [{
            layout:'form',
            items:[{
                width: '100%',
				style: 'padding:0px; border:0px; margin:0px;',
                layout: 'form',
                items: []},
				{
                width: '100%',
                layout: 'form',
                items: []}
				  ]
					}]
	  }); 
		
		
///////////////// FIM DO FORM ///////////////////////////////////////////////////

////////////////// NOVO PRODUTO ////////////////////////////////////////////////////



    var NewProd = new Ext.FormPanel({
        labelAlign: 'top',
		 fileUpload: true,
		layout: 'form',
        frame:true,
        //bodyStyle:'padding:5px 5px 0',
		//autoHeight: true,
	    autoWidth: true,
		autoScroll:true,
        items: [{
            layout:'column',
            items:[{
                columnWidth:.3,
                layout: 'form',
				//height: 455,
				
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Codigo',
					iconCls:'icon-grid',
                    name: 'Codigo',
					id: 'Codigo',
                    anchor:'70%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('Descricao').focus().select(); 

						}}
					}

                }, 
					{
                    xtype:'textfield',
                    fieldLabel: 'Codigo Fabrica 001',
                    name: 'Codigo_Fabricante',
					id: 'Codigo_Fabricante',
                    anchor:'70%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('Codigo_Fabricante2').focus().select(); 

						}}
					}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Codigo Original',
					id: 'cod_original',
                    name: 'cod_original',
                    anchor:'70%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('cod_original2').focus().select(); 

						}}
					}
                },
					{
                    xtype:'combo',
					hideTrigger: true,
					allowBlank: true,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idmarca','marca'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					fieldLabel: 'Marca',
					id: 'marca',
					minChars: 2,
					name: 'marca',
					anchor:'60%',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_marca.php?acao=1',
					root: 'resultados',
					fields: [ 'idmarca', 'marca' ]
					}),
						hiddenName: 'idmarca',
						valueField: 'idmarca',
						displayField: 'marca',
						listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('grupo').focus().select(); 

						}}
					}


							
                },
				
                    new Ext.ux.MaskedTextField({
                    fieldLabel: '% Margem A',
					id: 'margen_a',
                    name: 'margen_a',
					mask:'porcentagem',
					textReverse : true,
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('margen_b').focus().select(); 
                            }}

                }),
				
					new Ext.ux.MaskedTextField({
                    fieldLabel: 'Valor A',
					id: 'vla',
                    name: 'vla',
					mask:'decimal',
					textReverse : true,
					renderer: 'usMoney',
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('vlb').focus().select(); 
                            }}
							
                }),
					{
                    xtype:'textfield',
                    fieldLabel: 'Estoque',
					id: 'Estoque',
                    name: 'Estoque',
                    anchor:'60%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('qtd_min').focus().select(); 

						}}
					}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Embalagem',
					id: 'embalagem',
                    name: 'embalagem',
                    anchor:'60%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('local').focus().select(); 

						}}
					}
				},
				{
            	xtype:'textfield',
            	id:'obsprod',
				name: 'obsprod',
            	fieldLabel:'Observacao',
            	anchor:'100%',
				listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('foto').focus().select(); 

						}}
					}
        		},
				{
				xtype: 'fileuploadfield',
         		emptyText: 'Selecione uma imagem...',
         		fieldLabel: 'Imagem',
         		name: 'foto',
				id:'foto',
				permitted_extensions: ['jpg', 'jpeg', 'gif', 'png'],
				buttonCfg: { text: '', iconCls: 'upload-icon' },
         		anchor:'100%'
      			}
					
					]
            },
			//#################Segunda Coluna ####################################
				{
                columnWidth:.3,
                layout: 'form',
                items: [
				    {
                    xtype:'textfield',
                    fieldLabel: 'Descricao',
					id: 'Descricao',
                    name: 'Descricao',
                    anchor:'95%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('Descricaoes').focus().select(); 

						}}
					}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Codigo Fabrica 002',
					id: 'Codigo_Fabricante2',
                    name: 'Codigo_Fabricante2',
                    anchor:'70%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('Codigo_Fabricante3').focus().select(); 

						}}
					}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Codigo Original 2',
					id: 'cod_original2',
                    name: 'cod_original2',
                    anchor:'70%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('marca').focus().select(); 

						}}
					}
                },
					{
                    xtype:'combo',
					hideTrigger: true,
					allowBlank: true,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['id','grupo'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
                    fieldLabel: 'Grupo	',
					id: 'grupo',
					minChars: 2,
                    name: 'grupo',
                    anchor:'60%',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_grupo.php?acao=1',
					root: 'resultados',
					fields: [ 'idgrupo', 'grupo' ]
			}),
						hiddenName: 'idgrupo',
						valueField: 'idgrupo',
						displayField: 'grupo',
						listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('custo').focus().select(); 

						}}
					}
                },
                    new Ext.ux.MaskedTextField({
                    fieldLabel: '% Margem B',
					id: 'margen_b',
                    name: 'margen_b',
					mask:'porcentagem',
					textReverse : true,
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('margen_c').focus().select(); 
                            }}
                }),
				
                    new Ext.ux.MaskedTextField({
                    fieldLabel: 'Valor B',
					id: 'vlb',
                    name: 'vlb',
					mask:'decimal',
					textReverse : true,
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('vlc').focus().select(); 
                            }}
                }),
				{
                    xtype:'textfield',
                    fieldLabel: 'Qtd. Min',
					id: 'qtd_min',
                    name: 'qtd_min',
                    anchor:'60%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('pr_min').focus().select(); 

						}}
					}
                },
				{
                    xtype:'textfield',
                    fieldLabel: 'Locacao',
					id: 'local',
                    name: 'local',
                    anchor:'60%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('iva').focus().select(); 

						}}
					}
                }
				
				
				]
            },
			//#################Terceira Coluna #################################### 
			 {
		       columnWidth:.3,
                layout: 'form',
                items: [
				    {
                    xtype:'textfield',
					icon: 'upload-icon',
                    fieldLabel: 'Descricao Esp',
					id: 'Descricaoes',
                    name: 'Descricaoes',
                    anchor:'95%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('Codigo_Fabricante').focus().select(); 

						}}
					}
				},
				{
                    xtype:'textfield',
                    fieldLabel: 'Codigo Fabrica 003',
					id: 'Codigo_Fabricante3',
                    name: 'Codigo_Fabricante3',
                    anchor:'65%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('cod_original').focus().select(); 

						}}
					}
                },
					{
					style: 'margin-top:30px',
					float:'left'
					 },
					 new Ext.ux.MaskedTextField({
                    fieldLabel: 'Custo',
					id: 'custo',
					mask:'decimal',
					textReverse : true,
                    name: 'custo',
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							    Ext.getCmp('margen_a').focus().select().select(); 
                            }}
					
					
                }),
					
					new Ext.ux.MaskedTextField({
                    fieldLabel: '% Margem C',
					id: 'margen_c',
					mask:'porcentagem',
					textReverse : true,
                    name: 'margen_c',
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('vla').focus().select(); 
                            }}
					
					
                }),
					
					new Ext.ux.MaskedTextField({
                    fieldLabel: 'Valor C',
					id: 'vlc',
                    name: 'vlc',
					mask:'decimal',
					textReverse : true,
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('Estoque').focus().select(); 
                            }}
					
					
                }),
				
                    new Ext.ux.MaskedTextField({
                    fieldLabel: 'Preco Min',
					id: 'pr_min',
                    name: 'pr_min',
					mask:'decimal',
					textReverse : true,
                    anchor:'60%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('embalagem').focus().select(); 

						}}
					}
                }),
				{
                    xtype:'textfield',
                    fieldLabel: '% Imposto',
					id: 'iva',
                    name: 'iva',
                    anchor:'60%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('obsprod').focus().select(); 

						}}
					}
                }
				
				
				]
				}
			
			
			
			]
        }
		
		
		      		
			]
		
        
    });

var addnovoProduto = function(){
	    if (NovoProdWindowa == null)
			{
				NovoProdWindowa = new Ext.Window({
					id:'NovoProdWindowa'
					, title: "Novo Produto"
					//, resizable: false
	                , layout: 'form'
	                , width: 650
				   // , autoScroll:true
	                , closeAction :'hide'
					, constrain: true
					, height: 550
	                , plain: true
					, modal: false
					, items: [NewProd]
					,focus: function(){
 	   					 Ext.get('Codigo').focus();
						},
					buttons: [{
			id: 'cadastrar',
            text: 'Cadastrar',
			iconCls: 'save',
			handler: function(){
			NewProd.getForm().submit({
				url: "php/cadastra_produto.php",
				params: {
						user: id_usuario
				}
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
		{
            text: 'Fechar',
			handler: function(){ // Fun��o executada quando o Button � clicado
     	    NovoProdWindowa.hide();
			NewProd.getForm().reset();
  			 }

        }]
				});
			}
NovoProdWindowa.show();
}
	
/////////////////////FIM NOVO PRODUTO /////////////////////////////////////










/////////////////// INICIO DA WINDOW PRINCIPAL

	winCadProdutos = new Ext.Window({
		id: 'winCadProdutos',
		title: 'Cadastro de Produtos',
		width:830,
		height:520,
		autoScroll: true,
		shim:true,
		//animateTarget: 'lista_prod',
		closable : true,
		//layout: 'border',
		resizable: false,
		closeAction: 'destroy',
		draggable: true, //Movimentar Janela
		plain: true,
		modal: false, //Bloquear tela do fundo
		items:[listaProdsP,FormCadProdutos],
		//focus: function(){
		//			Ext.get('controleCli').focus(); 
		//},
		buttons: [
           	{
            text: 'Cerrar',
            handler: function(){ // fechar	
     	    winCadProdutos.destroy();
			NovoProdWindowa.destroy();
  			 }
			 
        }],
		focus: function(){
				setTimeout(function(){
  				Ext.getCmp('queryProdutoSearch').focus();
				}, 250);
		}
		
	});
	
	
	winCadProdutos.show();
	
////// FIM DA WINDOW PRINCIPAL ////////////////////////






		});
								 });
