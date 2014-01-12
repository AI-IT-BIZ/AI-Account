Ext.define('Account.Project.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Project',
			closeAction: 'hide',
			height: 450,
			width: 600,
			layout: 'border',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Project.Item.Form');

		this.items = [
			this.form
		];

		this.buttons = [{
			enabled: !UMS.CAN.EDIT('PJ'),
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

			// สั่ง pr_item grid load
			//this.form.gridItem.load({jobnr: id});

			//this.btnPreview.setDisabled(false);
		}else{
			this.dialogId = null;
			this.form.reset();
			this.show(false);

			//this.btnPreview.setDisabled(true);
		}
	}
});