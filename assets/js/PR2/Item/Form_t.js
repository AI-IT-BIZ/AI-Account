Ext.define('Account.PR2.Item.Form_t', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'quotation/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',
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
			labelWidth: 150,
			width:240,
			readOnly: true
		});
		this.txtDiscount = Ext.create('Ext.form.field.Text', {
			fieldLabel: 'Discount',
			name: 'dismt',
			labelWidth: 80,
			width:150,
			align: 'right',
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
			name: 'aaa',
			align: 'right',
			width:85,
			margin: '0 0 0 5',
			readOnly: true
         });
		this.txtDiscountSum = Ext.create('Ext.form.field.Text', {
			fieldLabel: 'After Discount',
			name: 'bbb',
			align: 'right',
			labelWidth: 150,
			width:240,
			readOnly: true
		});
		this.txtTaxValue = Ext.create('Ext.ux.form.NumericField', {
            xtype: 'textfield',
            fieldLabel: 'Vat Total',
			name: 'vat01',
			align: 'right',
			alwaysDisplayDecimals: true,
			width:240,
			labelWidth: 150,
			readOnly: true
         });
		this.txtNet = Ext.create('Ext.ux.form.NumericField', {
         	xtype: 'textfield',
			fieldLabel: 'Net Amount',
			name: 'netwr',
			align: 'right',
			labelWidth: 150,
			width:240,
			alwaysDisplayDecimals: true,
			style: 'font-weight:bold',
			labelStyle: 'font-weight:bold',
			readOnly: true
		});

		this.items = [{
            xtype: 'container',
            layout: 'hbox',
            margin: '5',
            defaultType: 'textfield',
            
            items:[{
                xtype: 'container',
                flex: 0,
                layout: 'anchor',
            	margin: '0 0 0 0',
                items: [{
					xtype: 'textarea',
					fieldLabel: 'Text Note',
					name: 'sgtxt',
					width: 455, 
					rows:3,
					allowBlank: true
                }]
            },{
                xtype: 'container',
                flex: 0,
                layout: 'anchor',
            	margin: '0 0 0 70',
                items: [{
		            xtype: 'container',
		            layout: 'hbox',
            		margin: '0 0 5 0',
                	items: [this.txtTotal,{
                	}]
                },{
		            xtype: 'container',
		            layout: 'hbox',
            		margin: '0 0 5 0',
                	items: [this.txtDiscount,this.txtDiscountValue]
             	},{
		            xtype: 'container',
		            layout: 'hbox',
            		margin: '0 0 5 0',
                	items: [this.txtDiscountSum,{
                	}]
             	},{
		            xtype: 'container',
		            layout: 'hbox',
            		margin: '0 0 5 0',
                	items: [
						this.txtTaxValue ,{
                	}]
             	},{
		            xtype: 'container',
		            layout: 'hbox',
            		margin: '0 0 5 0',
                	items: [this.txtNet,{
                	}]
                }]
		
			},
		]},
	];

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
		//this.txtTax.on('keyup', this.calculate, this);

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'pr2/load'
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

	// calculate function
	calculate: function(){
		var total = this.txtTotal.getValue();//.replace(',',''),
			total = parseFloat(total);
			total = isNaN(total)?0:total;

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

		var vat = this.txtTaxValue.getValue();

		var net = (total - discountValue) + vat;
		this.txtNet.setValue(net);
	}
});