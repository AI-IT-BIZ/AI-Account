Ext.define('Account.UMS.Login.Window', {
	extend	: 'Ext.window.Window',
    //requires : [],
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Login',
			closeAction: 'hide',
			width : 400,
			minWidth : 400,
			height : 280,
			minHeight : 280,
			resizable: true,
			modal: true,
			layout:'border',
			closable: false,
			buttonAlign : 'center'
		});

		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.UMS.Login.Form', {
			region: 'center'
		});

		this.submitAct = new Ext.Action({
			text: 'Login',
			iconCls: 'b-small-key',
			animate: true
		});

		this.buttons = [
			new Ext.button.Button(this.submitAct)
		];

		this.items = [{
			xtype: 'panel',
			region: 'north',
			border: false,
			height: 140,
			html: '<div style="height:120px; background:#f3f3f5 url('+__base_url+'assets/images/icons/bmblogo.jpg) no-repeat center center;"></div>'
		},
		this.form];

		this.submitAct.setHandler(function(){
			_this.form.submit(function(err, result){
				if(err)
					Ext.Msg.alert('Failure', err);
				else
					Ext.Msg.alert('Success', result);
			});
		});

		return this.callParent(arguments);
	}
});
