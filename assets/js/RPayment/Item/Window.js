Ext.define('Account.RPayment.Item.Window', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Payment Report',
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

       // this.itemDialog = Ext.create('Account.RQuotation.Item.Window');
         this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel',
                          handler: function () {
                            _this.fireEvent('export_exel_click', _this);
                          }
		});
		
		this.grid = Ext.create('Account.RPayment.Item.Grid', {
			region:'center',
			border: false
		});

		this.items = [this.grid];
		this.tbar = [this.excelAct];

		return this.callParent(arguments);
	}
});