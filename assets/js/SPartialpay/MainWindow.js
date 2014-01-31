Ext.define('Account.SPartialpay.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Purchase Requisitions',
			closeAction: 'hide',
			height: 700,
			minHeight: 380,
			width: 1000,
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
		this.grid = Ext.create('Account.SPartialpay.Grid', {
			region:'center',
			border: false,
			tbar : [this.addAct, this.editAct, this.displayAct, this.deleteAct,
		    this.excelAct,this.importAct]
		});
		
		//this.searchForm = Ext.create('Account.PR.FormSearch', {
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

		this.searchForm = Ext.create('Account.SPartialpay.FormSearch', searchOptions);

		this.items = [this.searchForm, this.grid];

		//this.tbar = [this.addAct, this.editAct, this.deleteAct,
		//this.excelAct,this.importAct];


        this.searchForm.on('search_click', function(values){
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
        /*****************************************************/

        /*****************************************************/
		return this.callParent(arguments);
	}
});