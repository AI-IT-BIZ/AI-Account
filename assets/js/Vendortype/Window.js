Ext.define('Account.Vendortype.Window', {
	extend	: 'Ext.window.Window',
	requires : ['Account.Vendortype.Form'],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Vendor type Request',
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

		this.form = Ext.create('Account.Vendortype.Form', {
			region:'north',
			split:true,
			border:true,
			height:'120'
		});
		this.grid = Ext.create('Account.Vendortype.GridItem', {
			region:'center'
		});

		this.items = [this.form, this.grid];

		this.buttons = [{
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.hide();
			}
		}, {
			text: 'Save',
			handler: function() {
				var rs = _this.grid.getData();
				_this.form.hdnItem.setValue(Ext.encode(rs));

				_this.form.save();
				_this.grid.load();
				_this.hide();
			}
		}];

		// --- after ---
		this.grid.load();
		return this.callParent(arguments);
	}
});