Ext.define('Account.Quotation.MainWindow', {
	extend	: 'Ext.window.Window',
	//requires : [
	//	'Account.Quotation.Grid',
	//	'Account.Quotation.Item.Window'
	//],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Quotation',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 1020,
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
		// --- Init external component ---
		this.searchForm = Ext.create('Account.Quotation.FormSearch', {
			region: 'north',
			height:100
		});
		// --- End Init external component ---

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
		this.printAct = new Ext.Action({
			text: 'Print',
			iconCls: 'b-small-print'
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

        this.itemDialog = Ext.create('Account.Quotation.Item.Window');
		this.grid = Ext.create('Account.Quotation.Grid', {
			region:'center',
			border: false
		});

		this.items = [this.searchForm, this.grid];

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
			if(id){
				_this.itemDialog.show();
				_this.itemDialog.form.load(id);

				// สั่ง pr_item grid load
				_this.itemDialog.form.gridItem.load({vbeln: id});
				_this.itemDialog.form.gridPayment.load({vbeln: id});
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

		this.searchForm.on('search_click', function(values){
			_this.grid.load();
		});
		this.searchForm.on('reset_click', function(values){
			_this.grid.load();
		});

		this.grid.store.on("beforeload", function (store, opts) {
			opts.params = opts.params || {};
			if(opts.params){
				var formValues = _this.searchForm.getValues();
				Ext.apply(opts.params, formValues);
			}
	    });


		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});