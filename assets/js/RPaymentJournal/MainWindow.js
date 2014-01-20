Ext.define('Account.RPaymentJournal.MainWindow', {
	extend	: 'Ext.window.Window',
	title: 'Report Payment Journal',
	closeAction: 'hide',
	width: 420,
	height: 220,
	resizable: false,
	modal: true,
	layout:'fit',
	maximizable: false,
	initComponent:function(config) {
		var result = Ext.create("Account.RPaymentJournal.Result.Grid");
		var form =  Ext.create('Ext.form.Panel', {
			layout: 'form',
			bodyPadding: '15 15 15 15',
			fieldDefaults: {
				labelWidth: 150
			},
			frame: true,
			items: [{
				xtype: 'datefield',
				fieldLabel: 'เริ่มต้น',
				name: 'start_date',
				format: 'Y-m-d',
				allowBlank: false
			},{
				xtype: 'datefield',
				fieldLabel: 'สิ้นสุด',
				name: 'end_date',
				format: 'Y-m-d',
				allowBlank: false
			},{
				xtype: 'textfield',
				name: 'kunnr',
				fieldLabel: 'Customer / Supplier Code',
			}],
			buttons: [{
				text: 'ยืนยัน',
				handler: function(){
					form = this.up('form').getForm();
					if (form.isValid()){
						result.loadMask.show();
						Ext.Ajax.request({
							url: __base_url + "index.php/rpaymentjournal/result",
							params: form.getValues(),
							success: function(response){
								var rs = response.responseText;
								rs =  Ext.JSON.decode(rs);
								if (rs.success) {

									result.params = form.getValues();
									result.storeGrid.loadData(rs.datas);
									result.show();
									result.loadMask.hide();
								}
							}
						});
					}
				}
			},{
				text: 'ยกเลิก',
				handler: function(){
					form = this.up('form').getForm();
					form.reset();
				}
			}]
		});
		this.items = [form];
		
		return this.callParent(arguments);
	}
});