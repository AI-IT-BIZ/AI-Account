Ext.define('Account.RInvoice.Item.Window', {
	extend	: 'Ext.window.Window',
	//requires : [
	//	'Account.Quotation.Grid',
	//	'Account.Quotation.Item.Window'
	//],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Invoice Report',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 1000,
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
		/*this.addAct = new Ext.Action({
			text: 'Add',
			iconCls: 'b-small-plus'
		});
		this.editAct = new Ext.Action({
			text: 'Edit',
			iconCls: 'b-small-pencil'
		});
		this.deleteAct = new Ext.Action({
			text: 'Delete',
			iconCls: 'b-small-minus'
		});*/

       // this.itemDialog = Ext.create('Account.RQuotation.Item.Window');
		this.grid = Ext.create('Account.RQuotation.Item.Grid', {
			region:'center',
			border: false
		});

		this.items = [this.grid];

		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});