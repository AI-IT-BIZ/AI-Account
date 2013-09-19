Ext.define('Account.Journal.Item.Form_t', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'journal/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.txtDebit = Ext.create('Ext.form.field.Text', {
			fieldLabel: 'Total Amount',
			name: 'debit',
			labelWidth: 90,
			width:190,
			margin: '0 0 0 290',
			labelStyle: 'font-weight:bold;',
			readOnly: true
		});
		
		this.txtCredit = Ext.create('Ext.form.field.Text', {
			//fieldLabel: 'Total',
			name: 'credi',
			width:100,
			//margin: '0 0 0 20',
			readOnly: true
		});
		
		this.txtNet = Ext.create('Ext.form.field.Text', {
         	xtype: 'textfield',
			fieldLabel: 'Balance Amount',
			name: 'netwr1',
			align: 'right',
			width:220,
			labelWidth: 110,
			margin: '0 0 0 10',
			//style: 'font-weight:bold',
			labelStyle: 'font-weight:bold;background-color: #15b52c;',
			readOnly: true
		});

// Start Write Forms
		this.items = [{
			xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.txtDebit,this.txtCredit,
	this.txtNet]
		}];
		
		// Event /////////
		var setAlignRight = function(o){
			o.inputEl.setStyle('text-align', 'right');
		};
		var setBold = function(o){
			o.inputEl.setStyle('font-weight', 'bold');
		};
		//var setColor = function(o){
		//	o.labelEl.setStyle('font-color', '#f00');
		//};

		var tnet = this.txtNet.getValue();
		this.txtDebit.on('render', setAlignRight);
        this.txtCredit.on('render', setAlignRight);
		this.txtNet.on('render', setAlignRight);
		this.txtNet.on('render', setBold);

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'journal/load'
		});
	},
	save : function(){
		var _this=this;
		var _form_basic = this.getForm();
		
		if (_form_basic.isValid()) {
			_form_basic.submit({
				success: function(form_basic, action) {
					form_basic.reset();
					_this.fireEvent('afterSave', _this);
				},
				failure: function(form_basic, action) {
					Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
				}
			});
		}
	},
	remove : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'journal/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	// calculate function
	calculate: function(){

		var debit = this.txtDebit.getValue();
		var credit = this.txtCredit.getValue();

		var net = debit - credit;
		this.txtNet.setValue(Ext.util.Format.usMoney(net).replace(/\$/, ''));
	}
});