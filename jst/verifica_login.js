// JavaScript Document
//Ext.onReady(function(){   
Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
Ext.QuickTips.init();

//var id_usuario ;
/////////////////////// INICIO STORE //////////////////////////////////

var dsUsuario = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: '../php/verifica_login.php',
        method: 'POST'
    }),   
reader:  new Ext.data.JsonReader({
			root: 'Usuario',
			id: 'id_usuario',
			fields: [
					 {name: 'id_usuario',  type: 'string', mapping: 'id_usuario' },
					 {name: 'usuario',  type: 'string', mapping: 'usuario' },
					 {name: 'nome_user',  type: 'string', mapping: 'nome_user' },
					 {name: 'perfil_id',  type: 'string', mapping: 'perfil_id' },
					 {name: 'id_cargo',  type: 'string', mapping: 'id_cargo' },
					 {name: 'host',  type: 'string', mapping: 'host' }

					 ]
			})					    
			
		})

 dsUsuario.on('load', function(grid, record, action, row, col, rowIndex) {
		 id_usuario = dsUsuario.getAt(0).get('id_usuario');
		 usuario = dsUsuario.getAt(0).get('usuario');
		 nome_user = dsUsuario.getAt(0).get('nome_user');
		 perfil_id = dsUsuario.getAt(0).get('perfil_id');
		 id_cargo = dsUsuario.getAt(0).get('id_cargo');
		 host = dsUsuario.getAt(0).get('host');
		
     }
     );

dsUsuario.load();

//setTimeout(function(){
//alert(id_usuario);  /// da erro
//}, 3250);
//alert(usuario);   ///  tbm da erro
	
//});