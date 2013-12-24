Ext.define('Account.DepositIn.Item.Form_t', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'depositin/save',
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
		
	   this.whtDialog = Ext.create('Account.WHT.Window');
       this.trigWHT = Ext.create('Ext.form.field.Trigger', {
			name: 'whtnr',
			//fieldLabel: 'SO No',
			labelAlign: 'letf',
			width:50,
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			margin: '4 0 0 10'//,
			//allowBlank : false
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

		this.txtTotal = Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Total',
			name: 'beamt',
			alwaysDisplayDecimals: true,
			labelWidth: 155,
			width:270,
			//margin: '0 0 0 175',
			readOnly: true
		});
		/*this.txtDiscount = Ext.create('Ext.form.field.Text', {
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
		});*/
		this.txtDiscountValue = Ext.create('Ext.ux.form.NumericField', {
			xtype: 'textfield',
			fieldLabel: 'Discount',
			name: 'dismt',
			align: 'right',
			width:270,
			labelWidth: 155,
			margin: '4 0 0 0',
			alwaysDisplayDecimals: true,
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
		
		/*this.txtInterest = Ext.create('Ext.ux.form.NumericField', {
            xtype: 'textfield',
            fieldLabel: 'Interest',
            alwaysDisplayDecimals: true,
			name: 'ccc',
			align: 'right',
			margin: '4 0 0 0',
			width:270,
			labelWidth: 155,
			readOnly: true

         });*/
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
			editable: false,
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
            //anchor: '100%',
            defaultType: 'textfield',
            //margin: '5 0 5 600',
        items: [{
                xtype: 'container',
                layout: 'anchor',
     items :[{
			xtype: 'container',
            layout: 'hbox',
            //anchor: '100%',
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
		},{
			xtype: 'container',
            layout: 'hbox',
            anchor: '100%',
            //margin: '5 0 5 600',
        items: [this.comboWHType,this.trigWHT,{
   	        xtype: 'textfield',
   	        name: 'whtxt',
   	        margin: '4 0 0 7',
   	        //allowBlank: false,
			width:250
		}]
		}]
            },{
                xtype: 'container',
                layout: 'anchor',
                margins: '0 0 0 20',
        items: [this.txtTotal,{
			xtype: 'container',
            layout: 'hbox',
            //margin: '5 0 5 600',
			items: [this.txtDiscount,this.txtDiscountValue]
		},this.txtDiscountSum,
		this.txtTaxValue,
		this.txtWHTValue,
	    this.txtNet]
		}]
		}];
		
		// event trigWHT///
		this.trigWHT.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'invoice/loads_wht',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.whtnr);
							//_this.formTotal.getForm().findField('curr').setValue(r.data.ctype);
							if(r.data.whtnr != '6'){
							_this.getForm().findField('whtxt').setValue(r.data.whtxt);
						    }
						}else{
							o.markInvalid('Could not find wht code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.whtDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigWHT.setValue(record.data.whtnr);
			if(record.data.whtnr != '6'){
            _this.getForm().findField('whtxt').setValue(record.data.whtxt);
           }
            
			grid.getSelectionModel().deselectAll();
			_this.whtDialog.hide();
		});

		this.trigWHT.onTriggerClick = function(){
			_this.whtDialog.show();
		};
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
		//this.txtInterest.on('render', setAlignRight);
		this.txtNet.on('render', setAlignRight);
		this.txtNet.on('render', setBold);

		//this.txtDiscount.on('keyup', this.calculate, this);
		//this.txtTax.on('keyup', this.calculate, this);

		return this.callParent(arguments);
	},
	
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'depositin/load'
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
			url:__site_url+'invoice/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	// calculate function
	calculate: function(){
		var total = this.txtTotal.getValue();//.replace(',',''),
			total = parseFloat(total);
			total = isNaN(total)?0:total;

		//console.log(total);

		if(total<=0) return;

		var discountValue = this.txtDiscountValue.getValue();
		/*	discountValue = 0;
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
*/
		if(discountValue>0){
			this.txtDiscountSum.setValue(Ext.util.Format.usMoney(total - discountValue).replace(/\$/, ''));
		}else{
			this.txtDiscountValue.setValue('0.00');
			this.txtDiscountSum.setValue(Ext.util.Format.usMoney(total).replace(/\$/, ''));
		}

		/*var tax = this.txtInterest.getValue(),
			taxValue = 0;
		if(this.txtInterest.isValid() && !Ext.isEmpty(tax)){
			taxValue = parseFloat(tax);
			taxValue = isNaN(taxValue)?0:taxValue;
    
			//if(taxValue>0){
				//taxValue = taxValue * total / 100;
				//this.txtTaxValue.setValue(Ext.util.Format.usMoney(taxValue).replace(/\$/, ''));
			//}
		}else{
			this.txtInterest.setValue('');
		}*/

		var vat = this.txtTaxValue.getValue();
		//var vat = _this.vatValue;
		//this.txtTaxValue.setValue(Ext.util.Format.usMoney(vat).replace(/\$/, ''));
		
		var wht = this.txtWHTValue.getValue();
		//this.txtWHTValue.setValue(Ext.util.Format.usMoney(wht).replace(/\$/, ''));

		var net = (total - discountValue) + (vat - wht);
		this.txtNet.setValue(net);
		
		return net;
	}
});