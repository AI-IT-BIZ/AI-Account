Ext.define('Account.Project.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Project Management',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 1020,
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
		this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel'
		});
		this.importAct = new Ext.Action({
			text: 'Import',
			disabled: true,
			iconCls: 'b-small-import'
		});

		//this.tbar = [this.addAct, this.editAct, this.deleteAct,
		//this.printAct, this.excelAct, this.pdfAct,this.importAct, this.exportAct];
        this.itemDialog = Ext.create('Account.Project.Item.Window');

		this.grid = Ext.create('Account.Project.Grid', {
			region:'center',
			border: false,
			tbar: [this.addAct, this.editAct, this.deleteAct,
				this.excelAct,this.importAct]
		});

		this.searchForm = Ext.create('Account.Project.FormSearch', {
			region: 'north',
			height:100
		});

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
				//_this.itemDialog.grid.load({jobnr: id});
			}
		});

		this.deleteAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.form.remove(id);
			}
		});

		this.itemDialog.form.on('afterSave', function(){
			_this.itemDialog.hide();
			_this.grid.load();
		});

		this.itemDialog.form.on('afterDelete', function(){
			_this.grid.load();
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
				Ext.apply(opts.params, formValues);
			}
	    });

        if(!this.disableGridDoubleClick){
	      this.grid.getView().on('itemdblclick', function(grid, record, item, index){
	    	_this.editAct.execute();
	      });
	    }

		/*if(this.gridParams && !Ext.isEmpty(this.gridParams)){
			this.grid.store.on('beforeload', function (store, opts) {
				opts.params = opts.params || {};
				if(opts.params){
					opts.params = Ext.apply(opts.params, _this.gridParams);
				}
		    });
		}*/

	    this.excelAct.setHandler(function(){
			var params = _this.searchForm.getValues(),
				sorters = (_this.grid.store.sorters && _this.grid.store.sorters.length)?_this.grid.store.sorters.items[0]:{};
			params = Ext.apply({
				sort: sorters.property,
				dir: sorters.direction
			}, params);
			query = Ext.urlEncode(params);
			window.location = __site_url+'export/project/index?'+query;
		});


		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});