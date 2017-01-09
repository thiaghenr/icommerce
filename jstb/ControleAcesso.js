// JavaScript Document
ControleAcesso = function(){


if(perm.ControleAcesso.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'No tenes acceso a esta pantalla');
}

    Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = 'side';
	
	function ativos(val){
        if(val > 0){
            return '<span style="color:blue;font-weight: bold;">' +'SIM' + '</span>';
        }else if(val == 0){
            return '<span style="color:red;font-weight: bold">' + 'NAO' + '</span>';
        }
        return val;
    };
	
	var dsCargos = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'funcionarios/listar.php',
			method: 'POST'
		}),   
		baseParams:{acao: "listarCargos"},
		reader:  new Ext.data.JsonReader({
			root: 'dados',
			id: 'id_cargo'
		},
			[
				{name: 'id_cargo'},
				{name: 'cargo'}				
			]
		),
		sortInfo: {field: 'cargo', direction: 'DESC'},
		remoteSort: true		
	});
	dsCargos.load();	
	
	dsUsuarios = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'funcionarios/listar.php',
			method: 'POST'
		}),   
		//baseParams:{acao: "listarDados"},
		reader:  new Ext.data.JsonReader({
			root: 'dados',
			totalProperty: 'total',
			id: 'id_usuario'
		},
			[
				{name: 'id_usuario'},
				{name: 'nome_user'},
				{name: 'nome'},
				{name: 'id_cargo'},
				{name: 'ativo'}
			]
		),
		sortInfo: {field: 'nome', direction: 'DESC'},
		remoteSort: true
		});
	
	var cm = new Ext.grid.ColumnModel([
		new Ext.grid.RowNumberer(),
		{dataIndex: 'ativo', header: 'Ativos', width: 40, hideable: false, renderer: ativos},
		{dataIndex: 'id_usuario', header: 'Id',	hidden: true,  hideable: false},
		{dataIndex: 'nome_user', header: 'Nome System',	width: 100},	
		{dataIndex: 'nome',	header: 'Nome',	width: 150},	
		{dataIndex: 'id_cargo', header: "Cargo", width: 100,renderer: function(value) {
				record = dsCargos.getById(value);	
				if(record) {
					return record.data.cargo;
				} else {
					return 'SEM CARGO';
				}
			}
		}
	]);
	cm.defaultSortable = true;
	var gridUsuarios = new Ext.grid.EditorGridPanel({
		//id: 'gridUsuarios',
		ds: dsUsuarios,
		cm: cm,
		enableColLock: false,
		containerScroll  : true,
		height: 150,
		loadMask: true,
		autoScroll: true,
		stripeRows: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		autoWidth: true,
		viewConfig: {
			forceFit:true,
			getRowClass : function (row, index) {				
				var cls = '';
				if(row.data.ativo == false){
					cls = 'corGrid'
				} else {
					cls = ''
				}				
				return cls;
			}	
		}
	});
		dsUsuarios.load({params:{start: 0, acao:'listarDados', limit: 30}});	

	
	
	gridUsuarios.on('rowclick', function(grid, row, e, col) {
		user = dsUsuarios.getAt(row).data.id_usuario;
		nomeuser = dsUsuarios.getAt(row).data.nome;
		dsControl.load(({params:{user: user, acao: 'Ler' }}));
		gridContAcesso.getTopToolbar().items.items[4].el.innerHTML = nomeuser;
	}); 
	
	function formataPerm(value){
        return value == 1 ? 'Sim' : 'Não';  
    };
	
	  dsControl = new Ext.data.GroupingStore({
		  proxy: new Ext.data.HttpProxy({
		  method: 'POST',
		  url: '../php/ControleAcesso.php'
		  }),
      groupField:'nome_telagrupo',
      sortInfo:{field: 'idtelascontrole', direction: "ASC"},
      reader: new Ext.data.JsonReader({
	     root:'dados',
	     fields: [
			{name: 'nome_telagrupo'},
			{name: 'tela',  mapping: 'tela'},
			{name: 'menu'},
			{name: 'idtelascontrole', mapping: 'idtelascontrole'},
	        {name: 'telaid'},
            {name: 'iduser'},
            {name: 'acessar'},
            {name: 'alterar'},
            {name: 'inserir'},
			{name: 'deletar'}
 		]
		})
   });	
/*	var checkColumn = new Ext.grid.CheckColumn({
       header: 'Acessar',
       dataIndex: 'ler',
       width: 80
    });
*/	
	
	var summary = new Ext.grid.GroupSummary(); 
    var gridContAcesso = new Ext.grid.EditorGridPanel({
	    store: dsControl,
		enableColLock: true,
		containerScroll  : false,
        columns: [
			
			{	
				id: 'nome_telagrupo',
                header: "Menu",
                sortable: true,
                dataIndex: 'nome_telagrupo',
				fixed:true
            },
			
			{	
				id: 'menu',
                header: "Menu",
                sortable: true,
                dataIndex: 'menu',
				fixed:true,
				width: 320
            },
            
			{	
                header: "Acessar",
                sortable: false,
                dataIndex: 'acessar',
				align: 'left',
				fixed:true,
				width: 80,
				renderer: formataPerm,
				editor: new Ext.grid.GridEditor(new Ext.form.Checkbox())
            },
			{
                header: "Alterar",
                width: 80,
                sortable: true,
				align: 'left',
				fixed:true,
                dataIndex: 'alterar',
				renderer: formataPerm,
				editor: new Ext.grid.GridEditor(new Ext.form.Checkbox())
               
            },
			{
                header: "Inserir",
                width: 80,
				align: 'left',
                sortable: true,
				fixed:true,
                dataIndex: 'inserir',
				renderer: formataPerm,
				editor: new Ext.grid.GridEditor(new Ext.form.Checkbox())
            },
			
			{
				header: 'Deletar',
				width: 80,
				align: 'left',
				dataIndex: 'deletar',
				name: 'deletar',
				fixed:true,
				renderer: formataPerm,
				editor: new Ext.grid.GridEditor(new Ext.form.Checkbox())
			},
			{
                header: "iduser",
                width: 60,
				align: 'right',
                sortable: true,
                dataIndex: 'iduser',
				name: 'iduser',
				id: 'iduser',
				hidden:true
               
            },
			{
				header: "idtelascontrole",
				dataIndex: 'idtelascontrole',
				fixed:true,
				hidden: true,
				id: 'idtelascontrole',
				name: 'idtelascontrole'
								
			},
			{
				header: "telaid",
				dataIndex: 'telaid',
				fixed:true,
				hidden: true,
				id: 'telaid',
				name: 'telaid'
								
			}
			
        ],

        view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true
        }),

        plugins: summary,
        autoWidth: true,
        height: 385,
		border: false,
        clicksToEdit: 1,
		autoScroll:true,
		tbar: new Ext.Toolbar({ 
				items:[
			   {
				text: 'Salvar',
				iconCls:'icon-save',
				tooltip: 'Clique para Salvar as alteracoes',
				handler: function(){
					jsonData = "[";
						
						for(d=0;d<dsControl.getCount();d++) {
							record = dsControl.getAt(d);
							if(record.data.newRecord || record.dirty) {
								jsonData += Ext.util.JSON.encode(record.data) + ",";
							}
						}
						
						jsonData = jsonData.substring(0,jsonData.length-1) + "]";
						//alert(jsonData);
							Ext.Ajax.request(
							{
								waitMsg: 'Enviando Cotacão, por favor espere...',
								url:'php/ControleAcesso.php',
								params:{data:jsonData,'acao':'Alterar'},
								success:function(form, action) {
									Ext.Msg.alert('Obrigado', 'Enviado com sucesso!!!!');
									dsControl.reload();
								},
								
								failure: function(form, action) {
									Ext.Msg.alert('Alerta', 'Erro, Tente Novamente');
								}								
							}
						);						
					} 
					},
					{
					text: 'Cadastrar Tela',
					id: 'btnCadTela',
					iconCls: 'icon-tela',
					tooltip: 'Cadastrar uma nova tela',
					handler: function(){
							Ext.Load.file('jstb/CadTelas.js', function(obj, item, el, cache){CadTela();},this);
						}
					},'-','<b>Usuario: </b>',''
		]
		}),
		listeners:{ 
	    celldblclick: function(grid, rowIndex, columnIndex, e){
        //    var record = grid.getStore().getAt(rowIndex); // Pega linha 
        //    var fieldName = grid.getColumnModel().getDataIndex(0); // Pega campo da coluna
        //    var data = record.get(fieldName); //Valor do campo
            //alert(data);
		//	win_grid_parcial.show();
		//	dsPagoProv.baseParams.id = data;
		//	dsPagoProv.load();
         }
	}
    });
	///TERMINA A GRID		
	
	 var FormgridContAcesso = new Ext.FormPanel({
        title: 'Permissoes',
	//	id: 'FormgridContAcesso',
        autoWidth: true,
		split: true,
		closable: true,
		frame: true,
		//layout: 'form',
        items: [gridUsuarios,gridContAcesso],
		listeners:{
					destroy: function() {
						//	 sul.remove('FormgridUsuarios');
         				}
			
		}
	 });
	 
	 
	  var FormgridUsuarios = new Ext.FormPanel({
        title:'Usuarios',
		id: 'FormgridUsuarios',
        autoWidth: true,
		split: true,
		closable: true,
		//autoScroll: true,
		layout: 'form',
      //  items: [gridUsuarios],	
		listeners:{
				destroy: function(){
		//		tabs.remove('FormgridContAcesso');
				}
			}
  });
	
	
	
	
	
/*	
Ext.getCmp('sul').add(FormgridUsuarios);
Ext.getCmp('sul').setActiveTab(FormgridUsuarios);
FormgridUsuarios.doLayout();		
*/	

Ext.getCmp('tabss').add(FormgridContAcesso);
Ext.getCmp('tabss').setActiveTab(FormgridContAcesso);
FormgridContAcesso.doLayout();	
	
}