Ext.define('Account.Material.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Material Management',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 1200,
			minWidth: 100,
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
		this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel'
		});
		this.importAct = new Ext.Action({
			text: 'Import',
			iconCls: 'b-small-import'
		});
		
		this.itemDialog = Ext.create('Account.Material.Item.Window');

		this.grid = Ext.create('Account.Material.Grid', {
			region:'center',
			border: false,
			tbar: [this.addAct, this.editAct, this.deleteAct,
				 this.excelAct,this.importAct]
		});

		this.searchForm = Ext.create('Account.Material.FormSearch', {
			region: 'north',
			height:100
		});

		//this.tbar = [this.addAct, this.editAct, this.deleteAct,
		//this.printAct, this.excelAct, this.pdfAct,this.importAct];

		this.items = [this.searchForm, this.grid];

		// --- event ---
		this.addAct.setHandler(function(){
			_this.itemDialog.openDialog();
			//_this.itemDialog.form.reset();
			//_this.itemDialog.show();
		});

		this.editAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.openDialog(id);
				//_this.itemDialog.show();
				//_this.itemDialog.form.load(id);

				// สั่ง pr_item grid load
				//_this.itemDialog.form.gridItem.load({vbeln: id});
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

		this.excelAct.setHandler(function(){
			var params = _this.searchForm.getValues(),
				sorters = (_this.grid.store.sorters && _this.grid.store.sorters.length)?_this.grid.store.sorters.items[0]:{};
			params = Ext.apply({
				sort: sorters.property,
				dir: sorters.direction
			}, params);
			query = Ext.urlEncode(params);
			window.location = __site_url+'export/material/index?'+query;
		});

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
				opts.params = Ext.apply(opts.params, formValues);
			}
	    });

		if(!this.disableGridDoubleClick){
		    this.grid.getView().on('itemdblclick', function(grid, record, item, index){
		    	_this.editAct.execute();
		    });
		}


		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});