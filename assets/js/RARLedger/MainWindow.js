Ext.define('Account.RARLedger.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'ARLedger Selection',
			closeAction: 'hide',
			height: 220,
			width: 550,
			layout: 'border',
			//layout: 'accordion',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		

		this.form = Ext.create('Account.RARLedger.Form',{ region:'center' });

		this.items = [
		     this.form
				];

		this.buttons = [{
			text: 'Report',
			handler: function() {
			    start_date = this.form.form.findField('year').getValue();
			    end_date = this.params.end_date;
			    show(start_date);
			}
		}, {
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.hide();
			}
		}];
	

		return this.callParent(arguments);
	}
});