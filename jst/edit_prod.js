
var GridWindow = function(){
	
	//dados fictícios
	var dummyData = [
		 {nome: 'Bruno' 	,idade: 19 ,desenvolveExt: 'S'}
		,{nome: 'Ricardo' 	,idade: 22 ,desenvolveExt: 'N'}
		,{nome: 'Mayara'	,idade: 26 ,desenvolveExt: 'N'}
		,{nome: 'Maurício' 	,idade: 21 ,desenvolveExt: 'S'}
	]
	
	//define dataStore
	var store = new Ext.data.JsonStore({
		  data		: dummyData							   
		 ,fields	: [
			 {name: 'nome' 			,type: 'string'	}
			,{name: 'idade' 		,type: 'int'	}
			,{name: 'desenvolveExt' ,type: 'string'	}
		]
	});
	
	//define renderers
	var renderDesenvolveExt = function( value )
	{ 
		return value === 'S' ? 'Sim' : 'Nao';
	}


	return {
		
		init:function()
		{
			//cria grid e guarda a referencia
			this.grid = new Ext.grid.GridPanel({
				 title			: 'Grid Window'					   
				,renderTo		: Ext.getBody()
				,width			: 450
				,height			: 300
				,store			: store
				,deferRowRender	: false
				,viewConfig		: { 
					 forceFit	: true 
				}
				,columns	: [
					 {header:'Nome' 			,dataIndex:'nome'	}
					,{header:'Idade' 			,dataIndex:'idade'	}
					,{header:'Desenvolve Ext?' 	,dataIndex:'desenvolveExt'	,renderer: renderDesenvolveExt	}
				]
				
				,bbar:[{
					 text	: 'Editar Selecionado'
					,scope	: this
					,handler: function()
					{
						//busca record da linha selecionada pelo SelectionModel. Ver docs de Ext.grid.RowSelectionModel
						var record = this.grid.getSelectionModel().getSelected();
						
						//invoca funçao
						this.editRecord( record );
					}
				},'->','<span style="color:gray;">*duplo clique sobre a linha para editar</span>']
				
				,listeners: {
					 scope		: this
					,rowdblclick: function( grid, rowIndex, e ) 
					{
						//pelo índice buscamos no store o record
						var record = grid.getStore().getAt( rowIndex );
						
						//invoca funçao
						this.editRecord( record );
					}
				}
				
			});
			
			//seleciona primeira linha do grid
			this.grid.getSelectionModel().selectFirstRow();
		}
		
		,editRecord: function( record )
		{
			this.recordAtualizando = record;
			
			if(!this.win)
			{
				this.win = new Ext.Window({
					 title		: 'Ediçao de Registro'
					,width		: 400
					,height		: 200
					,layout		: 'fit'
					,closeAction: 'hide'
					,bodyStyle	: 'background:white; padding:10px;'
					,modal		: true
					,items		: this.formWindow = new Ext.form.FormPanel({
						 border			: false									 
						,defaultType	: 'textfield'
						,items			: [{
							 fieldLabel	: 'Nome'	   
							,name		: 'nome'
						},{
							 fieldLabel		: 'Idade'	   
							,xtype			: 'numberfield'
							,name			: 'idade'
							,allowDecimals	: false
							,allowNegative	: false
						},{
							 xtype		: 'radiogroup'
							,fieldLabel	: 'Desenvolve Ext'
							,hiddenName	: 'desenvolveExt'
							,items		: [{
								 boxLabel	: 'Sim'
								,name		: 'desenvolveExt'
								,inputValue	: 'S'
							},{
								 boxLabel	: 'Nao'
								,name		: 'desenvolveExt'
								,inputValue	: 'N'
							}]
						}]
					})
					,bbar		: ['->',{
						 text	: 'Atualizar Registro'	   
						,scope	: this
						,handler: function()
						{debugger;
							var values = this.formWindow.getForm().getValues();
							
							this.recordAtualizando.set('nome'			, values.nome  );
							this.recordAtualizando.set('idade'			, values.idade );
							this.recordAtualizando.set('desenvolveExt'	, values.desenvolveExt );
							
							this.win.hide();
						}
					}]
				});
			}
			
		
			this.win.show();
			
			//carrega formulário
			this.formWindow.getForm().loadRecord( record );
		}
	}
}();

Ext.override(Ext.form.CheckboxGroup, {
  getNames: function() {
    var n = [];

    this.items.each(function(item) {
      if (item.getValue()) {
        n.push(item.getName());
      }
    });

    return n;
  },

  getValues: function() {
    var v = [];

    this.items.each(function(item) {
      if (item.getValue()) {
        v.push(item.getRawValue());
      }
    });

    return v;
  },

  setValues: function(v) {
    var r = new RegExp('(' + v.join('|') + ')');

    this.items.each(function(item) {
      item.setValue(r.test(item.getRawValue()));
    });
  }
});

Ext.override(Ext.form.RadioGroup, {
  getName: function() {
    return this.items.first().getName();
  },

  getValue: function() {
    var v;

    this.items.each(function(item) {
      v = item.getRawValue();
      return !item.getValue();
    });

    return v;
  },

  setValue: function(v) {
	  
    this.items.each(function(item) {
      item.setValue(item.getRawValue() == v);
    });
  }
});

/*
var GridWindow = (function()
{
	
		
	
		
	
		
	return {
		
		init: function()
		{
			//grid
			var grid = new Ext.grid.GridPanel({
				 title			: 'Grid Window'					   
				,renderTo		: Ext.getBody()
				,width			: 600
				,height			: 300
				,store			: store
				,deferRowRender	: false
				,viewConfig		: { 
					 forceFit	: true 
				}
				
				,columns	: [
					 {header:'Nome' 			,dataIndex:'nome'	}
					,{header:'Idade' 			,dataIndex:'idade'	}
					,{header:'Sexo' 			,dataIndex:'sexo' 			,renderer: renderSexo			}
					,{header:'Desenvolve Ext?' 	,dataIndex:'desenvolveExt'	,renderer: renderDesenvolveExt	}
				]
				
				,bbar:[{
					 text	: 'Editar Selecionado'
					,handler: function()
					{
						//busca record da linha selecionada pelo SelectionModel. Ver docs de Ext.grid.RowSelectionModel
						var record = grid.getSelectionModel().getSelected();
						
						//invoca funçao
						editRecord( record );
					}
				},'->','<span style="color:gray;">*duplo clique sobre a linha para editar</span>']
				
				,listeners: {
					rowdblclick : function( grid, rowIndex, e ) 
					{
						//pelo índice buscamos no store o record
						var record = grid.getStore().getAt( rowIndex );
						
						//invoca funçao
						editRecord( record );
					}
				}
			});
			
			//seleciona primeira linha do grid
			grid.getSelectionModel().selectFirstRow();
	
		}
		
	}
	
	
}());
*/
Ext.EventManager.onDocumentReady( GridWindow.init , GridWindow );
