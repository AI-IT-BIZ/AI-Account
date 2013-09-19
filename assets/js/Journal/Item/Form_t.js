Ext.define('Account.Journal.Item.Form_t', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'journal/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.txtDebit = Ext.create('Ext.form.field.Text', {
			fieldLabel: 'Total Amount',
			name: 'debit',
			labelWidth: 90,
			width:190,
			margin: '0 0 0 290',
			labelStyle: 'font-weight:bold;',
			readOnly: true
		});
		
		this.txtCredit = Ext.create('Ext.form.field.Text', {
			//fieldLabel: 'Total',
			name: 'credi',
			width:100,
			//margin: '0 0 0 20',
			readOnly: true
		});
		
		this.txtNet = Ext.create('Ext.form.field.Text', {
         	xtype: 'textfield',
			fieldLabel: 'Balance Amount',
			name: 'netwr',
			align: 'right',
			width:220,
			labelWidth: 110,
			margin: '0 0 0 10',
			style: 'font-weight:bold',
			labelStyle: 'font-weight:bold;background-color: #f00;',
			readOnly: true
		});

// Start Write Forms
		this.items = [{
			xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.txtDebit,this.txtCredit,
	this.txtNet]
		}];
		
		// Event /////////
		var setAlignRight = function(o){
			o.inputEl.setStyle('text-align', 'right');
		};
		var setBold = function(o){
			o.inputEl.setStyle('font-weight', 'bold');
		};
		var setColor = function(o){
			o.inputEl.setStyle('font-color', 'red');
		};
		this.txtDebit.on('render', setAlignRight);
        this.txtCredit.on('render', setAlignRight);
		this.txtNet.on('render', setAlignRight);

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'journal/load'
		});
	},
	save : function(){
		var _this=this;
		var _form_basic = this.getForm();
		if (_form_basic.isValid()) {
			_form_basic.submit({
				success: function(form_basic, action) {
					form_basic.reset();
					_this.fireEvent('afterSave', _this);
				},
				failure: function(form_basic, action) {
					Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
				}
			});
		}
	},
	remove : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'journal/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	// calculate function
	calculate: function(){
		var total = this.txtTotal.getValue().replace(',',''),
			total = parseFloat(total),
			total = isNaN(total)?0:total;

		//console.log(total);

		if(total<=0) return;

		var discount = this.txtDiscount.getValue(),
			discountValue = 0;
		if(this.txtDiscount.isValid() && !Ext.isEmpty(discount)){
			if(discount.match(/%$/gi)){
				discount = discount.replace('%','');
				var discountPercent = parseFloat(discount);
				discountValue = total * discountPercent / 100;
			}else{
				discountValue = parseFloat(discount);

			}
			discountValue = isNaN(discountValue)?0:discountValue;

			this.txtDiscountValue.setValue(Ext.util.Format.usMoney(discountValue).replace(/\$/, ''));

			if(discountValue>0)
				this.txtDiscountSum.setValue(Ext.util.Format.usMoney(total - discountValue).replace(/\$/, ''));
		}else{
			this.txtDiscountValue.setValue('');
			this.txtDiscountSum.setValue('');
		}

		var tax = this.txtTax.getValue(),
			taxValue = 0;
		if(this.txtTax.isValid() && !Ext.isEmpty(tax)){
			taxValue = parseFloat(tax);
			taxValue = isNaN(taxValue)?0:taxValue;

			if(taxValue>0){
				taxValue = taxValue * total / 100;
				this.txtTaxValue.setValue(Ext.util.Format.usMoney(taxValue).replace(/\$/, ''));
			}
		}else{
			this.txtTaxValue.setValue('');
		}

		var net = total - discountValue + taxValue;
		this.txtNet.setValue(Ext.util.Format.usMoney(net).replace(/\$/, ''));
	}
});