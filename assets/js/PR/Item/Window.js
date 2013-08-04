Ext.define('Account.PR.Item.Window', {
	extend	: 'Ext.window.Window',
	requires : ['Account.PR.Item.Form'],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Purchase Request',
			closeAction: 'hide',
			height: 180,
			minHeight: 180,
			width: 300,
			minWidth: 300,
			layout: 'fit',
			resizable: true,
			modal: true,
			html: 'This is content'
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.PR.Item.Form');

		this.items = this.form;

		return this.callParent(arguments);
	}
});