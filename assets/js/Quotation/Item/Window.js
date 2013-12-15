Ext.define('Account.Quotation.Item.Window', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Quotation',
			closeAction: 'hide',
			height: 700,
			width: 950,
			layout: 'border',
			border: false,
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Quotation.Item.Form',{ region:'center' });

		this.previewDialog = Ext.create('Account.Quotation.Item.PreviewWindow');

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
			disabled: !(UMS.CAN.CREATE('QT') || UMS.CAN.EDIT('QT')),
			handler: function() {
				_this.form.save();
			}
		}, {
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.hide();
			}
		}, this.btnPreview];

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
			this.form.gridItem.load({vbeln: id});
			this.form.gridPayment.load({vbeln: id});

			this.btnPreview.setDisabled(false);
		}else{
			this.dialogId = null;
			this.form.reset();
			this.show(false);

			this.btnPreview.setDisabled(true);
		}
	}
});