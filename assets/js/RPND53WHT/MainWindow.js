Ext.define('Account.Rpnd53WHT.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'รายงานภาษีหัก ณ ที่จ่ายนิติบุคคล',
			closeAction: 'hide',
			height: 130,
			width: 560,
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

		this.form = Ext.create('Account.Rpnd53WHT.Form',{ region:'center' });

		this.previewDialog = Ext.create('Account.Rpnd53WHT.PreviewWindow');
        this.previewDialog2 = Ext.create('Account.Rpnd53WHT.PreviewWindow2');
        this.previewDialog3 = Ext.create('Account.Rpnd53WHT.PreviewWindow3');
        this.previewDialog4 = Ext.create('Account.Rpnd53WHT.PreviewWindow4');
        
		this.items = [
		     this.form
		];
		
		this.btnPreview = Ext.create('Ext.Button', {
			text: 'รายงานภาษีหัก ณ ที่จ่าย(ฝั่งซื้อ)',
			disabled: !UMS.CAN.DISPLAY('TR'),
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog.openDialog(form_basic.getValues());
				}
			}
		});
		
		this.btnPreview2 = Ext.create('Ext.Button', {
			text: 'รายงานภาษีหัก ณ ที่จ่าย(ฝั่งขาย)',
			disabled: !UMS.CAN.DISPLAY('TR'),
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog2.openDialog(form_basic.getValues());
				}
			}
		});
		
		this.btnPreview3 = Ext.create('Ext.Button', {
			text: 'ใบแนบ ภ.ง.ด.53',
			disabled: !UMS.CAN.DISPLAY('TF'),
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog3.openDialog(form_basic.getValues());
				}
			}
		});
		
		this.btnPreview4 = Ext.create('Ext.Button', {
			text: 'ฟอร์มนำส่ง ภ.ง.ด.53',
			disabled: !UMS.CAN.DISPLAY('TF'),
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog4.openDialog(form_basic.getValues());
				}
			}
		});

		this.buttons = [this.btnPreview,
		this.btnPreview2,this.btnPreview3,
		this.btnPreview4];
		
		// set handler for item grid store
		//this.itemDialog.grid.store.on('beforeload', function(store){
		//	var formValues = _this.form.getForm().getValues();
		//	store.getProxy().extraParams = formValues;
		//});

		return this.callParent(arguments);
	}
});