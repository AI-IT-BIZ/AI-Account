Ext.define('Account.PR.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'pr/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'right',
				labelWidth: 100,
				width:300,
				labelStyle: 'font-weight:bold'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.hdnPrItem = Ext.create('Ext.form.Hidden', {
			name: 'pr_item'
		});

		this.comboMType = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Choose Material',
			//hiddenName : 'mat',
			name: 'mtart',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select material --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'mattype/loads_combo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'mtart'
					}
				},
				fields: [
					'mtart',
					'matxt'
				],
				remoteSort: true,
				sorters: 'mtart ASC'
			}),
			queryMode: 'remote',
			displayField: 'matxt',
			valueField: 'mtart'
		});

		this.items = [
			this.hdnPrItem,
		{
			xtype: 'hidden',
			name: 'id'
		},{
			xtype: 'textfield',
			fieldLabel: 'Code',
			name: 'code',
			allowBlank: false
		},
		this.comboMType,
		{
			xtype: 'datefield',
			fieldLabel: 'วันที่สร้าง',
			name: 'create_date',
			allowBlank: false,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
		}];

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'pr/load'
		});
	},
	save : function(){
		var _this=this;
		var _form_basic = this.getForm();
		if (_form_basic.isValid()) {
			_form_basic.submit({
				success: function(form_basic, action) {
					form_basic.reset();
					_this.fireEvent('afterSave', _this);
				},
				failure: function(form_basic, action) {
					Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
				}
			});
		}
	},
	remove : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'pr/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});