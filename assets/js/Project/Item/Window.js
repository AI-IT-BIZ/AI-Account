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

		this.form = Ext.create('Account.Project.Item.Form', {
			region:'center'
		});

		this.items = [
			this.form
		];

		this.btnSave = Ext.create('Ext.Button', {
			text: 'Save',
			disabled: !(UMS.CAN.CREATE('PJ') || UMS.CAN.EDIT('PJ')||UMS.CAN.APPROVE('PJ')),
			handler: function() {
				_this.form.save();
			}
		});

		this.btnReset = Ext.create('Ext.Button', {
			text: 'New',
			disabled: !(UMS.CAN.CREATE('PJ') || UMS.CAN.EDIT('PJ')||UMS.CAN.APPROVE('PJ')),
			handler: function() {
				_this.form.reset();
			}
		});

		this.buttons = [this.btnSave, this.btnReset, {
			text: 'Close',
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
	},
	setReadOnly: function(readOnly){
		var children = this.items ? this.items.items : [];
		for(var i=0;i<children.length;i++){
			var child = children[i];
			child.query('.field').forEach(function(c){c.setReadOnly(readOnly);});
			child.query('.button').forEach(function(c){
				if(c.xtype!='tab')
					c.setDisabled(readOnly);
			});
		}
		// ตามแต่ละ window

		if(!this.btnSave.initialConfig.disabled)
			this.btnSave.setDisabled(readOnly);
			
		this.btnReset.setDisabled(readOnly);
	}
});