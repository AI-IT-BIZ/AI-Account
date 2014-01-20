Ext.define('Account.SUnit.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Unit List',
			closeAction: 'hide',
			height: 620,
			width: 450,
			layout: 'border',
			resizable: true,
			modal: true,
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.grid = Ext.create('Account.SUnit.GridItem', {
			region:'center'
		});

		this.items = [this.grid];

		this.buttons = [{
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