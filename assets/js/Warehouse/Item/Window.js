Ext.define('Account.Warehouse.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Warehouse',
			closeAction: 'hide',
			height: 500,
			width: 400,
			layout: 'border',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Warehouse.Item.Form', {
			region:'north'
		});
/*
		this.grid = new Ext.Panel({
			title:'this is item grid',
			html:'item grid',
			region: 'center'
		});
*/
		this.grid = Ext.create('Account.Warehouse.Grid', {
			title: 'grid 1'
		});
		this.grid2 = Ext.create('Account.Warehouse.Grid', {
			border: false,
			region:'center'
		});
		this.formTotal = Ext.create('Account.Warehouse.Item.Form', {
			border: false,
			split: true,
			region:'south'
		});

		this.items = [this.form, {
			xtype:'tabpanel',
			region:'center',
			activeTab: 0,
			items: [
				this.grid,
				{
					xtype: 'panel',
					border: false,
					title: 'grid2',
					layout: 'border',
					items:[
						this.grid2,
						this.formTotal
					]
				}
			]
		}];

		this.buttons = [{
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.hide();
			}
		}, {
			text: 'Save',
			handler: function() {
				_this.form.save();
			}
		}];

		return this.callParent(arguments);
	}
});