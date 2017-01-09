// JavaScript Document

function $B(v){
	return document.getElementById(v);
}

function addEvent(obj, evType, fn)
{
    if (obj.addEventListener)
    {
       obj.addEventListener(evType, fn, false);
       return true;
    }
    else if (obj.attachEvent)
    {
       var r = obj.attachEvent("on"+evType, fn);
       return r;
    } 
    else
    {
       return false;
    }
}

function Mov(obj){
	obj.style.backgroundColor = '#000000';
}
function Mou(obj){
	obj.style.backgroundColor = '#FFFFFF';
}
function Move(obj){
	obj.style.backgroundColor = '#dfe7ed';
}
function Mout(obj, cor){
	obj.style.backgroundColor = cor;
}
function exibeDetalhes(id){
  var s = document.getElementById(id).style;
  s.display = s.display == "none" ? "block" : "none";
}

function redirect(url){
	window.location = url;
}

function cadastrar(url){
	window.location = "./"+url;
}

function enviar(url){
	window.location = "./"+url;
}

//abre uma janela de pesquisa do grupo
function abrePesquisa(url){
  var esquerda = (window.screen.width-620)/2;
  var topo = (window.screen.height-400)/2;
	window.open(url, "_blank","left=" + esquerda + ",top=" + topo + ",width=640,height=350,resizable=no,status=no,scrollbars=no");
}

function pagina(x,y){
	alert();
   document.y.action = '?acao=consulta&pagina='+x;	
   document.y.submit();	
}



//FUNÇÃO PARA CARREGAR CONTEÚDO DO SISTEMA
function checkBrowser(){
	this.ver = navigator.appVersion
	this.dom = document.getElementById?1:0
	this.ie7 = (this.ver.indexOf("MSIE 7")>-1 && this.dom)?1:0;
	this.ie6 = (this.ver.indexOf("MSIE 6")>-1 && this.dom)?1:0;
	this.ie5 = (this.ver.indexOf("MSIE 5")>-1 && this.dom)?1:0;
	this.ie4 = (document.all && !this.dom)?1:0;
	this.ns5 = (this.dom && parseInt(this.ver) >= 5) ?1:0;
	this.ns4 = (document.layers && !this.dom)?1:0;
	this.bw = (this.ie7 || this.ie6 || this.ie5 || this.ie4 || this.ns4 || this.ns5)
	return this
}

bw = new checkBrowser()



/*---------------------------------------------------------------------------------------------------------*/

function formatamoney(c) {
	alert(c);
    var t = this; if(c == undefined) c = 2;		
    var p; 
    var d = (t=t.split("."))[1].substr(0, c);
    for(p = (t=t[0]).length; (p-=3) >= 1;) {
	        t = t.substr(0,p) + "." + t.substr(p);
    }
    return t+","+d+Array(c+1-d.length).join(0);
}

String.prototype.formatCurrency=formatamoney

function demaskvalue(valor, currency){
/*
* Se currency é false, retorna o valor sem apenas com os números. Se é true, os dois últimos caracteres são considerados as 
* casas decimais
*/
var val2 = '';
var strCheck = '0123456789';
var len = valor.length;
	if (len== 0){
		return 0.00;
	}

	if (currency ==true){	
		/* Elimina os zeros à esquerda 
		* a variável  <i> passa a ser a localização do primeiro caractere após os zeros e 
		* val2 contém os caracteres (descontando os zeros à esquerda)
		*/
		
		for(var i = 0; i < len; i++)
			if ((valor.charAt(i) != '0') && (valor.charAt(i) != ',')) break;
		
		for(; i < len; i++){
			if (strCheck.indexOf(valor.charAt(i))!=-1) val2+= valor.charAt(i);
		}

		if(val2.length==0) return "0.00";
		if (val2.length==1)return "0.0" + val2;
		if (val2.length==2)return "0." + val2;
		
		var parte1 = val2.substring(0,val2.length-2);
		var parte2 = val2.substring(val2.length-2);
		var returnvalue = parte1 + "." + parte2;
		return returnvalue;
		
	}
	else{
			/* currency é false: retornamos os valores COM os zeros à esquerda, 
			* sem considerar os últimos 2 algarismos como casas decimais 
			*/
			val3 ="";
			for(var k=0; k < len; k++){
				if (strCheck.indexOf(valor.charAt(k))!=-1) val3+= valor.charAt(k);
			}			
	return val3;
	}
}

function reais(obj,event){

var whichCode = (window.Event) ? event.which : event.keyCode;
/*
Executa a formatação após o backspace nos navegadores !document.all
*/
if (whichCode == 8 && !documentall) {	
/*
Previne a ação padrão nos navegadores
*/
	if (event.preventDefault){ //standart browsers
			event.preventDefault();
		}else{ // internet explorer
			event.returnValue = false;
	}
	var valor = obj.value;
	var x = valor.substring(0,valor.length-1);
	obj.value= demaskvalue(x,true).formatCurrency();
	return false;
}
/*
Executa o Formata Reais e faz o format currency novamente após o backspace
*/
FormataReais(obj,'.',',',event);
} // end reais


function backspace(obj,event){
/*
Essa função basicamente altera o  backspace nos input com máscara reais para os navegadores IE e opera.
O IE não detecta o keycode 8 no evento keypress, por isso, tratamos no keydown.
Como o opera suporta o infame document.all, tratamos dele na mesma parte do código.
*/

var whichCode = (window.Event) ? event.which : event.keyCode;
if (whichCode == 8 && documentall) {	
	var valor = obj.value;
	var x = valor.substring(0,valor.length-1);
	var y = demaskvalue(x,true).formatCurrency();

	obj.value =""; //necessário para o opera
	obj.value += y;
	
	if (event.preventDefault){ //standart browsers
			event.preventDefault();
		}else{ // internet explorer
			event.returnValue = false;
	}
	return false;

	}// end if		
}// end backspace

function FormataReais(fld, milSep, decSep, e) {
var sep = 0;
var key = '';
var i = j = 0;
var len = len2 = 0;
var strCheck = '0123456789';
var aux = aux2 = '';
var whichCode = (window.Event) ? e.which : e.keyCode;

//if (whichCode == 8 ) return true; //backspace - estamos tratando disso em outra função no keydown
if (whichCode == 0 ) return true;
if (whichCode == 9 ) return true; //tecla tab
if (whichCode == 13) return true; //tecla enter
if (whichCode == 16) return true; //shift internet explorer
if (whichCode == 17) return true; //control no internet explorer
if (whichCode == 27 ) return true; //tecla esc
if (whichCode == 34 ) return true; //tecla end
if (whichCode == 35 ) return true;//tecla end
if (whichCode == 36 ) return true; //tecla home

/*
O trecho abaixo previne a ação padrão nos navegadores. Não estamos inserindo o caractere normalmente, mas via script
*/

if (e.preventDefault){ //standart browsers
		e.preventDefault()
	}else{ // internet explorer
		e.returnValue = false
}

var key = String.fromCharCode(whichCode);  // Valor para o código da Chave
if (strCheck.indexOf(key) == -1) return false;  // Chave inválida

/*
Concatenamos ao value o keycode de key, se esse for um número
*/
fld.value += key;

var len = fld.value.length;
var bodeaux = demaskvalue(fld.value,true).formatCurrency();
fld.value=bodeaux;

/*
Essa parte da função tão somente move o cursor para o final no opera. Atualmente não existe como movê-lo no konqueror.
*/
  if (fld.createTextRange) {
    var range = fld.createTextRange();
    range.collapse(false);
    range.select();
  }
  else if (fld.setSelectionRange) {
    fld.focus();
    var length = fld.value.length;
    fld.setSelectionRange(length, length);
  }
  return false;

}

function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function ltrim(stringToTrim) {
	return stringToTrim.replace(/^\s+/,"");
}
function rtrim(stringToTrim) {
	return stringToTrim.replace(/\s+$/,"");
}


function limpar(campoID){
	var campo = document.getElementsByTagName("input");
	for (i=0; i<campo.length; i++){
		if (campo[i].type == "text" || campo[i].type == "password"){
			if(campo[i].id != '_id')
				campo[i].value = '';
		}
	}
	if(campoID != undefined){
		setaFoco(campoID);
	}
		
}

function inverteData(data){
	var dia = data.substr(0,2);
	var mes = data.substr(3,2);
	var ano = data.substr(6,8);

	return (ano+''+dia+''+mes);
}

function getDateCurrentInvert(){
	var data = new Date();
	var dia = data.getDate();
	var mes = data.getMonth()+1;
	var ano = data.getFullYear();
	return (ano+''+dia+''+mes);
}

function formataMoeda(fld, milSep, decSep, e){
	var sep = 0;
	var key = '';
	var i = j = 0;
	var len = len2 = 0;
	var strCheck = '0123456789';
	var aux = aux2 = '';
	//var whichCode = (window.Event) ? e.which : e.keyCode;
	var whichCode = getKey(e);
	//alert(whichCode);
	if (whichCode == 13) return true;  // Enter
    if (whichCode == 8) return true;  // Enter
	if (whichCode == 46) return true;  // Enter
	if (whichCode == 39) return true;  // Enter
	if (whichCode == 37) return true;  // Enter
	if (whichCode == 9) return true;
	key = String.fromCharCode(whichCode);  // Get key value from key code
	if (strCheck.indexOf(key) == -1) return false;  // Not a valid key
	len = fld.value.length;
	for(i = 0; i < len; i++)
		if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)) break;
		aux = '';
	for(; i < len; i++)
		if (strCheck.indexOf(fld.value.charAt(i))!=-1) aux += fld.value.charAt(i);
			aux += key;
			len = aux.length;
	if (len == 0) fld.value = '';
	if (len == 1) fld.value = '0'+ decSep + '0' + aux;
	if (len == 2) fld.value = '0'+ decSep + aux;
	if (len > 2) {
		aux2 = '';
	for (j = 0, i = len - 3; i >= 0; i--) {
		if (j == 3) {
			aux2 += milSep;
			j = 0;
		}
		aux2 += aux.charAt(i);
		j++;
	}
	fld.value = '';
	len2 = aux2.length;
	for (i = len2 - 1; i >= 0; i--)
	fld.value += aux2.charAt(i);
	fld.value += decSep + aux.substr(len - 2, len);
	}
	return false;
}

function currencyFormat(fld, milSep, decSep, e) {
	return formataMoeda(fld, milSep, decSep, e);
}

function setaFoco(campoId){
	document.getElementById(campoId).focus();
}

function enter(e,idForm){
	if(document.all){
		var key = event.keyCode;
         }
	else{
		var key = e.which;
	}
	if(key==13){
		document.getElementById(idForm).submit();
	}
}

function novo_registro(url){
	window.location = url;
}

function float2moeda(num) {
   x = 0;
   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }
   if(isNaN(num)) num = "0";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = "0" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));

   ret = num + ',' + cents;

   if (x == 1) ret = ' - ' + ret;return ret;
}

function moeda2float(moeda){
   moeda = moeda.replace(".","");
   moeda = moeda.replace(",",".");

   return parseFloat(moeda);

}

function roundNumber (rnum) {
   return Math.round(rnum*Math.pow(10,2))/Math.pow(10,2);
}

String.prototype.replaceAll = function(de, para){
    var str = this;
    var pos = str.indexOf(de);
    while (pos > -1){
		str = str.replace(de, para);
		pos = str.indexOf(de);
	}
    return (str);
}

function replaceAll(str, de, para){
	try{
	    var pos = str.indexOf(de);
	    while (pos > -1){
			str = str.replace(de, para);
			pos = str.indexOf(de);
		}
	}
	catch(e){}
	
    return (str);
}

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

//colocar no evento onKeyPress = somenteNumero(event) do input
function somenteNumero(e){
	var tecla = getKey(e);
	if ((tecla >= 48 && tecla <= 57) || (tecla == 8) || (tecla==37) || (tecla==39) || (tecla == 9)|| (tecla == 13)){
		return true;
	}else 
		return false;
}

function somenteLetra(e){
	var tecla = getKey(e);
	if ((tecla >= 65 && tecla <= 90) || (tecla >= 97 && tecla <= 122) || (tecla == 8) || (tecla==37) || (tecla==39)){
		return true;
	}else 
		return false;
}

function somenteNumeroLetra(e){
	var tecla = getKey(e);
	if ((tecla >= 65 && tecla <= 90) || (tecla >= 97 && tecla <= 122) || (tecla == 8) || (tecla==37) || (tecla==39) || (tecla >= 65 && tecla <= 90)){
		return true;
	}else 
		return false;
}

//#############################################################################################
//FORMATA REAL
// <input type="text" onkeypress="reais(this,event)" onkeydown="backspace(this,event)">
function formatamoney(c) {
    var t = this; if(c == undefined) c = 2;		
    var p, d = (t=t.split("."))[1].substr(0, c);
    for(p = (t=t[0]).length; (p-=3) >= 1;) {
	        t = t.substr(0,p) + "." + t.substr(p);
    }
    return t+","+d+Array(c+1-d.length).join(0);
}

String.prototype.formatCurrency=formatamoney

function demaskvalue(valor, currency){
/*
* Se currency é false, retorna o valor sem apenas com os números. Se é true, os dois últimos caracteres são considerados as 
* casas decimais
*/
var val2 = '';
var strCheck = '0123456789';
var len = valor.length;
	if (len== 0){
		return 0.00;
	}

	if (currency ==true){	
		/* Elimina os zeros à esquerda 
		* a variável  <i> passa a ser a localização do primeiro caractere após os zeros e 
		* val2 contém os caracteres (descontando os zeros à esquerda)
		*/
		
		for(var i = 0; i < len; i++)
			if ((valor.charAt(i) != '0') && (valor.charAt(i) != ',')) break;
		
		for(; i < len; i++){
			if (strCheck.indexOf(valor.charAt(i))!=-1) val2+= valor.charAt(i);
		}

		if(val2.length==0) return "0.00";
		if (val2.length==1)return "0.0" + val2;
		if (val2.length==2)return "0." + val2;
		
		var parte1 = val2.substring(0,val2.length-2);
		var parte2 = val2.substring(val2.length-2);
		var returnvalue = parte1 + "." + parte2;
		return returnvalue;
		
	}
	else{
			/* currency é false: retornamos os valores COM os zeros à esquerda, 
			* sem considerar os últimos 2 algarismos como casas decimais 
			*/
			val3 ="";
			for(var k=0; k < len; k++){
				if (strCheck.indexOf(valor.charAt(k))!=-1) val3+= valor.charAt(k);
			}			
	return val3;
	}
}

function reais(obj,event){

var whichCode = (window.Event) ? event.which : event.keyCode;
/*
Executa a formatação após o backspace nos navegadores !document.all
*/
if (whichCode == 8 && !documentall) {	
/*
Previne a ação padrão nos navegadores
*/
	if (event.preventDefault){ //standart browsers
			event.preventDefault();
		}else{ // internet explorer
			event.returnValue = false;
	}
	var valor = obj.value;
	var x = valor.substring(0,valor.length-1);
	obj.value= demaskvalue(x,true).formatCurrency();
	return false;
}
/*
Executa o Formata Reais e faz o format currency novamente após o backspace
*/
FormataReais(obj,'.',',',event);
} // end reais


function backspace(obj,event){
/*
Essa função basicamente altera o  backspace nos input com máscara reais para os navegadores IE e opera.
O IE não detecta o keycode 8 no evento keypress, por isso, tratamos no keydown.
Como o opera suporta o infame document.all, tratamos dele na mesma parte do código.
*/

var whichCode = (window.Event) ? event.which : event.keyCode;
if (whichCode == 8 && documentall) {	
	var valor = obj.value;
	var x = valor.substring(0,valor.length-1);
	var y = demaskvalue(x,true).formatCurrency();

	obj.value =""; //necessário para o opera
	obj.value += y;
	
	if (event.preventDefault){ //standart browsers
			event.preventDefault();
		}else{ // internet explorer
			event.returnValue = false;
	}
	return false;

	}// end if		
}// end backspace

function FormataReais(fld, milSep, decSep, e) {
var sep = 0;
var key = '';
var i = j = 0;
var len = len2 = 0;
var strCheck = '0123456789';
var aux = aux2 = '';
var whichCode = (window.Event) ? e.which : e.keyCode;

//if (whichCode == 8 ) return true; //backspace - estamos tratando disso em outra função no keydown
if (whichCode == 0 ) return true;
if (whichCode == 9 ) return true; //tecla tab
if (whichCode == 13) return true; //tecla enter
if (whichCode == 16) return true; //shift internet explorer
if (whichCode == 17) return true; //control no internet explorer
if (whichCode == 27 ) return true; //tecla esc
if (whichCode == 34 ) return true; //tecla end
if (whichCode == 35 ) return true;//tecla end
if (whichCode == 36 ) return true; //tecla home

/*
O trecho abaixo previne a ação padrão nos navegadores. Não estamos inserindo o caractere normalmente, mas via script
*/

if (e.preventDefault){ //standart browsers
		e.preventDefault()
	}else{ // internet explorer
		e.returnValue = false
}

var key = String.fromCharCode(whichCode);  // Valor para o código da Chave
if (strCheck.indexOf(key) == -1) return false;  // Chave inválida

/*
Concatenamos ao value o keycode de key, se esse for um número
*/
fld.value += key;

var len = fld.value.length;
var bodeaux = demaskvalue(fld.value,true).formatCurrency();
fld.value=bodeaux;

/*
Essa parte da função tão somente move o cursor para o final no opera. Atualmente não existe como movê-lo no konqueror.
*/
  if (fld.createTextRange) {
    var range = fld.createTextRange();
    range.collapse(false);
    range.select();
  }
  else if (fld.setSelectionRange) {
    fld.focus();
    var length = fld.value.length;
    fld.setSelectionRange(length, length);
  }
  return false;

}

function getkey(e,frm)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
{
frm.focus();
return false;
}
else
return true;
}

function Limpar(valor, validos) {
// retira caracteres invalidos da string
var result = "";
var aux;
for (var i=0; i < valor.length; i++) {
aux = validos.indexOf(valor.substring(i, i+1));
if (aux>=0) {
result += aux;

}
}
return result;
}


function Formata(campo,tammax,teclapres,decimal) {
var tecla = teclapres.keyCode;
vr = Limpar(campo.value,"0123456789");
tam = vr.length;
dec=decimal;

if (tam < tammax && tecla != 8){
tam = vr.length + 1 ;

}

if (tecla == 8 ){
tam = tam - 1 ;

}

    if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <=
105 )
    {

        if ( tam <= dec ){
        campo.value = vr ;
        }

        if ( (tam > dec) && (tam <= 5) ){
        campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec,
tam ) ;
        }
        if ( (tam >= 6) && (tam <= 8) ){
        campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3
) + "," + vr.substr( tam - dec, tam ) ;
        }
        if ( (tam >= 9) && (tam <= 11) ){
        campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3
) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ;
        }
        if ( (tam >= 12) && (tam <= 14) ){
        campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11,
3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," +
vr.substr( tam - dec, tam ) ;
        }
        if ( (tam >= 15) && (tam <= 17) ){
        campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14,
3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." +
vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;
        }
    }

} 

function mascaraInteiro(obj)
  {
            // remove pontos do valor armazenado no objeto
            while (obj.value.indexOf('.') >= 0)
            {
                obj.value = obj.value.replace('.','');
            }

          // inclui pontos nos locais adequados
          var copia = obj.value;
          var tam = obj.value.length;
          var temp = '';
          for (i = tam - 1; i >= 0; i--)
          { 
              temp = copia.charAt(i) + temp;
              if ((copia.substr(i).length % 3 == 0) && (i > 0))
              {
                  temp = '.' + temp;
              }
          }
          obj.value = temp;
  }

function getContainer(node) {
    var body = dojo.body();
    while(node && node != body
          && !dojo.hasClass(node, "container")) {
      node = node.parentNode;
    }
    if(dojo.hasClass(node, "container")){
      return node;
    }
    return null;
  }



var placar = 0;
var competicao = 106;
c = navigator.appVersion.toLowerCase();
if (c.indexOf("msie 5") != -1)
  document.write('<link href="styles-ie5.css" rel="stylesheet" type="text/css" />');

function showDown(evt)
{
    evt = (evt) ? evt : ((event) ? event : null);
    
    if (evt)
    {
        if (navigator.appName=="Netscape")
        {
            if (evt.which == 116)
            {
                // When F5 is pressed
                cancelKey(evt);
            }
            else if (evt.ctrlKey && (evt.which == 82))
            {
                // When ctrl is pressed with R or N
                cancelKey(evt);
            }
        }
        else
        {
            if (event.keyCode == 116)
            {
                // When F5 is pressed
                cancelKey(evt);
            }
            else if (event.ctrlKey && (event.keyCode == 78 || event.keyCode == 82))
            {
                // When ctrl is pressed with R or N
                cancelKey(evt);
            }
        }
    }
}

function cancelKey(evt)
{
    if (evt.preventDefault)
    {
        evt.preventDefault();
        return false;
    }
    else
    {
        evt.keyCode = 0;
        evt.returnValue = false;
    }
}

if (navigator.appName=="Netscape")
document.addEventListener("keypress",showDown,true);


document.onkeydown  = showDown;

//somentenumeros, colocar assim:(id do input aki)
var numero;
function Valida(obj)
{
var valor = document.getElementById(obj).value;
var char = valor.substr(valor.length-1);
var numeros = new Array();
numeros[0] = "1";
numeros[1] = "2";
numeros[2] = "3";
numeros[3] = "4";
numeros[4] = "5";
numeros[5] = "6";
numeros[6] = "7";
numeros[7] = "8";
numeros[8] = "9";
numeros[9] = "0";

for (i=0;i<numeros.length;i++)
{
if(char == numeros[i])
{
numero = "sim";
break;
}
else
{
numero = "nao";
}
}


if (numero == "sim")
{
document.getElementById(obj).value = valor;
}
else
{
document.getElementById(obj).value = valor.substr(0,valor.length-1); 
}
}

function confirma(idn){
var url = 'alterasenha.php';
var pars = 'idn=' + idn;
var myAjax = new Ajax.Updater(
'senha_atual',
url,
{
method: 'get',
parameters: pars
});
}
