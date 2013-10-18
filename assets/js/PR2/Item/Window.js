Ext.define('Account.PR2.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Purchase Request',
			closeAction: 'hide',
			height: 600,
			width: 880,
			layout: 'border',
			border: false,
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.PR2.Item.Form',{ region:'center' });

		this.items = [
		     this.form
		];

		this.buttons = [{
			text: 'Save',
			handler: function() {
				_this.form.save();
			}
		}, {
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				// สั่ง grid load เพื่อเคลียร์ค่า
				_this.form.gridItem.load({ purnr: 0 });
				_this.hide();
			}
		}];
		return this.callParent(arguments);
	}
});