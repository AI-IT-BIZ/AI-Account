Ext.define('Account.Customer.MainWindow', {
	extend	: 'Ext.window.Window',
	requires : [
		'Account.Customer.Grid',
		'Account.Customer.Item.Window'
	],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Customer Management',
			closeAction: 'hide',
			height: 380,
			minHeight: 380,
			width: 1000,
			minWidth: 1000,
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
		this.editAct = new Ext.Action({
			text: 'แก้ไข',
			iconCls: 'b-small-pencil'
		});
		this.deleteAct = new Ext.Action({
			text: 'ลบ',
			iconCls: 'b-small-minus'
		});
		this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel'
		});
		this.pdfAct = new Ext.Action({
			text: 'PDF',
			iconCls: 'b-small-pdf'
		});
		this.importAct = new Ext.Action({
			text: 'Import',
			iconCls: 'b-small-import'
		});
		this.exportAct = new Ext.Action({
			text: 'Export',
			iconCls: 'b-small-export'
		});

		this.itemDialog = Ext.create('Account.Customer.Item.Window');

		this.grid = Ext.create('Account.Customer.Grid', {
			region:'center'
		});

		this.items = [this.grid];

		this.tbar = [this.addAct, this.editAct, this.deleteAct,
		this.printAct, this.excelAct, this.pdfAct,this.importAct, this.exportAct];

		// --- event ---
		this.addAct.setHandler(function(){
			_this.itemDialog.form.reset();
			_this.itemDialog.show();
		});

		this.editAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			//alert(id);
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

		this.itemDialog.form.on('afterSave', function(form){
			_this.itemDialog.hide();
			_this.grid.load();
		});

		this.itemDialog.form.on('afterDelete', function(form){
			_this.grid.load();
		});

		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});