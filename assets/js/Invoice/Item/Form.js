Ext.define('Account.Invoice.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'invoice/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.doDialog = Ext.create('Account.SSaledelivery.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly:true
		});
		// INIT Customer search popup ///////////////////////////////
		//this.soDialog = Ext.create('Account.Saleorder.MainWindow');
		//this.customerDialog = Ext.create('Account.SCustomer.MainWindow', {
		//	disableGridDoubleClick: true,
		//	isApproveOnly:true
		//});
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
			enableKeyEvents: true//,
			//allowBlank : false
		});
		
		this.currencyDialog = Ext.create('Account.SCurrency.MainWindow');

		this.gridItem = Ext.create('Account.Invoice.Item.Grid_i',{
			title:'Invoice Items',
			height: 320,
			region:'center'
		});
		this.gridPayment = Ext.create('Account.Invoice.Item.Grid_p',{
			border: true,
			region:'center'
		});
		this.gridGL = Ext.create('Account.Invoice.Item.Grid_gl',{
			border: true,
			region:'center',
			title: 'GL Posting'
		});
		this.formTotal = Ext.create('Account.Quotation.Item.Form_t',{
			border: true,
			split: true,
			title:'Total->Invoice',
			region:'south'
		});
		this.formTotalthb = Ext.create('Account.Quotation.Item.Form_thb', {
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

		this.comboQStatus = Ext.create('Ext.form.ComboBox',{
			readOnly: !UMS.CAN.APPROVE('IV'),
			fieldLabel: 'INV Status',
			name : 'statu',
			labelAlign: 'right',
			//labelWidth: 95,
			width: 240,
			margin: '0 0 0 5',
			//allowBlank : false,
			triggerAction : 'all',
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
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			//emptyText: '-- Please Select Payments --',
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

		this.comboCond = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Condition',
			name : 'condi',
			width: 240,
			margin: '0 0 0 5',
			editable: false,
			labelAlign: 'right',
			triggerAction : 'all',
			clearFilterOnReset: true,
			//emptyText: '-- Please Select Condition --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'invoice/loads_condcombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'condi'
					}
				},
				fields: [
					'condi',
					'contx'
				],
				remoteSort: true,
				sorters: 'ptype ASC'
			}),
			queryMode: 'remote',
			value: '01',
			displayField: 'contx',
			valueField: 'condi'
		});

		this.comboTax = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Vat type',
			name : 'taxnr',
			width: 240,
			margin: '0 0 0 20',
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
			value: '01',
			valueField: 'taxnr'
		});

         this.numberVat = Ext.create('Ext.form.field.Number', {
			fieldLabel: 'Vat Value',
			name: 'taxpr',
			labelAlign: 'right',
			width:200,
			align: 'right',
			margin: '0 0 0 25'
         });

        this.trigDO = Ext.create('Ext.form.field.Trigger', {
			name: 'delnr',
			fieldLabel: 'Delivery No',
			labelAlign: 'letf',
			width:240,
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});

		this.trigCustomer = Ext.create('Ext.form.TextField', {
			name: 'kunnr',
			labelAlign: 'letf',
			width:240,
			fieldLabel: 'Customer Code',
			//triggerCls: 'x-form-search-trigger',
			//enableKeyEvents: true,
			readOnly: true,
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

		this.numberCredit = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'Credit Terms',
			name: 'terms',
			labelAlign: 'right',
			width:200,
			hideTrigger:false,
			align: 'right',
			margin: '0 0 0 25',
			allowDecimals: false,
			minValue:0
         });

		this.hdnIvItem = Ext.create('Ext.form.Hidden', {
			name: 'vbrp'
		});

		this.hdnGlItem = Ext.create('Ext.form.Hidden', {
			name: 'bcus',
		});
		
		this.hdnPpItem = Ext.create('Ext.form.Hidden', {
			name: 'payp',
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
			items: [this.hdnIvItem,this.hdnGlItem,this.hdnPpItem,
			{
			xtype:'fieldset',
            title: 'Heading Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
// Quotation Code
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
		},{
			xtype: 'hidden',
			name: 'whtgp'
		},{
			xtype: 'hidden',
			name: 'vbeln'
		 },this.trigDO,{
			xtype: 'displayfield',
			//name: 'jobtx',
			width:110,
			margins: '0 0 0 6',
            //emptyText: 'Customer',
            allowBlank: true
		},{
			xtype: 'displayfield',
            fieldLabel: 'Invoice No',
            name: 'invnr',
            value: 'IVXXXX-XXXX',
            labelAlign: 'right',
			width:240,
            readOnly: true,
			labelStyle: 'font-weight:bold'
		},{
			xtype: 'datefield',
			fieldLabel: 'Doc Date',
			name: 'bldat',
			labelAlign: 'right',
			width:240,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			allowBlank: false
		}]

// Customer Code
		},{
            xtype: 'container',
            layout: 'hbox',
            margin: '0 0 5 0',
     items :[this.trigCustomer,{
			xtype: 'displayfield',
			name: 'name1',
			margins: '0 0 0 6',
			width:350,
            allowBlank: true
		},this.trigCurrency]
// Address Bill&Ship
		},{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [{
			xtype: 'textarea',
			fieldLabel: 'Bill To',
			name: 'adr01',
			width:350,
			rows:3,
			readOnly: true,
			editable: false,
			labelAlign: 'top'
		},{
            xtype: 'textarea',
			fieldLabel: 'Ship To',
			name: 'adr02',
			width:355,
			rows:3,
			labelAlign: 'top',
			readOnly: true,
			editable: false,
			margin: '0 0 0 130'
         }]
// Sale Person
         },{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [this.trigSale,{
			xtype: 'displayfield',
			name: 'emnam',
			width:174,
			margins: '0 0 0 6'
		},this.numberCredit,{
			xtype: 'displayfield',
			margin: '0 0 0 5',
			width:10,
			value: 'Days'
		}
		,this.comboCond
		]
// Tax&Ref no.
         },{
         xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [this.comboPay,
          {
			xtype: 'datefield',
			fieldLabel: 'Due Date',
			name: 'duedt',
			labelAlign: 'right',
			width:200,
			margin: '0 0 0 25',
			//readOnly: true,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
		},this.comboTax
         ]
         },{
         xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [{
					xtype: 'textfield',
					fieldLabel: 'Reference No',
					name: 'refnr',
					maxValue: 50,
					width:350
				   },this.numberVat,{
			       xtype: 'displayfield',
			       align: 'right',
			       width:10,
			       margin: '0 0 0 5',
			       value: '%'
		          },this.comboQStatus
         ]
        }]
		}]
		};

		this.items = [mainFormPanel,{
			xtype:'tabpanel',
			region:'center',
			activeTab: 0,
			border: false,
			items: [this.gridItem,
			{
				xtype: 'panel',
				border: false,
				title: 'Partial Receipt',
				layout: 'border',
				items:[
					this.gridPayment
				]
			  }]
			},
		{
			xtype:'tabpanel',
			region:'south',
			activeTab: 0,
			height:220,
			items: [
				this.formTotal,
				this.formTotalthb,
				this.gridPrice,
				this.gridGL
			]
		}

		];

		// event trigQuotation///
		this.trigDO.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'saledelivery/load',
					method: 'POST',
					params: {
						id: v,
						key: 1
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.delnr);
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
			_this.getForm().findField('loekz').setValue(r.data.loekz);
			_this.getForm().findField('exchg').setValue(r.data.exchg);
			_this.getForm().findField('emnam').setValue(r.data.emnam);
			_this.getForm().findField('vbeln').setValue(r.data.vbeln);
			_this.formTotal.getForm().findField('dispc').setValue(r.data.dispc);
			if(r.data.taxnr=='03' || r.data.taxnr=='04'){
			      _this.numberVat.disable();
			}else{_this.numberVat.enable();}

			//---Load PRitem to POitem Grid-----------
			var donr = _this.trigDO.value;
			_this.gridItem.load({donr: donr });
			_this.gridPayment.setqtCode(r.data.vbeln);
			//----------------------------------------
						}else{
							o.setValue('');
			_this.getForm().findField('kunnr').setValue('');
			_this.getForm().findField('name1').setValue('');
			_this.getForm().findField('salnr').setValue('');
			_this.getForm().findField('ptype').setValue('');
			_this.getForm().findField('taxnr').setValue('');
			_this.getForm().findField('terms').setValue('');
			_this.getForm().findField('adr01').setValue('');
			_this.getForm().findField('adr02').setValue('');
			_this.getForm().findField('ctype').setValue('');
			_this.getForm().findField('taxpr').setValue('');
			_this.getForm().findField('loekz').setValue('');
			_this.getForm().findField('exchg').setValue('');
			_this.getForm().findField('emnam').setValue('');
			_this.getForm().findField('vbeln').setValue('');
			_this.formTotal.getForm().findField('dispc').setValue('');
			_this.numberVat.enable();
			//o.markInvalid('Could not find delivery order no : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.doDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigDO.setValue(record.data.delnr);

			_this.getForm().findField('kunnr').setValue(record.data.kunnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			_this.getForm().findField('salnr').setValue(record.data.salnr);
			_this.getForm().findField('ptype').setValue(record.data.ptype);
			_this.getForm().findField('taxnr').setValue(record.data.taxnr);
			_this.getForm().findField('terms').setValue(record.data.terms);

            Ext.Ajax.request({
					url: __site_url+'saledelivery/load',
					method: 'POST',
					params: {
						id: record.data.delnr
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
			_this.getForm().findField('adr01').setValue(r.data.adr01);
			_this.getForm().findField('adr02').setValue(r.data.adr02);
			_this.getForm().findField('ctype').setValue(r.data.ctype);
			_this.getForm().findField('taxpr').setValue(r.data.taxpr);
			_this.getForm().findField('loekz').setValue(r.data.loekz);
			_this.getForm().findField('exchg').setValue(r.data.exchg);
			_this.getForm().findField('emnam').setValue(r.data.emnam);
			_this.getForm().findField('vbeln').setValue(r.data.vbeln);
			_this.formTotal.getForm().findField('dispc').setValue(r.data.dispc);
			if(r.data.taxnr=='03' || r.data.taxnr=='04'){
			      _this.numberVat.disable();
			}else{_this.numberVat.enable();}

			_this.gridPayment.setqtCode(r.data.vbeln);
			       }
				}
				});

			grid.getSelectionModel().deselectAll();
			//---Load PRitem to POitem Grid-----------
			var donr = _this.trigDO.value;
			_this.gridItem.load({donr: donr });
			//----------------------------------------
			_this.doDialog.hide();
		});

		this.trigDO.onTriggerClick = function(){
			_this.doDialog.grid.load();
			_this.doDialog.show();
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
						salnr: v,
						key: 1
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.salnr);
							_this.getForm().findField('emnam').setValue(r.data.name1);
							
						}else{
							o.setValue('');
							_this.getForm().findField('emnam').setValue('');
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
			_this.saleDialog.show();
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


	// grid event
		this.gridItem.store.on('update', this.calculateTotal, this);
		this.gridItem.store.on('load', this.calculateTotal, this);
		this.gridPayment.store.on('update', this.calculateTotal, this);
		this.gridPayment.store.on('load', this.calculateTotal, this);
		this.on('afterLoad', this.calculateTotal, this);
		this.gridItem.getSelectionModel().on('selectionchange', this.onSelectChange, this);
		this.gridItem.getSelectionModel().on('viewready', this.onViewReady, this);
		//this.comboPay.on('select', this.selectPay, this);
        this.numberCredit.on('keyup', this.getDuedate, this);
		this.numberCredit.on('change', this.getDuedate, this);
		this.comboTax.on('change', this.calculateTotal, this);
		this.comboTax.on('select', this.selectTax, this);
		this.trigCurrency.on('change', this.changeCurrency, this);
		this.formTotal.txtRate.on('keyup', this.calculateTotal, this);
		this.formTotal.txtRate.on('change', this.calculateTotal, this);
		this.formTotal.txtDiscount.on('keyup', this.calculateTotal, this);
		this.numberVat.on('change', this.calculateTotal, this);
		
		return this.callParent(arguments);
	},

	onSelectChange: function(selModel, selections){
		var _this=this;
		var sel = this.gridItem.getView().getSelectionModel().getSelection()[0];
        //var id = sel.data[sel.idField.name];
        if (sel) {
            _this.gridPrice.load({
            	menge:parseFloat(sel.get('menge')),
            	unitp:parseFloat(sel.get('unitp')),
            	disit:sel.get('disit'),
            	vvat:this.numberVat.getValue(),
            	vwht:sel.get('whtpr'),
            	vat:sel.get('chk01'),
            	//wht:sel.get('whtpr'),
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
			url:__site_url+'invoice/load',
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
		this.hdnIvItem.setValue(Ext.encode(rsItem));

		var rsGL = _this.gridGL.getData();
		this.hdnGlItem.setValue(Ext.encode(rsGL));
		
		var rsPayment = _this.gridPayment.getData();
		this.hdnPpItem.setValue(Ext.encode(rsPayment));

		if (_form_basic.isValid()) {
			_form_basic.submit({
				success: function(form_basic, action) {
					_this.reset();
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
			url:__site_url+'invoice/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ invnr: 0 });
		this.gridGL.load({ netpr:0 });
		this.gridPrice.load({ belnr: 0 });
		this.gridPayment.load({ invnr: 0 });

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
		this.formTotal.getForm().findField('dispc').setValue('0.00');
		this.formTotal.getForm().findField('netwr').setValue('0.00');
	},

	// calculate total functions
	calculateTotal: function(){
		var _this=this;
		var store = this.gridItem.store;
		var store2 = this.gridPayment.store;
		var sum = 0;var vats=0;sum2=0;
		var whts=0;var discounts=0;
		var saknr_list = [];var netwr=0;var netwr2=0;
		var vattype = this.comboTax.getValue();
		var currency = this.trigCurrency.getValue();
		//var deamt = this.formTotal.getForm().findField('deamt').getValue();
		var rate = this.formTotal.getForm().findField('exchg').getValue();
		if(store2.count()>0){
		    store2.each(function(r){
			//par_amt = parseFloat(v.data['pramt'].replace(/[^0-9.]/g, '')),
				//discountValue = 0,
			percent = r.data['perct'];
				
            store.each(function(r){
			var qty = parseFloat(r.data['menge']),
				price = parseFloat(r.data['unitp']),
				discountValue = 0,
				discount = r.data['disit'];
			qty = isNaN(qty)?0:qty;
			price = isNaN(price)?0:price;
			//discount = isNaN(discount)?0:discount;

			var amt = qty * price;
			
			if(vattype =='02'){
				amt = amt * 100;
			    amt = amt / 107;
		    }
		  
		    if(isNaN(discount) && discount!='0.00'){
			if(discount.match(/%$/gi)){
				discount = discount.replace('%','');
				var discountPercent = parseFloat(discount);
				discountValue = amt * discountPercent / 100;
			}else{
				discountValue = parseFloat(discount);
			}
			discountValue = isNaN(discountValue)?0:discountValue;
			}
			
			netwr += amt;
			//netwr = netwr;// - discountValue;
			
			if(isNaN(percent) && percent!='0.00'){
				var per2 = percent;
		    if(per2.match(/%$/gi)){
		    	//alert(percent);
				per2 = per2.replace('%','');
				var percentPercent = parseFloat(per2);
				amt = amt * percentPercent / 100;
				discountValue=discountValue * percentPercent / 100;
			}//else{
				//netwr = par2;
				//amt = par2;
			//}
			}
			//alert('aaa'+amt);
			sum += amt;
			
			discounts += discountValue;
            
            amt = amt - discountValue;
            
			sum2+=amt;
			
			if(r.data['chk01']==true){
				var vat = _this.numberVat.getValue();
				    vat = (amt * vat) / 100;
				    vats += vat;
			}
			//if(r.data['chk02']==true){
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
	    	});
		}else{
			store.each(function(r){
			var qty = parseFloat(r.data['menge']),
				price = parseFloat(r.data['unitp']),
				discountValue = 0,
				discount = r.data['disit'];
			qty = isNaN(qty)?0:qty;
			price = isNaN(price)?0:price;
			//discount = isNaN(discount)?0:discount;

			var amt = qty * price;
			
			if(vattype =='02'){
				amt = amt * 100;
			    amt = amt / 107;
		    }
		    
		    if(isNaN(discount) && discount!='0.00'){
			if(discount.match(/%$/gi)){
				discount = discount.replace('%','');
				var discountPercent = parseFloat(discount);
				discountValue = amt * discountPercent / 100;
			}else{
				discountValue = parseFloat(discount);
			}
			discountValue = isNaN(discountValue)?0:discountValue;
			}
			
			sum += amt;
			//alert(amt+'aaa'+sum);
			discounts += discountValue;
            
            amt = amt - discountValue;
            sum2+=amt;
            			
			if(r.data['chk01']==true){
				var vat = _this.numberVat.getValue();
				    vat = (amt * vat) / 100;
				    vats += vat;
			}
			//if(r.data['chk02']==true){
				var whtpr = r.data['whtpr']
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
		}
		
		var tdisc = this.formTotal.txtDiscount.getValue();
		var vat = _this.numberVat.getValue();
        vat = (tdisc * vat) / 100;
        vats = vats - vat;
		this.formTotal.getForm().findField('beamt').setValue(sum);
		this.formTotal.getForm().findField('vat01').setValue(vats);
		this.formTotal.getForm().findField('wht01').setValue(whts);
		this.formTotal.getForm().findField('dismt').setValue(discounts);
        var net = this.formTotal.calculate();
// Set value to total form
		this.formTotal.taxType = this.comboTax.getValue();
		this.gridItem.vatValue = this.numberVat.getValue();

		this.gridItem.curValue = currency;
		netwr = netwr - tdisc;
		this.gridPayment.netValue = netwr;
		this.formTotal.getForm().findField('curr1').setValue(currency);
		this.formTotalthb.getForm().findField('curr2').setValue(currency);
		this.gridItem.customerValue = this.trigCustomer.getValue();

// Set value to GL Posting grid
		if(currency != 'THB'){
		  sum = sum * rate;
		  sum2 = sum2 * rate;
		  vats = vats * rate;
		  whts = whts * rate;
		  discounts = discounts * rate;
		  tdisc = tdisc * rate;
		}
		this.formTotalthb.getForm().findField('beamt2').setValue(sum);
		this.formTotalthb.getForm().findField('vat02').setValue(vats);
		this.formTotalthb.getForm().findField('wht02').setValue(whts);
		this.formTotalthb.getForm().findField('dismt2').setValue(discounts);
		this.formTotalthb.getForm().findField('exchg2').setValue(rate);
		this.formTotalthb.getForm().findField('dispc2').setValue(tdisc);
		var net2 = this.formTotalthb.calculate();

        if(this.trigCustomer.getValue()!=''){
            _this.gridGL.load({
            	netpr:sum2,
            	vvat:vats,
            	vdis:tdisc,
            	kunnr:this.trigCustomer.getValue(),
            	items: saknr_list.join(',')
            });
           }

// Set value to Condition Price grid
        var sel = this.gridItem.getView().getSelectionModel().getSelection()[0];
        if (sel) {
        	//_this.gridPrice.store.removeAll();
            _this.gridPrice.load({
            	menge:parseFloat(sel.get('menge')),
            	unitp:parseFloat(sel.get('unitp')),
            	disit:sel.get('disit'),
            	vvat:this.numberVat.getValue(),
            	vwht:sel.get('whtpr'),
            	vat:sel.get('chk01'),
            	//wht:sel.get('whtpr'),
            	vattype:this.comboTax.getValue()
            });
        }
	},

	// Add duedate functions
	getDuedate: function(){
		var bForm = this.getForm(),
			credit = this.numberCredit.getValue(),
			startDate = bForm.findField('bldat').getValue();
		if(!Ext.isEmpty(credit) && credit>0){
			var result = Ext.Date.add(startDate, Ext.Date.DAY, credit),
				dueDateField = bForm.findField('duedt');

			if(!Ext.isEmpty(credit) && !Ext.isEmpty(dueDateField))
				dueDateField.setValue(result);
		}
	},
	
	changeCurrency: function(){
		var _this=this;
		var store = this.gridItem.store;
		var store2 = this.gridPayment.store;
		var currency = this.trigCurrency.getValue();
		store.each(function(r){
			r.set('ctyp1', currency);
		});
		store2.each(function(r){
			r.set('ctyp1', currency);
		});
	},
	
	// Tax Value
	selectTax: function(combo, record, index){
		var _this=this;
		if(combo.getValue()=='03' || combo.getValue()=='04'){
			this.numberVat.setValue(0);
			this.numberVat.disable();
		}else{this.numberVat.enable();}
	}
});
