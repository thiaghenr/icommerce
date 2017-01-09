<?php
require_once("verifica_login.php");
include "config.php";
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
  <title><?=$title?></title>
	
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
	<script type="text/javascript" src="ux/RowExpander.js"></script>
	<script type="text/javascript" src="js/maskBr.js"></script>
	<script type="text/javascript" src="js/mask.js"></script>
    <script src="ext-3.1.1/src/locale/ext-lang-pt_BR.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="js/override.js"></script>
	<script src="loader/Ext.Loader.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="ux/Spinner.js"></script>
	<script type="text/javascript" src="ux/SpinnerField.js"></script>
	<link rel="stylesheet" type="text/css" href="ux/css/Spinner.css" />

<style type="text/css">
.x-grid3-row-ativo { background-color: #c6c6c6; }
.x-grid3-row-inativo { background-color: #f00; }
.x-grid3-row-ativo.x-grid3-row-over tbody tr { background-color: #2c6f0c; }
.x-grid3-row-inativo.x-grid3-row-over tbody tr { background-color: #6f6c0c; }

.red {background:red !important;}
.green {background:green !important;} 
.default-color {background:silver !important;

</style>

    <style>
.cor {
	font-style: italic;  
	background-color:#98fb98;
}
</style>
<style type="text/css">
.redcell { background-color:#FFE5E5 !important;}
.greenrow { background-color:#C3FF8F !important;}
.yellowrow { background-color:#FFFF66 !important;}
.pinkrow { background-color:#FFE6CC !important;}
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
			    background-image: url(ext-3.1.1/resources/images/default/grid/loading.gif) !important;
                
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
			 text: 'Facturacion',
			 iconCls: 'sales16',
			 menu: [{text: 'Pedido',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Efeztuar Pedido', iconCls:'icon-pedido', handler: function(){  abrir('pedidonew.php?menu=true')}},
						{text: 'Pesquiza', iconCls:'icon-pedpesquisa', handler: function(){Ext.Load.file('jstb/pesquisa_pedido.js', function(obj, item, el, cache){AbrePedido();},this)}},
					//	{text: 'Pendencias Cliente', iconCls:'', handler: function(){ abrir('pendencias_cli.php') }},
						{text: 'Importar Cotizacion', iconCls:'', handler: function(){ abrir('pesquisa_cot_imp.php') }},
						{text: 'Vendas por Periodo', iconCls:'', handler: function(){ abrir('pesquisa_ped.php') }}
                    ]
                }
			},
			{text: 'Consignacion',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Movimientos', iconCls:'icon-', handler: function(){Ext.Load.file('jstb/Consignacao.js', function(obj, item, el, cache){EntConsig();},this)}}
					//	{text: 'Pesquisa', iconCls:'icon-pedpesquisa', handler: function(){Ext.Load.file('jstb/pesquisa_pedido.js', function(obj, item, el, cache){AbrePedido();},this)}},
                    ]
                }
			},
			{text: 'Cotizacion',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
						{text: 'Pesquiza', iconCls:'icon-pedpesquisa', handler: function(){Ext.Load.file('jstb/pesquisa_cotacao.js', function(obj, item, el, cache){AbreCotacao();},this)}}
					//	{text: 'Imprimir Locacao', iconCls:'', handler: function(){ abrir('imprime_locacao.php') }}
                    ]
                }
			},
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
						{text: 'Facturar Pedido', iconCls:'', handler: function(){Ext.Load.file('jstb/FatPedido.js', function(obj, item, el, cache){FatPedido();},this)}},
						{text: 'Bajar Credito', iconCls:'', handler: function(){Ext.Load.file('jstb/BaixaCredito.js', function(obj, item, el, cache){BaixaCred();},this)}},
						{text: 'Movimiento', iconCls:'', handler: function(){Ext.Load.file('jstb/MovCaixa.js', function(obj, item, el, cache){MovCaixa();},this)}}
                    ]
                }
			},
			{text: 'Lanzamientos',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Lanzar', iconCls:'', handler: function(){Ext.Load.file('jstb/LancDespesa.js', function(obj, item, el, cache){LancDespesa();},this)}},
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
                        {text: 'Boletas', iconCls:'', handler: function(){Ext.Load.file('jstb/ImpBoleta.js', function(obj, item, el, cache){ImpBoleta();},this)}}
					//	{text: 'Pesquisa', iconCls:'', handler: function(){Ext.Load.file('jstb/RelDespesa.js', function(obj, item, el, cache){RelDespesa();},this)}}
                    ]
                }
			}
			]
        },'-',{
            xtype:'splitbutton',
            text: 'Stock',
            iconCls: 'icon-prod',
            menu: [{text: 'Catastro',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Catastro Productos', iconCls:'icon-prod', handler: function(){Ext.Load.file('jstb/CadProdutos.js', function(obj, item, el, cache){CadProd();},this)}},
						{text: 'Catastro Grupos', iconCls:'icon-grupo16', handler: function(){Ext.Load.file('jstb/CadGrupos.js', function(obj, item, el, cache){CadGrupos();},this)}},
						{text: 'Catastro Marcas', iconCls:'icon-marca16', handler: function(){Ext.Load.file('jstb/CadMarcas.js', function(obj, item, el, cache){CadMarcas();},this)}}
                    ]
                }
			},
			{text: 'Acerto Stock', iconCls:'', handler: function(){Ext.Load.file('jstb/AcertoEstoque.js', function(obj, item, el, cache){AcEstoque();},this)}},
			{text: 'Entrada Productos', iconCls:'', handler: function(){Ext.Load.file('jstb/WinEntrada_prod.js', function(obj, item, el, cache){WinEntradaProd();},this)}},
			{text: 'Depositos', iconCls:'', //handler: function(){Ext.Load.file('jstb/Depositos.js', function(obj, item, el, cache){CadDepositos();},this)}},
			menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Cadastro Deposito', iconCls:'', handler: function(){Ext.Load.file('jstb/Depositos.js', function(obj, item, el, cache){CadDepositos();},this)}},
						{text: 'Transferir', iconCls:'ico-app-go', handler: function(){Ext.Load.file('jstb/DepTransf.js', function(obj, item, el, cache){Tranferencias();},this)}},
						{text: 'Transferencias', iconCls:'', handler: function(){Ext.Load.file('jstb/Transferencias.js', function(obj, item, el, cache){Tranfs();},this)}}

                    ]
                }
			},
			{text: 'Informes',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                 //       {text: 'Estatistica', iconCls:'', handler: function(){Ext.Load.file('jstb/EstatisticaProd.js', function(obj, item, el, cache){EstProd();},this)}},
						{text: 'Listado', iconCls:'', handler: function(){Ext.Load.file('jstb/RelProds.js', function(obj, item, el, cache){RelatorioProds();},this)}},
						{text: 'Listado por Cantidad', iconCls:'', handler: function(){Ext.Load.file('jstb/RelGeral.js', function(obj, item, el, cache){RelatorioGeral();},this)}}
				//		{text: 'Historico de Producto', iconCls:'', handler: function(){  abrir('pesquisa_iten.php') }}
				//		{text: 'Vendidos no Periodo', iconCls:'icon-periodo', handler: function(){ abrir('vendidos_periodo.php')}}

                    ]
                }
			},
			{text: 'Etiquetas', iconCls:'', handler: function(){Ext.Load.file('jstb/GeraEtiquetas.js', function(obj, item, el, cache){GREtiquetas();},this)}}
			
			]
        } /*
		,'-',{
            xtype:'splitbutton',
            text: 'Producao',
            iconCls: 'producao',
            menu: [{text: 'Productos', iconCls:'formula', handler: function(){Ext.Load.file('jstb/Producao.js', function(obj, item, el, cache){Producao();},this)}},
			{text: 'Ordenes', iconCls:'icon-contas', handler: function(){Ext.Load.file('jstb/SolicitProd.js', function(obj, item, el, cache){Solicit();},this)}},
			{text: 'Producion', iconCls:'icon-fabrica', handler: function(){Ext.Load.file('jstb/Fabrica.js', function(obj, item, el, cache){FrabricaProd();},this)}}
			]
		}
		*/
		,'-',
		{
            xtype:'splitbutton',
            text: 'Financiero',
            iconCls: 'icon-money',
            menu: [{text: 'Informe Mensual', iconCls:'icon-chart', handler: function(){Ext.Load.file('jstb/relatorio_mensal.js', function(obj, item, el, cache){RelMens();},this)}},
				   {text: 'Ventas', iconCls:'', handler: function(){  abrir('vis_vendas.php') }},
				   {text: 'Cuentas Pagar', iconCls:'icon-grid', handler: function(){Ext.Load.file('jstb/contas_pagar.js', function(obj, item, el, cache){CtPagar();},this)}},
				   {text: 'Monedas', iconCls:'icon-cambio', handler: function(){Ext.Load.file('jstb/AtualizaCambio.js', function(obj, item, el, cache){AtCambio();},this)}},
				   {text: 'Definir Cambio', iconCls:'icon-cambio', handler: function(){  abrir('definir_cambio.php') }},
				   {text: 'Caja General', iconCls:'caixa-geral', handler: function(){Ext.Load.file('jstb/CaixaGeral.js', function(obj, item, el, cache){CaixaGeral();},this)}},
				   {text: 'Cuentas Recibir', iconCls:'', handler: function(){Ext.Load.file('jstb/contas_receber.js', function(obj, item, el, cache){ContReceber();},this)}}
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
                        {text: 'Lanzar Factura', iconCls:'icon-cartadd', handler: function(){Ext.Load.file('jstb/LancCompras.js', function(obj, item, el, cache){LancCompras();},this)}},
						{text: 'Pesquiza', iconCls:'icon-search', handler: function(){Ext.Load.file('jstb/pesquisa_compra.js', function(obj, item, el, cache){AbreCompra();},this)}}
                    ]
                }
			},
			{text: 'Requisicion',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Emitir', iconCls:'icon-cartadd', handler: function(){Ext.Load.file('jstb/EmitirRequisicao.js', function(obj, item, el, cache){EmitirReq();},this)}},
						{text: 'Pesquiza', iconCls:'icon-cartadd', handler: function(){Ext.Load.file('jstb/pesquisa_requisicao.js', function(obj, item, el, cache){ReqPesquisa();},this)}}
                    ]
                }
			},
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
			]
        },'-',{
            xtype:'splitbutton',
            text: 'Catastro',
            iconCls: 'icon-user',
            menu: [{text: 'Entidades',
			 menu: {        // <-- submenu by nested config object
                    items: [
                        // stick any markup in a menu
                        '<b class="menu-title"></b>',
                        {text: 'Catastrar Entidade', iconCls:'icon-useradd', handler: function(){Ext.Load.file('jstb/cadastro_clientes.js', function(obj, item, el, cache){CadastroCli();},this)}},
						{text: 'Listado Clientes', iconCls:'', handler: function(){  abrir('lista_clientes.php?menu=true')}},
						{text: 'Edicion de Catastro', iconCls:'icon-useredit', handler: function(){Ext.Load.file('jstb/lista_cli.js', function(obj, item, el, cache){CadCliente();},this)}},
						{text: 'Historico Productos 2', iconCls:'icon-hist-prod', handler: function(){Ext.Load.file('jstb/historico_cli_prod.js', function(obj, item, el, cache){HistoricoCliProd();},this)}},
						{text: 'Historico Facturas', iconCls:'icon-pedidos', handler: function(){  abrir('historico_cli.php?menu=true')}},
						{text: 'Historico Produtos', iconCls:'icon-hist-prod', handler: function(){  abrir('historico_cli_prod.php?menu=true')}}
                    ]
                }
			},
			{text: 'Historico Productos', iconCls:'icon-hist-prod', handler: function(){Ext.Load.file('jstb/HistEntProd.js', function(obj, item, el, cache){HistProd();},this)}},

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
                        {text: 'Catastro Usuarios', iconCls:'icon-useredit', handler: function(){Ext.Load.file('funcionarios/public/js/index.js', function(obj, item, el, cache){CadUser();},this)}},
						{text: 'Cambiar Contrasenha', iconCls:'icon-key', handler: function(){Ext.Load.file('funcionarios/public/js/AltSenha.js', function(obj, item, el, cache){AltSenha();},this)}}
                    ]
                }
			},
			{text: 'Catastro Ciudades', iconCls:'icon-', handler: function(){Ext.Load.file('jstb/CadCidades.js', function(obj, item, el, cache){CadCidades();},this)}}

			]
        },'-',{
            xtype:'splitbutton',
            text: 'Diversos',
            iconCls: 'icon-diversos',
            menu: [{text: 'Listado Precios', iconCls:'icon-lista', handler: function(){  abrir('lista_precos.php') }},
                    
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
				   {text: 'Control Acceso', iconCls:'icon-acesso', handler: function(){Ext.Load.file('jstb/ControleAcesso.js', function(obj, item, el, cache){ControleAcesso();},this)}},
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
                        title:'Atajos',
                        border:false,
                        iconCls:'nav'
                    },{
                        title:'Configuraciones',
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
                        title: 'Actividades ->',
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
	  perm = Ext.decode( response.responseText);
	

	}
	
	});
				
    });
	
	//perm[VariavelComNomeDaTela].ler console.log(desc);
id_usuario = '<?=$_SESSION['id_usuario']?>';
nome_user = '<?=$_SESSION['nome_user']?>';
host = '<?=$_SERVER['REMOTE_ADDR']?>'; 

	</script>
</head>
<body>
<script type="text/javascript" src="../shared/examples.js"></script><!-- EXAMPLES -->
  <div id="west">
 
<!--   <p><div align="center"><a href="#" onClick="abrir('pedidonew.php?menu=true')"> <img src="images/icon_pedido64.png" alt="Pedido" width="32" height="32" /></div></p> -->
   <br><div align="center"><a href="#" onClick="Ext.Load.file('jstb/pesquisa_pedido.js', function(obj, item, el, cache){AbrePedido();},this);"><img src="images/ped_pesquisa64.png" alt="Pesquisa Pedido" width="32" height="32" /></a></div></br>
   <p><div align="center"><a href="#" onClick="Ext.Load.file('jstb/lista_prod_new.js', function(obj, item, el, cache){ListaProd();},this);"> <img src="images/icon-produtos.png" alt="Produtos" width="37" height="37" /></div></p>
   <br><div align="center"><a href="#" onClick="Ext.Load.file('jstb/lista_cli.js', function(obj, item, el, cache){CadCliente();},this);"><img src="images/lista_cli.png" alt="Clientes" width="32" height="32" /></a></div></br>
<!--   <br><div align="center"><a href="#" onClick="Ext.Load.file('jstb/imprime_pagare.js', function(obj, item, el, cache){PrintPagare();},this);"><img src="images/icon-pagare.png" alt="Pagare" width="32" height="32" /></a></div></br>	-->
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

  <p>&nbsp;</p>  <!-- <a href="#" onClick="cadGrupo">Cadastro Grupo</a> -->
  <div id="south">
  </div>
  <div id="ContSul">
  </div>

</body>
</html>
