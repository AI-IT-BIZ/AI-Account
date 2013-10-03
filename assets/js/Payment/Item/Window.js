Ext.define('Account.Payment.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Payment',
			closeAction: 'hide',
			height: 650,
			width: 950,
			layout: 'border',
			border: false,
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Payment.Item.Form',{ region:'center' });

		this.items = [
		     this.form
		   ];

		this.buttons = [{
			text: 'Save',
			handler: function() {
				
				_this.form.save();
			}
		}, {
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.hide();
			}
		}];

		return this.callParent(arguments);
	}
});