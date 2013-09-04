Ext.define('Account.Quotation.Item.Form_t', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'quotation/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',//'side',
				//labelWidth: 125
				//width:300,
				//labelStyle: 'font-weight:bold'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.txtTotal = Ext.create('Ext.form.field.Text', {
			fieldLabel: 'Total',
			name: 'beamt',
			//textAlign: 'right',
			//flex: 2,
			//anchor:'50%',
			//style: {
              // textAlign: 'right'
             //     },
			labelWidth: 155,
			width:270,
			margin: '0 0 0 375',
			readOnly: true
		});
		this.txtDiscount = Ext.create('Ext.form.field.Text', {
			fieldLabel: 'Discount',
			name: 'dismt',
			//anchor:'80%',
			//fieldWidth: 250,
			align: 'right',
			//margin: '0 0 0 650',
			labelWidth: 80,
			width:150,
			enableKeyEvents: true,
			validator: function(v){
				if(!Ext.isEmpty(v)){
					var regEx = /^([0-9]*)(\.[0-9]*)?$|^([1-9]|[1-9][0-9]|100)(\.[0-9]*)?(%)$/gi;
					if(regEx.test(v))
						return true;
					else
						return 'Value can be only numbers or percent';
				}else
					return true;
			}
		});
		this.txtDiscountValue = Ext.create('Ext.form.field.Text', {
			//fieldLabel: 'Discount',
			name: 'aaa',
			align: 'right',
			//anchor:'80%',
			width:110,
			margin: '0 0 0 10',
			readOnly: true
         });
		this.txtDiscountSum = Ext.create('Ext.form.field.Text', {
			fieldLabel: 'After Discount',
			name: 'bbb',
			align: 'right',
			//flex: 2,
			//anchor:'90%',
			width:270,
			labelWidth: 155,
			margin: '0 0 0 600',
			readOnly: true
		});
		this.txtTax = Ext.create('Ext.form.field.Text', {
			xtype: 'numberfield',
			fieldLabel: 'Tax',
			name: 'taxpr',
			align: 'right',
			labelWidth: 80,
			//anchor:'90%',
			width:130,
			enableKeyEvents: true,
			minValue: 0,
			maxValue: 100,
			hideTrigger: true,
			allowDecimals: false,
			allowBlank: true
		});
		this.txtTaxValue = Ext.create('Ext.form.field.Text', {
            xtype: 'textfield',
			//fieldLabel: 'Discount',
			name: 'ccc',
			align: 'right',
			//anchor:'90%',
			margin: '0 0 0 20',
			width:110,
			readOnly: true

         });
		this.txtNet = Ext.create('Ext.form.field.Text', {
         	xtype: 'textfield',
			fieldLabel: 'Net Amount',
			name: 'netwr',
			align: 'right',
			//flex: 2,
			//anchor:'90%',
			width:270,
			labelWidth: 155,
			margin: '0 0 0 600',
			style: 'font-weight:bold',
			labelStyle: 'font-weight:bold',
			readOnly: true
		});

		this.items = [{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    //margin: '5 0 5 600',
   items: [{
            xtype: 'textfield',
			fieldLabel: 'Exchg.Rate',
			name: 'exchg',
			//anchor:'80%',
			labelAlign: 'right',
			width:240,
			align: 'right',
			margin: '0 0 0 -35',
			allowBlank: true
         },{
   	        xtype: 'displayfield',
			//fieldLabel: '%',
			//name: 'taxpr',
			align: 'right',
			//labelWidth: 5,
			//anchor:'90%',
			margin: '0 0 0 5',
			width:15,
			value: 'THB/USD',
			allowBlank: true
		},
		this.txtTotal
		]
		},{
			xtype: 'container',
            layout: 'hbox',
            defaultType: 'textfield',
            margin: '5 0 5 600',
			items: [this.txtDiscount,this.txtDiscountValue]
		},
		this.txtDiscountSum,
		{
			xtype: 'container',
			layout: 'hbox',
			defaultType: 'textfield',
			margin: '5 0 5 600',
	items: [
		this.txtTax
		,{
			xtype: 'displayfield',
			//fieldLabel: '%',
			//name: 'taxpr',
			align: 'right',
			//labelWidth: 5,
			//anchor:'90%',
			width:10,
			value: '%',
			allowBlank: true
		},
		this.txtTaxValue
	]
	},
	this.txtNet];

		// Event /////////
		var setAlignRight = function(o){
			o.inputEl.setStyle('text-align', 'right');
		};
		var setBold = function(o){
			o.inputEl.setStyle('font-weight', 'bold');
		};
		this.txtTotal.on('render', setAlignRight);
		this.txtDiscountValue.on('render', setAlignRight);
		this.txtDiscountSum.on('render', setAlignRight);
		this.txtTaxValue.on('render', setAlignRight);
		this.txtNet.on('render', setAlignRight);
		this.txtNet.on('render', setBold);

		this.txtDiscount.on('keyup', this.calculate, this);
		this.txtTax.on('keyup', this.calculate, this);

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'quotation/load'
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
			url:__site_url+'quotation/remove',
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

		return net;
	}
});