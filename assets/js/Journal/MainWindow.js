Ext.define('Account.Journal.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Journal',
			closeAction: 'hide',
			height: 680,
			minHeight: 380,
			width: 1000,
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
		this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel',
			disabled: !UMS.CAN.EXPORT('QT')
		});
		this.importAct = new Ext.Action({
			text: 'Salary Import',
			disabled: !UMS.CAN.CREATE('JN'),
			iconCls: 'b-small-import'
		});
		
		this.itemDialog = Ext.create('Account.Journal.Item.Window');
        this.importDialog = Ext.create('Account.Journal.Import.Window');
        
		this.grid = Ext.create('Account.Journal.Grid', {
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
        
        this.searchForm = Ext.create('Account.Journal.FormSearch', searchOptions);
		//this.importDialog = Ext.create('Account.Journal.Import.Window');
		
		this.items = [this.searchForm, this.grid];
		//this.tbar = [this.addAct, this.editAct, this.deleteAct, this.importAct];
		

		// --- event ---
		this.addAct.setHandler(function(){
			_this.itemDialog.openDialog();
			//_this.itemDialog.form.reset();
			//_this.itemDialog.show();

			// สั่ง gl_item grid load
			//_this.itemDialog.gridItem.load({tranr: 0});
		});

		this.editAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.openDialog(id);
				//_this.itemDialog.show();
				//_this.itemDialog.form.load(id);

				// สั่ง gl_item grid load
				//_this.itemDialog.form.gridItem.load({belnr: id});
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
		
		this.importDialog.grid.on('import_success', function(){
			_this.importDialog.hide();
			_this.grid.load();
		});
		
		this.excelAct.setHandler(function(){
			var params = _this.searchForm.getValues(),
				sorters = (_this.grid.store.sorters && _this.grid.store.sorters.length)?_this.grid.store.sorters.items[0]:{};
			params = Ext.apply({
				sort: sorters.property,
				dir: sorters.direction
			}, params);
			query = Ext.urlEncode(params);
			window.location = __site_url+'export/journal/index?'+query;
		});
		
		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});