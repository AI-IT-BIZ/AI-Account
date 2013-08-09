Ext.define('Account.Customer.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'customer2/save',
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
		/*District Combo*/
		this.comboMType = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Choose District',
			hiddenName : 'distr',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select district --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'district/loads_combo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'distr'
					}
				},
				fields: [
					'distr',
					'distx'
				],
				remoteSort: true,
				sorters: 'distr ASC'
			}),
			queryMode: 'remote',
			displayField: 'distx',
			valueField: 'distr'
		});

		/*id hid*/
		this.items = [{
			xtype: 'hidden',
			name: 'id'
		},{
		/*CustomerCode text*/	
			xtype: 'textfield',
			fieldLabel: 'Code',
			name: 'kunnr',
			allowBlank: false
		},{
		/*CustomerName text*/	
			xtype: 'textfield',
			fieldLabel: 'Name',
			name: 'name1',
			allowBlank: false
		},{
		/*CustomerAddr text*/	
			xtype: 'textarea',
			fieldLabel: 'Address',
			name: 'adr01',
			allowBlank: false
		},{
		/*CustomerTel text*/	
			xtype: 'textfield',
			fieldLabel: 'Telephone',
			name: 'telf1',
			allowBlank: false
		},{
		/*CustomerFax text*/	
			xtype: 'textfield',
			fieldLabel: 'Fax',
			name: 'telfx',
			allowBlank: true
		},{
		/*CustomerContact text*/	
			xtype: 'textfield',
			fieldLabel: 'Contact Person',
			name: 'pson1',
			anchor:'100%',
			labelWidth: 90,
			allowBlank: true
		}, this.comboMType];
		
		
		
		
		
		
		/*Cancel/Save bt*/
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
			url:__site_url+'customer2/load'
		});
	},
	remove : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'customer2/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});