Ext.define('Account.Saleorder.MainWindow', {
	extend	: 'Ext.window.Window',
	//requires : [
	//	'Account.Quotation.Grid',
	//	'Account.Quotation.Item.Window'
	//],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Sale Order',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 930,
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
		this.addAct = new Ext.Action({
			text: 'Add',
			iconCls: 'b-small-plus'
		});
		this.editAct = new Ext.Action({
			text: 'Edit',
			iconCls: 'b-small-pencil'
		});
		this.deleteAct = new Ext.Action({
			text: 'Delete',
			disabled: true,
			iconCls: 'b-small-minus'
		});

        this.itemDialog = Ext.create('Account.Saleorder.Item.Window');
		this.grid = Ext.create('Account.Saleorder.Grid', {
			region:'center',
			border: false
		});

		this.items = [this.grid];

		this.tbar = [this.addAct, this.editAct, this.deleteAct];

		// --- event ---
		this.addAct.setHandler(function(){
			_this.itemDialog.form.reset();
			_this.itemDialog.show();
		});

		this.editAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.show();
				_this.itemDialog.form.load(id);

				// สั่ง pr_item grid load
				_this.itemDialog.form.gridItem.load({ordnr: id});
				//_this.itemDialog.form.gridPayment.load({vbeln: id});
			}
		});

		this.deleteAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.form.remove(id);
			}
		});
		//console.log(this.itemDialog.form);

		this.itemDialog.form.on('afterSave', function(){
			_this.itemDialog.hide();
			_this.grid.load();
		});

		this.itemDialog.form.on('afterDelete', function(){
			_this.grid.load();
		});


		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});