Ext.define('Account.PR.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Purchase Requisition',
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

		this.form = Ext.create('Account.PR.Item.Form',{ region:'center' });

		this.previewDialog = Ext.create('Account.PR.Item.PreviewWindow');

		this.items = [
		     this.form
		];

		this.btnPreview = Ext.create('Ext.Button', {
			text: 'Preview',
			handler: function() {
				_this.previewDialog.openDialog(_this.dialogId);
			}
		});

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
		},
		this.btnPreview];

		return this.callParent(arguments);
	},
	dialogId: null,
	openDialog: function(id){
		if(id){
			this.dialogId = id;
			this.show(false);
			this.form.load(id);
			this.form.gridItem.load({purnr: id});

			this.btnPreview.setDisabled(false);
		}else{
			this.dialogId = null;
			this.form.reset();
			this.show(false);

			this.btnPreview.setDisabled(true);
		}
	}
});