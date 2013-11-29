Ext.define('Account.GR.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Goods Receipt',
			closeAction: 'hide',
			height: 650,
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

		this.form = Ext.create('Account.GR.Item.Form',{ region:'center' });

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
				_this.hide();
			}
		}, {
			text: 'Preview',
			handler: function() {
				window.open("index.php/form/gr");
			}
		}];
		return this.callParent(arguments);
	}
});