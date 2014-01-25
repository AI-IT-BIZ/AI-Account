Ext.define('Account.RAssetRegister.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Asset Register Selection',
			closeAction: 'hide',
			height: 150,
			width: 500,
			layout: 'border',
			//layout: 'accordion',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.itemDialog = Ext.create('Account.RAssetRegister.Item.Window');

		this.form = Ext.create('Account.RAssetRegister.Form',{ region:'center' });

		this.items = [
		     this.form
				];

		this.buttons = [{
			text: 'Report',
			handler: function() {

			    _this.itemDialog.show();
			    _this.itemDialog.grid.load();
			}
		}, {
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.hide();
			}
		}];
		
		// set handler for item grid store
		this.itemDialog.grid.store.on('beforeload', function(store){
			var formValues = _this.form.getForm().getValues();
			store.getProxy().extraParams = formValues;
		});
		return this.callParent(arguments);
	}
});