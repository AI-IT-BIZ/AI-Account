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
			height: 700,
			minHeight: 380,
			width: 1200,
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
            this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel',
                          handler: function () {
                            _this.fireEvent('export_exel_click', _this);
                          }
		});
		this.grid = Ext.create('Account.RInvoice.Item.Grid', {
			region:'center',
			border: false
		});

		this.items = [this.grid];
        this.tbar = [this.excelAct];

		// --- after ---
		//this.grid.load();

		return this.callParent(arguments);
	}
});