Ext.define('Account.RSumVat.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Vat Report Selection',
			closeAction: 'hide',
			height: 130,
			width: 450,
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
			text: 'รายงานภาษีมูลค่าเพิ่ม',
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog.openDialog(form_basic.getValues());
				}
			}
		});
		
		this.btnPreview2 = Ext.create('Ext.Button', {
			text: 'รายงานภาษีขาย',
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog2.openDialog(form_basic.getValues());
				}
			}
		});
		
		this.btnPreview3 = Ext.create('Ext.Button', {
			text: 'รายงานภาษีซื้อ',
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog3.openDialog(form_basic.getValues());
				}
			}
		});

		this.buttons = [this.btnPreview2,
		this.btnPreview3,this.btnPreview];
		
		// set handler for item grid store
		//this.itemDialog.grid.store.on('beforeload', function(store){
		//	var formValues = _this.form.getForm().getValues();
		//	store.getProxy().extraParams = formValues;
		//});

		return this.callParent(arguments);
	}
});