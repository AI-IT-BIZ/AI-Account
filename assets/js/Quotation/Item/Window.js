Ext.define('Account.Quotation.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Quotation',
			closeAction: 'hide',
			height: 700,
			width: 900,
			layout: 'border',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form1 = Ext.create('Account.Quotation.Item.Form',{ region:'north' });
        this.grid1 = Ext.create('Account.Quotation.Item.Grid_p',{ region:'center' });
        this.grid2 = Ext.create('Account.Quotation.Item.Grid_i',{ region:'south' });

		this.items = [
			this.form1,
			this.grid1,
			this.grid2
		];
		
          /*this.grid = new Ext.Panel({
			title:'this is item grid',
			html:'item grid',
			region: 'center'
		});*/

		this.buttons = [{
			text: 'Save',
			handler: function() {
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
	}
});