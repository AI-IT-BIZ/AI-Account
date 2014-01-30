Ext.define('Account.SJournaltemp.MainWindow', {
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
			modal: true,
			layout:'border',
			maximizable: true//,
			//defaultFocus: 'ttype'
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		// --- object ---
		
		this.grid = Ext.create('Account.SJournaltemp.Grid', {
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
        
        this.searchForm = Ext.create('Account.SJournaltemp.FormSearch', searchOptions);
		//this.importDialog = Ext.create('Account.Journal.Import.Window');
		
		this.items = [this.searchForm, this.grid];

		this.tbar = [this.addAct, this.editAct, this.deleteAct];

		// --- event ---


		
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