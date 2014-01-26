Ext.define('Account.RReceipt.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Receipt Selection',
			closeAction: 'hide',
			height: 240,
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
		
		this.itemDialog = Ext.create('Account.RReceipt.Item.Window');

		this.form = Ext.create('Account.RReceipt.Form',{ region:'center' });

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
		
		this.itemDialog.on('export_exel_click', function(dialog){
			var params = _this.form.getValues(),
				sorters = (dialog.grid.store.sorters && dialog.grid.store.sorters.length)?dialog.grid.store.sorters.items[0]:{};
			params = Ext.apply({
			   sort: sorters.property,
			   dir: sorters.direction
			}, params);
			query = Ext.urlEncode(params);
			window.location = __site_url+'export/rreceipt/index?'+query;
		}, this);
		
		// set handler for item grid store
		this.itemDialog.grid.store.on('beforeload', function(store){
			var formValues = _this.form.getForm().getValues();
			store.getProxy().extraParams = formValues;
		});
		return this.callParent(arguments);
	}
});