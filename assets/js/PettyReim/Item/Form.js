Ext.define('Account.PettyReim.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'pettyreim/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		//this.grDialog = Ext.create('Account.OtherExpense.MainWindow', {
		//	disableGridDoubleClick: true,
		//	isApproveOnly:true
		//});
		
		// INIT other components ///////////////////////////////////
		this.vendorDialog = Ext.create('Account.SVendor.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly:true
		});
		
		this.currencyDialog = Ext.create('Account.SCurrency.MainWindow');

		this.gridItem = Ext.create('Account.PettyReim.Item.Grid_i',{
			height: 320,
			region:'center'
		});
		this.gridGL = Ext.create('Account.PettyReim.Item.Grid_gl',{
			border: true,
			region:'center',
			title: 'GL Posting'
		});
		this.formTotal = Ext.create('Account.DepositOut.Item.Form_t', {
			title:'AP Total',
			border: true,
			split: true,
			region:'south'
		});
		this.formTotalthb = Ext.create('Account.DepositOut.Item.Form_thb', {
			border: true,
			split: true,
			title:'Exchange Rate->THB',
			region:'south'
		});
		this.gridPrice = Ext.create('Account.Quotation.Item.Grid_pc', {
			border: true,
			split: true,
			title:'Item Pricing',
			region:'south'
		});
		// END INIT other components ////////////////////////////////
        this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			readOnly: !UMS.CAN.APPROVE('OE'),
			fieldLabel: 'Petty Cash Status',
			name : 'statu',
			labelAlign: 'right',
			width: 280,
			labelWidth:140,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			margin: '0 0 0 -40',
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
/*---ComboBox Tax Type----------------------------*/
		this.comboTax = Ext.create('Ext.form.ComboBox', {			
			fieldLabel: 'Vat Type',
			name: 'taxnr',
			labelAlign: 'right',
			width:240,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select data --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'quotation/loads_taxcombo',  //loads_tycombo($tb,$pk,$like)
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

/*-------------------------------*/			
		this.hdnApItem = Ext.create('Ext.form.Hidden', {
			name: 'ebtp',
		});
		
		this.hdnGlItem = Ext.create('Ext.form.Hidden', {
			name: 'bsid',
		});

        /*this.trigGR = Ext.create('Ext.form.field.Trigger', {
			name: 'mbeln',
			fieldLabel: 'GR No',
			labelAlign: 'letf',
			//width:240,
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});*/
		
		this.trigVendor = Ext.create('Ext.form.field.Trigger', {
			name: 'lifnr',
			fieldLabel: 'Vendor Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});
         
         this.trigCurrency = Ext.create('Ext.form.field.Trigger', {
			name: 'ctype',
			fieldLabel: 'Currency',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			width: 240,
			//margin: '0 0 0 6',
			labelAlign: 'right',
			allowBlank : false
		});
		
		this.numberPetty = Ext.create('Ext.ux.form.NumericField', {
           // xtype: 'numberfield',
			fieldLabel: 'Petty Cash Limit',
			name: 'deamt'//,
			//labelAlign: 'right',
			//width:170,
			//align: 'right'//,
			//margin: '0 0 0 35'
         });

         this.numberVat = Ext.create('Ext.ux.form.NumericField', {
           // xtype: 'numberfield',
			fieldLabel: 'Vat Value',
			name: 'taxpr',
			labelAlign: 'right',
			width:170,
			align: 'right'//,
			//margin: '0 0 0 35'
         });
         
         this.whtDialog = Ext.create('Account.WHT.Window');
         this.trigWHT = Ext.create('Ext.form.field.Trigger', {
       	    fieldLabel: 'WHT Value',
			name: 'whtnr',
			labelAlign: 'right',
			width:150,
			hideTrigger:false,
			align: 'right',
			value: '10'
		 });
		 
		  this.numberWHT = Ext.create('Ext.form.field.Display', {
			name: 'whtpr',
			width:15,
			align: 'right',
			margin: '0 0 0 5'
         });
         
         /*this.radioType = Ext.create('Ext.form.RadioGroup', {
			//xtype: 'radiogroup',
           // fieldLabel: 'Payable Type',
            cls: 'x-check-group-alt',
            items: [
                {boxLabel: 'Account Payable', width:150, name: 'docty', inputValue: 1, checked: true},
                {boxLabel: 'Pretty Cash', width:100,  name: 'docty', inputValue: 2}
            ]
		});*/
		
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
			items: [this.hdnApItem, this.hdnGlItem,
			{
				xtype:'fieldset',
				title: 'Heading Data',
				collapsible: true,
				items:[{
		    // Project Code
	 				xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
		 			items :[{
						xtype: 'hidden',
						name: 'id'
					},{
						xtype: 'hidden',
						name: 'loekz'
					},this.numberPetty,{
						xtype: 'displayfield',
					    fieldLabel: 'Petty Cash No',
					    name: 'remnr',
						value: 'CPVXXXX-XXXX',
						labelAlign: 'right',
						width:240,
						labelWidth:140,
						readOnly: true,
						margin: '0 0 0 230',
						labelStyle: 'font-weight:bold'
					}]
				// Address Bill&Ship
	            },{
	 				xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
            		items:[{
		                xtype: 'container',
		                flex: 0,
		                layout: 'anchor',
		                
		                items :[{
			 				xtype: 'container',
							layout: 'hbox',
							margin: '0 0 5 0',
				 			items :[this.trigVendor,{
								xtype: 'displayfield',
								name: 'name1',
								margins: '0 0 0 6',
								width:160,
								allowBlank: true 
			                }]
						}, {
							xtype: 'textarea',
							fieldLabel: 'Vendor Address',
							name: 'adr01',
							width: 450, 
							rows:3,
		                },{
			 				xtype: 'container',
							layout: 'hbox',
							margin: '0 0 5 0',
				 			items :[{
								xtype: 'textfield',
								fieldLabel: 'Reference No',
								width: 450, 
								name: 'refnr',
			                }]
		                }]
		            },{
		                xtype: 'container',
		                flex: 0,
		                layout: 'anchor',
		            	margin: '0 0 0 70',
		                items: [this.comboPtype,{
		                //}, {
							xtype: 'datefield',
							fieldLabel: 'Doc Date',
							name: 'bldat',
							labelAlign: 'right',
							width:240,
							format:'d/m/Y',
							altFormats:'Y-m-d|d/m/Y',
							submitFormat:'Y-m-d',
		                }, this.comboTax,
                		this.trigCurrency,
                		{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
            items: [this.numberVat,{
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
				this.trigWHT,this.numberWHT,{
			       xtype: 'displayfield',
			       align: 'right',
			       width:15,
			       margin: '0 0 0 5',
			       value: '%'
		           }]
				},
					    this.comboQStatus]
		            }]
				}]

			}]
		};
		
		this.items = [mainFormPanel,this.gridItem,
		{
			xtype:'tabpanel',
			region:'south',
			activeTab: 0,
			height:195,
			items: [
				this.formTotal,
				this.formTotalthb,
				this.gridPrice,
				this.gridGL
			]
		}	
		];
		
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
							_this.getForm().findField('whtpr').setValue(r.data.whtpr);
						
						}else{
							o.setValue('');
							_this.getForm().findField('whtpr').setValue('');
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
		
		// event trigVender///
		this.trigVendor.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'vendor/load2',
					method: 'POST',
					params: {
						id: v,
						key: 1
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.kunnr);
							_this.getForm().findField('name1').setValue(r.data.name1);
							_this.getForm().findField('adr01').setValue(r.data.adr01);
							_this.getForm().findField('terms').setValue(r.data.terms);
			                _this.getForm().findField('ptype').setValue(r.data.ptype);
			                _this.getForm().findField('taxnr').setValue(r.data.taxnr);
						}else{
							o.setValue('');
							_this.getForm().findField('name1').setValue('');
							_this.getForm().findField('adr01').setValue('');
							_this.getForm().findField('terms').setValue('');
			                _this.getForm().findField('ptype').setValue('');
			                _this.getForm().findField('taxnr').setValue('');
							o.markInvalid('Could not find customer code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.vendorDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigVendor.setValue(record.data.lifnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			
			var v = record.data.lifnr;
			if(Ext.isEmpty(v)) return;
				Ext.Ajax.request({
					url: __site_url+'vendor/load2',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							_this.getForm().findField('adr01').setValue(r.data.adr01);
						    _this.getForm().findField('terms').setValue(r.data.terms);
			                _this.getForm().findField('ptype').setValue(r.data.ptype);
			                _this.getForm().findField('taxnr').setValue(r.data.taxnr);
						}
					}
				});

			grid.getSelectionModel().deselectAll();
			_this.vendorDialog.hide();
		});

		this.trigVendor.onTriggerClick = function(){
			_this.vendorDialog.show();
		};
		
		// event trigProject///
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
			                rc.set('ctype', r.data.ctype);
		                    });
		                    _this.gridItem.curValue = r.data.ctype;
						}else{
							o.setValue('');
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
		
//---------------------------------------------------------------------
		// grid event
		this.gridItem.store.on('update', this.calculateTotal, this);
		this.gridItem.store.on('load', this.calculateTotal, this);
		this.on('afterLoad', this.calculateTotal, this);
		this.gridItem.getSelectionModel().on('selectionchange', this.onSelectChange, this);
		this.gridItem.getSelectionModel().on('viewready', this.onViewReady, this);
        
		this.comboTax.on('change', this.calculateTotal, this);
		this.trigCurrency.on('change', this.changeCurrency, this);
		this.formTotal.txtRate.on('keyup', this.calculateTotal, this);
		this.formTotal.txtRate.on('change', this.calculateTotal, this);
		this.numberWHT.on('change', this.calculateTotal, this);
		this.numberVat.on('change', this.calculateTotal, this);
		return this.callParent(arguments);
	},
	
	onSelectChange: function(selModel, selections){
		var _this=this;
		var sel = this.gridItem.getView().getSelectionModel().getSelection()[0];
        //var id = sel.data[sel.idField.name];
        if (sel) {
            _this.gridPrice.load({
            	menge:sel.get('menge').replace(/[^0-9.]/g, ''),
            	unitp:sel.get('unitp').replace(/[^0-9.]/g, ''),
            	disit:sel.get('disit').replace(/[^0-9.]/g, ''),
            	vvat:this.numberVat.getValue(),
            	vwht:this.numberWHT.getValue(),
            	vat:sel.get('chk01'),
            	wht:sel.get('chk02'),
            	vattype:this.comboTax.getValue()
            });

        }
    },

    onViewReady: function(grid) {
        grid.getSelectionModel().select(0);
    },
    
	load : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'pettyreim/load',
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
		this.hdnApItem.setValue(Ext.encode(rsItem));
		
		var rsGL = _this.gridGL.getData();
		this.hdnGlItem.setValue(Ext.encode(rsGL));

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
			params: { invnr: invnr },
			url:__site_url+'otexpense/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	reset: function(){
		this.getForm().reset();
		// สั่ง grid load เพื่อเคลียร์ค่า
		//this.gridItem.load({ invnr: 0 });
		this.gridGL.load({ netpr: 0 });
		
		// สร้างรายการเปล่า 5 รายการใน grid item
		this.gridItem.addDefaultRecord();

		// default status = wait for approve
		this.comboQStatus.setValue('01');
		this.comboTax.setValue('01');
		this.trigCurrency.setValue('THB');
		this.numberVat.setValue(7);
		this.numberWHT.setValue(3);
		this.getForm().findField('bldat').setValue(new Date());
		this.formTotal.getForm().findField('exchg').setValue('1.0000');
		this.formTotalthb.getForm().findField('exchg2').setValue('1.0000');
		this.formTotal.getForm().findField('bbb').setValue('0.00');
		this.formTotal.getForm().findField('netwr').setValue('0.00');
	},
	// Add duedate functions
	/*getDuedate: function(){
		var bForm = this.getForm(),
			credit = this.numberCredit.getValue(),
			startDate = bForm.findField('bldat').getValue(),
			result = Ext.Date.add(startDate, Ext.Date.DAY, credit);

		bForm.findField('duedt').setValue(result);
	},*/
	// calculate total functions
	calculateTotal: function(){
		var _this=this;
		var store = this.gridItem.store;
		var sum = 0;var vats=0;sum2=0;
		var whts=0;var discounts=0;
		var saknr_list = [];
		var vattype = this.comboTax.getValue();
		store.each(function(r){
			var qty = parseFloat(r.data['menge']),
				price = parseFloat(r.data['unitp']),
				discount = parseFloat(r.data['disit']);
			qty = isNaN(qty)?0:qty;
			price = isNaN(price)?0:price;
			discount = isNaN(discount)?0:discount;

			var amt = qty * price;//) - discount;
			if(vattype =='02'){
				amt = amt * 100;
			    amt = amt / 107;
		    }
			sum += amt;
			
			discounts += discount;
            
            amt = amt - discount;
            sum2+=amt;
			if(r.data['chk01']==true){
				var vat = _this.numberVat.getValue();
				    vat = (amt * vat) / 100;
				    vats += vat;
			}
			var item = r.data['saknr'] + '|' + amt;
        		saknr_list.push(item);
			if(r.data['chk02']==true){
				var wht = _this.numberWHT.getValue();
				    wht = (amt * wht) / 100;
				    whts += wht;
			}
		});
		this.formTotal.getForm().findField('beamt').setValue(sum);
		this.formTotal.getForm().findField('vat01').setValue(vats);
		this.formTotal.getForm().findField('wht01').setValue(whts);
		this.formTotal.getForm().findField('dismt').setValue(discounts);
        var net = this.formTotal.calculate();
// Set value to total form
		this.formTotal.taxType = this.comboTax.getValue();
		this.gridItem.vatValue = this.numberVat.getValue();
		
		var currency = this.trigCurrency.getValue();
		this.gridItem.curValue = currency;
		this.formTotal.getForm().findField('curr1').setValue(currency);
		this.formTotalthb.getForm().findField('curr2').setValue(currency);
		this.gridItem.vendorValue = this.trigVendor.getValue();
		//alert(this.comboPay.getValue());
// Set value to GL Posting grid 
		var rate = this.formTotal.txtRate.getValue();
		if(currency != 'THB'){
	      sum2 = sum2 * rate;
		  sum = sum * rate;
		  vats = vats * rate;
		  whts = whts * rate;
		  discounts = discounts * rate;
		}  
		
		this.formTotalthb.getForm().findField('beamt2').setValue(sum);
		this.formTotalthb.getForm().findField('vat02').setValue(vats);
		this.formTotalthb.getForm().findField('wht02').setValue(whts);
		this.formTotalthb.getForm().findField('dismt2').setValue(discounts);
		this.formTotalthb.getForm().findField('exchg2').setValue(rate);
		var net2 = this.formTotalthb.calculate();
		//alert(sum);  
        if(sum>0 && this.trigVendor.getValue()!=''){
            _this.gridGL.load({
            	netpr:sum2,
            	vvat:vats,
            	lifnr:this.trigVendor.getValue(),
            	items: saknr_list.join(',')
            }); 
           }

// Set value to Condition Price grid
        var sel = this.gridItem.getView().getSelectionModel().getSelection()[0];
        if (sel) {
        	//_this.gridPrice.store.removeAll();
            _this.gridPrice.load({
            	menge:sel.get('menge').replace(/[^0-9.]/g, ''),
            	unitp:sel.get('unitp').replace(/[^0-9.]/g, ''),
            	disit:sel.get('disit').replace(/[^0-9.]/g, ''),
            	vvat:this.numberVat.getValue(),
            	vwht:this.numberWHT.getValue(),
            	vat:sel.get('chk01'),
            	wht:sel.get('chk02'),
            	vattype:this.comboTax.getValue()
            });     
        }
	},
	
	changeCurrency: function(){
		var _this=this;
		var store = this.gridItem.store;
		var currency = this.trigCurrency.getValue();
		store.each(function(r){
			r.set('ctyp1', currency);
		});
	}
	
// Payments Method	
	/*selectPay: function(combo, record, index){
		var _this=this;
		var store = this.gridItem.store;
		var vtax = combo.getValue();
		var sum = 0;var vats=0;var i=0;
		store.each(function(r){
			var qty = parseFloat(r.data['menge'].replace(/[^0-9.]/g, '')),
				price = parseFloat(r.data['unitp'].replace(/[^0-9.]/g, '')),
				discount = parseFloat(r.data['disit'].replace(/[^0-9.]/g, '')),
				mtart = r.data['mtart'];
				
			qty = isNaN(qty)?0:qty;
			price = isNaN(price)?0:price;
			discount = isNaN(discount)?0:discount;

			var amt = (qty * price) - discount;
            
			sum += amt;
			if(r.data['chk01']==true){
				var vat = _this.numberVat.getValue();
				    vat = (amt * vat) / 100;
				    vats += vat;
			}		
		});
		
		if(currency != 'THB'){
	      var rate = this.formTotal.getForm().findField('exchg').getValue();
		  sum = sum * rate;
		  vats = vats * rate;
		} 
		if(sum>0){
            _this.gridGL.load({
            	netpr:sum,
            	vvat:vats,
            	lifnr:this.trigVendor.getValue(),
            	ptype:combo.getValue(),
            	dtype:'01'
            }); 
           }
	}*/
});