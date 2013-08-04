Ext.define('Account.Warehouse.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Warehouse',
			closeAction: 'hide',
			height: 400,
			width: 400,
			layout: 'border',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Warehouse.Item.Form', { region:'north' });

		this.grid = new Ext.Panel({
			title:'this is item grid',
			html:'item grid',
			region: 'center'
		});

		this.items = [
			this.form,
			this.grid
		];

		this.buttons = [{
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.hide();
			}
		}, {
			text: 'Save',
			handler: function() {
				_this.form.save();
			}
		}];

		return this.callParent(arguments);
	}
});