Ext.define('Account.PO.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

        /************************************/
		Ext.apply(this, {
			title: 'Create/Edit Purchase Order',
			closeAction: 'hide',
			height: 650,
			width: 880,
			layout: 'border',
			border: false,
			resizable: true,
			modal: true//,
            //tbar:[btnPOPrint]
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.PO.Item.Form',{ region:'center' });
		
		this.previewDialog = Ext.create('Account.PO.Item.PreviewWindow');

		this.items = [
		     this.form
		];
		
		this.btnPreview = Ext.create('Ext.Button', {
			text: 'Preview',
			handler: function() {
				_this.previewDialog.openDialog(_this.dialogId);
			}
		});
		
		this.btnSave = Ext.create('Ext.Button', {
			text: 'Save',
			disabled: !(UMS.CAN.CREATE('PO') || UMS.CAN.EDIT('PO')||UMS.CAN.APPROVE('PO')),
			handler: function() {
				_this.form.save();
			}
		});
        
		this.btnReset = Ext.create('Ext.Button', {
			text: 'New',
			disabled: !(UMS.CAN.CREATE('PO') || UMS.CAN.EDIT('PO')||UMS.CAN.APPROVE('PO')),
			handler: function() {
				_this.form.reset();
			}
		});

		this.buttons = [this.btnSave, this.btnReset,{
			text: 'Close',
			handler: function() {
				_this.form.getForm().reset();
				
				_this.form.gridItem.load({ ebeln: 0 });
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
			this.form.gridItem.load({ebeln: id});

			this.btnPreview.setDisabled(false);
		}else{
			this.dialogId = null;
			this.form.reset();
			this.show(false);

			this.btnPreview.setDisabled(true);
		}
	},
	setReadOnly: function(readOnly){
		var children = this.items ? this.items.items : [];
		for(var i=0;i<children.length;i++){
			var child = children[i];
			child.query('.field').forEach(function(c){
				//console.log(c);
				if(!c.initialConfig.readOnly){
					c.setReadOnly(readOnly);
				}
			});
			child.query('.button').forEach(function(c){
				if(c.xtype!='tab'){
					if(!c.initialConfig.disabled)
						c.setDisabled(readOnly);
				}
			});
		}
		// ตามแต่ละ window
		this.form.gridItem.readOnly = readOnly;

		if(!this.btnSave.initialConfig.disabled)
			this.btnSave.setDisabled(readOnly);
			
			this.btnReset.setDisabled(readOnly);
	}
});