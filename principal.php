<?php
include("verifica_login.php");
require_once ("config.php");
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST')
	unset($_SESSION[isLogado]);

$msg = ($_SESSION["isLogado"] == TRUE ) ?
			"<p style='color:#008000;'>Você está logado no sistema.</p>":
			"<p style='color:#ff0000;'>Você não está logado no sistema. Faça seu <a href='index.html'>login</a></p>";


?>

<html>
<head>
  <title>Nelore</title>
	
	<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>
	
	<link rel="stylesheet" type="text/css" href="ext-3.2.1/resources/css/ext-all.css" />
 	<script type="text/javascript" src="ext-3.2.1/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="ext-3.2.1/ext-all.js"></script>

	<link rel="stylesheet" type="text/css" href="css/RowEditor.css" />
	<script type="text/javascript" src="js/RowEditor.js"></script>
	<link rel="stylesheet" type="text/css" href="css/themes/xtheme-indigo/css/xtheme-indigo.css" id="theme" />
	<link rel="stylesheet" type="text/css" href="css/forms.css"/>
	<script type="text/javascript" src="jst/GroupSummary.js"></script>
	<link rel="stylesheet" type="text/css" href="css/summary.css" />
	<link rel="stylesheet" type="text/css" href="css/Ext.ux.grid.RowActions.css"/>
	<script type="text/javascript" src="js/MaskedTextField-0.5.js"></script>
	<script type="text/javascript" src="js/Ext.ux.grid.RowActions.js"></script>
	<script type="text/javascript" src="ux/Ext.ux.state.TreePanel.js"></script>
	<link rel="stylesheet" type="text/css" href="ux/statusbar/css/statusbar.css" />
	<script type="text/javascript" src="ux/statusbar/StatusBar.js"> </script>
	<link rel="stylesheet" type="text/css" href="css/file-upload.css"/>
	<script type="text/javascript" src="php/extjs_printergrid_0.0.1.js"></script>
	<script type="text/javascript" src="js/FileUploadField.js"></script>
	<script type="text/javascript" src="js/override.js"></script>
	<script type="text/javascript" src="js/maskBr.js"></script>
    <script src="ext-3.2.1/src/locale/ext-lang-pt_BR.js" type="text/javascript" charset="utf-8"></script>
	<script src="loader/Ext.Loader.js" type="text/javascript" charset="utf-8"></script>
	

  

    <style>
.cor {
	font-style: italic;  
	background-color:#98fb98;
}
</style>
<style type="text/css">
    .odd { background-color: #f6f6f6; }
    .even { background-color: #ccc; }
	
	.red {background:red !important;}
	.green {background:green !important;} 
	.default-color {background:silver !important;
</style>	
	<style type="text/css">
	html, body {
        font:normal 12px verdana;
        margin:0;
        padding:0;
        border:0 none;
        overflow:hidden;
        height:100%;
    }
	p {
	    margin:5px;
	}
    .settings {
        background-image:url(shared/icons/fam/folder_wrench.png);
    }
    .nav {
        background-image:url(shared/icons/fam/folder_go.png);
    }
    
    .loading-icon {
			    background-image: url(ext-3.2.1/resources/images/default/grid/loading.gif) !important;
                
    </style>
	<script type="text/javascript">
	Ext.Load.cacheFiles.theme = Ext.get('theme').dom
	var global_printer = null;  // it has to be on the index page or the generator page  always 
	function printmygridGO(obj){  global_printer.printGrid(obj);	} 
	function printmygridGOcustom(obj){ global_printer.printCustom(obj);	}  	
	</script>
	<script language="JavaScript">
	function includeJs(filename){
    var id = filename+ '-js';
   //verifica se nao existe a tag no dom 
   if(!document.getElementById(id)){
        var body = document.getElementsByTagName('head').item(0);
        script = document.createElement('script');
        script.id = id;
        script.src = 'jstb/CadProdutos'+filename+ '.js';
        script.type = 'text/javascript';
        body.appendChild(script);
    }
    //se ja existir apenas chama a funcao da classe js
    else{
        Main(values[filename]);
    }
}
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='#';
 }
 else if(lugar=='sair'){
  window.location.href='login_controller.php?acao=logoff';
 }
 else if(lugar=='Curso'){
  window.location.href='#';
 }
}	
	function abrir(URL) {
	   var width = 1000;
	   var height = 768;
	   var left = 10;
	   var top = 00	;
	   window.open(URL,'_blank', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=yes, toolbar=no, location=no, directories=no, menubar=no, resizable=yes, fullscreen=no ');
}



//Ext.Loader.setPath('Ext.ux', 'js/StatusBar.js');



    Ext.onReady(function(){
	Ext.BLANK_IMAGE_URL = "ext-3.2.1/resources/images/default/s.gif";	
	Ext.QuickTips.init();

	Ext.override(Ext.Button, {
		initComponent: Ext.Button.prototype.initComponent.createSequence(function(){
		
			if(this.menu){
				this.menu.ownerBt = this;
			}
		})
	})
        // NOTE: This is an example showing simple state management. During development,
        // it is generally best to disable state management as dynamically-generated ids
        // can change across page loads, leading to unpredictable results.  The developer
        // should ensure that stable state ids are set for stateful components in real apps.
        Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
        
	
	
		 menus = new Ext.Panel({
				id: 'norte',
                region: 'north',
                height: 32, // give north and south regions a height
				frame: true,
               //autoEl: {
                    //tag: 'div',
                    //html:'<p>north - generally for menus, toolbars and/or advertisements</p>',
				    //items:[]
            	  //},
			   tbar: [{
			 xtype:'splitbutton',
			 text: 'Faturamento',
			 iconCls: 'sales16',
			 menu: [{text: 'Pedido',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Efetuar Pedido', iconCls:'icon-pedido', handler: function(){  abrir('pedidonew.php?menu=true')}},
						{text: 'Pesquisa', iconCls:'icon-pedpesquisa', handler: function(){Ext.Load.file('jstb/pesquisa_pedido.js', function(obj, item, el, cache){AbrePedido();},this)}}
					//	{text: 'Pendencias Cliente', iconCls:'', handler: function(){ abrir('pendencias_cli.php') }},
					//	{text: 'Importar Cotacao', iconCls:'', handler: function(){ abrir('pesquisa_cot_imp.php') }}
                    ]
                }
			},
			{text: 'Consignacion',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Movimientos', iconCls:'icon-', handler: function(){Ext.Load.file('jstb/Consignacao.js', function(obj, item, el, cache){EntConsig();},this)}},
						{text: 'Facturar/Devolver', iconCls:'icon-', handler: function(){Ext.Load.file('jstb/consig_mov.js', function(obj, item, el, cache){ConsigMov();},this)}}
                    ]
                }
			}
			/*
			,
			{text: 'Orcamento',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Efetuar Cotacao', iconCls:'icon-cotacao', handler: function(){  abrir('cotizacion.php?menu=true')}},
						{text: 'Pesquisa', iconCls:'', handler: function(){ abrir('pesquiza_cot.php') }}
					//	{text: 'Imprimir Locacao', iconCls:'', handler: function(){ abrir('imprime_locacao.php') }}
                    ]
                }
			}
			*/
			,
			{text: 'Devoluciones',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Devolucion Itens', iconCls:'', handler: function(){Ext.Load.file('jstb/Devolucao.js', function(obj, item, el, cache){DevItens();},this)}},
						{text: 'Devoluciones', iconCls:'', handler: function(){Ext.Load.file('jstb/pesquisa_devolucao.js', function(obj, item, el, cache){AbreDevolucao();},this)}}
                    ]
                }
			},
			{text: 'Caja',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Caja usuario', iconCls:'', handler: function(){Ext.Load.file('jstb/CaixaUsu.js', function(obj, item, el, cache){Caixa();},this)}},
                //        {text: 'Faturar Pedido', iconCls:'', handler: function(){  abrir('pesquisa_pedido_venda.php') }},
						{text: 'Faturar Pedido', iconCls:'', handler: function(){Ext.Load.file('jstb/FatPedido.js', function(obj, item, el, cache){FatPedido();},this)}},
						{text: 'Movimiento', iconCls:'', handler: function(){Ext.Load.file('jstb/MovCaixa.js', function(obj, item, el, cache){MovCaixa();},this)}},
						{text: 'Bajar Credito', iconCls:'', handler: function(){Ext.Load.file('jstb/BaixaCredito.js', function(obj, item, el, cache){BaixaCred();},this)}}
					//	{text: 'Informar Cheque', iconCls:'', handler: function(){Ext.Load.file('jstb/caixaChange.js', function(obj, item, el, cache){CaixaChange();},this)}}
                    ]
                }
			},
			{text: 'Lancamientos',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Lancar', iconCls:'', handler: function(){Ext.Load.file('jstb/LancDespesa.js', function(obj, item, el, cache){LancDespesa();},this)}},
						{text: 'Informe Proveedor', iconCls:'', handler: function(){Ext.Load.file('jstb/RelDespesa.js', function(obj, item, el, cache){RelDespesa();},this)}},
						{text: 'Informe Cuentas', iconCls:'', handler: function(){Ext.Load.file('jstb/RelContas.js', function(obj, item, el, cache){DespesaContas();},this)}}
                    ]
                }
			},
			{text: 'Ventas',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Facturas', iconCls:'', handler: function(){Ext.Load.file('jstb/ImpBoleta.js', function(obj, item, el, cache){ImpBoleta();},this)}}
					//	{text: 'Pesquisa', iconCls:'', handler: function(){Ext.Load.file('jstb/RelDespesa.js', function(obj, item, el, cache){RelDespesa();},this)}}
                    ]
                }
			}
			]
        },'-',{
            xtype:'splitbutton',
            text: 'Estoque',
            iconCls: 'icon-prod',
            menu: [{text: 'Cadastro',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Cadastro Produtos', iconCls:'icon-prod', handler: function(){Ext.Load.file('jstb/CadProdutos.js', function(obj, item, el, cache){CadProd();},this)}},
						{text: 'Cadastro Grupos', iconCls:'icon-grupo16', handler: function(){Ext.Load.file('jstb/CadGrupos.js', function(obj, item, el, cache){CadGrupos();},this)}},
						{text: 'Cadastro Marcas', iconCls:'icon-marca16', handler: function(){Ext.Load.file('jstb/CadMarcas.js', function(obj, item, el, cache){CadMarcas();},this)}}
                    ]
                }
			},
			{text: 'Acerto Estoque', iconCls:'', handler: function(){Ext.Load.file('jstb/AcertoEstoque.js', function(obj, item, el, cache){AcEstoque();},this)}},
			{text: 'Entrada Produtos', iconCls:'', handler: function(){Ext.Load.file('jstb/WinEntrada_prod.js', function(obj, item, el, cache){WinEntradaProd();},this)}},
		//	{text: 'Depositos', iconCls:'', handler: function(){Ext.Load.file('jstb/Depositos.js', function(obj, item, el, cache){CadDepositos();},this)}},
			{text: 'Relatorios',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                 //       {text: 'Estatistica', iconCls:'', handler: function(){Ext.Load.file('jstb/EstatisticaProd.js', function(obj, item, el, cache){EstProd();},this)}},
						{text: 'Listado', iconCls:'', handler: function(){Ext.Load.file('jstb/RelProds.js', function(obj, item, el, cache){RelatorioProds();},this)}},
						{text: 'Historico Produtos', iconCls:'icon-hist-prod', handler: function(){Ext.Load.file('jstb/HistEntProd.js', function(obj, item, el, cache){HistProd();},this)}}
				//		{text: 'Historico de Produto', iconCls:'', handler: function(){  abrir('pesquisa_iten.php') }}
				//		{text: 'Vendidos no Periodo', iconCls:'icon-periodo', handler: function(){ abrir('vendidos_periodo.php')}}

                    ]
                }
			}
		//	{text: 'Etiquetas', iconCls:'', handler: function(){Ext.Load.file('jstb/GeraEtiquetas.js', function(obj, item, el, cache){GREtiquetas();},this)}}
			
			]
        },'-',
		
		{
            xtype:'splitbutton',
            text: 'Producion',
            iconCls: 'producao',
            menu: [{text: 'Productos', iconCls:'formula', handler: function(){Ext.Load.file('jstb/Producao.js', function(obj, item, el, cache){Producao();},this)}},
			{text: 'Ordenes', iconCls:'icon-contas', handler: function(){Ext.Load.file('jstb/SolicitProd.js', function(obj, item, el, cache){Solicit();},this)}},
			{text: 'Producion', iconCls:'icon-fabrica', handler: function(){Ext.Load.file('jstb/Fabrica.js', function(obj, item, el, cache){FrabricaProd();},this)}}
			]
		}
		,'-',
		
		{
            xtype:'splitbutton',
            text: 'Financeiro',
            iconCls: 'icon-money',
            menu: [{text: 'Relatorio Mensal', iconCls:'icon-chart', handler: function(){Ext.Load.file('jstb/relatorio_mensal.js', function(obj, item, el, cache){RelMens();},this)}},
				   //{text: 'Vendas', iconCls:'', handler: function(){  abrir('vis_vendas.php') }},
				   {text: 'Contas Pagar', iconCls:'icon-grid', handler: function(){Ext.Load.file('jstb/contas_pagar.js', function(obj, item, el, cache){CtPagar();},this)}},
				   {text: 'Monedas', iconCls:'icon-cambio', handler: function(){Ext.Load.file('jstb/AtualizaCambio.js', function(obj, item, el, cache){AtCambio();},this)}},
				   {text: 'Caixa Geral', iconCls:'caixa-geral', handler: function(){Ext.Load.file('jstb/CaixaGeral.js', function(obj, item, el, cache){CaixaGeral();},this)}},
				   {text: 'Contas Receber', iconCls:'', handler: function(){Ext.Load.file('jstb/contas_receber.js', function(obj, item, el, cache){ContReceber();},this)}},
				   {text: 'Comissoes', iconCls:'icon-pedidos', handler: function(){  abrir('comissoes.php?menu=true')}}
				  ]
				  
				  
				  
        },'-',
		{
            xtype:'splitbutton',
            text: 'Compras',
            iconCls: 'icon-compras',
            menu: [{text: 'Entradas',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Lancar Fatura', iconCls:'icon-cartadd', handler: function(){Ext.Load.file('jstb/LancCompras.js', function(obj, item, el, cache){LancCompras();},this)}},
						{text: 'Pesquisa', iconCls:'icon-search', handler: function(){ abrir('pesquisa_compras.php?menu=true')}}
                    ]
                }
			},
			{text: 'Requisicao',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Emitir', iconCls:'icon-cartadd', handler: function(){Ext.Load.file('jstb/EmitirRequisicao.js', function(obj, item, el, cache){EmitirReq();},this)}}
					//	{text: 'Pesquisa', iconCls:'icon-cartadd', handler: function(){Ext.Load.file('jstb/pesquisa_requisicao.js', function(obj, item, el, cache){ReqPesquisa();},this)}}
                    ]
                }
			}
			/*
			{text: 'Importacion',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Despachos', iconCls:'icon-cartadd', handler: function(){Ext.Load.file('jstb/Despachos.js', function(obj, item, el, cache){ContDespachos();},this)}},
						{text: 'Productos', iconCls:'icon-', handler: function(){Ext.Load.file('jstb/lista_prodLegal.js', function(obj, item, el, cache){ProdsLegal();},this)}}
                    ]
                }
			},
			{text: 'Acerto Cantidad', iconCls:'', handler: function(){Ext.Load.file('jstb/legal/AcertoEstoqueLegal.js', function(obj, item, el, cache){AcEstoqueLegal();},this)}}
			*/
			]
        },'-',{
            xtype:'splitbutton',
            text: 'Cadastro',
            iconCls: 'icon-user',
            menu: [{text: 'Entidades',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Cadastrar Entidade', iconCls:'icon-useradd', handler: function(){Ext.Load.file('jstb/cadastro_clientes.js', function(obj, item, el, cache){CadastroCli();},this)}},
						{text: 'Edicao de Cadastro', iconCls:'icon-useredit', handler: function(){Ext.Load.file('jstb/lista_cli.js', function(obj, item, el, cache){CadCliente();},this)}},
						{text: 'Historico Produtos 2', iconCls:'icon-hist-prod', handler: function(){Ext.Load.file('jstb/historico_cli_prod.js', function(obj, item, el, cache){HistoricoCliProd();},this)}},
						{text: 'Listado Clientes', iconCls:'', handler: function(){  abrir('lista_clientes.php?menu=true')}}
					//	{text: 'Historico Boletas', iconCls:'icon-pedidos', handler: function(){  abrir('historico_cli.php?menu=true')}}
					//	{text: 'Historico Produtos', iconCls:'icon-hist-prod', handler: function(){  abrir('historico_cli_prod.php?menu=true')}}
                    ]
                }
			},
			

		/*	{text: 'Fornecedores',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
						{text: 'Cadastro Proveedor', iconCls:'icon-useredit', handler: function(){Ext.Load.file('jstb/cadastro_prov.js', function(obj, item, el, cache){CadProv();},this)}},
						{text: 'Alterar Cadastro', iconCls:'icon-useredit', handler: function(){  abrir('alterar_prov.php') }}
                    ]
                }
			}, */
			{text: 'Usuarios',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Cadastro Usuarios', iconCls:'icon-useredit', handler: function(){Ext.Load.file('funcionarios/public/js/index.js', function(obj, item, el, cache){CadUser();},this)}},
						{text: 'Alterar Senha', iconCls:'icon-key', handler: function(){Ext.Load.file('funcionarios/public/js/AltSenha.js', function(obj, item, el, cache){AltSenha();},this)}}
                    ]
                }
			},
			{text: 'Cadastro Cidades', iconCls:'icon-', handler: function(){Ext.Load.file('jstb/CadCidades.js', function(obj, item, el, cache){CadCidades();},this)}}

			]
        },'-',{
            xtype:'splitbutton',
            text: 'Diversos',
            iconCls: 'icon-diversos',
            menu: [{text: 'Gerar Lista Precos', iconCls:'icon-lista', handler: function(){  abrir('lista_precos.php') }},
                    
			 {text: 'Temas',
			 menu: {        // <-- submenu by nested config object
                    items: [
                   {text:'Gray',handler: function(){Ext.Load.theme({file:'ext-3.2.1/resources/css/xtheme-gray.css', id: 'theme'})}},
				   {text:'Purple',handler: function(){Ext.Load.theme({file:'ext-3.2.1/resources/css/xtheme-purple.css', id: 'theme'})}},
                   {text:'Slate',handler: function(){Ext.Load.theme({file:'ext-3.2.1/resources/css/xtheme-slate.css', id: 'theme'})}},
                   {text:'Olive',handler: function(){Ext.Load.theme({file:'ext-3.2.1/resources/css/xtheme-olive.css', id: 'theme'})}},
                   {text:'Blueen',handler: function(){Ext.Load.theme({file:'ext-3.2.1/resources/css/xtheme-blueen.css', id: 'theme'})}},
                   {text:'Green',handler: function(){Ext.Load.theme({file:'ext-3.2.1/resources/css/xtheme-light-green.css', id: 'theme'})}},
                   {text:'Orange',handler: function(){Ext.Load.theme({file:'ext-3.2.1/resources/css/xtheme-light-orange.css', id: 'theme'})}},
                   {text:'Access',handler: function(){Ext.Load.theme({file:'ext-3.2.1/resources/css/xtheme-access.css', id: 'theme'})}},
                   {text:'Blue',handler: function(){Ext.Load.theme({file:'ext-3.2.1/resources/css/xtheme-blue.css', id: 'theme'})}}
                  
				  ]
                  }}]
				  
				  
				  
        },'-',{
            xtype:'splitbutton',
            text: 'Bancos',
            iconCls: 'icon-bank',
            menu: [{text: 'Catastro Banco', iconCls:'icon-cadbank', handler: function(){Ext.Load.file('jstb/CadBanco.js', function(obj, item, el, cache){CadastroBancos();},this)}},
				   {text: 'Cheques Recibidos', iconCls:'icon-check', handler: function(){Ext.Load.file('jstb/Cheques.js', function(obj, item, el, cache){AbreCheques();},this)}},
				   {text: 'Cheques Emitidos', iconCls:'icon-check', handler: function(){Ext.Load.file('jstb/ChequesEmit.js', function(obj, item, el, cache){AbreChequesEmit();},this)}},
				   {text: 'Cuenta Bancaria', iconCls:'icon-diversos', handler: function(){Ext.Load.file('jstb/ContasBanco.js', function(obj, item, el, cache){AbreContas();},this)}}
				  
				  ]
				  
				  
				  
        },'-',{
            xtype:'splitbutton',
            text: 'Administrativo',
            iconCls: 'icon-admin',
            menu: [
				   {text: 'Controle Acesso', iconCls:'icon-acesso', handler: function(){Ext.Load.file('jstb/ControleAcesso.js', function(obj, item, el, cache){ControleAcesso();},this)}},
				   {text: 'Plan de Cuentas', iconCls:'icon-contas', handler: function(){Ext.Load.file('jstb/newplanocontas.js', function(obj, item, el, cache){NewPlanoContas();},this)}},
				   {text: 'Formas de Pago', iconCls:'icon-', handler: function(){Ext.Load.file('jstb/FormasPago.js', function(obj, item, el, cache){FomPgto();},this)}}
				  ]
				  
				  
				  
        }
		]
			
            });
			
    	CantoDireito = new Ext.Panel({
		    width:180,
			autoScroll: true,
			border: true,
			id: 'CantoDireito',
	        frame:false,
			//autoHeight: true,
			height: 153,
			layout: 'form',
	        //title: 'Pedidos',
			items: []	
 		});
			
			
		
			
       var viewport = new Ext.Viewport({
            layout:'border',
            items:[menus,
                 {
                    region:'west',
                    id:'west-panel',
                    title:' ',
                    split:true,
                    width: 111,
                    minSize: 110,
                    maxSize: 112,
                    collapsible: true,
                    margins:'0 0 0 5',
                    layout:'accordion',
                    layoutConfig:{
                        animate:true
                    },
                    items: [{
                        contentEl: 'west',
                        title:'Atalhos',
                        border:false,
                        iconCls:'nav'
                    },{
                        title:'Configuracoes',
                        html:'',
                        border:false,
                        iconCls:'settings'
                    }]
                },
                 tabs = new Ext.TabPanel({
				 	id: 'tabss',
                    autoDestroy: true,
					split:true,
					//autoScroll: true,
					//width: 400,
                    region:'center',
					//tabWidth: 400,
                    activeTab:0,
                    items:[{
                        title: 'Atividades ->',
						frame: true,
                    //	html:'<div align="center"><br><br><br><br><img src="images/vidriopar.png" alt="login"  /></br></br></br></br></div>',
                        items:[{
								xtype:'button',
								text: 'Logout',
								id: 'LINK12',
								name: 'LINK12',
								iconCls: 'icon-key',
								labelWidth: 70,
								width: 100,
								handler:function(){
										navegacao('sair');
								}
					}],
					autoScroll:true
                    }]
                })
             ]
        });

		////////////////STORE DOS PEDIDOS DO CLIENTE ///////////////////////
 
//////// FIM STORE DOS PEDIDOS DO CLIENTE //////////////
//////// INICIO DA GRID DOS PEDIDOS DO CLIENTE ////////


/*
gridUltimos.on('rowdblclick', function(sm, grid, row, e) {
					record = gridUltimos.getSelectionModel().getSelected();
					var idName = gridUltimos.getColumnModel().getDataIndex(0); // Get field name
					idData = record.get(idName);
					
					Ext.Load.file('jstb/itens_pedido.js', function(obj, item, el, cache){ItensPedido();},this);
					
		}, this);
		*/
			
			
			
Ext.Ajax.request({
	url: 'php/verifica_login.php',
	success: function(response){
	  perm = Ext.decode(response.responseText);
	}
	
	});
				
    });
	
	//perm[VariavelComNomeDaTela].ler console.log(desc);
id_usuario = "<?=$_SESSION['id_usuario']?>";
nome_user = "<?=$_SESSION['nome_user']?>";
host = "<?=$_SERVER['REMOTE_ADDR']?>"; 


	</script>
</head>
<body>
<!--<script type="text/javascript" src="../shared/examples.js"></script><!-- EXAMPLES -->
  <div id="west">
 
<!--  <p><div align="center"><a href="#" onClick="abrir('pedidonew.php?menu=true')"> <img src="images/icon_pedido64.png" alt="Pedido" width="32" height="32" /></div></p> -->
   <br><div align="center"><a href="#" onClick="Ext.Load.file('jstb/pesquisa_pedido.js', function(obj, item, el, cache){AbrePedido();},this);"><img src="images/ped_pesquisa64.png" alt="Pesquisa Pedido" width="32" height="32" /></a></div></br>
   <p><div align="center"><a href="#" onClick="Ext.Load.file('jstb/lista_prod_new.js', function(obj, item, el, cache){ListaProd();},this);"> <img src="images/icon-produtos.png" alt="Produtos" width="37" height="37" /></div></p>
   <br><div align="center"><a href="#" onClick="Ext.Load.file('jstb/lista_cli.js', function(obj, item, el, cache){CadCliente();},this);"><img src="images/lista_cli.png" alt="Clientes" width="32" height="32" /></a></div></br>
   <br><div align="center"><a href="#" onClick="Ext.Load.file('jstb/imprime_pagare.js', function(obj, item, el, cache){PrintPagare();},this);"><img src="images/icon-pagare.png" alt="Pagare" width="32" height="32" /></a></div></br>	
 </div>
  <div id="north">
    <p>&nbsp;</p>
  </div>
  <div id="center2">
  <p> Reservado</p>
           
  </div>
  <div id="center1">
       
  </div>
  <div id="props-panel" style="width:200px;height:200px;overflow:hidden;">  </div>

  <p>
  <div id="south">
  </div>
  <div id="ContSul">
  </div>

</body>
</html>
