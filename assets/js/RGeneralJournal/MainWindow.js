Ext.define('Account.RGeneralJournal.MainWindow', {
	extend	: 'Ext.window.Window',
	title: 'Report General Journal',
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
						Ext.Ajax.request({
							url: __base_url + "index.php/rgeneraljournal/result",
							params: form.getValues(),
							success: function(response){
								var rs = response.responseText;
								rs =  Ext.JSON.decode(rs)
								if (rs.success) {
									var result = Ext.create("Account.RGeneralJournal.Result.Grid");
									result.params = form.getValues();
									result.storeGrid.loadData(rs.datas);
									result.show();
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
		this.callParent(arguments);
	}
});