Ext.define('Account.UMS.Employee.Window', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Choose employee',
			closeAction: 'hide',
			height: 380,
			minHeight: 380,
			width: 1000,
			minWidth: 1000,
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

		this.grid = Ext.create('Account.UMS.Employee.Grid', {
			region:'center',
			border: false
		});

		this.searchForm = Ext.create('Account.Employee.FormSearch', {
			region: 'north',
			height:100
		});

		this.items = [this.searchForm, this.grid];

		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});