Ext.define('Account.PO.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Purchase Orders',
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
			disabled: true,
			iconCls: 'b-small-minus'
		});

        this.itemDialog = Ext.create('Account.PO.Item.Window');
		this.grid = Ext.create('Account.PO.Grid', {
			region:'center',
			border: false
		});
        this.printAct = new Ext.Action({
			text: 'Print',
			iconCls: 'b-small-print'
		});
        this.excelAct = new Ext.Action({
			text: 'Excel',
			iconCls: 'b-small-excel'
		});
		this.pdfAct = new Ext.Action({
			text: 'PDF',
			iconCls: 'b-small-pdf'
		});
		this.importAct = new Ext.Action({
			text: 'Import',
			iconCls: 'b-small-import'
		});
		this.exportAct = new Ext.Action({
			text: 'Export',
			iconCls: 'b-small-export'
		});
		
		this.items = [this.grid];

		this.tbar = [this.addAct, this.editAct, this.deleteAct,
		this.printAct, this.excelAct, this.pdfAct,this.importAct, this.exportAct];

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
			_this.itemDialog.openDialog(id);
			/*
			if(id){
				_this.itemDialog.show();
				_this.itemDialog.form.load(id);

				// สั่ง pr_item grid load
				_this.itemDialog.form.gridItem.load({ebeln: id});
			}
			*/
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


		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});