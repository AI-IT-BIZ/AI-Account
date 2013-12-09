Ext.define('Account.DepositOut.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Deposit Payment',
			closeAction: 'hide',
			height: 600,
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

       var form_import_file =  Ext.create('Ext.form.Panel', {
        id: 'form_panel-PR-MainWindow',
        layout: 'absolute',
        frame: true,
        width: 300,
        height: 200,
        items:[fibasic],
        tbar :[],
        bbar :[]
      });

        var win_import_file = Ext.create('Ext.Window', {
           id: 'win_import_file-PR-MainWindow',
           title: 'Left Header, plain: true',
           width: 300,
           height: 200,
           //x: 10,
           //y: 200,
           closeAction: 'hide',
           plain: true,
           headerPosition: 'top',
           layout: 'fit',
           items:[ form_import_file]
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
			iconCls: 'b-small-minus'
		});
        this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel'
		});
		this.importAct = new Ext.Action({
			text: 'Import',
			iconCls: 'b-small-import'
		});
		
        this.itemDialog = Ext.create('Account.DepositOut.Item.Window');
		this.grid = Ext.create('Account.DepositOut.Grid', {
			region:'center',
			border: false,
			tbar : [this.addAct, this.editAct, this.deleteAct,
		            this.excelAct,this.importAct]
		});

	    this.searchForm = Ext.create('Account.DepositOut.FormSearch', {
			region: 'north',
			height:100
		});

		this.items = [this.searchForm, this.grid];

		//this.tbar = [this.addAct, this.editAct, this.deleteAct,
		//this.excelAct, this.pdfAct,this.importAct];

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

				// สั่ง gr_item grid load
				//_this.itemDialog.form.gridItem.load({mbeln: id});
				//_this.itemDialog.form.gridPayment.load({purnr: id});
			}
		});

		this.deleteAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				
				_this.itemDialog.form.remove(id);
			}
		});
		//console.log(this.itemDialog.form);
		
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

	    this.grid.getView().on('itemdblclick', function(grid, record, item, index){
	    	_this.editAct.execute();
	    });
	    
	    		this.excelAct.setHandler(function(){
			var params = _this.searchForm.getValues(),
				sorters = (_this.grid.store.sorters && _this.grid.store.sorters.length)?_this.grid.store.sorters.items[0]:{};
			params = Ext.apply({
				sort: sorters.property,
				dir: sorters.direction
			}, params);
			query = Ext.urlEncode(params);
			window.location = __site_url+'export/depositout/index?'+query;
		});

		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});