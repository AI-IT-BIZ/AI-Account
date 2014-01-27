Ext.define('Account.RAPaging.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'AP Aging Selection',
			closeAction: 'hide',
			height: 200,
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
		

		this.form = Ext.create('Account.RAPaging.Form',{ region:'center' });
		this.preview = Ext.create('Account.RAPaging.Item.PreviewWindow');

		this.items = [
		     this.form
				];

		this.buttons = [{
			text: 'PDF',
			handler: function() {
				if(_this.form.getForm().isValid()){
					start_date = _this.form.getForm().findField('start_date').getValue();
			    	start_date = Ext.Date.format(start_date,'Y-m-d');
			    	end_date = _this.form.getForm().findField('end_date').getValue();
			    	end_date = Ext.Date.format(end_date,'Y-m-d'); 
			    	lifnr = _this.form.getForm().findField('lifnr').getValue();
			    	lifnr2 = _this.form.getForm().findField('lifnr2').getValue();
			    	params = params = "start_date="+start_date+"&end_date="+end_date+"&lifnr="+lifnr+"&lifnr2="+lifnr2;
			    	_this.preview.openDialog(__base_url + 'index.php/rapaging/pdf?'+params,'_blank');
			   }
			}
		},{
			text: 'EXCEL',
			handler: function() {
				if(_this.form.getForm().isValid()){
					start_date = _this.form.getForm().findField('start_date').getValue();
			    	start_date = Ext.Date.format(start_date,'Y-m-d');
			    	end_date = _this.form.getForm().findField('end_date').getValue();
			    	end_date = Ext.Date.format(end_date,'Y-m-d'); 
			    	lifnr = _this.form.getForm().findField('lifnr').getValue();
			    	lifnr2 = _this.form.getForm().findField('lifnr2').getValue();
			    	params = params = "start_date="+start_date+"&end_date="+end_date+"&lifnr="+lifnr+"&lifnr2="+lifnr2;
			    	_this.preview.openDialog(__base_url + 'index.php/rapaging/excel?'+params,'_blank');
			   }
			}
		},{
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.hide();
			}
		}];
	

		return this.callParent(arguments);
	}
});