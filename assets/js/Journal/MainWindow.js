Ext.define('Account.Journal.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Journal',
			closeAction: 'hide',
			height: 380,
			minHeight: 380,
			width: 745,
			minWidth: 500,
			resizable: true,
			modal: true,
			layout:'border',
			maximizable: true//,
			//defaultFocus: 'code'
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		// --- object ---
		
		this.addAct = new Ext.Action({
			text: 'Add',
			iconCls: 'b-small-plus',
			disabled: !UMS.CAN.CREATE('JN')
		});
		this.editAct = new Ext.Action({
			text: 'Edit',
			iconCls: 'b-small-pencil',
			disabled: !(UMS.CAN.DISPLAY('JN') || UMS.CAN.CREATE('JN') || UMS.CAN.EDIT('JN'))
		});
		this.deleteAct = new Ext.Action({
			text: 'Delete',
			iconCls: 'b-small-minus',
			disabled: !UMS.CAN.DELETE('JN')
		});
		
		this.importAct = new Ext.Action({
			text: 'Salary Import',
			disabled: true,
			iconCls: 'b-small-import'
		});
		
		this.itemDialog = Ext.create('Account.Journal.Item.Window');

		this.grid = Ext.create('Account.Journal.Grid', {
			region:'center',
			border: false
		});

		this.importDialog = Ext.create('Account.Journal.Import.Window');
		
		this.items = [this.grid];

		this.tbar = [this.addAct, this.editAct, this.deleteAct, this.importAct];
		

		// --- event ---
		this.addAct.setHandler(function(){
			_this.itemDialog.form.reset();
			_this.itemDialog.show();

			// สั่ง gl_item grid load
			//_this.itemDialog.gridItem.load({tranr: 0});
		});

		this.editAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.show();
				_this.itemDialog.form.load(id);

				// สั่ง gl_item grid load
				_this.itemDialog.form.gridItem.load({belnr: id});
			}
		});

		this.deleteAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.form.remove(id);
			}
		});
		
		this.importAct.setHandler(function(){
			_this.importDialog.openDialog();
		});
		
		this.itemDialog.form.on('afterSave', function(form){
			_this.itemDialog.hide();

			_this.grid.load();
		});

		this.itemDialog.form.on('afterDelete', function(form){
			_this.grid.load();
		});
		
		this.importDialog.grid.on('import_success',function(){
			_this.importDialog.hide();
			_this.grid.load();
		});
		
		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});