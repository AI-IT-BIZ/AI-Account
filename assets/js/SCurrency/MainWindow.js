Ext.define('Account.SCurrency.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Currency List',
			closeAction: 'hide',
			height: 620,
			minHeight: 380,
			width: 350,
			minWidth: 300,
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

		this.grid = Ext.create('Account.SCurrency.Grid', {
			region:'center',
			border: false,
			tbar: [this.addAct, this.editAct, this.deleteAct, this.excelAct,this.importAct]
		});
		
		//this.searchForm = Ext.create('Account.SCurrency.FormSearch', {
		//	region: 'north',
		//	height:60
		//});

		//this.items = [this.searchForm, this.grid];
		this.items = [this.grid];
		
		/*this.searchForm.on('search_click', function(values){
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
	    });*/

		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});