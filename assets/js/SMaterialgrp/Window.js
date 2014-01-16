Ext.define('Account.SMaterialgrp.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Material Group List',
			closeAction: 'hide',
			height: 420,
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
		
		this.grid = Ext.create('Account.SMaterialgrp.GridItem', {
			region:'center'
		});

		this.items = [this.grid];

		this.buttons = [/*{
			text: 'Save',
			handler: function() {
				//var rs = _this.grid.getData();
				//_this.grid.hdnItem.setValue(Ext.encode(rs));

				_this.grid.save();
				//_this.grid.load();
			}
		},*/{
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