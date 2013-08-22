Ext.define('Account.Saleperson.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Sale Person',
			closeAction: 'hide',
			height: 430,
			width: 620,
			layout: 'border',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Saleperson.Item.Form');//, { region:'north' });

		/*this.grid = new Ext.Panel({
			title:'this is item grid',
			html:'item grid',
			region: 'center'
		});*/

		this.items = //[
			this.form;
			//this.grid
		//];

		return this.callParent(arguments);
	}
});