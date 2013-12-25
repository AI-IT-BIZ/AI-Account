Ext.define('Account.UMSLimit.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Limitation setting',
			closeAction: 'destroy',
			height: 500,
			minHeight: 500,
			width: 550,
			minWidth: 550,
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

		this.tree = Ext.create('Account.UMSLimit.TreeDocType', {
			region:'center',
			border: false,
			extraParams: this.treeExtraParams
		});


		this.items = [this.tree];
/*
		this.grid = Ext.create('Account.UMS.Grid', {
			region:'center',
			border: false
		});

        this.itemDialog = Ext.create('Account.UMS.Item.Window');

		this.items = [this.grid];

		// --- event ---
		this.editAct.setHandler(function(){
			var id = _this.grid.getSelectionId();
			if(id){
				_this.itemDialog.openDialog(id);
			}
		});
		this.itemDialog.form.on('afterSave', function(){
			_this.itemDialog.hide();
			_this.grid.load();
		});

	    this.grid.getView().on('itemdblclick', function(grid, record, item, index){
	    	_this.editAct.execute();
	    });

		// --- after ---
		this.grid.load();
*/
		return this.callParent(arguments);
	},
	dialogParams: null,
	openDialog: function(params){
		this.dialogParams = params;


		this.show(false, function(){
			this.tree.load(params);
		});
	}
});