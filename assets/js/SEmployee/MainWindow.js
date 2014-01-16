Ext.define('Account.SEmployee.MainWindow', {
	extend	: 'Ext.window.Window',
	
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Employee List',
			closeAction: 'hide',
			height: 500,
			minHeight: 380,
			width: 500,
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
		/*
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
			iconCls: 'b-small-minus'
		});
		*/
		//this.itemDialog = Ext.create('Account.PR.Item.Window');

		this.grid = Ext.create('Account.SEmployee.Grid', {
			region:'center',
			border: false//,
			//tbar: [this.addAct, this.editAct, this.deleteAct, this.excelAct,this.importAct]
		});
		
		this.searchForm = Ext.create('Account.SEmployee.FormSearch', {
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
	    
		//this.tbar = [this.addAct, this.editAct, this.deleteAct];

		// --- event ---
		/*
		this.addAct.setHandler(function(){
			_this.itemDialog.show();

			// สั่ง pr_item grid load
			_this.itemDialog.grid.load({pr_id: 0});
		});

		this.editAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.show();
				_this.itemDialog.form.load(id);

				// สั่ง pr_item grid load
				_this.itemDialog.grid.load({pr_id: id});
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

		*/
		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});