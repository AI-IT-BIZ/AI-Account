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
		
		// INIT Customer search popup ///////////////////////////////
		this.soDialog = Ext.create('Account.Saleorder.MainWindow');
		this.customerDialog = Ext.create('Account.Customer.MainWindow');
		this.currencyDialog = Ext.create('Account.SCurrency.MainWindow');
		
		this.gridItem = Ext.create('Account.Invoice.Item.Grid_i',{
			//title:'Invoice Items',
			height: 320,
			region:'center'
		});
		this.gridGL = Ext.create('Account.Invoice.Item.Grid_gl',{
			border: true,
			region:'center',
			title: 'GL Posting'
		});
		this.formTotal = Ext.create('Account.Invoice.Item.Form_t',{
			border: true,
			split: true,
			title:'Total Invoice',
			region:'south'
		});
		this.gridPrice = Ext.create('Account.Invoice.Item.Grid_pc', {
			border: true,
			split: true,
			title:'Item Pricing',
			region:'south'
		});
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox',{
			fieldLabel: 'INV Status',
			name : 'statu',
			labelAlign: 'right',
			//labelWidth: 95,
			width: 240,
			margin: '0 0 0 6',
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Select Status --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'invoice/loads_acombo',
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

		this.comboPSale = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Saleperson',
			name : 'salnr',
			//labelWidth: 95,
			width: 350,
			editable: false,
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select Saleperson --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'invoice/loads_scombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'salnr'
					}
				},
				fields: [
					'salnr',
					'name1'
				],
				remoteSort: true,
				sorters: 'salnr ASC'
			}),
			queryMode: 'remote',
			displayField: 'name1',
			valueField: 'salnr'
		});
		
		this.comboPay = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Payments',
			name : 'ptype',
			width: 350,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please Select Payments --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'invoice/loads_tcombo',
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
			margin: '0 0 0 20',
			editable: false,
			labelAlign: 'right',
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please Select Condition --',
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
			displayField: 'contx',
			valueField: 'condi'
		});
		
		this.comboTax = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Vat type',
			name : 'taxnr',
			width: 240,
			margin: '0 0 0 5',
			labelAlign: 'right',
			editable: false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Select Tax --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'invoice/loads_taxcombo',
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
		
		this.numberWHT = Ext.create('Ext.form.field.Number', {
			fieldLabel: 'WHT Value',
			name: 'whtpr',
			labelAlign: 'right',
			width:200,
			align: 'right',
			margin: '0 0 0 25'
         });

         this.numberVat = Ext.create('Ext.form.field.Number', {
			fieldLabel: 'Vat Value',
			name: 'taxpr',
			labelAlign: 'right',
			width:200,
			align: 'right',
			margin: '0 0 0 25'
         });
		
        this.trigSO = Ext.create('Ext.form.field.Trigger', {
			name: 'ordnr',
			fieldLabel: 'SO No',
			labelAlign: 'letf',
			width:240,
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
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
			width: 240,
			margin: '0 0 0 6',
			labelAlign: 'right',
			allowBlank : false
		});
		
		this.hdnIvItem = Ext.create('Ext.form.Hidden', {
			name: 'vbrp'
		});
		
		this.hdnGlItem = Ext.create('Ext.form.Hidden', {
			name: 'belpr',
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
			items: [this.hdnIvItem,this.hdnGlItem,{
			xtype:'fieldset',
            title: 'Header Data',
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
		},this.trigSO,{
			xtype: 'displayfield',
			//name: 'jobtx',
			width:350,
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
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [{
			xtype: 'textarea',
			fieldLabel: 'Bill To',
			name: 'adr01',
			width:350,
			rows:2,
			editable: false,
			labelAlign: 'top'
		},{
            xtype: 'textarea',
			fieldLabel: 'Ship To',
			name: 'adr02',
			width:355,
			rows:2,
			labelAlign: 'top',
			editable: false,
			margin: '0 0 0 130'
         }]
// Sale Person         
         },{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [this.comboPSale ,{
			xtype: 'numberfield',
			fieldLabel: 'Credit Terms',
			name: 'terms',
			labelAlign: 'right',
			width:200,
			margin: '0 0 0 25'
		},{
			xtype: 'displayfield',
			margin: '0 0 0 5',
			width:10,
			value: 'Days'
		},this.trigCurrency]
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
			readOnly: true,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
		},this.comboCond
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
					width:350
				   },this.numberVat,{
			       xtype: 'displayfield',
			       align: 'right',
			       width:10,
			       margin: '0 0 0 5',
			       value: '%'
		          },this.comboTax
         ]
       },{  
			 	xtype: 'container',
				layout: 'hbox',
				margin: '0 0 5 0',
				items: [{
					xtype: 'displayfield',
					width:350
				   },this.numberWHT,{
			       xtype: 'displayfield',
			       align: 'right',
			       width:10,
			       margin: '0 0 0 5',
			       value: '%'
		           },this.comboQStatus]
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
				this.gridPrice,
				this.gridGL
			]
		}
			
		];
		
		// event trigQuotation///
		this.trigSO.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'saleorder/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.ordnr);
			//_this.getForm().findField('jobtx').setValue(r.data.jobtx);		
			_this.getForm().findField('kunnr').setValue(r.data.kunnr);
			_this.getForm().findField('name1').setValue(r.data.name1);
			_this.getForm().findField('salnr').setValue(r.data.salnr);	
			_this.getForm().findField('ptype').setValue(r.data.ptype);	
			_this.getForm().findField('taxnr').setValue(r.data.taxnr);	
			_this.getForm().findField('terms').setValue(r.data.terms);	
			_this.getForm().findField('adr01').setValue(r.data.adr01);
			_this.getForm().findField('adr02').setValue(r.data.adr02);
			
			//---Load PRitem to POitem Grid-----------
			var sonr = _this.trigSO.value;
			_this.gridItem.load({sonr: sonr });
			//----------------------------------------			
						}else{
							o.markInvalid('Could not find saleorder no : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		_this.soDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigSO.setValue(record.data.ordnr);
			//_this.getForm().findField('jobtx').setValue(record.data.jobtx);
			
			_this.getForm().findField('kunnr').setValue(record.data.kunnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			_this.getForm().findField('salnr').setValue(record.data.salnr);
			_this.getForm().findField('ptype').setValue(record.data.ptype);
			_this.getForm().findField('taxnr').setValue(record.data.taxnr);
			_this.getForm().findField('terms').setValue(record.data.terms);
            
            Ext.Ajax.request({
					url: __site_url+'saleorder/load',
					method: 'POST',
					params: {
						id: record.data.ordnr
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
			_this.getForm().findField('adr01').setValue(r.data.adr01);
			_this.getForm().findField('adr02').setValue(r.data.adr02);
			       }
				}
				});           
 
			grid.getSelectionModel().deselectAll();
			//---Load PRitem to POitem Grid-----------
			var sonr = _this.trigSO.value;
			_this.gridItem.load({sonr: sonr });
			//----------------------------------------
			_this.soDialog.hide();
		});

		this.trigSO.onTriggerClick = function(){
			_this.soDialog.show();
		};
		
		// event trigCustomer///
		this.trigCustomer.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'customer/load',
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
			
			var v = record.data.kunnr;
			if(Ext.isEmpty(v)) return;
				Ext.Ajax.request({
					url: __site_url+'customer/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							_this.getForm().findField('adr01').setValue(r.data.adr01);
			                _this.getForm().findField('adr02').setValue(r.data.adr02);
						}
					}
				});

			grid.getSelectionModel().deselectAll();
			_this.customerDialog.hide();
		});

		this.trigCustomer.onTriggerClick = function(){
			_this.customerDialog.show();
		};
		
		_this.currencyDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigCurrency.setValue(record.data.ctype);

            _this.formTotal.getForm().findField('curr1').setValue(record.data.ctype);
			grid.getSelectionModel().deselectAll();
			_this.currencyDialog.hide();
		});

		this.trigCurrency.onTriggerClick = function(){
			_this.currencyDialog.show();
		};
		
	// grid event
		this.gridItem.store.on('update', this.calculateTotal, this);
		this.gridItem.store.on('load', this.calculateTotal, this);
		this.on('afterLoad', this.calculateTotal, this);
		this.gridItem.getSelectionModel().on('selectionchange', this.onSelectChange, this);
		this.gridItem.getSelectionModel().on('viewready', this.onViewReady, this);
		//this.comboPay.on('select', this.selectPay, this);

		return this.callParent(arguments);
	},	
	
	onSelectChange: function(selModel, selections){
		var _this=this;
		var sel = this.gridItem.getView().getSelectionModel().getSelection()[0];
        //var id = sel.data[sel.idField.name];
        if (sel) {
            _this.gridPrice.load({
            	menge:sel.get('menge'),
            	unitp:sel.get('unitp'),disit:sel.get('disit'),
            	vvat:this.numberVat.getValue(),
            	vwht:this.numberWHT.getValue(),
            	vat:sel.get('chk01'),
            	wht:sel.get('chk02')
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
	
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ invnr: 0 });
		//this.gridPayment.load({ vbeln: 0 });

		// default status = wait for approve
		this.comboQStatus.setValue('05');
		this.comboCond.setValue('01');
		this.trigCurrency.setValue('THB');
		this.comboPay.setValue('01');
		//this.comboPay.setDisabled(true);
		this.numberVat.setValue(7);
		this.numberWHT.setValue(3);
		this.formTotal.getForm().findField('exchg').setValue('1.0000');
	},
	
	// calculate total functions
	calculateTotal: function(){
		var _this=this;
		var store = this.gridItem.store;
		var sum = 0;var vats=0; var whts=0;var i=0;
		//var matData= new Array();
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
			    //matData = {
                //'matnr': matnr,
                //'itamt': amt,
                //};
			
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
		this.formTotal.getForm().findField('beamt').setValue(Ext.util.Format.usMoney(sum).replace(/\$/, ''));
		this.formTotal.getForm().findField('vat01').setValue(Ext.util.Format.usMoney(vats).replace(/\$/, ''));
		this.formTotal.getForm().findField('wht01').setValue(Ext.util.Format.usMoney(whts).replace(/\$/, ''));
        var net = this.formTotal.calculate();
// Set value to total form
		this.formTotal.taxType = this.comboTax.getValue();
		this.gridItem.vatValue = this.numberVat.getValue();
		
		this.gridItem.whtValue = this.numberWHT.getValue();
		var currency = this.trigCurrency.getValue();
		this.gridItem.curValue = currency;
		this.formTotal.getForm().findField('curr1').setValue(currency);
		this.gridItem.customerValue = this.trigCustomer.getValue();
		//alert(this.comboPay.getValue());
// Set value to GL Posting grid    
        if(sum>0){
            _this.gridGL.load({
            	netpr:sum,
            	vvat:vats,
            	vwht:whts,
            	kunnr:this.trigCustomer.getValue(),
            	ptype:'01',
            	dtype:'01'
            }); 
           }
           /* var v = record.data.kunnr;
			if(Ext.isEmpty(v)) return;
				Ext.Ajax.request({
					url: __site_url+'invoice/loads_gl_item',
					method: 'POST',
					params: {
						//JSON.stringify( matData ),
						netpr:sum,
            	        kunnr:this.trigCustomer.getValue(),
            	        ptype:this.comboPay.getValue,
            	        dtype:'01',
            	        vvat:vats,
            	        vwht:whts
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							_this.getForm().findField('adr01').setValue(r.data.adr01);
						}
					}
				});*/ 

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
            	wht:sel.get('chk02')
            });     
        }
	},
// Payments Method	
	selectPay: function(combo, record, index){
		var _this=this;
		var store = this.gridItem.store;
		var vtax = combo.getValue();
		var sum = 0;var vats=0; var whts=0;var i=0;
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
			if(r.data['chk02']==true){
				var wht = _this.numberWHT.getValue();
				    wht = (amt * wht) / 100;
				    whts += wht;
			}			
		});
		
		if(sum>0){
            _this.gridGL.load({
            	netpr:sum,
            	vvat:vats,
            	vwht:whts,
            	kunnr:this.trigCustomer.getValue(),
            	ptype:combo.getValue(),
            	dtype:'01'
            }); 
           }
	}
});