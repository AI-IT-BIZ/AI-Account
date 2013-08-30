Ext.define('Account.Invoice.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Invoice',
			closeAction: 'hide',
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
        this.grid1 = Ext.create('Account.Invoice.Item.Grid_i',{ 
        	//title:'Invoice Items'
        	height: 320,
        	region:'center'
        	});
        this.grid2 = Ext.create('Account.Invoice.Item.Grid_gl',{ 
        	border: false,
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
		     this.grid1,
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
				var rs = _this.grid1.getData();
				_this.form.hdnIvItem.setValue(Ext.encode(rs));
				
				_this.form.save();
			}
		}, {
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.hide();
			}
		}];
		
		// event
		this.grid1.store.on('update', function(store, record){
			var sum = 0;
			store.each(function(r){
				var qty = parseFloat(r.data['menge']),
					price = parseFloat(r.data['unitp']),
					discount = parseFloat(r.data['dismt']);
				qty = isNaN(qty)?0:qty;
				price = isNaN(price)?0:price;
				discount = isNaN(discount)?0:discount;

				var amt = (qty * price) - discount;

				sum += amt;
			});
			_this.formTotal.getForm().findField('beamt').setValue(Ext.util.Format.usMoney(sum).replace(/\$/, ''));
			_this.formTotal.calculate();
		});

		return this.callParent(arguments);
	}
});