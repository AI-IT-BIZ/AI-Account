Ext.define('Account.RAP.Item.Window', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Account Payable Report',
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
		
		this.txtParam = Ext.create('Ext.form.Text', {
                 width: 300
               });

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
       this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel',
                          handler: function () {
                            //   alert(_this.txtParam.getValue());
                               var param = _this.txtParam.getValue();
                               window.location = __site_url+'export/rap/Index?' + param;
                          }
		});

		this.grid = Ext.create('Account.RAP.Item.Grid', {
			region:'center',
			border: false
		});

		this.items = [this.grid];
		this.tbar = [this.excelAct];

		return this.callParent(arguments);
	}
});