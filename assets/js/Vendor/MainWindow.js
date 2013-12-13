Ext.define('Account.Vendor.MainWindow', {
	extend	: 'Ext.window.Window',
	
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Vendor Management',
			closeAction: 'hide',
			height: 580,
			minHeight: 580,
			width: 1050,
			minWidth: 1000,
			resizable: true,
			modal: true,
			layout:'border',
			maximizable: true,
			defaultFocus: 'code'
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
			text: 'เพิ่ม',
			iconCls: 'b-small-plus'
		});
		this.editAct = new Ext.Action({
			text: 'แก้ไข',
			iconCls: 'b-small-pencil'
		});
		this.deleteAct = new Ext.Action({
			text: 'ลบ',
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

		this.itemDialog = Ext.create('Account.Vendor.Item.Window');

		this.grid = Ext.create('Account.Vendor.Grid', {
			region:'center',
			border: false,
			tbar: [this.addAct, this.editAct, this.deleteAct, this.excelAct,this.importAct]
		});
		
		this.searchForm = Ext.create('Account.Vendor.FormSearch', {
			region: 'north',
			height:100
		});

		this.items = [this.searchForm, this.grid];

		//this.tbar = [this.addAct, this.editAct, this.deleteAct,
		//this.excelAct,this.importAct];

		// --- event ---
		this.addAct.setHandler(function(){
			_this.itemDialog.openDialog();
			/*
			_this.itemDialog.form.reset();
			_this.itemDialog.show();
			*/
		});

		this.editAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			
			if(id){
				_this.itemDialog.openDialog(id);
				//_this.itemDialog.show();
				//_this.itemDialog.form.load(id);

				// สั่ง pr_item grid load
				//_this.itemDialog.form.gridItem.load({ebeln: id});
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
				Ext.apply(opts.params, formValues);
			}
	    });
	    
        if(!this.disableGridDoubleClick){
	    this.grid.getView().on('itemdblclick', function(grid, record, item, index){
	    	_this.editAct.execute();
	    });
	    }
	    
	    this.excelAct.setHandler(function(){
			var params = _this.searchForm.getValues(),
				sorters = (_this.grid.store.sorters && _this.grid.store.sorters.length)?_this.grid.store.sorters.items[0]:{};
			params = Ext.apply({
				sort: sorters.property,
				dir: sorters.direction
			}, params);
			query = Ext.urlEncode(params);
			window.location = __site_url+'export/vendor/index?'+query;
		});

		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});