Ext.ns('Ext.ux');
/**
 * @copyright 2009 André Luis
 * @projectDescription MaskedTextField
 * @author André Luis
 * @namespace Ext.ux
 * @extends Ext.form.TextField
 * @version 0.5
 * @license License details: http://www.gnu.org/licenses/lgpl.html
 */

Ext.ux.MaskedTextField = function(config){
	Ext.applyIf(this, config);
	this.initComponents();
	Ext.ux.MaskedTextField.superclass.constructor.call(this, config);
};
Ext.extend(Ext.ux.MaskedTextField,Ext.form.TextField,{
	initComponents: function(){
		Ext.apply(this,{
				 id:'MaskedTextField',
				 mask : null,
				 fixedRegExp: new RegExp(/[\s()-\/,.:]/g),
				 textReverse: false,
				 preDefinedTypes : {
				 	'phone'	: '(999) 9999999999',
					'date'	: '39/19/2999',
					'time'	: '29:69',	
					'cep'	: '99999-999',
					'cpf'	: '999.999.999-99',
					'cnpj'	: '99.999.999/9999-99',
					'creditCard': '9999 9999 9999 9999',
					'decimal' : '999.999.999.999,99',
					'porcentagem' : '999.999.999.999.99',
					'percent' : '999.9999',
					'guarani' : '9.999.999.999.999',
					'planoconta' : '9.99.99.99.999.99'
				 },
				 enableKeyEvents: true,
				 listeners : {
				 	render : function(){
						this.applyReverse();
					},
					keyup: function(){
						if(this.checkValueLenght())
							this.applyMask();
						else
							this.setValue(this.getValue().substring(0,(this.getMaskFormat().length)));
					}				 	
				 }
			});				
		},
		applyMask: function(){	
			
			var valueWOFixedRegExp  = this.getClearValue().split('');
			var valueMask 	= this.getMaskFormat().split('');
			
			if (this.textReverse) {
				valueWOFixedRegExp = valueWOFixedRegExp.reverse();
				valueMask = valueMask.reverse();
			}
			
			var newValue	= new Array();
			var valueCount	= 0;
			var maskCount	= 0;
			
			while((valueCount < valueWOFixedRegExp.length) && (maskCount < valueMask.length)){					
				
				var valueChar = valueWOFixedRegExp[valueCount];
				var maskChar  = valueMask[maskCount];
				
				if(/\d/.test(maskChar)){
					if(/\d/.test(valueChar)){
						if(valueChar <= maskChar){
							newValue.push(valueChar);
						}
					}
					valueCount++;
					maskCount++;
				}else if(/\?/.test(maskChar)){
					if(/[a-zA-Z]/.test(valueChar)){
						newValue.push(valueChar);
					}
					valueCount++;
					maskCount++;
				}
				else if(/\*/.test(maskChar)){
					newValue.push(valueChar);
					valueCount++;
					maskCount++;
				}else if(this.fixedRegExp.test(maskChar)){
					newValue.push(maskChar);
					maskCount++;
				}					
			}			
			if(this.textReverse)
				newValue = newValue.reverse();
			
			Ext.form.TextField.superclass.setValue.apply(this,[newValue.join('')]);
			
		},
		applyReverse: function(){
			if (this.textReverse)
				Ext.get(this.getId()).applyStyles({'text-align': 'right'});	
		},
		checkValueLenght: function(){
			if(this.getValue().length > this.getMaskFormat().length){
				return false;
			}else{
				return true;
			}						
		},
		getClearValue: function(){
			return this.getValue().replace(this.fixedRegExp,'');
		},
		getMask : function(){
			return this.mask;
		},
		getMaskFormat: function(){
			if(this.preDefinedTypes[this.mask])
				return this.preDefinedTypes[this.mask];
			else
				return this.mask;	
		},
		setMask: function(newMask){
			this.mask = newMask;
		},
		setValue: function(value){
			Ext.form.TextField.superclass.setValue.apply(this,[value]);
			this.applyMask();
		}
			
});

Ext.reg('maskedtextfield', Ext.ux.MaskedTextField);
