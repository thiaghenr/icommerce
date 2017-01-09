// JavaScript Document


WinEntradaProd = function(){

/*	if(perm.CadGrupos.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}
*/
    Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = 'side';


var Receita = function(value){
	
	if(value==2)
		  return 'Saida';
		else if(value==1)
		  return 'Entrada';
		else
		  return 'Desconhecido'; 

};

var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Por favor selecione um Registro');
}

var PrecoGrupo;
var selectedKeys;
var cad_grupos;
var WinEntProd;
var print_grupos;
var gruposel;

//////////INICIO DA STORE ////////////////////
var dsEntCompras = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/EntProd.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Compras',
			totalProperty: 'totalcompras',
			id: 'id_compra'
		},
			[
			{name: 'id_compra'},
			{name: 'fornecedor_id'},
			{name: 'nome'},
			{name: 'nm_fatura'},
			{name: 'dt_emissao_fatura'},
			{name: 'vl_total_fatura'}
			]
		),
		sortInfo: {field: 'nomecidade', direction: 'ASC'},
		remoteSort: true		
	});
//////// FIM STORE //////////////
//////// INICIO DA GRID  ////////
 var grid_ent_compras = new Ext.grid.EditorGridPanel(
	    {
	        store: dsEntCompras, // use the datasource
	        columns:
		        [
						{id:'id_compra', header: "Compra N.", width: 50, sortable: true, dataIndex: 'id_compra'},	        
						{hidden: true, align: 'left', sortable: true, dataIndex: 'fornecedor_id'},
						{header: "Proveedor", width: 170, align: 'left', sortable: true, dataIndex: 'nome'},
						{header: "Fatura N.", width: 50, align: 'left', sortable: true, dataIndex: 'nm_fatura'},
						{header: "Data", width: 70, align: 'left', sortable: true, dataIndex: 'dt_emissao_fatura'},
						{header: "Valor", width: 60, align: 'left', renderer: "usMoney", sortable: true, dataIndex: 'vl_total_fatura'}
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			height: 300,
			autoScroll: true,
			ds: dsEntCompras,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dsEntCompras,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Nao tem dados",
				pageSize: 8,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				items:[],
				refreshText : "Atualizar",
				paramNames : {start: 'start', limit: 'limit'},
				items:[]
			}),
			tbar:[],
			listeners:{ 
        	afteredit:function(e){
			dsEntCompras.load(({params:{valor: e.value, acao: 'alterar', idcidade: e.record.get('idcidade'), campo: e.column,  'start':0, 'limit':100}}));
	  		},
						celldblclick: function(grid, rowIndex, columnIndex, e){
						var record = grid.getStore().getAt(rowIndex); // Pega linha 
						var fieldName = grid.getColumnModel().getDataIndex(0); // Pega campo da coluna
						compra = record.get(fieldName); //Valor do campo
						
						var fieldProv = grid.getColumnModel().getDataIndex(2); // Pega campo da coluna
						nomeprov = record.get(fieldProv); //Valor do campo
						
						var fieldValor = grid.getColumnModel().getDataIndex(5); // Pega campo da coluna
						vlcompra = record.get(fieldValor); //Valor do campo
						
						var fieldIdForn = grid.getColumnModel().getDataIndex(1); // Pega campo da coluna
						idForn = record.get(fieldIdForn); //Valor do campo
						
						var abre = function(){Ext.Load.file('jstb/entrada_prod.js', function(obj, item, el, cache){EntProdCompra();},this)}
						abre();
						WinEntProd.hide(); 
						
         }
			}
		
});

dsEntCompras.load(({params:{'idcidade':1, 'start':0, 'limit':200}}));





 var FormEntProd= new Ext.FormPanel({
			id			: 'FormEntProd',
            closable	: true,
			frame		: false,
            autoWidth   : true,
			closeAction: 'destroy',
			layout		: 'form',
			items:[grid_ent_compras],
			listeners: {
						destroy: function() {
						//	if(PrecoGrupo instanceof Ext.Window)
                       //     PrecoGrupo.destroy(); 
						//	if(NovoGrupo instanceof Ext.Window)
						//	NovoGrupo.destroy(); 
         				}
			         }
        }); 
 

if (WinEntProd == null){
				WinEntProd = new Ext.Window({
					//id:'WinEntProd'
	                layout: 'form'
	                , width: 500
					//, height: 130
	                , closeAction :'close'
	                , plain: true
					, resizable: true
					, modal: true
					, items:[FormEntProd]
					,buttons: [
					'-', '<b>Doble click sobre la linea para abrir</b>','-',
								{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					WinEntProd.hide();
								FormEntProd.getForm().reset();
								}
  			 					}
							],
					listeners: {
						close: function(){
							FormEntProd.getForm().reset();
						}
					}

				});
			}

	WinEntProd.show();		

}