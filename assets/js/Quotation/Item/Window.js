Ext.define('Account.Quotation.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Quotation',
			//closeAction: 'hide',
			height: 650,
			width: 950,
			layout: 'border',
			//layout: 'accordion',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form1 = Ext.create('Account.Quotation.Item.Form',{ region:'north' });
        this.grid1 = Ext.create('Account.Quotation.Item.Grid_i',{ 
        	title:'Project Items'
        	});
        this.grid2 = Ext.create('Account.Quotation.Item.Grid_p',{ 
        	border: false,
        	region:'center' 
        	});
       this.formTotal = Ext.create('Account.Quotation.Item.Form_t', {
			border: false,
			split: true,
			region:'south'
		});

		this.items = [
		     this.form1, 
		   {
			xtype:'tabpanel',
			region:'center',
			activeTab: 0,
			items: [
				this.grid1,
				{
				xtype: 'panel',
				border: false,
				title: 'Payment Periods',
				layout: 'border',
				items:[
					this.grid2//,
					
				]
			  }]
			},this.formTotal];
		
          /*this.grid = new Ext.Panel({
			title:'this is item grid',
			html:'item grid',
			region: 'center'
		});*/

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
	}
});