Ext.define('app.controller.mainController', {
 extend: 'Ext.app.Controller',
 
 views: ['home', 'parceiros'],
 models:['parceiros'], 
 stores: ['Parceiros'], 
 config:{
 refs: {
 ContactForm: '#contactForm'
 },
 },
 init: function() {
 console.log('mainController:init');
 
 this.control({
 'button[action=sendMessage]': {
 tap: 'submitContactForm'
 }
 });
 },
 submitContactForm:function(){
 
 var formValues = this.getContactForm().getValues();
 
 var $this=this;
 Ext.Ajax.request({
 url: 'ajax.php',
 method: 'POST',
 params: {
 formValues: Ext.encode({form_fields: formValues})
 },
 success: function(response, opts) {
 var obj = Ext.decode(response.responseText);
 Ext.Msg.alert('Contact Complete!', obj.responseText);
 $this.resetForm();
 },
 failure: function(response, opts) {
 console.log('server-side failure with status code ' + response.status);
 }
 });
 },
 resetForm: function() {
 this.getContactForm().reset();
 },
 
});