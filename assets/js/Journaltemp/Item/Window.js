Ext.define('Account.Journaltemp.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Journal Template',
			closeAction: 'hide',
			height: 450,
			width: 910,
			layout: 'border',
			border: false,
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Journaltemp.Item.Form',{ region:'center' });

		this.items = [
		     this.form
		   ];

		this.buttons = [{
			text: 'Save',
			disabled: !(UMS.CAN.CREATE('JT') || UMS.CAN.EDIT('JT')),
			handler: function() {
				//var rs = _this.grid1.getData();
				//_this.form.hdnIvItem.setValue(Ext.encode(rs));
				
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
			this.form.gridItem.load({tranr: id});
			//this.form.gridPayment.load({vbeln: id});

			//this.btnPreview.setDisabled(false);
		}else{
			this.dialogId = null;
			this.form.reset();
			this.show(false);

			//this.btnPreview.setDisabled(true);
		}
	}
});