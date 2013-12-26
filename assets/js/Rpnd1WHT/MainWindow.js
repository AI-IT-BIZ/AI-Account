Ext.define('Account.Rpnd1WHT.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'เลือกเดือนที่ต้องการดู รายงาน ภ.ง.ด. 1',
			closeAction: 'hide',
			height: 130,
			width: 400,
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

		this.form = Ext.create('Account.Rpnd1WHT.Form',{ region:'center' });

		this.previewDialog = Ext.create('Account.Rpnd1WHT.PreviewWindow');
		this.previewDialog2 = Ext.create('Account.Rpnd1WHT.PreviewWindow2');
		this.previewDialog3 = Ext.create('Account.Rpnd1WHT.PreviewWindow3');

		this.items = [
		     this.form
		];
		
		this.btnPreview = Ext.create('Ext.Button', {
			text: 'Report Preview',
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog.openDialog(form_basic.getValues());
				}
			}
		});
		
		this.btnPreview2 = Ext.create('Ext.Button', {
			text: 'Docket Preview',
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog2.openDialog(form_basic.getValues());
				}
			}
		});
		
		this.btnPreview3 = Ext.create('Ext.Button', {
			text: 'Attached Preview',
			handler: function() {
				var form_basic = _this.form.getForm();
				if(form_basic.isValid()){
					_this.previewDialog3.openDialog(form_basic.getValues());
				}
			}
		});

		this.buttons = [this.btnPreview, 
		this.btnPreview2, this.btnPreview3,{
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