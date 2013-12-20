Ext.define('Account.WHT.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'WHT Search Help',
			closeAction: 'hide',
			height: 420,
			width: 450,
			layout: 'border',
			resizable: true,
			modal: true,
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.grid = Ext.create('Account.WHT.GridItem', {
			region:'center'
		});

		this.items = [this.grid];

		// --- after ---
		this.grid.load();
		return this.callParent(arguments);
	}
});