Ext.define('Account.Invoice.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Invoice',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 1120,
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
		
		this.itemDialog = Ext.create('Account.Invoice.Item.Window');

		this.grid = Ext.create('Account.Invoice.Grid', {
			region:'center',
			border: false
		});

		this.items = [this.grid];
		
		this.tbar = [this.addAct, this.editAct, this.deleteAct];

		// --- event ---
		this.addAct.setHandler(function(){
			_this.itemDialog.form.getForm().reset();
			_this.itemDialog.formTotal.getForm().reset();
			_this.itemDialog.show();
			
			// สั่ง pr_item grid load
			_this.itemDialog.grid1.load({invpr: 0});
			//_this.itemDialog.grid2.load({invpr: 0});
		});
		
		this.editAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.show();
				_this.itemDialog.form.load(id);
				
				// สั่ง pr_item grid load
				_this.itemDialog.grid1.load({invpr: id});
				//_this.itemDialog.grid2.load({invpr: id});
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