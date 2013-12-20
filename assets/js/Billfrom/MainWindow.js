Ext.define('Account.Billfrom.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Billing Received',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 950,
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
		
		/*****************************************************/

       var fibasic = Ext.create('Ext.form.field.File', {
        width: 200,
        x: 50,
        y: 50,
        hideLabel: true
    });

      /*****************************************************/

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
		//this.pdfAct = new Ext.Action({
		//	text: 'PDF',
		//	iconCls: 'b-small-pdf'
		//});
		this.importAct = new Ext.Action({
			text: 'Import',
			iconCls: 'b-small-import'
		});

		this.itemDialog = Ext.create('Account.Billfrom.Item.Window');

		this.grid = Ext.create('Account.Billfrom.Grid', {
			region:'center',
			border: false,
			tbar: [this.addAct, this.editAct, this.deleteAct,
				this.printAct, this.excelAct,this.importAct]
		});

		this.searchForm = Ext.create('Account.Billfrom.FormSearch', {
			region: 'north',
			height:100
		});

		//this.tbar = [this.addAct, this.editAct, this.deleteAct,
		//this.printAct, this.excelAct,this.importAct];

		this.items = [this.searchForm, this.grid];

		// --- event ---
		this.addAct.setHandler(function(){
			//_this.itemDialog.form.reset();
			//_this.itemDialog.show();
			_this.itemDialog.openDialog();

		});

		this.editAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
			_this.itemDialog.openDialog(id);
			
				/*_this.itemDialog.show();
				_this.itemDialog.form.load(id);

				// สั่ง pr_item grid load
				_this.itemDialog.form.gridItem.load({bilnr: id});
			    //_this.itemDialog.form.gridPayment.load({recnr: id});*/
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
			window.location = __site_url+'export/po/index?'+query;
		});

		this.itemDialog.form.on('afterSave', function(){
			_this.itemDialog.hide();
			_this.grid.load();
		});//

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

	    this.grid.getView().on('itemdblclick', function(grid, record, item, index){
	    	_this.editAct.execute();
	    });
		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});