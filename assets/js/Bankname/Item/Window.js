Ext.define('Account.Bankname.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Bank Name',
			closeAction: 'hide',
			height: 140,
			width: 510,
			layout: 'border',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Bankname.Item.Form');//, { region:'north' });

		this.items =
			this.form;

		return this.callParent(arguments);
	},
	dialogId: null,
	openDialog: function(id){
		if(id){
			this.dialogId = id;
			this.show(false);

			this.show();
			this.form.load(id);
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

	}
});