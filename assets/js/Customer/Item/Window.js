Ext.define('Account.Customer.Item.Window', {
	extend	: 'Ext.window.Window',
	requires : ['Account.Customer.Item.Form'],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Customer',
			closeAction: 'hide',
			height: 500,
			minHeight: 500,
			width: 500,
			minWidth: 500,
			layout: 'fit',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Customer.Item.Form');

		this.items = this.form;

		return this.callParent(arguments);
	}
});