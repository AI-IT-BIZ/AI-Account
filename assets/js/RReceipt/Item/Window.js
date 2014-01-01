Ext.define('Account.RReceipt.Item.Window', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Receipt Report',
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
		
		this.txtParam = Ext.create('Ext.form.Text', {
           
                 width: 300
      
               });
		
		 this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel',
                          handler: function () {
                            //   alert(_this.txtParam.getValue());
                               var param = _this.txtParam.getValue();
                               window.location = __site_url+'export/rinvoice/GetReportFromPageSelect?' + param;
                          }
		});

       // this.itemDialog = Ext.create('Account.RQuotation.Item.Window');
		this.grid = Ext.create('Account.RReceipt.Item.Grid', {
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