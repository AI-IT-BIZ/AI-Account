Ext.define('Account.RJournal.GL.GLWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Journal Detail',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 800,
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
		this.grid2 = Ext.create('Account.RJournal.GL.GLGrid', {
			region:'center',
			border: false
		});

		this.items = [this.grid2];

		// --- after ---
		//this.grid2.load();

		return this.callParent(arguments);
	}
});