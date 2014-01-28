Ext.define('Account.RARLedger.Item.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {
		var _this=this;

		Ext.apply(this, {
			title: 'AR Ledger preview',
			maximizable: true,
			maximized: true,
			enableCopies: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {

		return this.callParent(arguments);
	}
});
