Ext.define('Account.Initdoc.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Initdoc Type',
			closeAction: 'hide',
			height: 580,
			width: 850,
			layout: 'border',
			resizable: true,
			modal: true,
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.grid = Ext.create('Account.Initdoc.GridItem', {
			region:'center'
		});

		this.items = [this.grid];

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