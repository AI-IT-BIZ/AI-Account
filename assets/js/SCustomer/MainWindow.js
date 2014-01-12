Ext.define('Account.SCustomer.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Customer List',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 800,
			minWidth: 600,
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

		this.grid = Ext.create('Account.SCustomer.Grid', {
			region:'center',
			border: false//,
			//tbar: [this.addAct, this.editAct, this.deleteAct, this.excelAct,this.importAct]
		});
		
		this.searchForm = Ext.create('Account.SCustomer.FormSearch', {
			region: 'north',
			height:100
		});

		this.items = [this.searchForm, this.grid];
		
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