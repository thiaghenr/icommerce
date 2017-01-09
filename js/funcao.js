// JavaScript Document

//FORMATA MOEDA REAL
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
////////////////////////
//PULAR DE CAMPO
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
////////////////////////

function submitForm(form) {
        /*   
        usa método request() da classe Form da prototype, que serializa os campos   
        do formulário e submete (por POST como default) para a action especificada no form   
        */   
        form.request({   
          onComplete: function(transport){   
              /*   
            se o retorno for diferente de -1, entende-se que não houve problemas, então apaga-se   
            os campos do formulário usando o método reset() da classe Form   
            */		
			lista(s);    
            if(transport.responseText!=-1)   
                form.reset();   
            }    
        });   
        return false;
  
    }   