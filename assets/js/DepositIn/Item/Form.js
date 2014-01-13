Ext.define('Account.DepositIn.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'depositin/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.quotationDialog = Ext.create('Account.Quotation.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
		
		// INIT Customer search popup ///////////////////////////////
		//this.quotationDialog = Ext.create('Account.Quotation.MainWindow');
		this.customerDialog = Ext.create('Account.SCustomer.MainWindow');
		this.currencyDialog = Ext.create('Account.SCurrency.MainWindow');
		
		this.gridItem = Ext.create('Account.DepositIn.Item.Grid_i',{
			//title:'Invoice Items',
			height: 200,
			region:'center'
		});
		this.gridGL = Ext.create('Account.DepositIn.Item.Grid_gl',{
			border: true,
			region:'center',
			title: 'GL Posting'
		});
		this.formTotal = Ext.create('Account.DepositIn.Item.Form_t', {
			border: true,
			split: true,
			title:'Total->Deposit',
			region:'south'
		});
		this.formTotalthb = Ext.create('Account.Quotation.Item.Form_thb', {
			border: true,
			split: true,
			title:'Exchange Rate->THB',
			region:'south'
		});
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			readOnly: !UMS.CAN.APPROVE('DR'),
			fieldLabel: 'Deposit Status',
			name : 'statu',
			labelAlign: 'right',
			width: 240,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			//margin: '0 0 0 6',
			clearFilterOnReset: true,
			emptyText: '-- Select Status --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'quotation/loads_acombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'statu'
					}
				},
				fields: [
					'statu',
					'statx'
				],
				remoteSort: true,
				sorters: 'statu ASC'
			}),
			queryMode: 'remote',
			displayField: 'statx',
			valueField: 'statu'
		});
		
		this.comboTax = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Vat type',
			name : 'taxnr',
			width: 240,
			//margin: '0 0 0 5',
			labelAlign: 'right',
			editable: false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Select Vat --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'quotation/loads_taxcombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'taxnr'
					}
				},
				fields: [
					'taxnr',
					'taxtx'
				],
				remoteSort: true,
				sorters: 'taxnr ASC'
			}),
			queryMode: 'remote',
			displayField: 'taxtx',
			valueField: 'taxnr'
		});
		
		this.hdnDpItem = Ext.create('Ext.form.Hidden', {
			name: 'vbdp'
		});
		
		this.hdnGlItem = Ext.create('Ext.form.Hidden', {
			name: 'bcus',
		});
		
		this.trigCustomer = Ext.create('Ext.form.field.Trigger', {
			name: 'kunnr',
			labelAlign: 'letf',
			width:240,
			fieldLabel: 'Customer Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});
		
		this.trigCurrency = Ext.create('Ext.form.field.Trigger', {
			name: 'ctype',
			fieldLabel: 'Currency',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			width: 200,
			editable: false,
			labelAlign: 'right',
			allowBlank : false
		});
		
		this.trigQuotation = Ext.create('Ext.form.field.Trigger', {
			name: 'vbeln',
			fieldLabel: 'Quotation No.',
			width:240,
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});
	   
	   this.whtDialog = Ext.create('Account.WHT.Window');
       this.trigWHT = Ext.create('Ext.form.field.Trigger', {
       	    fieldLabel: 'WHT Value',
			name: 'whtnr',
			labelAlign: 'right',
			width:150,
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			//margin: '4 0 0 10'
		});
		
		this.numberWHT = Ext.create('Ext.form.field.Display', {
			name: 'whtpr',
			width:15,
			align: 'right',
			margin: '0 0 0 8'
         });

         this.numberVat = Ext.create('Ext.form.field.Number', {
			fieldLabel: 'Vat Value',
			name: 'taxpr',
			labelAlign: 'right',
			width:150,
			//align: 'right',
			//margin: '0 0 0 25'
         });
         
         this.numberCredit = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'Credit Terms',
			name: 'terms',
			//labelAlign: 'right',
			width:180,
			hideTrigger:false,
			//align: 'right',
			//margin: '0 0 0 25',
			allowDecimals: false,
			minValue:0
         });
		
// Start Write Forms
		var mainFormPanel = {
			xtype: 'panel',
			border: true,
			region:'north',
			bodyPadding: '5 10 0 10',
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',
				labelWidth: 105
			},
			items: [this.hdnDpItem,this.hdnGlItem,
			{
			xtype:'fieldset',
            title: 'Heading Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },

// Customer Code            
     items:[{
     	xtype: 'container',
                layout: 'hbox',
                //margin: '0 0 5 0',
     items: [{
                xtype: 'container',
                layout: 'anchor',
// Quotation Code
     items :[{
     	        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'hidden',
			name: 'id'
		},{
			xtype: 'hidden',
			name: 'loekz'
		},this.trigQuotation,
					{
						xtype: 'displayfield',
						//name: 'name1',
						margins: '0 0 0 6',
						width:350,
						allowBlank: true
					}]
		},{
     	        xtype: 'container',
                layout: 'hbox',
                //margin: '0 0 5 0',
     items :[this.trigCustomer,{
			xtype: 'displayfield',
			name: 'name1',
			margins: '0 0 0 6',
			width:350,
            allowBlank: true
		}]
		},{
			xtype: 'textarea',
			fieldLabel: 'Bill To',
			name: 'adr01',
			width:400,
			rows:3,
			labelAlign: 'top'
		},{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [this.numberCredit
   ,{
			xtype: 'displayfield',
			margin: '0 0 0 5',
			width:10,
			value: 'Days'
		},{
			xtype: 'datefield',
			fieldLabel: 'Due Date',
			name: 'duedt',
			labelAlign: 'right',
			width:200,
			margin: '0 0 0 5',
			//readOnly: true,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
		}]
// Tax&Ref no.
         }]
		},{
			xtype: 'container',
                layout: 'anchor',
     items :[{
			xtype: 'displayfield',
            fieldLabel: 'Deposit No',
            name: 'depnr',
            value: 'DRXXXX-XXXX',
            labelAlign: 'right',
			width:240,
            readOnly: true,
			labelStyle: 'font-weight:bold'
	    },{
			xtype: 'datefield',
			fieldLabel: 'Document Date',
			name: 'bldat',
			labelAlign: 'right',
			width:240,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			allowBlank: false
	    },this.comboTax,{
			 	xtype: 'container',
				layout: 'hbox',
				margin: '0 0 5 0',
				items: [
				this.trigWHT,this.numberWHT,{
			       xtype: 'displayfield',
			       align: 'right',
			       width:15,
			       margin: '0 0 0 5',
			       value: '%'
		           }]
				},{
			 	xtype: 'container',
				layout: 'hbox',
				margin: '0 0 5 0',
				items: [
				this.numberVat,{
			       xtype: 'displayfield',
			       align: 'right',
			       width:15,
			       margin: '0 0 0 5',
			       value: '%'
			       }]
		           },this.trigCurrency,this.comboQStatus
		 ]
		}]
		}]
		}]
		};
		
		this.items = [mainFormPanel,this.gridItem,
		{
			xtype:'tabpanel',
			region:'south',
			activeTab: 0,
			height:200,
			items: [
				this.formTotal,
				this.formTotalthb,
				this.gridGL
			]
		}
			
		];
		
		// event trigQuotation///
		this.trigQuotation.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'quotation/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.vbeln);
			//_this.getForm().findField('jobtx').setValue(r.data.jobtx);		
			_this.getForm().findField('kunnr').setValue(r.data.kunnr);
			_this.getForm().findField('name1').setValue(r.data.name1);
			_this.getForm().findField('adr01').setValue(r.data.adr01);
			_this.getForm().findField('ctype').setValue(r.data.ctype);
			_this.getForm().findField('taxnr').setValue(r.data.taxnr);
			_this.getForm().findField('terms').setValue(r.data.terms);
			_this.getForm().findField('taxpr').setValue(r.data.taxpr);
			_this.getForm().findField('whtpr').setValue(r.data.whtpr);
			_this.getForm().findField('loekz').setValue(r.data.loekz);
			
			//---Load PRitem to POitem Grid-----------
			var qtnr = _this.trigQuotation.value;
			//alert(qtnr);
			//_this.gridItem.load({qtnr: qtnr });
			//----------------------------------------			
						}else{
							o.markInvalid('Could not find quotation no : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		_this.quotationDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigQuotation.setValue(record.data.vbeln);
			//_this.getForm().findField('jobtx').setValue(record.data.jobtx);
			
			_this.getForm().findField('kunnr').setValue(record.data.kunnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
            
            Ext.Ajax.request({
					url: __site_url+'quotation/load',
					method: 'POST',
					params: {
						id: record.data.vbeln
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
			_this.getForm().findField('adr01').setValue(r.data.adr01);
			_this.getForm().findField('ctype').setValue(r.data.ctype);
			_this.getForm().findField('taxnr').setValue(r.data.taxnr);
			_this.getForm().findField('terms').setValue(r.data.terms);
			_this.getForm().findField('taxpr').setValue(r.data.taxpr);
			_this.getForm().findField('whtpr').setValue(r.data.whtpr);
			_this.getForm().findField('loekz').setValue(r.data.loekz);
			       }
				}
				});           
 
			grid.getSelectionModel().deselectAll();
			//---Load PRitem to POitem Grid-----------
			var qtnr = _this.trigQuotation.value;
			//console.log(qtnr);
			//alert(qtnr);
			_this.gridItem.load({qtnr: qtnr });
			//----------------------------------------
			_this.quotationDialog.hide();
		});

		this.trigQuotation.onTriggerClick = function(){
			_this.quotationDialog.grid.load();
			_this.quotationDialog.show();
		};
		
		// event trigCustomer///
		this.trigCustomer.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'customer/load2',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.kunnr);
							_this.getForm().findField('name1').setValue(r.data.name1);
							_this.getForm().findField('adr01').setValue(r.data.adr01);
			 			}else{
							o.markInvalid('Could not find customer code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.customerDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigCustomer.setValue(record.data.kunnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			
			var _addr = record.data.adr01;
			if(!Ext.isEmpty(record.data.distx))
              _addr += ' '+record.data.distx;
            if(!Ext.isEmpty(record.data.pstlz))
              _addr += ' '+record.data.pstlz;
            if(!Ext.isEmpty(record.data.telf1))
               _addr += '\n'+'Tel: '+record.data.telf1;
             if(!Ext.isEmpty(record.data.telfx))
               _addr += ' '+'Fax: '+record.data.telfx;
             if(!Ext.isEmpty(record.data.email))
               _addr += '\n'+'Email: '+record.data.email;
             _this.getForm().findField('adr01').setValue(_addr);
             //_this.getForm().findField('adr11').setValue(_addr);

			grid.getSelectionModel().deselectAll();
			_this.customerDialog.hide();
		});

		this.trigCustomer.onTriggerClick = function(){
			_this.customerDialog.show();
		};
		
	// event trigCurrency///
		this.trigCurrency.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'currency/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.ctype);
							_this.formTotal.getForm().findField('curr').setValue(r.data.ctype);
							var store = _this.gridItem.store;
		                    store.each(function(rc){
			                //price = parseFloat(rc.data['unitp']),
			                rc.set('ctype', r.data.ctype);
		                    });
		                    _this.gridItem.curValue = r.data.ctype;
						}else{
							o.markInvalid('Could not find currency code : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		_this.currencyDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigCurrency.setValue(record.data.ctype);

            _this.formTotal.getForm().findField('curr1').setValue(record.data.ctype);
            var store = _this.gridItem.store;
		    store.each(function(rc){
			//price = parseFloat(rc.data['unitp']),
			rc.set('ctype', record.data.ctype);
		    });
		    _this.gridItem.curValue = record.data.ctype;
			grid.getSelectionModel().deselectAll();
			_this.currencyDialog.hide();
		});

		this.trigCurrency.onTriggerClick = function(){
			_this.currencyDialog.show();
		};
		
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
							//if(r.data.whtnr != '6'){
							_this.getForm().findField('whtpr').setValue(r.data.whtpr);
						   //}
						}else{
							o.markInvalid('Could not find wht code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.whtDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigWHT.setValue(record.data.whtnr);
			//if(record.data.whtnr != '6'){
            _this.getForm().findField('whtpr').setValue(record.data.whtpr);
           //}
            
			grid.getSelectionModel().deselectAll();
			_this.whtDialog.hide();
		});

		this.trigWHT.onTriggerClick = function(){
			_this.whtDialog.show();
		};

	// grid event
		this.gridItem.store.on('update', this.calculateTotal, this);
		//this.gridItem.store.on('change', this.calculateTotal, this);
		this.gridItem.store.on('load', this.calculateTotal, this);
		this.on('afterLoad', this.calculateTotal, this);
		
		this.numberCredit.on('keyup', this.getDuedate, this);
		this.numberCredit.on('change', this.getDuedate, this);
		this.formTotal.txtRate.on('keyup', this.calculateTotal, this);
		this.formTotal.txtRate.on('change', this.calculateTotal, this);
		this.comboTax.on('change', this.calculateTotal, this);
		this.trigCurrency.on('change', this.changeCurrency, this);

		return this.callParent(arguments);
	},	
	
	load : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'depositin/load',
			success: function(form, act){
				_this.fireEvent('afterLoad', form, act);
			}
		});
	},
	
	save : function(){
		var _this=this;
		var _form_basic = this.getForm();
		
		// add grid data to json
		var rsItem = this.gridItem.getData();
		this.hdnDpItem.setValue(Ext.encode(rsItem));
		//var rsPayment = _this.gridPayment.getData();
		//this.hdnPpItem.setValue(Ext.encode(rsPayment));
		
		var rsGL = _this.gridGL.getData();
		this.hdnGlItem.setValue(Ext.encode(rsGL));
/*
		this.getForm().getFields().each(function(f){
			//console.log(f.name);
    		 if(!f.validate()){
    		 	var p = f.up();
    		 	console.log(p);
    			 console.log('invalid at : '+f.name);
    		 }
    	 });
*/
		if (_form_basic.isValid()) {
			_form_basic.submit({
				success: function(form_basic, action) {
					form_basic.reset();
					_this.fireEvent('afterSave', _this, action);
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
			url:__site_url+'depositin/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ depnr: 0 });
		this.gridGL.load({
            	netpr:0
            });
		
		// default status = wait for approve
		this.comboQStatus.setValue('01');
		this.comboTax.setValue('01');
		this.numberVat.setValue(7);
		this.numberWHT.setValue(3);
		this.trigCurrency.setValue('THB');
		this.getForm().findField('bldat').setValue(new Date());
		this.formTotal.txtRate.setValue('1.0000');
		this.formTotalthb.getForm().findField('exchg2').setValue('1.0000');
		this.formTotal.getForm().findField('bbb').setValue('0.00');
		this.formTotal.getForm().findField('netwr').setValue('0.00');
	},
	
	// Calculate total functions
	calculateTotal: function(){
		var _this=this;
		var store = this.gridItem.store;
		var amt = 0;var vats=0; var whts=0;
		var i=0;var sum=0;discounts=0;discount=0;
		var sum2=0;
		var vattype = this.comboTax.getValue();
		store.each(function(r){
			var amt = parseFloat(r.data['pramt'].replace(/[^0-9.]/g, ''));
				//pay = parseFloat(r.data['payrc'].replace(/[^0-9.]/g, ''));
				discountValue = 0,
				discount = r.data['disit'];
				
			    amt = isNaN(amt)?0:amt;
                //discount = isNaN(discount)?0:discount;
                
			if(vattype =='02'){
			  amt = amt * 100;
			  amt = amt / 107;
		    }
		    
		    if(discount.match(/%$/gi)){
				discount = discount.replace('%','');
				var discountPercent = parseFloat(discount);
				discountValue = amt * discountPercent / 100;
			}else{
				discountValue = parseFloat(discount);
			}
			discountValue = isNaN(discountValue)?0:discountValue;
		    
			sum += amt;
			
			discounts += discountValue;
            amt = amt - discountValue;
            sum2 += amt;
			if(r.data['chk01']==true){
				var vat = _this.numberVat.getValue();
				    vat = (amt * vat) / 100;
				    vats += vat;
			}
            
			if(r.data['chk02']==true){
				var wht = _this.numberWHT.getValue();
				    wht = (amt * wht) / 100;
				    whts += wht;
			}
		});
		this.formTotal.getForm().findField('beamt').setValue(sum);
		var currency = this.trigCurrency.getValue();
		this.gridItem.curValue = currency;
		this.formTotal.getForm().findField('curr1').setValue(currency);
		this.formTotal.getForm().findField('vat01').setValue(vats);
		this.formTotal.getForm().findField('wht01').setValue(whts);
		this.formTotal.getForm().findField('dismt').setValue(discounts);
		var net = this.formTotal.calculate();
		
		//this.gridItem.netValue = net;
		this.formTotal.taxType = this.comboTax.getValue();
		this.gridItem.vatValue = this.numberVat.getValue();
		this.gridItem.whtValue = this.numberWHT.getValue();
		this.formTotal.getForm().findField('curr1').setValue(currency);
        var rate = this.formTotal.txtRate.getValue();
		if(currency != 'THB'){
		  sum = sum * rate;
		  vats = vats * rate;
		  sum2 = sum2 * rate;
		  discounts = discounts * rate;
		}   
		
		this.formTotalthb.getForm().findField('beamt2').setValue(sum);
		this.formTotalthb.getForm().findField('vat02').setValue(vats);
		this.formTotalthb.getForm().findField('wht02').setValue(whts);
		this.formTotalthb.getForm().findField('dismt2').setValue(discounts);
		this.formTotalthb.getForm().findField('exchg2').setValue(rate);
		this.formTotalthb.getForm().findField('curr2').setValue(currency);
		var net2 = this.formTotalthb.calculate();
		
        if(sum>0 && this.trigCustomer.getValue()!=''){
        	//console.log(rsPM);
            _this.gridGL.load({
            	netpr:sum2,
            	vvat:vats,
            	kunnr:this.trigCustomer.getValue()
            }); 
           }
	},
	// Add duedate functions
	getDuedate: function(){
		var bForm = this.getForm(),
			credit = this.numberCredit.getValue(),
			startDate = bForm.findField('bldat').getValue(),
			result = Ext.Date.add(startDate, Ext.Date.DAY, credit);

		bForm.findField('duedt').setValue(result);
	},
	
	changeCurrency: function(){
		var _this=this;
		var store = this.gridItem.store;
		var sum = 0;
		var currency = this.trigCurrency.getValue();
		store.each(function(r){
			r.set('ctyp1', currency);
		});
	}
	
	// Load GL functions
	/*loadGL: function(){
		var _this=this;
		var store = this.gridItem.store;
		var sum = 0;
		store.each(function(r){
			var itamt = parseFloat(r.data['pramt'].replace(/[^0-9.]/g, '')),
				//pay = parseFloat(r.data['payrc'].replace(/[^0-9.]/g, ''));
			itamt = isNaN(itamt)?0:itamt;
			//pay = isNaN(pay)?0:pay;
			//var amt = itamt - pay;
			sum += itamt;
		});

		// set value to grid payment
		//var rsPM = _this.gridPayment.getData();
		// Set value to GL Posting grid  
		var currency = this.trigCurrency.getValue();
		if(currency != 'THB'){
	      var rate = this.formTotal.getForm().findField('exchg').getValue();
		  sum = sum * rate;
		}   
        if(sum>0){
        	//console.log(rsPM);
            _this.gridGL.load({
            	//paym:Ext.encode(rsPM),
            	netpr:sum,
            	kunnr:this.trigCustomer.getValue(),
            	rate:rate,
            	dtype:'01'
            }); 
           }
	}*/
	
});