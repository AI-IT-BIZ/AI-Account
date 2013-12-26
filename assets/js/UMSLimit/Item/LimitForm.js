Ext.define('Account.UMSLimit.Item.LimitForm', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'umslimit/save_limit',
			border: true,
			bodyPadding: '15 5 0 5',
			defaults: {
				labelAlign: 'right',
				msgTarget: 'qtip',
				labelWidth: 95,
				width: 280
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.items = [{
			xtype: 'numberfield',
			fieldLabel: 'Limit amount',
			name: 'limam',
			allowBlank: false,
			allowDecimals: true,
			minValue:0
		}];

		// event

		return this.callParent(arguments);
	},
	form_params: null,
	load : function(prms){
		var _this=this;

		this.form_params = prms;

		this.getForm().load({
			params: _this.form_params,
			url:__site_url+'ums/load',
			success: function(form, act){
				_this.fireEvent('afterLoad', form, act);
			}
		});

		// สั่ง grid permission load
		this.grid.load({
			uname: id
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
	remove : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'quotation/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	reset: function(){
		this.getForm().reset();
	}
});