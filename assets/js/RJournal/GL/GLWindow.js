Ext.define('Account.RJournal.GL.GLWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Journal Detail',
			closeAction: 'hide',
			height: 300,
			minHeight: 450,
			width: 680,
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

       // this.itemDialog = Ext.create('Account.RQuotation.Item.Window');
		this.grid = Ext.create('Account.RJournal.GL.GLGrid', {
			region:'center',
			border: false
		});

		this.items = [this.grid];

		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});