<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Produtos</title>

	<link rel="stylesheet" type="text/css" href="resources/css/ext-all.css"/>
	<link rel="stylesheet" type="text/css" href="ext-3.2.1/resources/css/ext-all.css" />
	<script type="text/javascript" src="ext-3.2.1/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="ext-3.2.1/ext-all.js"></script>
    <script type="text/javascript" src="js/MaskedTextField-0.5.js"></script>
	<link rel="stylesheet" type="text/css" href="css/forms.css"/>
	
	<link rel="stylesheet" type="text/css" href="css/summary.css"/>
	<link rel="stylesheet" type="text/css" href="css/Ext.ux.grid.RowActions.css"/>
	<script type="text/javascript" src="ext-3.2.1/Ext.ux.grid.RowActions.js"></script>
	<script type="text/javascript" src="jst/GroupSummary.js"></script>
	
	<script type="text/javascript" src="js/bugs.js"></script>
	<script type="text/javascript" src="jst/verifica_login.js"></script>

</head>
<style type="text/css">
body {
font-family: "Trebuchet MS", Verdana, Arial;
font-size: 12px;
color: #006;
background-image: url(images/fundo.gif);
}
</style>

<script language="javascript">

Ext.onReady(function(){   
  Ext.BLANK_IMAGE_URL = 'ext2.2/resources/images/default/s.gif';
  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  Ext.QuickTips.init();
  
		  Ext.override(Ext.grid.EditorGridPanel, {
			initComponent: Ext.grid.EditorGridPanel.prototype.initComponent.createSequence(function(){
			this.addEvents("editcomplete");
			}),
			onEditComplete: Ext.grid.EditorGridPanel.prototype.onEditComplete.createSequence(function(ed, value, startValue){
			this.fireEvent("editcomplete", ed, value, startValue);
			})
			});


    function azul(val){
        if(val >= 0){
            return '<span style="color:blue;font-weight: bold;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;font-weight: bold">' + val + '</span>';
        }
        return val;
    };
	
	function change(val){
        if(val > 0){
            return '<span style="color:blue;font-weight: bold;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;font-weight: bold">' + val + '</span>';
        }
        return val;
    };


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
function total(e){
				var qtd = e.record.get('qtd');
				var preco = e.record.get('valorB');
				total = qtd * preco;
				return total;
			}

	
var prodId;
var xg = Ext.grid;
var expander;
var FormContato;
var win_novocontato;


/////////////////INICIO DO FORM  NORTH //////////////////////////////
		var listaProdsP = new Ext.FormPanel({
			labelAlign: 'top',
			title: 'Pesquiza de Productos',
            region      : 'north',
			frame		: true,
			border: false,
			renderTo: 'formNorth',
            split       : true,
			autoHeight: true,
			height		: 53,
            collapsible : true,
			items:[{
            layout:'column',
            items:[{
                columnWidth:.3,
				border: false,
                layout: 'form',
                items: [{
                    xtype:'combo',
					hideTrigger: false,
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
						fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('grupo').focus();
                            }}

                }]
      
	  
				   },
				   {
                columnWidth:.3,
				border: false,
                layout: 'form',
                items: [{
                    xtype:'combo',
					hideTrigger: false,
					allowBlank: false,
					editable: false,
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
     	    	dslistaProd.load(({params:{pesquisa: e.value, campo: e.column, grupo: pgrupo, marca: pmarca, 'start':0, 'limit':20000}}));
				Ext.getCmp('marca').clearValue();
				Ext.getCmp('grupo').clearValue();
  			 	}
        		}]
      
	  
				   }
				   
				   ]
					},
					{
					xtype       : 'fieldset',
					title       : 'Busca de Productos',
					labelAlign: 'top',
					layout      : 'form',
					collapsible : true,                    
					collapsed   : false,
					autoHeight  : true,
					items:[{
								layout:'column',
								border: false,
								items:[{
									columnWidth:.2,
									layout: 'form',
									border: false,
									items: [{
										xtype:'textfield',
										fieldLabel: 'Codigo',
										name: 'CodigoProduto',
										id: 'CodigoProduto',
										anchor:'70%',
										enableKeyEvents: true,
										listeners: {
										keyup: function(field, key){
												if(key.getKey() == key.ENTER) {
													var Codigo = Ext.getCmp('CodigoProduto').getValue(); 
													dslistaProd.load(({params:{'pesquisa':Codigo, 'start':0, 'limit':200}}));
												 
												}
												
											}
									}
									}
									]
									},
									{
									columnWidth:.3,
									layout: 'form',
									border: false,
									items: [{
										xtype:'textfield',
										fieldLabel: 'Descripcion',
										name: 'DescricaoProduto',
										id: 'DescricaoProduto',
										anchor:'80%',
										enableKeyEvents: true,
										listeners: {
										keyup: function(field, key){
												if(key.getKey() == key.ENTER) {
													var Descricao = Ext.getCmp('DescricaoProduto').getValue(); 
													dslistaProd.load(({params:{'pesquisa':Descricao, 'campo': 2, 'start':0, 'limit':200}}));
												 
												}
												
											}
									}
									}
									]
									}
				
									]
								}]
							}]		
        }); 
/////////////////////////// FIM DO FORM NORTH //////////////////////////////////////////////////////////////////////

////////////////////////// INICIO GRID PRINCIPAL DOS PRODUTOS ////////////////////////////////////////////////////////////////	
	
	
	var dslistaProd = new Ext.data.Store({
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
				   {name: 'id',  mapping : 'id'},
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
		remoteSort: false		
	});
//////// FIM STORE DOS PRODUTOS //////////////
//////// INICIO DA GRID DOS PRODUTOS ////////
 var grid_listaProd = new Ext.grid.GridPanel({
	        store: dslistaProd, // use the datasource
	        columns:[
						{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 250, sortable: true, dataIndex: 'Descricao'},
						{header: "Disponivel", width: 55, align: 'right', sortable: true, dataIndex: 'Estoque', renderer: change},
						{header: "Bloqueados", width: 55,  align: 'right',  sortable: true, dataIndex: 'qtd_bloq'},
						{header: "Valor A", width: 80, align: 'right', sortable: true, dataIndex: 'valorA',renderer: 'usMoney'},
						{header: "Valor B", width: 80, align: 'right', sortable: true, dataIndex: 'valorB',renderer: 'usMoney'},	        
						{header: "Valor C", width: 80, align: 'right', sortable: true, dataIndex: 'valorC',renderer: 'usMoney'}	 
			 ],
	        viewConfig:{
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			width:'100%',
			ddGroup          : 'secondGridDDGroup',
			enableDragDrop   : true,
		//	sm: new Ext.grid.RowSelectionModel(),
			height: 250,
			autoExpandColumn : 'id',
			loadMask: true,
			//enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dslistaProd,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Nao tem dados",
				pageSize: 100,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				refreshText : "Atualizar",
				paramNames : {start: 'start', limit: 'limit'},
				items:[{
                    xtype:'button',
					text: 'Imprimir',
					style: 'margin-left:7px',
					iconCls: 'icon-pdf',
					handler: function(){
						basic_printGrid();
					}
					}]
				
			}),
			listeners:{ 
			
			}
		
});	


	

	
		// define a custom summary function
  //  	Ext.grid.GroupSummary.Calculations['total'] = function(v, record, field){
//		//Barrafinal.getBottomToolbar().items.items[3].el.innerHTML = nome_user;
//		var v = v+ (parseFloat(record.data.qtd) * parseFloat(record.data.valorB));   //toNum
		//Ext.getCmp("SubTotal").setValue((v));
		//var subnota =  Ext.get("SubTotal").getValue();
		//var frete = Ext.get("Frete").getValue();
		//var freteA = frete.replace(".","");
		//var freteB = freteA.replace(",",".");
		//var totalnota = parseFloat(freteB) + parseFloat(subnota);
	//	Ext.getCmp("Total").setValue(Ext.util.Format.usMoney(totalnota));
	//	return v;
//    }

//var summary = new Ext.grid.GroupSummary(); 

    // create the destination Grid
	Ext.data.Record2 = Ext.data.Record;

Ext.data.Record = function(data, id, inserted){
	this.inserted = inserted || false;
	Ext.data.Record.superclass.constructor.call(this, data, id);
	this.calc();
}

Ext.data.Record.create = Ext.data.Record2.create;
Ext.data.Record.AUTO_ID = Ext.data.Record2.AUTO_ID;
Ext.data.Record.EDIT = Ext.data.Record2.EDIT;
Ext.data.Record.REJECT = Ext.data.Record2.REJECT;
Ext.data.Record.COMMIT = Ext.data.Record2.COMMIT;

Ext.extend(Ext.data.Record, Ext.data.Record2, {
	inserted: false,
	set: function(name, value){
		if (String(this.data[name]) == String(value)) {
			return;
		}
		this.dirty = true;
		if (!this.modified) {
			this.modified = {};
		}
		if (typeof this.modified[name] == 'undefined') {
			this.modified[name] = this.data[name];
		}
		this.data[name] = value;
		this.calc(name);
		if (!this.editing && this.store) {
			this.store.afterEdit(this);
		}
	},
	calcF: {
		sum: function(r,f){
			var v = null;
			Ext.each(f.dependencies, function(i){
				v = v == null ? parseFloat(r.get(i)) : v + parseFloat(r.get(i));
			},this)
			return v;
		},
		mult: function(r,f){
			a = r;
			var v = null;
			Ext.each(f.dependencies, function(i){
				v = v == null ? parseFloat(r.get(i)) : v * parseFloat(r.get(i));
			},this)
			return v;
		},
		sub: function(r,f){
			var v = null;
			Ext.each(f.dependencies, function(i){
				v = v == null ? parseFloat(r.get(i)||0) : v - parseFloat(r.get(i)||0);
			},this)
			return v;
		}
	},
	calc: function(name){
		this.fields.each(
			function(field){
				if (
					(field.name != name) && 
					((typeof field.calc == 'function')||(this.calcF[field.calc])) &&
					(!name || (!field.dependencies || field.dependencies.indexOf(name) != -1))
				) {
					var value = null;
					if(typeof field.calc == 'function'){
						value = field.calc.createDelegate(field.scope||this)(this, field);
					}else{
						value = this.calcF[field.calc].createDelegate(field.scope||this)(this, field);
					}
					if(field.notDirty == null){field.notDirty = true}
					if (!name || field.notDirty) {
						// do not show calculated field as dirty:
						this.data[field.name] = value;
					}
					else {
						this.set(field.name, value);
					}
				}
			},
			this
		);
	}
})
	
	var secondGridStore = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod.phps',
			method: 'POST'
		}),   
		sortInfo:{field: 'Codigo', direction: "DESC"},
		nocache: true,
		
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[		
				   {name: 'id',  mapping : 'id', type: 'string'},
				   {name: 'Codigo', type: 'string'},
		           {name: 'Descricao', type: 'string'},
				   {name: 'qtd', type: 'string'},
				   {name: 'valorB', type: 'string'},
				   {
					name: 'total',
					type: 'float',
					dependencies: ['qtd','valorB'],
					calc: function(r) {
					alert('oi');
						return (r.get('qtd') * r.get('valorB'));
					}
					}
			]
		)	
	});
	
	
    var secondGrid = new Ext.grid.EditorGridPanel({
	        columns:[
						{id:'id',header: "id", hidden: true, sortable: true, dataIndex: 'id'},
						{header:'Codigo',header: "Codigo", width: 120, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 270, sortable: true, dataIndex: 'Descricao'},
						{header: "Qtd", width: 80, sortable: true, dataIndex: 'qtd',
							 editor: new Ext.form.NumberField({
								allowBlank: false,
								selectOnFocus:true,
								allowNegative: false
								})
								},
						{header: "Valor B", width: 90, align: 'right', sortable: true, dataIndex: 'valorB',renderer: 'usMoney',
							 editor: new Ext.form.NumberField({
								allowBlank: false,
								selectOnFocus:true,
								allowNegative: false	
								})
						},
						{header: "Total", width: 90, sortable: true, align: 'right', dataIndex: 'total'}     
				 ],
			
			ddGroup          : 'firstGridDDGroup',
			enableDragDrop   : true,
			stripeRows       : true,
			//plugins: [summary],
			store			 : secondGridStore,
			sm: new Ext.grid.RowSelectionModel(),
			width 			 : 680,
			height			 : 165,
			autoExpandColumn : 'id',
			listeners:{
				editcomplete:function(ed,value){
					  setTimeout(function(){
					  if(ed.col == 3 ){				
					  secondGrid.startEditing(ed.row,ed.col+1);
					  }
					   }, 250);
					  },
				afteredit:function(e,v, field){   
				//v = record.data.total;
				//Ext.getCmp('TotalSub').setValue(v);
				
				
			//	anterior = Ext.getCmp('TotalSub').getValue();
			//	tot = parseFloat(anterior) + parseFloat(v);
			// 	Ext.getCmp('TotalSub').setValue(tot);
			
			 console.log(record.data.valorB);
			 console.log(record.data.qtd);
				
				}
				}
		});
	
	//this.totalField.setValue(Ext.util.Format.brMoney(parseFloat(this.dsItens.sum('total'))+parseFloat(this.dsValores.sum('sv_valor'))));

	
	
////////////////////////////////////////  FIM GRID PRINCIPAL DOS PRODUTOS //////////////////////////////////////////////
		var listaProd = new Ext.FormPanel({
           // title       : 'Produtos',
			labelAlign: 'top',
			renderTo: 'formCenter',
            region      : 'center',
            split       : true,
			autoHeight		: true,
            collapsible : false,
           // margins     : '3 3 3 0',
			//bodyStyle:'padding:5px 5px 0',
            //cmargins    : '3 3 3 3',
			items:[grid_listaProd]		
        }); 




		//////// INICIO DA GRID DOS PRODUTOS ////////
var dslistaProdDet = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod_det.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'nom_marca'},
		           {name: 'nom_grupo'},
		           {name: 'custo'},
		           {name: 'Codigo_Fabricante'},
		           {name: 'Codigo_Fabricante2'},
				   {name: 'cod_original'},
				   {name: 'cod_original2'}
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: true		
	});
 var gridDetProd = new Ext.grid.EditorGridPanel(
	    {
	        store: dslistaProdDet, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header: 'Marca', width: 80, sortable: true, dataIndex: 'nom_marca'},
						{header: "Grupo", width: 80, sortable: true, dataIndex: 'nom_grupo'},
						{header: "custo", width: 55, align: 'right', sortable: true, dataIndex: 'custo', renderer: 'usMoney'},
						{header: "Fabricante", width: 80,  align: 'right',  sortable: true, dataIndex: 'Codigo_Fabricante'},
						{header: "Fabricante2", width: 80, align: 'right', sortable: true, dataIndex: 'Codigo_Fabricante2'},
						{header: "cod_original", width: 80, align: 'right', sortable: true, dataIndex: 'cod_original'},	        
						{header: "cod_original2", width: 80, align: 'right', sortable: true, dataIndex: 'cod_original2'}	 
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width:'100%',
			id: 'prods',
			height: 45,
			ds: dslistaProdDet,
			selModel: new Ext.grid.CellSelectionModel({singleSelect:false}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true
		
});
 ////////FIM GRID DOS DETALHES ///////////////////////////////////////////////////
//////// INICIO DA GRID DOS DETALHES DE COMPRA ////////
var dslistaProdCmp = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod_cmp.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'margen_a'},
		           {name: 'margen_b'},
		           {name: 'margen_c'},
		           {name: 'custo'},
		           {name: 'custo_medio'},
				   {name: 'custo_anterior'},
				   {name: 'custoagr'}
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: true		
	});
 var gridDetProdCmp = new Ext.grid.EditorGridPanel({
	        store: dslistaProdCmp, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header: 'Margen A %', width: 80, sortable: true, dataIndex: 'margen_a', renderer: azul},
						{header: "Margen B %", width: 80, sortable: true, dataIndex: 'margen_b', renderer: azul},
						{header: "Margem C %", width: 55, align: 'right', sortable: true, dataIndex: 'margen_c', renderer: azul},
						{header: "Custo", width: 80,  align: 'right',  sortable: true, dataIndex: 'custo',  renderer: 'usMoney'},
						{header: "Custo Medio", width: 80, align: 'right', sortable: true, dataIndex: 'custo_medio', renderer: 'usMoney'},
						{header: "Custo Anterior", width: 80, align: 'right', sortable: true, dataIndex: 'custo_anterior', renderer: 'usMoney'},	        
						{header: "Custo Agregado", width: 80, align: 'right', sortable: true, dataIndex: 'custoagr', renderer: 'usMoney'}	 
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width:'100%',
			id: 'prodscmp',
			height: 45,
			ds: dslistaProdCmp,
			selModel: new Ext.grid.CellSelectionModel({singleSelect:false}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true
		
});
//////// INICIO DA GRID DOS VENDIDOS ////////
var dslistaProdVend = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod_det_vend.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'idped'},
				   {name: 'controle_cli'},
		           {name: 'nome_cli'},
		           {name: 'data_car'},
		           {name: 'qtd_produto'},
		           {name: 'prvenda'},
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: true		
	});
 var gridDetProdVend = new Ext.grid.EditorGridPanel(
	    {
	        store: dslistaProdVend, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "Pedido", width: 50, sortable: true, dataIndex: 'idped'},
						{header: 'Codigo', width: 80, sortable: true, dataIndex: 'controle_cli'},
						{header: "Nome", width: 230, sortable: true, dataIndex: 'nome_cli'},
						{header: "Data", width: 90, align: 'right', sortable: true, dataIndex: 'data_car', renderer: change},
						{header: "Qtd", width: 80,  align: 'right',  sortable: true, dataIndex: 'qtd_produto'},
						{header: "Valor", width: 90, align: 'right', sortable: true, dataIndex: 'prvenda'}
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width:'100%',
			id: 'prodsVd',
			height: 100,
			ds: dslistaProdVend,
			selModel: new Ext.grid.CellSelectionModel({singleSelect:false}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true
			
		
});
 ////////FIM GRID DOS DETALHES ///////////////////////////////////////////////////
//////// INICIO DA GRID DOS DETALHES DE COMPRA ////////
var dslistaProdCompras = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod_det_cmp.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'idcmp'},
				   {name: 'fornecedor_id'},
		           {name: 'nome'},
		           {name: 'data_lancamento'},
		           {name: 'qtd_produto'},
		           {name: 'prcompra'},
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: true		
	});
 var gridDetProdCompras = new Ext.grid.EditorGridPanel(
	    {
	        store: dslistaProdCompras, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "Compra", width: 50, sortable: true, dataIndex: 'idcmp'},
						{header: 'Codigo', width: 80, sortable: true, dataIndex: 'fornecedor_id'},
						{header: "Fornecedor", width: 230, sortable: true, dataIndex: 'nome'},
						{header: "Data", width: 90, align: 'right', sortable: true, dataIndex: 'data_lancamento', renderer: change},
						{header: "Qtd", width: 80,  align: 'right',  sortable: true, dataIndex: 'qtd_produto'},
						{header: "Valor", width: 90, align: 'right', sortable: true, dataIndex: 'prcompra', renderer: 'usMoney'}
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width:'100%',
			id: 'prodsCp',
			height: 100,
			ds: dslistaProdCompras,
			selModel: new Ext.grid.CellSelectionModel({singleSelect:false}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true
			
		
});

			////////////////////////////////////////  FIM GRID DRAG //////////////////////////////////////////////
		var listaProd = new Ext.FormPanel({
            title       : 'Cotizacion',
			renderTo: 'formDrag',
            split       : true,
			autoHeight		: true,
            collapsible : true,
			collapsed   : true,
			layout: 'form',
			labelWidth: 45,
           // margins     : '3 3 3 0',
			//bodyStyle:'padding:5px 5px 0',
            //cmargins    : '3 3 3 3',
			items:[
			{
								layout:'column',
								border: false,
								items:[{
									columnWidth:.7,
									layout: 'form',
									border: false,
									items:[secondGrid]		
									},
									{
									columnWidth:.3,
									layout: 'form',
									border: false,
									items:[
					
					{
                    xtype:'combo',
					hideTrigger: false,
					allowBlank: true,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idcli','nome'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					fieldLabel: '<b>Cliente</b>',
					id: 'cliente',
					minChars: 3,
					listWidth:210,
					name: 'cliente',
					width: 210,
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_nome.php',
					root: 'resultados',
					fields: [ 'idcli', 'nome' ]
					}),
						hiddenName: 'idcli',
						valueField: 'idcli',
						displayField: 'nome'

                },
				{
					xtype: 'textfield',
                    fieldLabel: 'Total',
					id: 'TotalSub',
                    name: 'TotalSub',
					readOnly: true,
					//mask:'decimal',
					//hidden: true,
					//textReverse : true,
					value: '0',
					width: 100
					
                   
                }]		
									}]
									}]
        }); 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////




		var listaDtProdsD = new Ext.FormPanel({
           // title       : 'Detalhes',
			labelAlign: 'top',
			renderTo: 'formDetalhes',
			split       : true,
			height		:140,
			autoWidth: true,
			frame       :true,
            collapsible : true,
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
                items: [gridDetProd,gridDetProdCmp.hide()]},
				{
                width: '100%',
                layout: 'form',
                items: [gridDetProdVend,gridDetProdCompras.hide()]}
				  ]
					}]
	  }); 
		
		grid_listaProd.getSelectionModel().on('rowselect', function(sm, rowIndex, colIndex) {
		record = grid_listaProd.getStore().getAt( rowIndex );
		prodId = record.id;
		}, this);

		grid_listaProd.addListener('keydown',function(event){
		   getItemRow(this, event);
		});
		
		function getItemRow(grid, event){
		   key = getKey(event);
		//console.info(event);
		var idData = prodId; 
		    if(key==119){
	   
			gridDetProdCmp.hide();
			gridDetProdCompras.hide();
			
			gridDetProd.show();
			dslistaProdDet.load(({params:{codigo: prodId}}));
			
			gridDetProdVend.show();
			dslistaProdVend.load(({params:{codigo: prodId}}));
		}
		else if(key==120){
			gridDetProd.hide();
			gridDetProdVend.hide();
			
			gridDetProdCmp.show();
			dslistaProdCmp.load(({params:{codigo: prodId}}));
			
			gridDetProdCompras.show();
			dslistaProdCompras.load(({params:{codigo: prodId}}));
		}
		else if(key==13){
			if(NomeCol == 'Codigo' || NomeCol == 'Descricao'){
			winPesquisa.show();
		}
		}
		}

		dslistaProd.load(({params:{'Codigo':12, 'start':0, 'limit':200}}));

	var fields = dslistaProd.fields.keys;
	// used to add records to the destination stores
	var blankRecord =  Ext.data.Record.create(fields);

// This will make sure we only drop to the view container
	var grid_listaProdDropTargetEl =  grid_listaProd.getView().el.dom.childNodes[0].childNodes[1];
	var grid_listaProdDropTarget = new Ext.dd.DropTarget(grid_listaProdDropTargetEl, {
		ddGroup    : 'firstGridDDGroup',
		copy       : true,
		notifyDrop : function(ddSource, e, data){
			
			// Generic function to add records.
			function addRow(record, index, allItems) {
				
				// Search for duplicates
				var foundItem = dslistaProd.find('id', record.data.name);
				// if not found
				if (foundItem  == -1) {
					dslistaProd.add(record);
					
					// Call a sort dynamically
					dslistaProd.sort('id', 'ASC');
					
					//Remove Record from the source
					ddSource.grid.store.remove(record);
				}
			}

			// Loop through the selections
			Ext.each(ddSource.dragData.selections ,addRow);
			return(true);
		}
	}); 
	// This will make sure we only drop to the view container
	var secondGridDropTargetEl = secondGrid.getView().el.dom.childNodes[0].childNodes[1]
	
	var destGridDropTarget = new Ext.dd.DropTarget(secondGridDropTargetEl, {
		ddGroup    : 'secondGridDDGroup',
		copy       : false,
		notifyDrop : function(ddSource, e, data){
			// Generic function to add records.
			function addRow(record, index, allItems) {
				
				// Search for duplicates
				var foundItem = secondGridStore.find('id', record.data.id);
				// if not found
				if (foundItem  == -1) {
					secondGridStore.add(record);
					// Call a sort dynamically
					//	secondGridStore.sort('id', 'ASC');
					secondGrid.getSelectionModel().selectLastRow();	
					//Remove Record from the source
					ddSource.grid.store.remove(record);
				}
			}
			// Loop through the selections
			Ext.each(ddSource.dragData.selections ,addRow);
			return(true);
		}
	}); 	
				secondGrid.getSelectionModel().on('rowselect', function(sm, rowIndex, colIndex) {
					setTimeout(function(){
					secondGrid.startEditing(rowIndex,3);
					 }, 250);
					}, this);	



});


</script>

<body>
<div id="formNorth"></div>
<div id="formCenter"></div>
<div id="formDrag"></div>
<div id="formDetalhes"> </div>

</body>
</html>