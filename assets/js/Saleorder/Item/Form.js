Ext.define('Account.Saleorder.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'saleorder/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		// INIT other components ///////////////////////////////////
		this.quotationDialog = Ext.create('Account.Quotation.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
		this.customerDialog = Ext.create('Account.SCustomer.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
		this.saleDialog = Ext.create('Account.Saleperson.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
		this.trigSale = Ext.create('Ext.form.field.Trigger', {
			name: 'salnr',
			fieldLabel: 'Salesperson',
			triggerCls: 'x-form-search-trigger',
			//labelWidth: 100,
			labelAlign: 'left',
			width: 170,
			enableKeyEvents: true
		});
		this.currencyDialog = Ext.create('Account.SCurrency.MainWindow');

		this.gridItem = Ext.create('Account.Saleorder.Item.Grid_i',{
			height: 320,
			region:'center'
		});

		this.formTotal = Ext.create('Account.Saleorder.Item.Form_t', {
			border: true,
			split: true,
			title:'Total->SO',
			region:'south'
		});
		this.formTotalthb = Ext.create('Account.Saleorder.Item.Form_thb', {
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
			readOnly: !UMS.CAN.APPROVE('SO'),
			fieldLabel: 'SO Status',
			name : 'statu',
			labelAlign: 'right',
			width: 240,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			margin: '0 0 0 27',
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
			value: '01',
			valueField: 'statu'
		});

		this.comboPay = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Payments',
			name : 'ptype',
			width: 350,
			editable: false,
			allowBlank : false,
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
			valueField: 'ptype'
		});

		this.comboTax = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Vat Type',
			name : 'taxnr',
			width: 240,
			margin: '0 0 0 6',
			labelAlign: 'right',
			editable: false,
			allowBlank : false,
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
			value: '01',
			valueField: 'taxnr'
		});

		this.numberCredit = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'Credit Terms',
			name: 'terms',
			labelAlign: 'right',
			width:200,
			hideTrigger:false,
			align: 'right',
			margin: '0 0 0 35'
         });

	   this.whtDialog = Ext.create('Account.WHT.Window');
       this.trigWHT = Ext.create('Ext.form.field.Trigger', {
       	    fieldLabel: 'WHT Value',
			name: 'whtnr',
			labelAlign: 'right',
			width:150,
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			margin: '0 0 0 35'
		});
		
		this.numberWHT = Ext.create('Ext.form.field.Display', {
			name: 'whtpr',
			width:15,
			align: 'right',
			margin: '0 0 0 8'
         });

         this.numberVat = Ext.create('Ext.ux.form.NumericField', {
           // xtype: 'numberfield',
			fieldLabel: 'Vat Value',
			name: 'taxpr',
			labelAlign: 'right',
			width:200,
			align: 'right',
			margin: '0 0 0 35'
         });

		this.hdnSOItem = Ext.create('Ext.form.Hidden', {
			name: 'vbop',
		});

		this.trigQuotation = Ext.create('Ext.form.field.Trigger', {
			name: 'vbeln',
			fieldLabel: 'Quotation No.',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});

		this.trigCustomer = Ext.create('Ext.form.field.Trigger', {
			name: 'kunnr',
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
			width: 240,
			margin: '0 0 0 6',
			labelAlign: 'right',
			allowBlank : false
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
			items: [this.hdnSOItem,
			{
				xtype:'fieldset',
				title: 'Heading Data',
				collapsible: true,
				defaultType: 'textfield',
				layout: 'anchor',
				//defaults: {
				//	anchor: '100%'
				//},
				items:[{
					// Quotation Code
	 				xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
	 				items :[{
						xtype: 'hidden',
						name: 'id'
					},{
						xtype: 'hidden',
						name: 'loekz'
					},
					this.trigQuotation,
					{
						xtype: 'displayfield',
						name: 'name1',
						margins: '0 0 0 6',
						width:350,
						//emptyText: 'Customer',
						allowBlank: true
					},{
						xtype: 'displayfield',
						fieldLabel: 'SO No',
						name: 'ordnr',
						//flex: 3,
						value: 'SOXXXX-XXXX',
						labelAlign: 'right',
						//name: 'qt',
						width:240,
						readOnly: true,
						labelStyle: 'font-weight:bold'
						//disabled: true
					}]
				// Customer Code
				},{
					xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
					items :[this.trigCustomer,
					{
						xtype: 'displayfield',
						name: 'name1',
						margins: '0 0 0 6',
						width:350,
						//emptyText: 'Customer',
						allowBlank: true
					},{
						xtype: 'datefield',
						fieldLabel: 'Date',
						name: 'bldat',
						labelAlign: 'right',
						width:240,
						format:'d/m/Y',
						altFormats:'Y-m-d|d/m/Y',
						submitFormat:'Y-m-d',
						allowBlank: false
					}]
				// Address Bill&Ship
				},{
					xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
					items: [{
						xtype: 'textarea',
						fieldLabel: 'Bill To',
						name: 'adr01',
						width:350,
						rows:3,
						editable: false,
						labelAlign: 'top'
					},{
						xtype: 'textarea',
						fieldLabel: 'Ship To',
						name: 'adr02',
						width:355,
						rows:3,
						labelAlign: 'top',
						editable: false,
						margin: '0 0 0 140'
					 }]
				// Sale Person
				},{
					xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
					items: [this.trigSale,{
			xtype: 'displayfield',
			name: 'emnam',
			width:174,
			margins: '0 0 0 6'
		},
					this.numberCredit,{
						xtype: 'displayfield',
						margin: '0 0 0 5',
						width:10,
						value: 'Days'
					},this.trigCurrency
				]
             // Tax&Ref no.
			 },{
			 	xtype: 'container',
				layout: 'hbox',
				margin: '0 0 5 0',
				items: [this.comboPay,
				this.numberVat,{
			       xtype: 'displayfield',
			       align: 'right',
			       width:10,
			       margin: '0 0 0 5',
			       value: '%'
		           },this.comboTax]
				},{
			 	xtype: 'container',
				layout: 'hbox',
				margin: '0 0 5 0',
				items: [{
					xtype: 'textfield',
					fieldLabel: 'Reference No',
					name: 'refnr',
					width:350
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
				},this.comboQStatus]
				}]

			}]
		};

		this.items = [mainFormPanel,this.gridItem,
		{
			xtype:'tabpanel',
			region:'south',
			activeTab: 0,
			height:220,
			items: [
				this.formTotal,
				this.formTotalthb,
				this.gridPrice
			]
		}
		];

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
			                _this.getForm().findField('adr02').setValue(r.data.adr02);
						    _this.getForm().findField('terms').setValue(r.data.terms);
			                _this.getForm().findField('ptype').setValue(r.data.ptype);
			                _this.getForm().findField('taxnr').setValue(r.data.taxnr);
						}else{
							o.markInvalid('Could not find customer code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.customerDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigCustomer.setValue(record.data.kunnr);
			var v = record.data.kunnr;
			if(Ext.isEmpty(v)) return;
				Ext.Ajax.request({
					url: __site_url+'customer/load2',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							_this.getForm().findField('name1').setValue(r.data.name1);
							_this.getForm().findField('adr01').setValue(r.data.adr01);
			                _this.getForm().findField('adr02').setValue(r.data.adr02);
						    _this.getForm().findField('terms').setValue(r.data.terms);
			                _this.getForm().findField('ptype').setValue(r.data.ptype);
			                _this.getForm().findField('taxnr').setValue(r.data.taxnr);
						}
					}
				});

			grid.getSelectionModel().deselectAll();
			_this.customerDialog.hide();
		});

		this.trigCustomer.onTriggerClick = function(){
			_this.customerDialog.grid.load();
			_this.customerDialog.show();
		};
		
		// event Saleperson///
		this.trigSale.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'saleperson/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.salnr);
							_this.getForm().findField('emnam').setValue(r.data.emnam);
							
						}else{
							o.markInvalid('Could not find project owner : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.saleDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigSale.setValue(record.data.salnr);
			//alert(record.data.emnam);
			_this.getForm().findField('emnam').setValue(record.data.emnam);

			grid.getSelectionModel().deselectAll();
			_this.saleDialog.hide();
		});

		this.trigSale.onTriggerClick = function(){
			_this.saleDialog.grid.load();
			_this.saleDialog.show();
		};

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
			_this.getForm().findField('salnr').setValue(r.data.salnr);	
			_this.getForm().findField('ptype').setValue(r.data.ptype);	
			_this.getForm().findField('taxnr').setValue(r.data.taxnr);	
			_this.getForm().findField('terms').setValue(r.data.terms);	
			_this.getForm().findField('adr01').setValue(r.data.adr01);
			_this.getForm().findField('adr02').setValue(r.data.adr02);
			_this.getForm().findField('ctype').setValue(r.data.ctype);
			_this.getForm().findField('taxpr').setValue(r.data.taxpr);
			_this.getForm().findField('whtpr').setValue(r.data.whtpr);
			_this.getForm().findField('loekz').setValue(r.data.loekz);
			_this.formTotal.txtDepositValue.setValue(r.data.deamt);
			
			//---Load PRitem to POitem Grid-----------
			var qtnr = _this.trigQuotation.value;
			//alert(qtnr);
			_this.gridItem.load({qtnr: qtnr });
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
			_this.getForm().findField('salnr').setValue(record.data.salnr);
			_this.getForm().findField('ptype').setValue(record.data.ptype);
			_this.getForm().findField('taxnr').setValue(record.data.taxnr);
			_this.getForm().findField('terms').setValue(record.data.terms);
            
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
			_this.getForm().findField('adr02').setValue(r.data.adr02);
			_this.getForm().findField('ctype').setValue(r.data.ctype);
			_this.getForm().findField('taxpr').setValue(r.data.taxpr);
			_this.getForm().findField('whtpr').setValue(r.data.whtpr);
			_this.getForm().findField('loekz').setValue(r.data.loekz);
			_this.formTotal.txtDepositValue.setValue(r.data.deamt);
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
            	disit:sel.get('disit'),
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
			url:__site_url+'saleorder/load',
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
		this.hdnSOItem.setValue(Ext.encode(rsItem));

		if (_form_basic.isValid()) {
			_form_basic.submit({
				waitMsg: 'Save data...',
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
			url:__site_url+'saleorder/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ ordnr: 0 });
		//this.gridPayment.load({ vbeln: 0 });
		//this.gridPrice.load();

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
	// calculate total functions
	calculateTotal: function(){
		var _this=this;
		var store = this.gridItem.store;
		var sum = 0;var vats=0; var whts=0;var discounts=0;
		var vattype = this.comboTax.getValue();
		store.each(function(r){
			var qty = parseFloat(r.data['menge'].replace(/[^0-9.]/g, '')),
				price = parseFloat(r.data['unitp'].replace(/[^0-9.]/g, '')),
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

		// set value to grid payment
		//this.gridPayment.netValue = net;
		// set value to total form
		this.gridItem.vattValue = this.comboTax.getValue();
		this.gridItem.vatValue = this.numberVat.getValue();
		
		this.gridItem.whtValue = this.numberWHT.getValue();
		var currency = this.trigCurrency.getValue();
		this.gridItem.curValue = currency;
		this.formTotal.getForm().findField('curr1').setValue(currency);
		this.formTotalthb.getForm().findField('curr2').setValue(currency);
		this.gridItem.customerValue = this.trigCustomer.getValue();
		
		var rate = this.formTotal.txtRate.getValue();
		var deamt = this.formTotal.getForm().findField('deamt').getValue();
		if(currency != 'THB'){
	      //alert(rate);
		  sum = sum * rate;
		  vats = vats * rate;
		  whts = whts * rate;
		  discounts = discounts * rate;
		  deamt = deamt * rate;
		}  
		
		this.formTotalthb.getForm().findField('beamt2').setValue(sum);
		this.formTotalthb.getForm().findField('vat02').setValue(vats);
		this.formTotalthb.getForm().findField('wht02').setValue(whts);
		this.formTotalthb.getForm().findField('dismt2').setValue(discounts);
		this.formTotalthb.getForm().findField('exchg2').setValue(rate);
		this.formTotalthb.getForm().findField('deamt2').setValue(deamt);
		var net2 = this.formTotalthb.calculate();
        
        var sel = this.gridItem.getView().getSelectionModel().getSelection()[0];
        //var id = sel.data[sel.idField.name];
        if (sel) {
        	//_this.gridPrice.store.removeAll();
            _this.gridPrice.load({
            	menge:sel.get('menge').replace(/[^0-9.]/g, ''),
            	unitp:sel.get('unitp').replace(/[^0-9.]/g, ''),
            	disit:sel.get('disit'),
            	vvat:this.numberVat.getValue(),
            	vwht:this.numberWHT.getValue(),
            	vat:sel.get('chk01'),
            	wht:sel.get('chk02'),
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

	// select tax functions
	/*
	selectTax: function(combo, record, index){
		var store = this.gridItem.store;
		var vtax = combo.getValue();
		//alert(vtax);
		store.each(function(r){
			price = parseFloat(r.data['unitp']),
			      price = isNaN(price)?0:price;

			      var amt = price  / 1.07;
			      r.set('unitp', Ext.util.Format.usMoney(amt).replace(/\$/, ''));
		});
	}*/
});