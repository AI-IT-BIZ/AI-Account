Ext.define('Account.UMSLimit.Item.UserForm', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'umslimit/save_user',
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

		this.employeeDialog = Ext.create('Account.UMSLimit.User.Window');

		this.trigEmployee = Ext.create('Ext.form.field.Trigger', {
			name: 'empnr',
			fieldLabel: 'Employee',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false,
			labelAlign: 'right',
			msgTarget: 'qtip',
			labelWidth: 95,
			width: 280
		});

		this.items = [this.trigEmployee/*,{
			xtype:'combo',
			fieldLabel:'Department',
			hiddenName : 'depnr',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select department --',
	        fields: [ 'value', 'text' ],
			store:[
				['SM', 'Sale&Maketing'],
				['PE', 'Purchase'],
				['IT', 'IT'],
				['AC', 'Account'],
				['HR', 'HR']
			],
			valueField: 'value',
			displayField: 'text',
			listeners : {
				specialkey : function(o, e) {
					if (e.getKey() == e.ENTER)
						_this.searchAct.execute();
				}
			}
		}*/];

		// event
		this.trigEmployee.onTriggerClick = function(){
			_this.employeeDialog.show();
		};

		this.employeeDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigEmployee.setValue(record.data.empnr);
			grid.getSelectionModel().deselectAll();
			_this.employeeDialog.hide();
		});

		return this.callParent(arguments);
	},
	form_params: null,
	load : function(prms){
		var _this=this;

		this.form_params = prms;

		this.getForm().load({
			waitMsg: 'Loading, please wait...',
			params: _this.form_params,
			url:__site_url+'umslimit/load_limit',
			success: function(form, act){
				_this.fireEvent('afterLoad', form, act);
			},
			failure: _this.failureAlert
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
				failure: _this.failureAlert
			});
		}
	},
	remove : function(params){
		var _this=this;
		Ext.Msg.show({
			title : "Warning",
			msg : "Do you want to delete item?",
			icon : Ext.Msg.WARNING,
			buttons : Ext.Msg.YESNO,
			fn : function(bt) {
				if (bt == "yes") {
					var url = __site_url+'umslimit/remove_user';
					_this.form.load({
						url : url,
						success : function(form, act) {
							_this.fireEvent('afterDelete', _this, act);
						},
						failure: _this.failureAlert,
						waitMsg : 'Deleting...',
						waitTitle : 'Please wait...',
						params : params
					});
				}
			}
		});
	},
	failureAlert: function(form, action){
		var showError = function(title, msg){
			Ext.Msg.show({
				title : title,
				msg : msg,
				icon : Ext.Msg.ERROR,
				buttons : Ext.Msg.OK
			});
		};
		switch (action.failureType) {
			case Ext.form.action.Action.CLIENT_INVALID:
				showError('Failure', 'Form fields may not be submitted with invalid values');
				break;
			case Ext.form.action.Action.CONNECT_FAILURE:
				showError('Failure', 'Ajax communication failed');
				break;
			case Ext.form.action.Action.SERVER_INVALID:
				showError('Failure', action.response.responseText);
		}
	},
	reset: function(){
		this.getForm().reset();
	}
});