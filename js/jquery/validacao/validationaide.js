//----------------------------------------------------------------------------------
// File: validationaide.js 
//
// Copyright (c) 2007 Ste Brennan (dnaide.com)
// Licensed under the COMMON DEVELOPMENT AND DISTRIBUTION LICENSE (CDDL) Version 1.0
// http://www.opensource.org/licenses/cddl1.php
//
//----------------------------------------------------------------------------------

//
// Validator Rule classes
//
function ValidatorRule (name, errorMessage, validationMethod){
	this.validationMethod = validationMethod;
	this.errorMessage = errorMessage ? errorMessage : 'Falha.';
	this.name = name;
};
ValidatorRule.prototype = {
	doValidation : function(fieldValue, fieldObj) {
		return this.validationMethod(fieldValue, fieldObj);
	}
};

//
// Validator Rule Collection class
//
function ValidatorRuleCollection(){
	this.items = {};
};
ValidatorRuleCollection.prototype = {
	add : function(name, errorMessage, testFunction) {
		this.items[name] = new ValidatorRule(name, errorMessage, testFunction);
	}
};

//
// Static methods
//
jQuery.validationAide = {
	getDefaultValidationRules : function(){
	
		var rules = new ValidatorRuleCollection();
		
		rules.add('valida_branco', 'Preencha o campo.', function(fieldValue, fieldObj) {
			if (fieldValue == "")	return false;
			return true;
		});
		
		rules.add('valida_email', 'Por favor insira um e-mail v�lido. Exemplo nome@dominio.com', function(fieldValue, fieldObj) {
			if (fieldValue == "")	return true;
			return /\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(fieldValue);
		});
		
		rules.add('valida_numero_ponto', 'Por favor insira somente n�meros e pontos.', function(fieldValue, fieldObj) {
			if (fieldValue == "")	return true;
			return (!isNaN(fieldValue) && !/^\s+$/.test(fieldValue));
		});
		
		rules.add('valida_numero', 'Por favor insira somente n�meros.', function(fieldValue, fieldObj) {
			if (fieldValue == "")	return true;
			return !/[^\d]/.test(fieldValue);
		});
		
		rules.add('valida_texto', 'Por favor insira somente texto.', function(fieldValue, fieldObj) {
			if (fieldValue == "")	return true;
			return /^[a-zA-Z]+$/.test(fieldValue);
		});
		
		rules.add('valida_texto_numero', 'Por favor use somente letras de (a-z) ou n�meros de (0-9).', function(fieldValue, fieldObj) {
			if (fieldValue == "")	return true;
			return !/\W/.test(fieldValue);
		});
		
		rules.add('valida_dinheiro', 'Por favor, insira valor real. Por exemplo R$1.000,00', function(fieldValue, fieldObj) {
			if (fieldValue == "")	return true;
			return /^\d{1,3}(\.\d{3})*\,\d{2}$/.test(fieldValue);
		});
		
		rules.add('valida_hora', 'Por favor insira hora no formato: HH:mm.', function(fieldValue, fieldObj) {
			if (fieldValue == "")	return true;
			return /^([0-1]\d|2[0-3]):[0-5]\d$/.test(fieldValue);
		});
		
		rules.add('valida_data', 'Por favor use data no formato: dd/mm/aaaa.', function(fieldValue, fieldObj) {
			if (fieldValue == "")	return true;
			var regex = /^(\d{2})\/(\d{2})\/(\d{4})$/;
			if(!regex.test(fieldValue)) return false;
			var d = new Date(fieldValue.replace(regex, '$2/$1/$3'));
			return ( parseInt(RegExp.$2, 10) == (1+d.getMonth()) ) && 
							(parseInt(RegExp.$1, 10) == d.getDate()) && 
							(parseInt(RegExp.$3, 10) == d.getFullYear() );
		});
		
		rules.add('valida_url', 'Por favor insira uma URL v�lida.', function(fieldValue, fieldObj) {
			if (fieldValue == "")	return true;
			return /^(http|https|ftp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\/?/i.test(fieldValue);
		});

		return rules;
	},
	
	
	extendOptions : function(options){
	
		var retval = jQuery.extend({}, options || {});
		
		if (typeof retval.showInlineMessages == 'undefined')
			retval.showInlineMessages = true;
		
		if (typeof retval.inlineShowSpeed == 'undefined')
			retval.inlineShowSpeed= "";
			
		if (typeof retval.inlineMessageElementIdPrefix == 'undefined')
			retval.inlineMessageElementIdPrefix= "ValidationInlineErrorMessage-";
		
		if (typeof retval.inlineMessageCssClass == 'undefined')
			retval.inlineMessageCssClass= "mensagem-erro-validacao";
		
		if (typeof retval.showSummary == 'undefined')
			retval.showSummary = false;
			
		if (typeof retval.summaryElementId == 'undefined')
			retval.summaryElementId = "ClientValidationSummary";
		
		if (typeof retval.summaryMessage == 'undefined')
			retval.summaryMessage = "Please correct the following:";
			
		if (typeof retval.summaryFieldMessageFormat == 'undefined')
			retval.summaryFieldMessageFormat = "##FIELD## - ##MESSAGE##";
			
		if (typeof retval.fieldErrorCssClass == 'undefined')
			retval.fieldErrorCssClass = "falha-validacao";
		
		if (typeof retval.fieldMessageSeparator == 'undefined')
			retval.fieldMessageSeparator = ' - ';
		
		return retval;
	},
	
	
	resetForm : function (formId, options){
	
		if (typeof jQuery.fn.fieldStringVal != "function"){
			alert("Aten��o, a valida��o s�  vai funcionar se stringaide.js for carregado!");
		}
	
		var fullOptions = jQuery.validationAide.extendOptions(options);
		
		if (fullOptions.showSummary){
			// Hide summary container
			jQuery("#" + fullOptions.summaryElementId).html("").hide();
		}
			
		// Loop through each input and remove any previous inline error message / classes
		jQuery(formId + " :input").each( function(){
			var inlineMessageElementId = "#" + fullOptions.inlineMessageElementIdPrefix + this.id;
			jQuery(inlineMessageElementId).remove();
			jQuery(this).removeClass(fullOptions.fieldErrorCssClass);
		});
	
	},
	
	
	validateForm : function(formId, validationRules, options, preFieldValidation, postFieldValidation){
		jQuery.validationAide.resetForm(formId, options);
		
		var fullOptions = jQuery.validationAide.extendOptions(options);
				
		var validatedOK = true;
		
		validationRules = validationRules ? validationRules : jQuery.validationAide.getDefaultValidationRules();
	
	  var scrollTo = "";
	  var focusField = "";
	  var firstErroredField = true;
	  
	  if (fullOptions.showSummary){
			var messagesForSummary = new Array();
			var fieldsForSummary = new Array();
	  }
	  
		// Loop through each input and validate
		jQuery(formId + " :input").each( function(){
			
			var elmId = this.id;
			
			if (elmId != ""){
				var jQueryElm = jQuery(this);
				var cssClassesStr = new String(jQueryElm.attr("class")); 
				cssClassesStr = jQuery.trim(cssClassesStr);
				if (cssClassesStr.length > 0){
					var cssClasses = cssClassesStr.split(" ");
									
					for (var i=0; i<cssClasses.length; i++){
						
						var validationRule = validationRules.items[cssClasses[i]];					
						
						if (validationRule){
							
							// Get value of the field as a string
							var fieldValue = jQueryElm.fieldStringVal();
							
							// Fire off preFieldValidation event
							if (typeof preFieldValidation == 'function')
								preFieldValidation(fieldValue, this);
							
							var retval = validationRule.doValidation(fieldValue, this);
							
							// Fire off postFieldValidation event
							if (typeof postFieldValidation == 'function')
								postFieldValidation(fieldValue, this, retval);
							
							if (!retval){
							
								validatedOK = false;
								
								// Set focus and scroll to the first errored element
								if (firstErroredField){
									scrollTo = elmId;
									focusField = elmId;
									firstErroredField = false;
								}
								
								// Set the error css class
								jQueryElm.addClass(fullOptions.fieldErrorCssClass);
								
								var title = jQueryElm.attr("title");
								if (!title || title == 'undefined')
								{
									if (!title || title == 'undefined')
										title = elmId;
								}
								var fieldFriendlyName = title;	
								var fieldMessage = validationRule.errorMessage;
								
								if (fieldFriendlyName.indexOf(fullOptions.fieldMessageSeparator) > -1){
									var messageArr = fieldFriendlyName.split(fullOptions.fieldMessageSeparator);
									fieldFriendlyName = messageArr[0];
									fieldMessage = messageArr[1];
								}
								
								if (fullOptions.showSummary){
									// Add the message to the summary array
									fieldsForSummary.push(elmId);
									var messageForSummary = new String(fullOptions.summaryFieldMessageFormat);
									messageForSummary = messageForSummary.replace("##FIELD##", fieldFriendlyName);
									messageForSummary = messageForSummary.replace("##MESSAGE##", fieldMessage);
									messagesForSummary.push(messageForSummary);
								}
											
								if (fullOptions.showInlineMessages){
									var inlineMessageElementId = fullOptions.inlineMessageElementIdPrefix + elmId;
									// Insert the inline error message
									jQueryElm.after('<div id="' + inlineMessageElementId + '" class="' + fullOptions.inlineMessageCssClass + '">' + fieldMessage + '</div>');	
									if (fullOptions.inlineShowSpeed != ""){
										jQuery("#" + inlineMessageElementId).hide();
										jQuery("#" + inlineMessageElementId).show(fullOptions.inlineShowSpeed);	
									}
								}
								
								break;
							}
						}
					}
				}	
			}
			
		});
		
		if (!validatedOK && fullOptions.showSummary){
			// Show the message summary
			var summaryHtml = "";
			if (fullOptions.summaryMessage != ""){
				summaryHtml = fullOptions.summaryMessage;
			}
			
			summaryHtml += "<ul>";
			for(var i=0;i<messagesForSummary.length; i++){
				summaryHtml += "<li><a href=\"#\" onclick=\"location.hash = '#" + fieldsForSummary[i] + "'; jQuery('#" + fieldsForSummary[i] + "')[0].focus(); return false;\">" + messagesForSummary[i] + "</a></li>";
			}
			summaryHtml += "</ul>";
			
			jQuery("#" + fullOptions.summaryElementId).html(summaryHtml).show();
			
			scrollTo = fullOptions.summaryElementId;
		}
		
		if (scrollTo != ""){
			location.hash = "#" + scrollTo;
		}
		
		if (focusField != ""){
			jQuery("#" + focusField)[0].focus();
		}
		
		return validatedOK;
	}
};


//
// jQuery object method extensions
//
jQuery.fn.validationAideEnable = function(validationRules, options, preFieldValidation, postFieldValidation){
	jQuery.validationAide.resetForm("#" + this[0].id, options);
	this.unbind("submit");
	this.bind("submit", function(){ return jQuery.validationAide.validateForm("#" + this.id, validationRules, options, preFieldValidation, postFieldValidation); });
	return this;
};

jQuery.fn.validationAideDisable = function(){
	this.unbind("submit");
	return this;
};

jQuery.fn.validationAideDisableOnClick = function(formId){
	this.unbind("click");
	this.bind("click", function(){ jQuery(formId).unbind("submit"); });
	return this;
};

jQuery.fn.validationAideEnableOnClick = function(formId, validationRules, options, preFieldValidation, postFieldValidation){
	jQuery.validationAide.resetForm(formId, options);
	this.unbind("click");
	this.bind("click", function(){ jQuery(formId).validationAideEnable(validationRules, options, preFieldValidation, postFieldValidation); });
	return this;
};