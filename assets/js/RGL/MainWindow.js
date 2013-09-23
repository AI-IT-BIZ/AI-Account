Ext.define('Account.RGL.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'General Ledger Selection',
			closeAction: 'hide',
			height: 180,
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
		
		this.itemDialog = Ext.create('Account.RGL.Item.Window');

		this.form = Ext.create('Account.RGL.Form',{ region:'center' });

		this.items = [
		     this.form
				];

		this.buttons = [{
			text: 'Report',
			handler: function() {
				//var rs = _this.grid1.getData();
				//_this.form.hdnQtItem.setValue(Ext.encode(rs));

				_this.itemDialog.grid.reset();
			    //_this.itemDialog.formTotal.getForm().reset();
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