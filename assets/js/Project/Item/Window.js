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

		this.form = Ext.create('Account.Project.Item.Form');//, { region:'north' });

		/*this.grid = new Ext.Panel({
			title:'this is item grid',
			html:'item grid',
			region: 'center'
		});*/

		this.items = //[
			this.form;
			//this.grid
		//];

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