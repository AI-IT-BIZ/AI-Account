Ext.define('Account.Quotation.Item.Window', {
	extend	: 'Ext.window.Window',
	requires : ['Account.Quotation.Item.Form',
	            'Account.Quotation.Item.Form_t',
	            'Account.Quotation.Item.Grid_i',
	            'Account.Quotation.Item.Grid_p'
	           ],
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

		this.form = Ext.create('Account.Quotation.Item.Form',{ region:'north' });
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
		     this.form,
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
				var rs = _this.grid1.getData();
				_this.form1.hdnQtItem.setValue(Ext.encode(rs));

				_this.form1.save();
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

				sum += (qty * price) - discount;
			});
			_this.formTotal.getForm().findField('beamt').setValue(Ext.util.Format.usMoney(sum).replace(/\$/, ''));
			_this.formTotal.calculate();
		});

		return this.callParent(arguments);
	}
});