Ext.define('Account.RAssetDepreciation.Item.Window', {
	extend	: 'Ext.window.Window',
	//requires : [
	//	'Account.Quotation.Grid',
	//	'Account.Quotation.Item.Window'
	//],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Asset Depreciation Report',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 1100,
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
		
		//this.form = Ext.create('Account.Quotation.Item.Form',{ region:'center' });
                
        this.grid = Ext.create('Account.RAssetDepreciation.Item.Grid', {
			region:'center',
			border: false
		});

       // this.itemDialog = Ext.create('Account.RQuotation.Item.Window');
       this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel',
                          handler: function () {
                            _this.fireEvent('export_exel_click', _this);
                          }
		});
		
		this.items = [this.grid];
        this.tbar = [this.excelAct];

		// --- after ---
		//this.grid.load();

		return this.callParent(arguments);
	}
});