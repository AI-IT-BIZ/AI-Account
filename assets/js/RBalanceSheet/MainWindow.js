Ext.define('Account.RBalanceSheet.MainWindow', {
	extend	: 'Ext.window.Window',
	title: 'Report Balance Sheet',
	closeAction: 'hide',
	width: 320,
	height: 220,
	resizable: false,
	modal: true,
	layout:'fit',
	maximizable: false,
	initComponent:function(config) {
		
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
				text: 'ยืนยัน',
				handler: function(){
					form = this.up('form').getForm();
					if (form.isValid()){
						rs = form.getValues();
						start_date = rs.start_date;
						end_date = rs.end_date;
						comid = 1000;
						params = "start_date="+start_date+"&end_date="+end_date+"&comid="+comid;
						url = __base_url + 'index.php/rbalancesheet/pdf?'+params;
						
						Ext.create("Ext.window.Window",{
							title: "PDF",
							width: 830,
							height: 600,
							html: "<iframe src='"+url+"' style='width:100%;height:100%'></iframe>"
						}).show();
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
		this.callParent(arguments);
	}
});