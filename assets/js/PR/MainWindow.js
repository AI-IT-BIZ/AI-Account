
Ext.define('Account.PR.MainWindow', {
	extend	: 'Ext.window.Window',
	requires : ['Account.PR.Grid', 'Account.PR.Item.Window'],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Purchase Request',
			closeAction: 'hide',
			height: 380,
			minHeight: 380,
			width: 500,
			minWidth: 500,
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
		this.addAct = new Ext.Action({
			text: 'เพิ่ม',
			iconCls: 'b-small-plus'
		});

		this.itemDialog = Ext.create('Account.PR.Item.Window');

		this.grid = Ext.create('Account.PR.Grid', {
			region:'center'
		});

		this.items = [this.grid];

		this.tbar = [this.addAct];

		// --- event ---
		this.addAct.setHandler(function(){
			_this.itemDialog.show();
		});

		this.itemDialog.form.on('afterSave', function(form){
			_this.itemDialog.hide();
			_this.grid.load();
		});

		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});