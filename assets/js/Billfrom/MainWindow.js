Ext.define('Account.Billfrom.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Billing Received',
			closeAction: 'hide',
			height: 700,
			minHeight: 380,
			width: 950,
			minWidth: 500,
			resizable: true,
			modal: false,
			layout:'border',
			maximizable: true,
			minimizable: true,
			listeners: {
				minimize: function(win,obj) {
					if(!win.getCollapsed())
						win.collapse(Ext.Component.DIRECTION_BOTTOM, false);
					else
						win.expand(false);
				}
			}
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
			iconCls: 'b-small-plus',
			disabled: !UMS.CAN.CREATE('BF')
		});
		this.editAct = new Ext.Action({
			text: 'Edit',
			iconCls: 'b-small-pencil',
			disabled: !(UMS.CAN.DISPLAY('BF') || UMS.CAN.CREATE('BF') || UMS.CAN.EDIT('BF'))
		});
		this.displayAct = new Ext.Action({
			text: 'Display',
			iconCls: 'b-small-search',
			disabled: !UMS.CAN.DISPLAY('BF')
		});
		this.deleteAct = new Ext.Action({
			text: 'Delete',
			iconCls: 'b-small-minus',
			disabled: !UMS.CAN.DELETE('BF')
		});
		
        this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel',
			disabled: !UMS.CAN.EXPORT('BF')
		});
		//this.pdfAct = new Ext.Action({
		//	text: 'PDF',
		//	iconCls: 'b-small-pdf'
		//});
		this.importAct = new Ext.Action({
			text: 'Import',
			disabled: true,
			iconCls: 'b-small-import'
		});

		this.itemDialog = Ext.create('Account.Billfrom.Item.Window');

		this.grid = Ext.create('Account.Billfrom.Grid', {
			region:'center',
			border: false,
			tbar: [this.addAct, this.editAct, this.displayAct, this.deleteAct,
				   this.excelAct,this.importAct]
		});

		//this.searchForm = Ext.create('Account.Billfrom.FormSearch', {
		//	region: 'north',
		//	height:100
		//});

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

		this.searchForm = Ext.create('Account.Billfrom.FormSearch', searchOptions);
		
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
			_this.itemDialog.setReadOnly(false);
				/*_this.itemDialog.show();
				_this.itemDialog.form.load(id);

				// สั่ง pr_item grid load
				_this.itemDialog.form.gridItem.load({bilnr: id});
			    //_this.itemDialog.form.gridPayment.load({recnr: id});*/
			}
		});
		
		this.displayAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.openDialog(id);
				_this.itemDialog.setReadOnly(true);
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