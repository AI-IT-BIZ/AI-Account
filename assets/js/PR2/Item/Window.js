Ext.define('Account.PR2.Item.Window', {
	extend	: 'Ext.window.Window',
	requires : ['Account.PR2.Item.Form'],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Purchase Request',
			closeAction: 'hide',
			height: 600,
			width: 900,
			layout: 'border',
			resizable: true,
			modal: true,
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.PR2.Item.Form', {
			region:'north',
			split:true,
			border:true,
			height:'120'
		});
		this.grid = Ext.create('Account.PR2.Item.GridItem', {
			region:'center'
		});
		this.form2 = Ext.create('Account.PR2.Item.Form_t', {
			region:'south'
		});

		//this.items = [this.form, this.grid, this.grid2];
		this.items = [this.form, this.grid, this.form2];

		this.buttons = [{
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.form2.getForm().reset();
				_this.hide();
			}
		}, {
			text: 'Save',
			handler: function() {
				var rs = _this.grid.getData();
				_this.form.hdnPrItem.setValue(Ext.encode(rs));

				_this.form.save();
				
				_this.form2.save();
			}
		}];

		return this.callParent(arguments);
	}
});