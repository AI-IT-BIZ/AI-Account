Ext.define('Account.Billfrom.Item.Form_t', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'billfrom/save',
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

		this.txtTotal = Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Total',
			name: 'beamt',
			xtype: 'textfield',
		    fieldLabel: 'Total',
			name: 'beamt',
			alwaysDisplayDecimals: true,
			labelWidth: 155,
			width:270,
			readOnly: true
		});
		this.txtDiscount = Ext.create('Ext.form.field.Text', {
			fieldLabel: 'Discount',
			name: 'dispc',
			align: 'right',
			labelWidth: 80,
			width:150,
			enableKeyEvents: true,
			validator: function(v){
				if(!Ext.isEmpty(v)){
					var regEx = /^([0-9]*)(\.[1-9]*)?$|^([0-9]|[1-9][0-9]|100)(\.[1-9]*)?(%)$/gi;
					if(regEx.test(v))
						return true;
					else
						return 'Value can be only numbers or percent';
				}else
					return true;
			}
		});
		this.txtDiscountValue = Ext.create('Ext.form.field.Text', {
			name: 'dismt',
			align: 'right',
			width:110,
			margin: '0 0 0 10',
			readOnly: true
         });
		this.txtDiscountSum = Ext.create('Ext.form.field.Text', {
			fieldLabel: 'After Discount',
			name: 'bbb',
			align: 'right',
			width:270,
			labelWidth: 155,
			margin: '4 0 0 0',
			readOnly: true
		});
		this.txtInterest = Ext.create('Ext.form.field.Text', {
            xtype: 'textfield',
            fieldLabel: 'Interest',
			name: 'ccc',
			align: 'right',
			margin: '4 0 0 0',
			width:270,
			labelWidth: 155,
			readOnly: true

         });
		this.txtNet = Ext.create('Ext.ux.form.NumericField', {
         	xtype: 'textfield',
			fieldLabel: 'Net Amount',
			name: 'netwr',
			align: 'right',
			width:270,
			labelWidth: 155,
			alwaysDisplayDecimals: true,
			margin: '4 0 0 0',
			style: 'font-weight:bold',
			labelStyle: 'font-weight:bold',
			readOnly: true
		});

// Start Write Forms
		this.items = [{
			xtype: 'container',
            layout: 'hbox',
            defaultType: 'textfield',
            //margin: '5 0 5 600',
        items: [{
                xtype: 'container',
                layout: 'anchor',
     items :[{
			xtype: 'container',
            layout: 'hbox',
            //margin: '5 0 5 600',
        items: [{
            xtype: 'displayfield',
			//fieldLabel: 'Exchange Rate',
			//name: 'exchg',
			//labelAlign: 'right',
			width:240,
			align: 'right',
			//margin: '0 0 0 -35'
         },{
   	        xtype: 'displayfield',
			align: 'right',
			margin: '0 0 0 5',
			width:60,
			//value: 'THB/USD'
		}]
		},{
   	        xtype: 'textfield',
   	        fieldLabel: 'Rejected Reason',
			align: 'right',
			margin: '3 0 0 0',
			width:380,
			name: 'reanr1'
		},{
			xtype: 'textarea',
			fieldLabel: 'Text Note',
			//labelAlign: 'right',
			margin: '3 0 0 0',
			rows:2,
			width:380,
			name: 'txz01'//,
			//anchor:'90%'
		}]
            },{
                xtype: 'container',
                layout: 'anchor',
                margins: '0 0 0 200',
        items: [this.txtTotal,{
			xtype: 'container',
            layout: 'hbox',
            //margin: '5 0 5 600',
			items: [this.txtDiscount,this.txtDiscountValue]
		},this.txtDiscountSum,{
			xtype: 'container',
			layout: 'hbox',
			defaultType: 'textfield',
			//margin: '5 0 5 600',
	items: [
		this.txtInterest
	]
	},
	this.txtNet]
		}]
		}];
		
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
		this.txtInterest.on('render', setAlignRight);
		this.txtNet.on('render', setAlignRight);
		this.txtNet.on('render', setBold);

		this.txtDiscount.on('keyup', this.calculate, this);
		//this.txtTax.on('keyup', this.calculate, this);

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'billto/load'
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
			url:__site_url+'billto/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	// calculate function
	calculate: function(){
		var total = this.txtTotal.getValue();//replace(',',''),
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
			this.txtDiscountValue.setValue('0.00');
			this.txtDiscount.setValue('');
			this.txtDiscountSum.setValue(Ext.util.Format.usMoney(total).replace(/\$/, ''));
		}

		var tax = this.txtInterest.getValue(),
			taxValue = 0;
		if(this.txtInterest.isValid() && !Ext.isEmpty(tax)){
			taxValue = parseFloat(tax);
			taxValue = isNaN(taxValue)?0:taxValue;
		}else{
			this.txtInterest.setValue('');
		}

		var net = total - discountValue + taxValue;
		this.txtNet.setValue(net);
		
		return net;
	}
});