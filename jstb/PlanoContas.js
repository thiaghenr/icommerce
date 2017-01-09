/*!
 * Ext JS Library 3.2.1
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
PlanoContas = function(){


    Ext.QuickTips.init();

    var tree = new Ext.ux.tree.TreeGrid({
        title: 'Plan de Cuentas',
        width: 500,
        height: 300,
		closable: true,
        enableDD: true,

        columns:[{
            header: 'Codigo',
            dataIndex: 'plancodigo',
            width: 230
        },
		{
            header: 'Descripcion',
            dataIndex: 'plandescricao',
            width: 280
        },
		{
            header: 'Totales',
            width: 150,
            dataIndex: 'total',
            align: 'right',
            sortType: 'asFloat'
        },{
            header: 'Receita',
            width: 150,
            dataIndex: 'planreceita'
        }],

        dataUrl: 'php/PlanoContas.php'
    });

Ext.getCmp('tabss').add(tree);
Ext.getCmp('tabss').setActiveTab(tree);
tree.doLayout();	
	
	}