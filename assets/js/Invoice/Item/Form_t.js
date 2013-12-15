Ext.define('Account.Invoice.Item.Form_t', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'invoice/save',
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
		
		var myStorecomboWHTno = Ext.create('Ext.data.Store', {
    fields: ['idWHT', 'name'],
    data : [
        {"idWHT":"01", "name":"นิติบุคคล"},
        {"idWHT":"02", "name":"บุคคลธรรมดา"}
        //...
    ]
});
    
    this.comboWHType = Ext.create('Ext.form.ComboBox', {
    fieldLabel: 'Witholding Tax',
	name: 'whtyp',
	width:240,
	triggerAction : 'all',
	clearFilterOnReset: true,
	emptyText: '--Select WHT Typ--',
	//labelStyle: 'font-weight:normal; color: #000; font-style: normal; padding-left:55px;',	
    margin: '4 0 0 0',
    store: myStorecomboWHTno,
    labelAlign: 'left',
    queryMode: 'local',
    displayField: 'name',
    valueField: 'idWHT'
    });

		this.comboWHTno = Ext.create('Ext.form.ComboBox', {			
			//fieldLabel: 'Witholding Type',
			name: 'whtnr',
			//labelAlign: 'right',
			margin: '4 0 0 10',
			width:80,
			editable: false,
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '--WHT No--',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'invoice/loads_whtcombo',  //loads_tycombo($tb,$pk,$like)
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'whtnr'
					}
				},
				fields: [
					'whtnr',
					'whtxt'
				],
				remoteSort: true,
				sorters: 'whtnr ASC'
			}),
			queryMode: 'remote',
			displayField: 'whtxt',
			valueField: 'whtnr'
		});

		this.txtTotal = Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Total',
			name: 'beamt',
			labelWidth: 155,
			alwaysDisplayDecimals: true,
			width:270,
			//margin: '0 0 0 175',
			readOnly: true
		});
		
		this.txtDiscount = Ext.create('Ext.form.field.Text', {
			fieldLabel: 'Discount',
			name: 'dismt',
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
			name: 'aaa',
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
		this.txtTaxValue = Ext.create('Ext.ux.form.NumericField', {
            xtype: 'textfield',
            fieldLabel: 'Vat Total',
			align: 'right',
			alwaysDisplayDecimals: true,
			width:270,
			labelWidth: 155,
			name: 'vat01',
			align: 'right',
			margin: '4 0 0 0',
			readOnly: true

         });
        this.txtWHTValue = Ext.create('Ext.ux.form.NumericField', {
            xtype: 'textfield',
            fieldLabel: 'WHT Total',
			align: 'right',
			alwaysDisplayDecimals: true,
			width:270,
			labelWidth: 155,
			name: 'wht01',
			align: 'right',
			margin: '4 0 0 0',
			readOnly: true

         });
         
         this.txtRate = Ext.create('Ext.ux.form.NumericField', {
            xtype: 'textfield',
            fieldLabel: 'Exchange Rate',
			align: 'right',
			width:240,
			hideTrigger:true,
			alwaysDisplayDecimals: true,
			decimalPrecision : 4,
			name: 'exchg',
			align: 'right'
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
            anchor: '100%',
            defaultType: 'textfield',
            //margin: '5 0 5 600',
        items: [{
                xtype: 'container',
                layout: 'anchor',
     items :[{
			xtype: 'container',
            layout: 'hbox',
            anchor: '100%',
            //margin: '5 0 5 600',
        items: [this.txtRate,{
   	        xtype: 'displayfield',
			align: 'right',
			margin: '0 0 0 5',
			width:20,
			value: 'THB/'
		},{
   	        xtype: 'displayfield',
   	        name: 'curr1',
   	        margin: '0 0 0 7',
			width:30
		}]
		},{
   	        xtype: 'textfield',
   	        fieldLabel: 'Rejected Reason',
			align: 'right',
			margin: '3 0 0 0',
			width:380,
			name: 'reanr'
		},{
			xtype: 'textarea',
			fieldLabel: 'Text Note',
			//labelAlign: 'right',
			margin: '3 0 0 0',
			rows:2,
			width:380,
			name: 'txz01'//,
			//anchor:'90%'
		},{
			xtype: 'container',
            layout: 'hbox',
            anchor: '100%',
            //margin: '5 0 5 600',
        items: [this.comboWHType,this.comboWHTno,{
   	        xtype: 'textfield',
   	        name: 'whtxt',
   	        margin: '4 0 0 7',
			width:250
		}]
		}]
            },{
                xtype: 'container',
                layout: 'anchor',
                margins: '0 0 0 200',
        items: [this.txtTotal,{
			xtype: 'container',
            layout: 'hbox',
            margin: '5 0 5 600',
			items: [this.txtDiscount,this.txtDiscountValue]
		},this.txtDiscountSum,
		this.txtTaxValue,
		this.txtWHTValue,
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
		this.txtTaxValue.on('render', setAlignRight);
		this.txtNet.on('render', setAlignRight);
		this.txtNet.on('render', setBold);
		this.txtWHTValue.on('render', setAlignRight);

		this.txtDiscount.on('keyup', this.calculate, this);
		//this.txtRate.on('keyup', this.ex_rate, this);

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'invoice/load'
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
	ex_rate : function(id){
		var _this=this;
		_this.getForm().calculateTotal();
	},
	// calculate function
	calculate: function(){
		var _this = this;
		var total = this.txtTotal.getValue();//.replace(',',''),
			total = parseFloat(total);
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
			this.txtDiscountSum.setValue('0.00');
			this.txtDiscountSum.setValue(Ext.util.Format.usMoney(total).replace(/\$/, ''));
		}
        
        var vat = this.txtTaxValue.getValue();
		//var vat = _this.vatValue;
		//this.txtTaxValue.setValue(Ext.util.Format.usMoney(vat).replace(/\$/, ''));
		
		var wht = this.txtWHTValue.getValue();
		//this.txtWHTValue.setValue(Ext.util.Format.usMoney(wht).replace(/\$/, ''));

		var net = (total - discountValue) + (vat - wht);
		//alert(net);
		this.txtNet.setValue(net);
        
		return net;
	}
});