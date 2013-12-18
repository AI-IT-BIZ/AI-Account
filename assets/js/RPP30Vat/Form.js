Ext.define('Account.RPP30Vat.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			//url: __site_url+'quotation/report',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',//'side',
				labelWidth: 105
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
        // INIT Customer search popup ///////////////////////////////////
        this.numberBalance = Ext.create('Ext.ux.form.NumericField', {
           // xtype: 'numberfield',
			fieldLabel: 'ภาษีที่ชำระเกินยกมา',
			name: 'balwr',
			//labelAlign: 'right',
			width:250,
			align: 'right'//,
         });
        
		this.items = [{
// Project Code
        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'datefield',
			fieldLabel: 'Period Date',
			name: 'bldat',
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			width:250,
			allowBlank: false
			}]  
		},this.numberBalance];		

		return this.callParent(arguments);
	},

	//load : function(id){
	//	this.getForm().load({
	//		params: { id: id },
	//		url:__site_url+'quotation/load'
	//	});
	//},


});

