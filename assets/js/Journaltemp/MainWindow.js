Ext.define('Account.Journaltemp.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Journal Template',
			closeAction: 'hide',
			height: 700,
			minHeight: 380,
			width: 500,
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

		// --- object ---
		
		this.addAct = new Ext.Action({
			text: 'Add',
			iconCls: 'b-small-plus',
			disabled: !UMS.CAN.CREATE('JT')
		});
		this.editAct = new Ext.Action({
			text: 'Edit',
			iconCls: 'b-small-pencil',
			disabled: !(UMS.CAN.DISPLAY('JT') || UMS.CAN.CREATE('JT') || UMS.CAN.EDIT('JT'))
		});
		this.deleteAct = new Ext.Action({
			text: 'Delete',
			iconCls: 'b-small-minus',
			disabled: !UMS.CAN.DELETE('JT')
		});
		
		this.itemDialog = Ext.create('Account.Journaltemp.Item.Window');

		this.grid = Ext.create('Account.Journaltemp.Grid', {
			region:'center',
			border: false
		});

		var searchOptions = {
			region: 'north',
			height:60
		};
		if(this.isApproveOnly){
			searchOptions.status_options = {
				value: '02',
				readOnly: true
			};
		}
        
        this.searchForm = Ext.create('Account.Journaltemp.FormSearch', searchOptions);
		//this.importDialog = Ext.create('Account.Journal.Import.Window');
		
		this.items = [this.searchForm, this.grid];

		this.tbar = [this.addAct, this.editAct, this.deleteAct];

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
				//_this.itemDialog.form.gridItem.load({tranr: id});
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
		
		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});