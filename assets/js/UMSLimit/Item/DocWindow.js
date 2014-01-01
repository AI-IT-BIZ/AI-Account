Ext.define('Account.UMSLimit.Item.DocWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Document setting',
			closeAction: 'hide',
			height: 130,
			width: 300,
			layout: 'border',
			border: false,
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;


		this.form = Ext.create('Account.UMSLimit.Item.DocForm',{ region:'center' });

		this.items = [ this.form ];

		this.buttons = [{
			text: 'Save',
			handler: function() {
				_this.form.save();
			}
		}, {
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.hide();
			}
		}];

		return this.callParent(arguments);
	},
	openDialog: function(action, params){
		this.form.form_action = action;
		this.form.form_params = params;
		if(action=='edit'){
			this.show(false);

			this.show();
			this.form.load(params);
		}else{
			this.form.reset();
			this.show(false);
		}
	}
});