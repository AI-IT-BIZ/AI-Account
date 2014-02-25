Ext.define('Account.PettyExpense.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'pettyexpense/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.projectDialog = Ext.create('Account.Project.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
		
		this.pettyDialog = Ext.create('Account.PettyReim.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly:true
		});
		
		// INIT other components ///////////////////////////////////
		this.vendorDialog = Ext.create('Account.SVendor.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly:true
		});
		
		this.currencyDialog = Ext.create('Account.SCurrency.MainWindow');

		this.gridItem = Ext.create('Account.PettyExpense.Item.Grid_i',{
			height: 320,
			region:'center'
		});
		this.gridGL = Ext.create('Account.PettyExpense.Item.Grid_gl',{
			border: true,
			region:'center',
			title: 'GL Posting'
		});
		this.formTotal = Ext.create('Account.DepositOut.Item.Form_t', {
			title:'Petty Cash Total',
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
		this.gridPrice = Ext.create('Account.Invoice.Item.Grid_pc', {
			border: true,
			split: true,
			title:'Item Pricing',
			region:'south'
		});
		// END INIT other components ////////////////////////////////
        this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			readOnly: !UMS.CAN.APPROVE('PE'),
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
		    //emptyText: '-- Please select data --',
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
			readOnly: true,
			valueField: 'taxnr'
		});	

/*------------------------------------------------------*/			
		this.hdnApItem = Ext.create('Ext.form.Hidden', {
			name: 'ebep',
		});
		
		this.hdnGlItem = Ext.create('Ext.form.Hidden', {
			name: 'bsid',
		});
		
		this.trigProject = Ext.create('Ext.form.field.Trigger', {
			name: 'jobnr',
			fieldLabel: 'Project No.',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true//,
			//allowBlank : false
		});

        this.trigPetty = Ext.create('Ext.form.field.Trigger', {
			name: 'remnr',
			fieldLabel: 'CPV No',
			labelAlign: 'letf',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});
		
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
			labelAlign: 'right',
			readOnly: true,
			allowBlank : false
		});
		
		this.numberPetty = Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Petty Cash Limit',
			name: 'deamt',
			labelAlign: 'right',
			width: 240,
			alwaysDisplayDecimals: true,
			readOnly: true
         });
         
         this.numberRemain = Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Remain Amt',
			name: 'reman',
			labelWidth: 70,
			width: 187,
			margin: '0 0 0 15',
			alwaysDisplayDecimals: true,
			readOnly: true
         });

         this.numberVat = Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Vat Value',
			name: 'taxpr',
			labelAlign: 'right',
			width:170,
			align: 'right'
         });
		
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
					},this.trigPetty,{
						xtype: 'displayfield',
					    fieldLabel: 'Petty Cash No',
					    name: 'invnr',
						value: 'PCXXXX-XXXX',
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
				 			items :[this.trigProject,
					    {
						xtype: 'displayfield',
						name: 'jobtx',
						width:200,
						margins: '0 0 0 6',
						allowBlank: true
					    }]
						},{
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
								width: 250, 
								name: 'refnr',
			                },this.numberRemain]
		                }]
		                },{
		                xtype: 'container',
		                flex: 0,
		                layout: 'anchor',
		            	margin: '0 0 0 70',
		                items: [{
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
               },this.numberPetty,
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
			height:200,
			items: [
				this.formTotal,
				this.formTotalthb,
				this.gridPrice,
				this.gridGL
			]
		}	
		];
		
		// event trigProject///
		this.trigProject.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'project/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.jobnr);
			_this.getForm().findField('jobtx').setValue(r.data.jobtx);

						}else{
							o.setValue('');
			_this.getForm().findField('jobtx').setValue('');
			//o.markInvalid('Could not find project code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.projectDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigProject.setValue(record.data.jobnr);
			_this.getForm().findField('jobtx').setValue(record.data.jobtx);

			grid.getSelectionModel().deselectAll();
			_this.projectDialog.hide();
		});

		this.trigProject.onTriggerClick = function(){
			_this.projectDialog.show();
		};
		
		// event trigGR///
		this.trigPetty.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'pettreim/load',
					method: 'POST',
					params: {
						id: v,
						key: 1
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.remnr);
							_this.getForm().findField('lifnr').setValue(r.data.lifnr);
							_this.getForm().findField('name1').setValue(r.data.name1);
			                _this.getForm().findField('ctype').setValue(r.data.ctype);
			                _this.getForm().findField('adr01').setValue(r.data.adr01);
			                _this.getForm().findField('loekz').setValue(r.data.loekz);
			                _this.getForm().findField('exchg').setValue(r.data.exchg);
			                _this.getForm().findField('deamt').setValue(r.data.netwr);
			                //_this.getForm().findField('reman').setValue(r.data.reman);
						}else{
							_this.getForm().findField('lifnr').setValue('');
							_this.getForm().findField('name1').setValue('');
			                _this.getForm().findField('ctype').setValue('');
			                _this.getForm().findField('adr01').setValue('');
			                _this.getForm().findField('loekz').setValue('');
			                _this.getForm().findField('exchg').setValue('');
			                _this.getForm().findField('deamt').setValue('');
			               //_this.getForm().findField('reman').setValue('');
							//o.markInvalid('Could not find CPV no : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		_this.pettyDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigPetty.setValue(record.data.remnr);
			_this.getForm().findField('lifnr').setValue(record.data.lifnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			
			var v = record.data.remnr;
			if(Ext.isEmpty(v)) return;
				Ext.Ajax.request({
					url: __site_url+'pettyreim/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							_this.getForm().findField('adr01').setValue(r.data.adr01);
			                _this.getForm().findField('ctype').setValue(r.data.ctype);
			                _this.getForm().findField('loekz').setValue(r.data.loekz);
			                _this.getForm().findField('exchg').setValue(r.data.exchg);
			                _this.getForm().findField('deamt').setValue(r.data.netwr);
			                //_this.getForm().findField('reman').setValue(r.data.reman);
			        var petty = _this.numberPetty.getValue();
		            Ext.Ajax.request({
					url: __site_url+'pettyexpense/load_remain',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							_this.numberRemain.setValue(r.data);
							//_this.numberPetty2.setValue(r.data);
						}else{
							_this.numberRemain.setValue(petty);
							//_this.numberPetty2.setValue(petty);
							//o.markInvalid('Could not find Remain Amount : '+o.getValue());
						}
					}
				});
						}
					}
				});
			 
			grid.getSelectionModel().deselectAll();

			_this.pettyDialog.hide();
		});
		
		this.trigPetty.onTriggerClick = function(){
			_this.pettyDialog.grid.load();
			_this.pettyDialog.show();
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
			                _this.getForm().findField('taxnr').setValue(r.data.taxnr);
						}else{
							_this.getForm().findField('name1').setValue('');
							_this.getForm().findField('adr01').setValue('');
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
			                _this.getForm().findField('taxnr').setValue(r.data.taxnr);
						}
					}
				});

			grid.getSelectionModel().deselectAll();
			_this.vendorDialog.hide();
		});

		this.trigVendor.onTriggerClick = function(){
			_this.vendorDialog.grid.load();
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
			rc.set('ctype', record.data.ctype);
		    });
		    _this.gridItem.curValue = record.data.ctype;
			grid.getSelectionModel().deselectAll();
			_this.currencyDialog.hide();
		});

		this.trigCurrency.onTriggerClick = function(){
			_this.currencyDialog.grid.load();
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
		//this.numberWHT.on('change', this.calculateTotal, this);
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
            	disit:sel.get('disit'),
            	vvat:this.numberVat.getValue(),
            	vwht:sel.get('whtpr'),
            	vat:sel.get('chk01'),
            	//wht:sel.get('chk02'),
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
			url:__site_url+'pettyexpense/load',
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
			url:__site_url+'pettyexpense/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	reset: function(){
		this.getForm().reset();
		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ invnr: 0 });
		this.gridGL.load({ netpr: 0 });
		
		// สร้างรายการเปล่า 5 รายการใน grid item
		//this.gridItem.addDefaultRecord();

		// default status = wait for approve
		this.comboQStatus.setValue('01');
		this.comboTax.setValue('01');
		this.trigCurrency.setValue('THB');
		this.numberVat.setValue(7);
		//this.numberWHT.setValue(3);
		this.getForm().findField('bldat').setValue(new Date());
		this.formTotal.getForm().findField('exchg').setValue('1.0000');
		this.formTotalthb.getForm().findField('exchg2').setValue('1.0000');
		this.formTotal.getForm().findField('bbb').setValue('0.00');
		this.formTotal.getForm().findField('netwr').setValue('0.00');
	},
	
	// calculate total functions
	calculateTotal: function(){
		var _this=this;
		var store = this.gridItem.store;
		var sum = 0;var vats=0;sum2=0;amt_deamt=0;
		var whts=0;var discounts=0;
		var saknr_list = [];
		var vattype = this.comboTax.getValue();
		var currency = this.trigCurrency.getValue();
		var rate = this.formTotal.txtRate.getValue();
		//var deamt = this.numberPetty.getValue();
		store.each(function(r){
			var qty = parseFloat(r.data['menge']),
				price = parseFloat(r.data['unitp']),
				discountValue = 0,
				discount = r.data['disit'];
			qty = isNaN(qty)?0:qty;
			price = isNaN(price)?0:price;
			//discount = isNaN(discount)?0:discount;

			var amt = qty * price;//) - discount;
			
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
            sum2+=amt;
            
			if(r.data['chk01']==true){
				var vat = _this.numberVat.getValue();
				    vat = (amt * vat) / 100;
				    vats += vat;
			}
			var whtpr = r.data['whtpr'];
			    if(whtpr!='' && whtpr!=null){
				    whtpr = whtpr.replace('%','');
				    wht = (amt * whtpr) / 100;
				    whts += wht;
				   }
			if(currency != 'THB'){
				amt = amt * rate;
			}
			var item = r.data['saknr'] + '|' + amt;
        		saknr_list.push(item);
		});

		var remain = this.numberRemain.getValue();
		var petty = sum2;
		petty = petty + vats;
		petty = petty - whts;
		//this.numberRemain.setValue(petty);
		this.formTotal.getForm().findField('beamt').setValue(sum);
		this.formTotal.getForm().findField('vat01').setValue(vats);
		this.formTotal.getForm().findField('wht01').setValue(whts);
		this.formTotal.getForm().findField('dismt').setValue(discounts);
        var net = this.formTotal.calculate();
// Set value to total form
		this.formTotal.taxType = this.comboTax.getValue();
		this.gridItem.vatValue = this.numberVat.getValue();
		
		//var currency = this.trigCurrency.getValue();
		this.gridItem.curValue = currency;
		this.gridItem.remainValue = remain;
		this.gridItem.sumValue = petty;
		this.formTotal.getForm().findField('curr1').setValue(currency);
		this.formTotalthb.getForm().findField('curr2').setValue(currency);
		this.gridItem.vendorValue = this.trigVendor.getValue();

// Set value to GL Posting grid 
		//sum2 = sum2 - deamt;
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
		this.formTotalthb.getForm().findField('exchg2').setValue(rate);
		var net2 = this.formTotalthb.calculate();
		
        if(sum>0 && this.trigVendor.getValue()!=''){
            _this.gridGL.load({
            	netpr:sum2,
            	vvat:vats,
            	vwht:whts,
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
            	unitp:sel.get('unitp'),
            	disit:sel.get('disit'),
            	vvat:this.numberVat.getValue(),
            	vwht:sel.get('whtpr'),
            	vat:sel.get('chk01'),
            	//wht:sel.get('chk02'),
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

});