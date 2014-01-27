Ext.define('Account.RTrialBalance.MainWindow', {
	extend	: 'Ext.window.Window',
	title: 'Report Trial Balance',
	closeAction: 'hide',
	width: 320,
	height: 220,
	resizable: false,
	modal: true,
	layout:'fit',
	maximizable: false,
	initComponent:function(config) {
		var _this = this;
		this.previewDialog = Ext.create('Account.RTrialBalance.Item.PreviewWindow');
		var form =  Ext.create('Ext.form.Panel', {
			layout: 'form',
			bodyPadding: '15 15 15 15',
			fieldDefaults: {
				labelWidth: 50
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
			}],
			buttons: [{
				text: 'PDF',
				handler: function(){
					start_date = form.form.findField('start_date').getValue();
					start_date = Ext.Date.format(start_date,'Y-m-d');
					end_date = form.form.findField('end_date').getValue();
					end_date = Ext.Date.format(end_date,'Y-m-d');
					params = "start_date="+start_date+"&end_date="+end_date;
					_this.previewDialog.openDialog(__base_url + 'index.php/rtrialbalance/pdf?'+params,'_blank');
					//window.open(__base_url + 'index.php/rtrialbalance/pdf?'+params,'_blank');
				}
			},{
				text: 'EXCEL',
				handler: function(){
					start_date = form.form.findField('start_date').getValue();
					start_date = Ext.Date.format(start_date,'Y-m-d');
					end_date = form.form.findField('end_date').getValue();
					end_date = Ext.Date.format(end_date,'Y-m-d');
					params = "start_date="+start_date+"&end_date="+end_date;
					window.location = __base_url + 'index.php/rtrialbalance/excel?'+params;
				}
			},{
				text: 'CANCEL',
				handler: function(){
					form = this.up('form').getForm();
					form.reset();
				}	
			}]
		});
		this.items = [form];
		this.callParent(arguments);
	}
});