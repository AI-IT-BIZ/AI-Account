Ext.define('Account.SVendortype.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Vendor Type List',
			closeAction: 'hide',
			height: 620,
			width: 550,
			layout: 'border',
			resizable: true,
			modal: true,
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.grid = Ext.create('Account.SVendortype.GridItem', {
			region:'center'
		});

		this.items = [this.form, this.grid];

		this.buttons = [{
			text: 'Cancel',
			handler: function() {
				//_this.form.getForm().reset();
				_this.hide();
			}
		}];

		// --- after ---
		this.grid.load();
		return this.callParent(arguments);
	}
});