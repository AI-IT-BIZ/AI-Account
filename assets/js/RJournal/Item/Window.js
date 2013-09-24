Ext.define('Account.RJournal.Item.Window', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Journal Report',
			closeAction: 'hide',
			height: 600,
			minHeight: 380,
			width: 800,
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
		
		this.detailAct = new Ext.Action({
			text: 'Journal Details',
			iconCls: 'b-small-detail'
		});
		
		this.glDialog = Ext.create('Account.Journal.GL.GLWindow');

		this.grid = Ext.create('Account.RJournal.Item.Grid', {
			region:'center',
			border: false
		});

		this.items = [this.grid];
		this.tbar = [this.detailAct];
		
		// --- event ---
		this.detailAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.glDialog.show();
				//_this.itemDialog.form.load(id);

				// สั่ง gl_item grid load
				_this.glDialog.grid2.load({belnr: id});
			}
		});

		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});