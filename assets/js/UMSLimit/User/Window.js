Ext.define('Account.UMSLimit.User.Window', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Choose user',
			closeAction: 'hide',
			height: 320,
			minHeight: 320,
			width: 400,
			minWidth: 400,
			resizable: true,
			modal: true,
			layout:'border',
			maximizable: true,
			defaultFocus: 'code'
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		// --- object ---

		this.grid = Ext.create('Account.UMSLimit.User.Grid', {
			region:'center',
			border: false
		});

		this.items = [this.grid];

		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});