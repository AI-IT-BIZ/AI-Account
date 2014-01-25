Ext.define('Account.RAssetRegister.Item.Window', {
	extend	: 'Ext.window.Window',
	//requires : [
	//	'Account.Quotation.Grid',
	//	'Account.Quotation.Item.Window'
	//],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Asset Register Report',
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
                
        this.grid = Ext.create('Account.RAssetRegister.Item.Grid', {
			region:'center',
			border: false
		});

       // this.itemDialog = Ext.create('Account.RQuotation.Item.Window');
            this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel',
                          handler: function () {
                            var params = _this.form.getValues(),
				            sorters = (_this.grid.store.sorters && _this.grid.store.sorters.length)?_this.grid.store.sorters.items[0]:{};
			                params = Ext.apply({
				               sort: sorters.property,
				               dir: sorters.direction
			                }, params);
			                query = Ext.urlEncode(params);
			                window.location = __site_url+'export/rassetregister/index?'+query;
                          }
		});
		
		this.items = [this.grid];
        this.tbar = [this.excelAct];

		// --- after ---
		//this.grid.load();

		return this.callParent(arguments);
	}
});