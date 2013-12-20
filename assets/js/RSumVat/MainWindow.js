Ext.define('Account.RSumVat.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Sale Vat Report Selection',
			closeAction: 'hide',
			height: 150,
			width: 350,
			layout: 'border',
			//layout: 'accordion',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		//this.itemDialog = Ext.create('Account.RReceiptVat.Item.Window');

		this.form = Ext.create('Account.RSumVat.Form',{ region:'center' });

		this.previewDialog = Ext.create('Account.RSumVat.PreviewWindow');
        this.previewDialog2 = Ext.create('Account.RSumVat.PreviewWindow2');
        this.previewDialog3 = Ext.create('Account.RSumVat.PreviewWindow3');
        
		this.items = [
		     this.form
		];
		
		this.btnPreview = Ext.create('Ext.Button', {
			text: 'Sale&Purchase Vat Preview',
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog.openDialog(form_basic.getValues());
				}
			}
		});
		
		this.btnPreview2 = Ext.create('Ext.Button', {
			text: 'Sale Preview',
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog.openDialog(form_basic.getValues());
				}
			}
		});
		
		this.btnPreview3 = Ext.create('Ext.Button', {
			text: 'Purchase Preview',
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog.openDialog(form_basic.getValues());
				}
			}
		});

		this.buttons = [this.btnPreview2,
		this.btnPreview3,this.btnPreview, {
			text: 'Cancel',
			handler: function() {
				//_this.form.getForm().reset();
				_this.hide();
			}
		}];
		
		// set handler for item grid store
		//this.itemDialog.grid.store.on('beforeload', function(store){
		//	var formValues = _this.form.getForm().getValues();
		//	store.getProxy().extraParams = formValues;
		//});

		return this.callParent(arguments);
	}
});