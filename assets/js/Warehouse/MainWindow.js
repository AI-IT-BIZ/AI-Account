Ext.define('Account.Warehouse.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Warehouse management',
			closeAction: 'hide',
			height: 380,
			minHeight: 380,
			width: 500,
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

		this.grid = Ext.create('Account.Warehouse.Grid', {
			region:'center',
			border: false
		});

		this.itemDialog = Ext.create('Account.Warehouse.Item.Window');

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