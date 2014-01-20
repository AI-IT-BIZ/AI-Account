Ext.define('Account.Materialgrp.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Material Group',
			closeAction: 'hide',
			height: 650,
			width: 600,
			layout: 'border',
			resizable: true,
			modal: true,
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.grid = Ext.create('Account.Materialgrp.GridItem', {
			region:'center'
		});

		this.items = [this.grid];

		this.buttons = [{
			text: 'Save',
			handler: function() {
				Ext.Msg.show({
					title : "Warning",
					msg : "Are you sure you want to update item(s) ?",
					icon : Ext.Msg.WARNING,
					buttons : Ext.Msg.YESNO,
					fn : function(bt) {
						if (bt == "yes") {
							_this.grid.save();
							//_this.grid.load();
						}
					}
				});
			}
		},{
			text: 'Cancel',
			handler: function() {
				//_this.grid.getForm().reset();
				_this.hide();
			}
		}];

		// --- after ---
		this.grid.load();
		return this.callParent(arguments);
	}
});