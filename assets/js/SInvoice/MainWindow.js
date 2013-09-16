Ext.define('Account.SInvoice.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Invoice List',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 1090,
			minWidth: 500,
			resizable: true,
			modal: true,
			layout:'border',
			maximizable: true
		});

		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;

		// --- object ---

		this.grid = Ext.create('Account.SInvoice.Grid', {
			region:'center',
			border: false
		});

		this.items = [this.grid];

		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});