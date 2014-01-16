Ext.define('Account.PO.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'po/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.prDialog = Ext.create('Account.SPR.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
		
		this.vendorDialog = Ext.create('Account.SVendor.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});

		this.gridItem = Ext.create('Account.PO.Item.Grid_i',{
			height: 320,
			region:'center'
		});
		this.formTotal = Ext.create('Account.PR.Item.Form_t', {
			title:'PO Total',
			border: true,
			split: true,
			region:'south'
		});
		this.formTotalthb = Ext.create('Account.PR.Item.Form_thb', {
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

/*---ComboBox Tax Type----------------------------*/
		this.comboTax = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Vat Type',
			name: 'taxnr',
			labelAlign: 'right',
			width: 240,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select data --',
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
			readOnly: true,
			valueField: 'taxnr'
		});	
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			readOnly: !UMS.CAN.APPROVE('PO'),
			fieldLabel: 'PO Status',
			name : 'statu',
			labelAlign: 'right',
			width: 240,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			//margin: '0 0 0 -17',
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
			readOnly: true,
			valueField: 'statu'
		});
/*---ComboBox Payment type----------------------------*/
		this.comboPay = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Payments',
			name : 'ptype',
			width: 280,
			editable: false,
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please Select Payments --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'quotation/loads_tcombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'ptype'
					}
				},
				fields: [
					'ptype',
					'paytx'
				],
				remoteSort: true,
				sorters: 'ptype ASC'
			}),
			queryMode: 'remote',
			displayField: 'paytx',
			readOnly: true,
			valueField: 'ptype'
		});
/*-------------------------------*/			
		this.hdnPoItem = Ext.create('Ext.form.Hidden', {
			name: 'ekpo',
		});

        this.trigPR = Ext.create('Ext.form.field.Trigger', {
			name: 'purnr',
			fieldLabel: 'PR No',
			labelAlign: 'letf',
			//width:240,
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});
		
		this.trigVender = Ext.create('Ext.form.field.Trigger', {
			name: 'lifnr',
			fieldLabel: 'Vendor Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			readOnly: true,
			allowBlank : false
		});
		
		this.numberCredit = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'Credit Terms',
			name: 'terms',
			labelAlign: 'right',
			width:170,
			hideTrigger:false,
			readOnly: true,
			align: 'right'
         });
         
         this.trigCurrency = Ext.create('Ext.form.field.Trigger', {
			name: 'ctype',
			fieldLabel: 'Currency',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			width: 240,
			//margin: '0 0 0 6',
			labelAlign: 'right',
			readOnly: true,
			allowBlank : false
		});

         this.numberVat = Ext.create('Ext.ux.form.NumericField', {
           // xtype: 'numberfield',
			fieldLabel: 'Vat Value',
			name: 'taxpr',
			labelAlign: 'right',
			width:170,
			readOnly: true,
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
			items: [this.hdnPoItem,
			{
				xtype:'fieldset',
				title: 'Heading Data',
				collapsible: true,
				items:[{
	 				xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
		 			items :[{
						xtype: 'hidden',
						name: 'id'
					},{
						xtype: 'hidden',
						name: 'loekz'
					},this.trigPR,{
						xtype: 'displayfield',
						fieldLabel: 'Purchase Order',
						name: 'ebeln',
						value: 'POXXXX-XXXX',
						width:232,
						readOnly: true,
						labelStyle: 'font-weight:bold',
						margin: '0 0 0 292',
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
				 			items :[this.trigVender,{
								xtype: 'displayfield',
								name: 'name1',
								margins: '0 0 0 6',
								width:160,
								allowBlank: true 
			                }]
						}, {
							xtype: 'textarea',
							fieldLabel: 'Vendor Address',
							readOnly: true,
							name: 'adr01',
							width: 450, 
							rows:3,
		                }, {xtype: 'container',
							layout: 'hbox',
							margin: '0 0 5 0',
				 			items :[this.comboPay,this.numberVat]
				 			},{
			 				xtype: 'container',
							layout: 'hbox',
							margin: '0 0 5 0',
				 			items :[{
								xtype: 'textfield',
								fieldLabel: 'Reference No',
								width: 280, 
								name: 'refnr',
			                },this.numberCredit,{
						xtype: 'displayfield',
						margin: '0 0 0 5',
						width:25,
						value: 'Days'
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
							fieldLabel: 'PO Date',
							name: 'bldat',
							labelAlign: 'right',
							width:240,
							format:'d/m/Y',
							altFormats:'Y-m-d|d/m/Y',
							submitFormat:'Y-m-d',
							allowBlank: false
		                }, {
							xtype: 'datefield',
							fieldLabel: 'Delivery Date',
							name: 'lfdat',
							labelAlign: 'right',
							width:240,
							format:'d/m/Y',
							altFormats:'Y-m-d|d/m/Y',
							submitFormat:'Y-m-d',
							allowBlank: false
                		}, this.comboTax,
                		this.trigCurrency,
					    this.comboQStatus]
		            }]
				}]

			}]
		};
		
		this.items = [
			mainFormPanel,
			this.gridItem,
			{
			xtype:'tabpanel',
			region:'south',
			activeTab: 0,
			height:170,
			items: [
				this.formTotal,
				this.formTotalthb,
				this.gridPrice
			]
		}
			
		];		

		// event trigVender///
		this.trigVender.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'vendor/load2',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.lifnr);
							_this.getForm().findField('name1').setValue(r.data.name1);
							_this.getForm().findField('adr01').setValue(r.data.adr01);
						    _this.getForm().findField('terms').setValue(r.data.terms);
			                _this.getForm().findField('ptype').setValue(r.data.ptype);
			                _this.getForm().findField('taxnr').setValue(r.data.taxnr);
						}else{
							o.markInvalid('Could not find Vendor code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.vendorDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigVender.setValue(record.data.lifnr);
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

		this.trigVender.onTriggerClick = function(){
			_this.vendorDialog.show();
		};

		// event trigQuotation///
		this.trigPR.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'pr/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.purnr);
							_this.getForm().findField('lifnr').setValue(r.data.lifnr);
							_this.getForm().findField('name1').setValue(r.data.name1);			
						    _this.getForm().findField('terms').setValue(r.data.terms);
			                _this.getForm().findField('ptype').setValue(r.data.ptype);
			                _this.getForm().findField('taxnr').setValue(r.data.taxnr);
			                _this.getForm().findField('taxpr').setValue(r.data.taxpr);
			                _this.getForm().findField('ctype').setValue(r.data.ctype);
			                _this.getForm().findField('adr01').setValue(r.data.adr01);
			                _this.getForm().findField('loekz').setValue(r.data.loekz);
						}else{
							o.markInvalid('Could not find Purchase no : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		_this.prDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigPR.setValue(record.data.purnr);
			_this.getForm().findField('lifnr').setValue(record.data.lifnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			
			var v = record.data.purnr;
			if(Ext.isEmpty(v)) return;
				Ext.Ajax.request({
					url: __site_url+'pr/load',
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
			                _this.getForm().findField('taxpr').setValue(r.data.taxpr);
			                _this.getForm().findField('ctype').setValue(r.data.ctype);
			                _this.getForm().findField('loekz').setValue(r.data.loekz);
						}
					}
				});
			 
			grid.getSelectionModel().deselectAll();
			//---Load PRitem to POitem Grid-----------
			var grdpurnr = _this.trigPR.value;
			//alert(grdpurnr);
			_this.gridItem.load({grdpurnr: grdpurnr });
			//----------------------------------------
			_this.prDialog.hide();
		});

		
		this.trigPR.onTriggerClick = function(){
			_this.prDialog.show();
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
            	vat:sel.get('chk01')
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
			url:__site_url+'po/load',
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
		this.hdnPoItem.setValue(Ext.encode(rsItem));
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
	
	remove : function(ebeln){
		var _this=this;
		this.getForm().load({
			params: { ebeln: ebeln },
			url:__site_url+'po/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ ebeln: 0 });
		//this.gridPayment.load({ vbeln: 0 });

		// default status = wait for approve
		this.comboQStatus.setValue('01');
		this.comboTax.setValue('01');
		this.trigCurrency.setValue('THB');
		this.numberVat.setValue(7);
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
		var sum = 0;var vats=0;var i=0;discounts=0;
		var vattype = this.comboTax.getValue();
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
            
		if(r.data['chk01']==true){
				var vat = _this.numberVat.getValue();
				    vat = (amt * vat) / 100;
				    vats += vat;
			}
		});
		this.formTotal.getForm().findField('beamt').setValue(sum);
		this.formTotal.getForm().findField('vat01').setValue(vats);
		this.formTotal.getForm().findField('dismt').setValue(discounts);
		this.formTotal.calculate();
		
		this.gridItem.vattValue = this.comboTax.getValue();
		this.gridItem.vatValue = this.numberVat.getValue();
		var currency = this.trigCurrency.getValue();
		this.gridItem.curValue = currency;
		this.formTotal.getForm().findField('curr1').setValue(currency);
		this.formTotalthb.getForm().findField('curr2').setValue(currency);
		this.formTotal.getForm().findField('vat01').setValue(vats);
		
		var rate = this.formTotal.txtRate.getValue();
		if(currency != 'THB'){
	      //alert(rate);
		  sum = sum * rate;
		  vats = vats * rate;
		  discounts = discounts * rate;
		}  
		
		this.formTotalthb.getForm().findField('beamt2').setValue(sum);
		this.formTotalthb.getForm().findField('vat02').setValue(vats);
		this.formTotalthb.getForm().findField('dismt2').setValue(discounts);
		this.formTotalthb.getForm().findField('exchg2').setValue(rate);
		var net2 = this.formTotalthb.calculate();
	  
	  // Set value to Condition Price grid
        var sel = this.gridItem.getView().getSelectionModel().getSelection()[0];
        if (sel) {
        	//_this.gridPrice.store.removeAll();
            _this.gridPrice.load({
            	menge:sel.get('menge').replace(/[^0-9.]/g, ''),
            	unitp:sel.get('unitp').replace(/[^0-9.]/g, ''),
            	disit:sel.get('disit'),
            	vvat:this.numberVat.getValue(),
            	vat:sel.get('chk01'),
            	vattype:vattype
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