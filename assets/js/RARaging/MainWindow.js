Ext.define('Account.RARaging.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'AR Aging Selection',
			closeAction: 'hide',
			height: 150,
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
		

		this.form = Ext.create('Account.RARaging.Form',{ region:'center' });
		this.preview = Ext.create('Account.RARaging.Item.PreviewWindow');

		this.items = [
		     this.form
				];

		this.buttons = [{
			text: 'Report',
			handler: function() {
				if(_this.form.getForm().isValid()){ 
			    	kunnr = _this.form.getForm().findField('kunnr').getValue();
			    	kunnr2 = _this.form.getForm().findField('kunnr2').getValue();
			    	params = "kunnr="+kunnr+"&kunnr2="+kunnr2;
			    	_this.preview.openDialog(__base_url + 'index.php/raraging/pdf?'+params,'_blank');
			   }
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