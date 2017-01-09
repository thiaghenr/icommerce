// JavaScript Document

RelDespesa = function(){	

			
if(perm.RelDespesa.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}

var dsLctoDespesas;

///////GRID DOS LANCAMENTOS DE CAIXA/////////////////////
 dsLctoDespesas = new Ext.data.GroupingStore({
			 proxy: new Ext.data.HttpProxy({
                url: '../php/RelDespesa.php',
                method: 'POST'
				}),
				groupField:'nome',
				sortInfo:{field: 'id', direction: "DESC"},
				nocache: true,
				autoLoad: true,
				baseParams:{
					acao: 'LctoDespesas'
						},

 reader:  new Ext.data.JsonReader({
				totalProperty: 'totalLcto',
				root: 'Lcto',
				id: 'id',
				fields: [
						 {name: 'id'},
						 {name: 'despesa_id'},
						 {name: 'nome_despesa' },
						 {name: 'documento', type: 'string' },
						 {name: 'data' },
						 {name: 'venc_desp'},
						 {name: 'desc_desp' },
						 {name: 'valor', type: 'float' },
						 {name: 'nome_user' },
						 {name: 'nome'},
						 {name: 'valor_total'},
						 {name: 'totalGeralDespesas'}
						 ]
			})					    
			
		});

var summary = new Ext.grid.GroupSummary(); 

 gridLctoDespesas = new Ext.grid.EditorGridPanel({
   store: dsLctoDespesas,
   enableColLock: true,
   containerScroll  : false,
   loadMask: {msg: 'Carregando...'},
     columns: [
	  {id: 'despesa_id', header: 'Plano Conta', hidden: true, dataIndex: 'despesa_id'},	
	  {header: 'Plano Conta', width: 100, dataIndex: 'nome_despesa' },	
	  {header: 'Documento',  width: 100, hidden: false, dataIndex: 'documento'},
	  {header: 'Data Lcto', width: 80, hidden: false, dataIndex: 'data'},
      {header: 'Descricao', width: 150, dataIndex: 'desc_desp'},
	  {header: "Usuario", dataIndex: 'nome_user',  width: 90},
	  {header: "Entidade", dataIndex: 'nome',  width: 120},
	  {header: "Valor", dataIndex: 'valor', width: 90, align: 'right', renderer: 'usMoney', summaryType:'sum' }
	  
   ],
	 view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true
        }),
   autoWidth:true,
 //  autoHeight: true, 
   ds: dsLctoDespesas,
   border: true,
   plugins: [summary],
   loadMask: true,
   tbar : new Ext.Toolbar({ 
		items: [
		'-',
			{
			xtype:'button',
           	text: 'Imprimir',
			align: 'left',
			hidden: true,
			iconCls: 'icon-pdf',
            handler: function(){ 
			}
				
  			}
		] 
	}) 
}); 


//////////////////////////////////////////////////////////////////////////
dsLctoDespesas.on('load', function(){
	//total = dsLctoDespesas.reader.jsonData.totalLcto;
	//gridLctoDespesas.getTopTooltbar().items.item[0].el.innerHTML = Ext.util.Format.usMoney(total);
	
//	dias = dsLctoDespesas.reader.jsonData.dias;
//	gridLctoDespesas.getTopToolbar().items.items[5].el.innerHTML = dias;
});


	
Ext.ns('app');
Ext.Load.file(['jstb/ComboEntidade.js'], function(obj, item, el, cache){
app.FormRelDespesas = new Ext.FormPanel({
            title       : 'Relatorio de Despesas',
			labelAlign: 'left',
			frame		: true,
			closable:true,
            autoWidth   : true,
			autoScroll: true,
            collapsible : false,
			layout:'form',
			items: [
					{
			    xtype: 'datefield',
			    fieldLabel: 'Data incial',
			    name: 'datainicial',
			    id: 'datainicial',
				labelWidth:65,
			    width: 100
			  },
		  	  {
			  xtype: 'datefield',
			  fieldLabel: 'Data final',
			  name: 'datafinal',
			  id: 'datafinal',
			  width: 100,
			  labelWidth:65,
			  col: true
		  	  },
				app.form,  
		     {
			  xtype: 'button',
			  text: 'Pesquisar',
			  name: 'buscarlcto',
			  col:true,
			  handler: function(){ 
				prov = app.form.getValue();
				dsLctoDespesas.load(({params:{'acao': 'LctoDespesas', 'entidade': prov, 'dataini': Ext.get('datainicial').getValue(), 'datafim':Ext.get('datafinal').getValue()}}));
			  						}
		  },gridLctoDespesas]
	});
	},this)
setTimeout(function(){
Ext.getCmp('tabss').add(app.FormRelDespesas);
Ext.getCmp('tabss').setActiveTab(app.FormRelDespesas);
app.FormRelDespesas.doLayout();
}, 250);

	



}