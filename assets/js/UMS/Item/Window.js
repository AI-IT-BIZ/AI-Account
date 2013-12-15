Ext.define('Account.UMS.Item.Window', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit User',
			closeAction: 'hide',
			height: 580,
			width: 1050,
			layout: 'border',
			border: false,
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.UMS.Item.Form',{ region:'center' });

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
		}];

		return this.callParent(arguments);
	},
	dialogId: null,
	openDialog: function(id){
		if(id){
			this.dialogId = id;
			this.show(false);

			this.show();
			this.form.load(id);

			// สั่ง grid permission load
			this.form.grid.load({
				uname: id
			});
		}else{
			this.dialogId = null;
			this.form.reset();
			this.show(false);

			// สั่ง grid permission load
			this.form.grid.load({
				uname: '-1'
			});
		}
	}
});