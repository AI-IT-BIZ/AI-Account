Ext.define('Account.Initdoc.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Initdoc Type',
			closeAction: 'hide',
			height: 580,
			width: 850,
			layout: 'border',
			resizable: true,
			modal: true,
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.grid = Ext.create('Account.Initdoc.GridItem', {
			region:'center'
		});

		this.items = [this.grid];

		this.buttons = [{
			text: 'Save',
			disabled: !(UMS.CAN.DISPLAY('ID') || UMS.CAN.CREATE('ID') || UMS.CAN.EDIT('ID')),
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