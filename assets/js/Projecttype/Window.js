Ext.define('Account.Projecttype.Window', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Project Type Management',
			closeAction: 'hide',
			height: 650,
			minHeight: 380,
			width: 700,
			minWidth: 500,
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

		// --- object ---
		this.addAct = new Ext.Action({
			text: 'Add',
			iconCls: 'b-small-plus',
			disabled: !UMS.CAN.CREATE('PJ')
		});
		this.editAct = new Ext.Action({
			text: 'Edit',
			iconCls: 'b-small-pencil',
			disabled: !(UMS.CAN.CREATE('PJ') || UMS.CAN.EDIT('PJ') || UMS.CAN.APPROVE('PJ'))
		});
		this.displayAct = new Ext.Action({
			text: 'Display',
			iconCls: 'b-small-search',
			disabled: !UMS.CAN.DISPLAY('PJ')
		});
		this.deleteAct = new Ext.Action({
			text: 'Delete',
			disabled: true,
			iconCls: 'b-small-minus'
		});
		this.excelAct = new Ext.Action({
			text: 'Excel',
			disabled: true,
			iconCls: 'b-small-excel'
		});
		this.importAct = new Ext.Action({
			text: 'Import',
			iconCls: 'b-small-import',
			disabled: true
		});

		this.itemDialog = Ext.create('Account.Projecttype.Item.Window');
		
		//this.importDialog = Ext.create('Account.CustType.Import.Window');

		this.grid = Ext.create('Account.Projecttype.Grid', {
			region:'center',
			border: false,
			tbar: [this.addAct, this.editAct, this.displayAct, this.deleteAct, this.excelAct,this.importAct]
		});
		
		//this.searchForm = Ext.create('Account.CustType.FormSearch', {
		//	region: 'north',
		//	height:100
		//});

		this.items = [this.grid];

		//this.tbar = [this.addAct, this.editAct, this.deleteAct,
		//this.excelAct,this.importAct];

		// --- event ---
		this.addAct.setHandler(function(){
			_this.itemDialog.openDialog();
			_this.itemDialog.setReadOnly(false);
			_this.itemDialog.setTitle('Create Project Type');
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
				_this.itemDialog.setReadOnly(false);
				_this.itemDialog.setTitle('Edit Project Type');
				//_this.itemDialog.show();
				//_this.itemDialog.form.load(id);

				// สั่ง pr_item grid load
				//_this.itemDialog.form.gridItem.load({ebeln: id});
			}
		});
		
		this.displayAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.openDialog(id);
				_this.itemDialog.setReadOnly(true);
				_this.itemDialog.setTitle('Display Project Type');
			}
		});

		this.deleteAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.form.remove(id);
			}
		});
		
		//this.importAct.setHandler(function(){
		//	_this.importDialog.openDialog();
		//});

		this.itemDialog.form.on('afterSave', function(form){
			_this.itemDialog.hide();
			_this.grid.load();
		});

		this.itemDialog.form.on('afterDelete', function(form){
			_this.grid.load();
		});
        
        //this.searchForm.on('search_click', function(values){
		//	_this.grid.load();
		//});
		//this.searchForm.on('reset_click', function(values){
		//	_this.grid.load();
		//});

		this.grid.store.on("beforeload", function (store, opts) {
			opts.params = opts.params || {};
			//if(opts.params){
			//	var formValues = _this.searchForm.getValues();
			//	Ext.apply(opts.params, formValues);
			//}
	    });
        
       //if(!this.disableGridDoubleClick){
	    this.grid.getView().on('itemdblclick', function(grid, record, item, index){
	    	_this.editAct.execute();
	    });
	    //}
	    
	    /*this.excelAct.setHandler(function(){
			var params = _this.searchForm.getValues(),
				sorters = (_this.grid.store.sorters && _this.grid.store.sorters.length)?_this.grid.store.sorters.items[0]:{};
			params = Ext.apply({
				sort: sorters.property,
				dir: sorters.direction
			}, params);
			query = Ext.urlEncode(params);
			window.location = __site_url+'export/customer/index?'+query;
		});*/
		
		//this.importDialog.grid.on('import_success',function(){
		//	_this.importDialog.hide();
		//	_this.grid.load();
		//});
		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});