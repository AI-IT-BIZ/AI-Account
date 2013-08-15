Ext.define('Account.Invoice.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Invoice',
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

		this.form = Ext.create('Account.Invoice.Item.Form',{ region:'north' });
        this.grid = Ext.create('Account.Invoice.Item.Grid_i',{ 
        	//title:'Invoice Items'
        	height: 320,
        	region:'center'
        	});
        this.grid2 = Ext.create('Account.Invoice.Item.Grid_gl',{ 
        	//border: false,
        	region:'south'
        	});
       this.formTotal = Ext.create('Account.Invoice.Item.Form_t', {
			border: false,
			title:'Total Invoice',
			split: true//,
			//region:'south'
		});

		this.items = [
		     this.form, 
		     this.grid,
		  {
			xtype:'tabpanel',
			region:'south',
			activeTab: 0,
			items: [
				this.formTotal,
				{
				xtype: 'panel',
				border: false,
				title: 'GL Posting',
				layout: 'border',
				items:[
					this.grid2,
					
				]
			  }]
			}];
		
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