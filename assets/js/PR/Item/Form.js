Ext.define('Account.PR.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'pr/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'top',
				labelWidth: 100,
				width:200,
				labelStyle: 'font-weight:bold'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

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

		this.items = [{
			xtype: 'hidden',
			name: 'id'
		},{
			xtype: 'textfield',
			fieldLabel: 'Code',
			name: 'code',
			allowBlank: false
		}, this.comboMType,
		{
			xtype: 'datefield',
			fieldLabel: 'Date',
			name: 'bldat',
			allowBlank: false
		}];

		this.buttons = [{
			text: 'Cancel',
			handler: function() {
				this.up('form').getForm().reset();
				this.up('window').hide();
			}
		}, {
			text: 'Save',
			handler: function() {
				var _form_basic = this.up('form').getForm();
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
			}
		}];

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'pr/load'
		});
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