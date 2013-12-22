Ext.define('Account.Bankname.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Bank Name',
			closeAction: 'hide',
			height: 380,
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

		this.grid = Ext.create('Account.Bankname.GridItem', {
			region:'center',
			border: false
		});

		this.items = [this.grid];

		//this.tbar = [this.addAct, this.editAct, this.deleteAct];

		// --- event ---
		this.buttons = [{
			text: 'Save',
			handler: function() {
				//var rs = _this.grid.getData();
				//_this.grid.hdnItem.setValue(Ext.encode(rs));

				_this.grid.save();
				//_this.grid.load();
			}
		},{
			text: 'Cancel',
			handler: function() {
				//_this.grid.getForm().reset();
				_this.hide();
			}
		}];
		
		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});