Ext.define('Account.Vendor.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Vendor',
			closeAction: 'hide',
			height: 600,
			width: 660,
			layout: 'border',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Vendor.Item.Form');//, { region:'north' });

		/*this.grid = new Ext.Panel({
			title:'this is item grid',
			html:'item grid',
			region: 'center'
		});*/

		this.items = //[
			this.form;
			//this.grid
		//];
		
		this.btnSave = Ext.create('Ext.Button', {
			text: 'Save',
			disabled: !(UMS.CAN.CREATE('VD') || UMS.CAN.EDIT('VD')||UMS.CAN.APPROVE('VD')),
			handler: function() {
				_this.form.save();
			}
		});
		
		this.buttons = [this.btnSave, {
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
			//this.form.gridItem.load({ebeln: id});

			//this.btnPreview.setDisabled(false);
		}else{
			this.dialogId = null;
			this.form.reset();
			this.show(false);

			//this.btnPreview.setDisabled(true);
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

		if(!this.btnSave.initialConfig.disabled)
			this.btnSave.setDisabled(readOnly);
	}
});