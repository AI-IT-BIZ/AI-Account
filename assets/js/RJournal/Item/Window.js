Ext.define('Account.RJournal.Item.Window', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Journal Report',
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
		this.grid = Ext.create('Account.RJournal.Item.Grid', {
			region:'center',
			border: false
		});

		this.items = [this.grid];

		// --- after ---
		//this.grid.load();

		return this.callParent(arguments);
	}
});