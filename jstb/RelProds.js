// JavaScript Document


RelatorioProds = function(){

/*	if(perm.CadGrupos.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}
*/


    Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = 'side';

function criar() {
     //   wMsg=window.open("","informativo1","menubar=yes,scrollbars=1,status=1,width=400,height=600")
    //    wMsg.document.open()
      //  wMsg.document.write(document.FORM1.TEXTO1.value)
     //   setTimeout("fecharPopUp()",5000);
	 onclick="this.form.target='_blank';return true;"
}

function fecharPopUp() {
        wMsg.window.close();
        window.location.href = 'escrever_popup_fechar_atualizar.htm';
}




var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Por favor selecione um Registro');
}

var PrecoGrupo;
var selectedKeys;
var cad_grupos;
var WinRelProd;
var print_grupos;
var gruposel;

var cod;

 var win = new Ext.Window({
            title    : 'Relatório do mal',
            closable : true,
            width    : 690,
            height   : 400,
            layout   : 'fit',
            iconCls  : 'print',
            items: { html: "<iframe height='100%' width='100%' src='../sistema/pdf_recibo.php?idPgr="+'66'+"' > </iframe>" }
         });
   //      win.show(Ext.getCmp('imprimir'));


 var FormRelProd = new Ext.FormPanel({
			id			: 'FormRelProd',
            closable	: true,
			title		: 'Listado de Productos',
			frame		: false,
            width   : 400,
			closeAction: 'close',
			layout		: 'form',
			items:[
				{
				xtype: 'fieldset',
				title: 'Listado de Productos',
				autoHeight: true,
				defaultType: 'checkbox', // each item will be a checkbox
				items: [
				{
                fieldLabel: 'Incluir Colunas',
                boxLabel: 'Codigo',
                name: 'Codigo',
				checked: true
				},
				{
                boxLabel: 'Cod Original',
                name: 'original',
				checked: true
				},
				{
                boxLabel: 'Ref',
                name: 'ref',
				checked: true
				},
				{
                boxLabel: 'Descripcion',
                name: 'Descricao',
				checked: true
				},
				{
                boxLabel: 'Estoque',
                name: 'Estoque',
				checked: true
				},
				{
                fieldLabel: '',
                labelSeparator: '',
                boxLabel: 'Custo',
			//	disabled: true,
                name: 'Custo'
				}, {
                fieldLabel: '',
                labelSeparator: '',
                boxLabel: 'Valor A',
			//	disabled: true,
                name: 'ValorA'
				},
				{
                fieldLabel: '',
                labelSeparator: '',
                boxLabel: 'Somente con saldo',
                name: 'sme'
				},
				{
                fieldLabel: '',
                labelSeparator: '',
                boxLabel: 'Entre Fechas',
                name: 'datas',
				listeners: {
									check: function (ctl, val) {
										if(val == true){
											FormRelProd.getForm().findField('datainicial').setDisabled(false);
											FormRelProd.getForm().findField('datafinal').setDisabled(false);
										}
										if(val == false){
											FormRelProd.getForm().findField('datainicial').setDisabled(true);
											FormRelProd.getForm().findField('datafinal').setDisabled(true);
										}
									}
								}
				},
				{
				xtype: 'fieldset',
				title: 'Ventas entre las fechas:',
				autoHeight: true,
				defaultType: 'checkbox', // each item will be a checkbox
				items: [
				{
					xtype: 'datefield',
					fieldLabel: 'Fecha incial',
					name: 'datainicial',
				//	id: 'datainicial',
					labelWidth:65,
					disabled: true,
					width: 100
				    },
				    {
				    xtype: 'datefield',
				    fieldLabel: 'Fecha final',
				    name: 'datafinal',
					disabled: true,
				    //  id: 'datafinal',
				    width: 100,
				    labelWidth:65,
				    col: true
				    }
				
				]
				},
				{
				xtype: 'button',
            	text: 'Gerar',
				iconCls: 'icon-pdf',
            	handler: function(){ // fechar	
				cod = FormRelProd.getForm().findField('Codigo').getValue();
				datas = FormRelProd.getForm().findField('datas').getValue();
				desc = FormRelProd.getForm().findField('Descricao').getValue();
				stk = FormRelProd.getForm().findField('Estoque').getValue();
				custo = FormRelProd.getForm().findField('Custo').getValue();
				vla = FormRelProd.getForm().findField('ValorA').getValue();
				sme = FormRelProd.getForm().findField('sme').getValue();
				ori = FormRelProd.getForm().findField('original').getValue();
				ref = FormRelProd.getForm().findField('ref').getValue();
				dtini = FormRelProd.getForm().findField('datainicial').getValue();
			//	console.info(dtini);
				if (dtini == ""){
				dtini = (new Date());
				dtini = dtini.format("Y-m-d");
				}
				else{
				dtini = dtini.format("Y-m-d");
				}
			//	dtini = dtini.format("Y-m-d");
			//	console.info(dtini);
			//	console.log((new Date()).format('Y-m-d'));
				
				
				dtfim = FormRelProd.getForm().findField('datafinal').getValue();
				if (dtfim == ""){
				dtfim = (new Date());
				dtfim = dtfim.format("Y-m-d");
				}
				else{
				dtfim = dtfim.format("Y-m-d");
				}
   				WinRelProd = new Ext.Window({
	                 width: 650
					, height: 500
	                , closeAction :'hide'
	                , plain: true
					, resizable: true
					, modal: true
					,items: { html: "<iframe height='100%' width='100%' src='../sistema/pdf_prods.php?cod="+
					cod+"&datas="+datas+"&desc="+desc+"&stk="+stk+"&custo="+custo+"&vla="+vla+"&sme="+sme+"&ori="+ori+"&ref="+ref+"&dtini="+dtini+"&dtfim="+dtfim+"' > </iframe>" }
					,buttons: [
								{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					WinRelProd.hide();
								FormRelProd.getForm().reset();
								}
  			 					}
							]
				});
				WinRelProd.show();
					}
  			 	}
				]
				}
				],
				listeners: {
						destroy: function() {
						//	if(PrecoGrupo instanceof Ext.Window)
                       //     PrecoGrupo.destroy(); 
						//	if(NovoGrupo instanceof Ext.Window)
						//	NovoGrupo.destroy(); 
         				}
			         }
        }); 
 

if (WinRelProd == null){
				
			}

	
Ext.getCmp('tabss').add(FormRelProd);
Ext.getCmp('tabss').setActiveTab(FormRelProd);	

}