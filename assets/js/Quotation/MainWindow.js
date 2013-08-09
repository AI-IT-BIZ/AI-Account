Ext.define('Account.Quotation.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Quotation',
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
			iconCls: 'b-small-minus'
		});
		
		this.tbar = [this.addAct, this.editAct, this.deleteAct];

		this.grid = Ext.create('Account.Quotation.Grid', {
			region:'center'
		});

		this.itemDialog = Ext.create('Account.Quotation.Item.Window');

		this.items = [this.grid];

		// --- event ---
		this.addAct.setHandler(function(){
			_this.itemDialog.show();
		});
		
		this.editAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.show();
				_this.itemDialog.form.load(id);
			}
		});

		this.deleteAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.form.remove(id);
			}
		});

		//this.itemDialog.form.on('afterSave', function(){
		//	_this.itemDialog.hide();
		//	_this.grid.load();
		//});

		//this.itemDialog.form.on('afterDelete', function(){
		//	_this.grid.load();
		//});


		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});