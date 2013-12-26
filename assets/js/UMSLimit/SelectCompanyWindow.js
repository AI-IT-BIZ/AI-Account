Ext.define('Account.UMSLimit.SelectCompanyWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Select company',
			closeAction: 'hide',
			height: 130,
			width: 340,
			layout: 'border',
			border: false,
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.comboCompany = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Company',
			name : 'statu',
			labelAlign: 'right',
			width: 240,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Select Company --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'umslimit/loads_company_combo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'comid'
					}
				},
				fields: [
					'comid',
					'name1'
				]
			}),
			queryMode: 'remote',
			displayField: 'name1',
			valueField: 'comid'
		});

		var form = Ext.create('Ext.form.Panel',{
			region: 'center',
			bodyPadding: '15 5 0 5',
			defaults: {
				labelAlign: 'right',
				msgTarget: 'qtip',
				labelWidth: 95,
				width: 280
			},
			items : [this.comboCompany]
		});

		this.items = form;

		this.buttons = [{
			text: 'Select',
			handler: function() {
				if(form.isValid()){
					var mainWindow = Ext.create('Account.UMSLimit.MainWindow', {
						treeExtraParams: {
							comid: _this.comboCompany.getValue()
						}
					});
					mainWindow.openDialog({
						comid: _this.comboCompany.getValue()
					});
				}
			}
		}];

		return this.callParent(arguments);
	}
});