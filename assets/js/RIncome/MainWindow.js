Ext.define('Account.RIncome.MainWindow', {
	extend	: 'Ext.window.Window',
	title: 'Report Income Statement',
	closeAction: 'hide',
	width: 320,
	height: 150,
	resizable: false,
	modal: true,
	layout:'fit',
	maximizable: false,
	initComponent:function(config) {
		var _this = this;
		this.previewDialog = Ext.create('Account.RIncome.Item.PreviewWindow');
		

//============Combobox===============
var years = [],
nowYear = parseInt(Ext.Date.format(new Date(), 'Y'));
for(var i=nowYear;i>=nowYear-2;i--){
	years.push([i, i]);
}
			
		var form =  Ext.create('Ext.form.Panel', {
			layout: 'form',
			bodyPadding: '15 15 15 15',
			fieldDefaults: {
				labelWidth: 50
			},
			frame: true,
			items: [{
				xtype: 'combo',
				fieldLabel: 'Period',
				name: 'year',
				editable: false,
				allowBlank: false,
				triggerAction: 'all',
				clearFilterOnReset: true,
				emptyText: 'Please select',
				field: ['value','year'],
				store: years,
				valueField: 'value',
				displayField: 'text'
			}],
			buttons: [{
				text: 'ยืนยัน',
				handler: function(){
					/*
					start_date = form.form.findField('start_date').getValue();
					start_date = Ext.Date.format(start_date,'Y-m-d');
					end_date = form.form.findField('end_date').getValue();
					end_date = Ext.Date.format(end_date,'Y-m-d');
					*/
					start_date1 = form.form.findField('year').getValue()+"-01-01";
					end_date1 = form.form.findField('year').getValue()+"-12-31";
					start_date2 = parseInt(form.form.findField('year').getValue())-1+"-01-01";
					end_date2 = parseInt(form.form.findField('year').getValue())-1+"-12-31";
					params = "start_date1="+start_date1+"&end_date1="+end_date1+"&start_date2="+start_date2+"&end_date2="+end_date2;
					_this.previewDialog.openDialog(__base_url + 'index.php/rincome/pdf?'+params,'_blank');
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
		this.callParent(arguments);
	}
});