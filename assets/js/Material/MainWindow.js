Ext.define('Account.Material.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Material Management',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 600,
			minWidth: 1000,
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

		this.grid = Ext.create('Account.Material.Grid', {
			region:'center'
		});

		this.itemDialog = Ext.create('Account.Material.Item.Window');

		this.items = [this.grid];

		// --- event ---
		this.addAct.setHandler(function(){
			//_this.itemDialog.reset();
			_this.itemDialog.show();
			
			// สั่ง pr_item grid load
			_this.itemDialog.grid.load({jobnr: 0});
		});
		
		this.editAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.show();
				_this.itemDialog.form.load(id);
				
				// สั่ง pr_item grid load
				_this.itemDialog.grid.load({jobnr: id});
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