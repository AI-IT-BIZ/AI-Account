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

		// --- object ---
		this.addAct = new Ext.Action({
			text: 'Add',
			iconCls: 'b-small-plus',
			disabled: !UMS.CAN.CREATE('QT')
		});
		this.editAct = new Ext.Action({
			text: 'Edit',
			iconCls: 'b-small-pencil',
			disabled: !(UMS.CAN.DISPLAY('QT') || UMS.CAN.CREATE('QT') || UMS.CAN.EDIT('QT'))
		});
		this.deleteAct = new Ext.Action({
			text: 'Delete',
			iconCls: 'b-small-minus',
			disabled: !UMS.CAN.DELETE('QT')
		});
		//this.printAct = new Ext.Action({
		//	text: 'Print',
		//	iconCls: 'b-small-print'
		//});
		this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel',
			disabled: !UMS.CAN.EXPORT('QT')
		});
		//this.pdfAct = new Ext.Action({
		//	text: 'PDF',
		//	iconCls: 'b-small-pdf'
		//});
		this.importAct = new Ext.Action({
			text: 'Import',
			iconCls: 'b-small-import',
			disabled: true
			//disabled: !UMS.CAN.CREATE('QT')
		});

        this.itemDialog = Ext.create('Account.Quotation.Item.Window');

        //this.importDialog = Ext.create('Account.Quotation.Import.Window');

		this.grid = Ext.create('Account.Quotation.Grid', {
			region:'center',
			border: false,
			tbar: [this.addAct, this.editAct, this.deleteAct,
				 this.excelAct,this.importAct]
		});

		var searchOptions = {
			region: 'north',
			height:100
		};
		if(this.isApproveOnly){
			searchOptions.status_options = {
				value: '02',
				readOnly: true
			};
		}

		this.searchForm = Ext.create('Account.Quotation.FormSearch', searchOptions);
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
			window.location = __site_url+'export/quotation/index?'+query;
		});

		//this.importAct.setHandler(function(){
		//	_this.importDialog.openDialog();
		//});

		this.itemDialog.form.on('afterSave', function(form, action){
			_this.itemDialog.hide();
			_this.grid.load();

			var resultId = action.result.data.id;
			_this.itemDialog.openDialog(resultId);
			Ext.Msg.alert('Status', 'Save quotation number: '+resultId+' successfully.');
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

		if(this.gridParams && !Ext.isEmpty(this.gridParams)){
			this.grid.store.on('beforeload', function (store, opts) {
				opts.params = opts.params || {};
				if(opts.params){
					opts.params = Ext.apply(opts.params, _this.gridParams);
				}
		    });
		}

		//this.importDialog.grid.on('import_success', function(){
		//	_this.importDialog.hide();
		//	_this.grid.load();
		//});

		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	},
	disableGridDoubleClick: false
});
