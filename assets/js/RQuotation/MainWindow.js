Ext.define('Account.RQuotation.MainWindow', {
	extend	: 'Ext.window.Window',
	//requires : ['Account.Quotation.Item.Form',
	//            'Account.Quotation.Item.Form_t',
	//            'Account.Quotation.Item.Grid_i',
	//            'Account.Quotation.Item.Grid_p'
	//           ],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Quotation Selection',
			closeAction: 'hide',
			height: 250,
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
		
		this.itemDialog = Ext.create('Account.RQuotation.Item.Window');

		this.form = Ext.create('Account.RQuotation.Form',{ region:'center' });

		this.items = [
		     this.form
				];

		this.buttons = [{
			text: 'Report',
			handler: function() {
				//var rs = _this.grid1.getData();
				//_this.form.hdnQtItem.setValue(Ext.encode(rs));

				//_this.itemDialog.form.getForm().reset();
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