Ext.define('Account.Vendortype.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Vendor Type',
			closeAction: 'hide',
			height: 420,
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

		this.grid = Ext.create('Account.Vendortype.GridItem', {
			region:'center'
		});

		this.items = [this.form, this.grid];

		this.buttons = [{
			text: 'Save',
			handler: function() {
				//var rs = _this.grid.getData();
				//_this.form.hdnItem.setValue(Ext.encode(rs));

				//_this.form.save();
				_this.grid.save();
				//_this.hide();
			}
		},{
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