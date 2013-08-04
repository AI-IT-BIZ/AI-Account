Ext.define('Account.Warehouse.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Warehouse',
			closeAction: 'hide',
			height: 200,
			minHeight: 200,
			width: 300,
			minWidth: 300,
			layout: 'fit',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Warehouse.Item.Form');

		this.items = this.form;

		return this.callParent(arguments);
	}
});