Ext.define('Account.UMS.Login.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			border: false,
			bodyStyle : 'padding:5px 0px 5px 0px;',
			labelWidth : 80,
			waitMsgTarget: true,
			defaults: {
				allowBlank: false,
				labelAlign: 'right',
				width:280
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.items = [{
			xtype: 'textfield',
			fieldLabel : 'Username',
			name : "username",
			emptyText: '',
			listeners : {
				specialkey : function(o, e) {
					if (e.getKey() == e.ENTER)
						_this.submitAct.execute();
				}
			}
		},{
			xtype: 'textfield',
			inputType: 'password',
			fieldLabel : 'Password',
			name : "password",
			emptyText: '',
			listeners : {
				specialkey : function(o, e) {
					if (e.getKey() == e.ENTER)
						_this.submitAct.execute();
				}
			}
		}];

		return this.callParent(arguments);
	},
	submit: function(){
		var _this=this,
			formBasic = this.getForm();
        if (formBasic.isValid()) {
			var progress = Ext.Msg.show({
				msg: 'Processing login, please wait...',
				closable: false,
				draggable: false,
				toFrontOnShow: true,
				progress : true,
				wait:true,
				waitConfig: {
					interval:250,
					animate: true,
					text: 'Loggin in...'
				}
			});
            formBasic.submit({
				clientValidation: true,
				waitMsg: 'Loging in...',
				url: __site_url+'ums/do_login',
				success: function(formBasic, action) {
					_this.fireEvent('login_success', action.result.msg);
					//progress.hide();
				},
				failure: function(formBasic, action) {
					var showError = function(title, msg){
						Ext.Msg.show({
							title: title,
							msg: msg,
							buttons: Ext.Msg.OK,
							icon: Ext.MessageBox.ERROR
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
							showError('Failure', action.result.msg);
					}
				}
            });
        }
	},
	getValues: function(){
		return this.getForm().getValues();
	},
	reset: function(){
		this.getForm().reset();
	}
});