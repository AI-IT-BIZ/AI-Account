Ext.define('Account.UMSLimit.Item.DocForm', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'umslimit/save_document',
			border: true,
			bodyPadding: '15 5 0 5',
			defaults: {
				labelAlign: 'right',
				msgTarget: 'qtip',
				labelWidth: 145,
				width: 250
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.items = [{
			xtype:'combo',
			fieldLabel:'Depend on department',
			name : 'depdp',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: 'Please select',
	        fields: [ 'value', 'text' ],
			store:[
				['1', 'Yes'],
				['0', 'No']
			],
			valueField: 'value',
			displayField: 'text'
		}];

		return this.callParent(arguments);
	},
	form_params: null,
	load : function(prms){
		var _this=this;

		this.form_params = prms;

		this.getForm().load({
			waitMsg: 'Loading, please wait...',
			params: _this.form_params,
			url:__site_url+'umslimit/load_document',
			success: function(form, act){
				_this.fireEvent('afterLoad', form, act);
			}
		});
	},
	save : function(){
		var _this=this;
		var _form_basic = this.getForm();

		if (_form_basic.isValid()) {
			_form_basic.submit({
				clientValidation: true,
				waitMsg: 'Saving, please wait...',
				params: this.form_params,
				success: function(form_basic, action) {
					form_basic.reset();
					_this.fireEvent('afterSave', _this, action);
				},
				failure: function(form_basic, action) {
					Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
				}
			});
		}
	},
	reset: function(){
		this.getForm().reset();
	}
});