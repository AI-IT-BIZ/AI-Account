Ext.define('Account.Saleorder.Item.Window', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Create/Edit Sale Order',
			closeAction: 'hide',
			height: 700,
			width: 950,
			layout: 'border',
			border: false,
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Saleorder.Item.Form',{ region:'center' });

		this.items = [
		     this.form
		];

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
		}, {
			text: 'Preview',
			handler: function() {
				window.open("index.php/form/saleorder");
			}
		}];
/*
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
*/
		return this.callParent(arguments);
	}
});