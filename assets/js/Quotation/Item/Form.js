Ext.define('Account.Quotation.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'quotation/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		// INIT other components ///////////////////////////////////
		this.projectDialog = Ext.create('Account.Project.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
		this.customerDialog = Ext.create('Account.Customer.MainWindow');
		this.currencyDialog = Ext.create('Account.SCurrency.MainWindow');

		this.gridItem = Ext.create('Account.Quotation.Item.Grid_i',{
			title:'Quotation Items'
		});
		this.gridPayment = Ext.create('Account.Quotation.Item.Grid_p',{
			border: true,
			region:'center'
		});
		this.formTotal = Ext.create('Account.Quotation.Item.Form_t', {
			border: true,
			split: true,
			title:'Total->Quotation',
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
			readOnly: !UMS.CAN.APPROVE('QT'),
			fieldLabel: 'QT Status',
			name : 'statu',
			labelAlign: 'right',
			width: 240,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			margin: '0 0 0 6',
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

		this.comboPSale = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Salesperson',
			name : 'salnr',
			width: 350,
			editable: false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select Salesperson --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'quotation/loads_scombo',
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

		this.numberWHT = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'WHT Value',
			name: 'whtpr',
			labelAlign: 'right',
			width:200,
			hideTrigger:false,
			align: 'right',
			margin: '0 0 0 35'
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

		this.hdnQtItem = Ext.create('Ext.form.Hidden', {
			name: 'vbap',
		});

		this.hdnPpItem = Ext.create('Ext.form.Hidden', {
			name: 'payp',
		});

		this.trigProject = Ext.create('Ext.form.field.Trigger', {
			name: 'jobnr',
			fieldLabel: 'Project No.',
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
			items: [this.hdnQtItem, this.hdnPpItem,
			{
				xtype:'fieldset',
				title: 'Heading Data',
				collapsible: true,
				defaultType: 'textfield',
				layout: 'anchor',
				defaults: {
					anchor: '100%'
				},
				items:[{
					// Project Code
	 				xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
	 				items :[{
						xtype: 'hidden',
						name: 'id'
					},
					this.trigProject,
					{
						xtype: 'displayfield',
						name: 'jobtx',
						width:350,
						margins: '0 0 0 6',
						allowBlank: true
					},{
						xtype: 'displayfield',
						fieldLabel: 'Quotation No',
						name: 'vbeln',
						//flex: 3,
						value: 'QTXXXX-XXXX',
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
					items: [this.comboPSale,
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

		this.items = [mainFormPanel,
		{
			xtype:'tabpanel',
			region:'center',
			activeTab: 0,
			border: false,
			items: [this.gridItem,
			{
				xtype: 'panel',
				border: false,
				title: 'Partial Payment',
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
			height:200,
			items: [
				this.formTotal,
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
			_this.customerDialog.show();
		};

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

			_this.getForm().findField('kunnr').setValue(r.data.kunnr);
			_this.getForm().findField('name1').setValue(r.data.name1);
			_this.getForm().findField('salnr').setValue(r.data.salnr);
			_this.getForm().findField('adr01').setValue(r.data.adr01);
			_this.getForm().findField('adr02').setValue(r.data.adr02);
			//_this.getForm().findField('terms').setValue(r.data.terms);
			//_this.getForm().findField('ptype').setValue(r.data.ptype);
			//_this.getForm().findField('taxnr').setValue(r.data.taxnr);
			//_this.trigCustomer.on('keyup', this.selectTax, this);

						}else{
							o.markInvalid('Could not find project code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.projectDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigProject.setValue(record.data.jobnr);
			_this.getForm().findField('jobtx').setValue(record.data.jobtx);

			_this.getForm().findField('kunnr').setValue(record.data.kunnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			_this.getForm().findField('salnr').setValue(record.data.salnr);

			Ext.Ajax.request({
					url: __site_url+'project/load',
					method: 'POST',
					params: {
						id: record.data.jobnr
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
			_this.getForm().findField('adr01').setValue(r.data.adr01);
			_this.getForm().findField('adr02').setValue(r.data.adr02);
			//_this.getForm().findField('terms').setValue(r.data.terms);
			//_this.getForm().findField('ptype').setValue(r.data.ptype);
			//_this.getForm().findField('taxnr').setValue(r.data.taxnr);
			       }
				}
				});

			grid.getSelectionModel().deselectAll();
			_this.projectDialog.hide();
		});

		this.trigProject.onTriggerClick = function(){
			_this.projectDialog.show();
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

		// grid event
		this.gridItem.store.on('update', this.calculateTotal, this);
		this.gridItem.store.on('load', this.calculateTotal, this);
		this.on('afterLoad', this.calculateTotal, this);
		this.gridItem.getSelectionModel().on('selectionchange', this.onSelectChange, this);
		this.gridItem.getSelectionModel().on('viewready', this.onViewReady, this);
		//this.comboTax.on('select', this.selectTax, this);

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
			url:__site_url+'quotation/load',
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
		this.hdnQtItem.setValue(Ext.encode(rsItem));

		var rsPayment = _this.gridPayment.getData();
		this.hdnPpItem.setValue(Ext.encode(rsPayment));

		if (_form_basic.isValid()) {
			_form_basic.submit({
				waitMsg: 'Save data...',
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
			url:__site_url+'quotation/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ vbeln: 0 });
		this.gridPayment.load({ vbeln: 0 });
		//this.gridPrice.load();

		// default status = wait for approve
		this.comboQStatus.setValue('01');
		this.comboTax.setValue('01');
		this.trigCurrency.setValue('THB');
		this.numberVat.setValue(7);
		this.numberWHT.setValue(3);
		this.getForm().findField('bldat').setValue(new Date());
		this.formTotal.getForm().findField('exchg').setValue('1.0000');
	},
	// calculate total functions
	calculateTotal: function(){
		var _this=this;
		var store = this.gridItem.store;
		var sum = 0;var vats=0; var whts=0;
		store.each(function(r){
			var qty = parseFloat(r.data['menge'].replace(/[^0-9.]/g, '')),
				price = parseFloat(r.data['unitp'].replace(/[^0-9.]/g, '')),
				discount = parseFloat(r.data['disit'].replace(/[^0-9.]/g, ''));
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
		this.formTotal.getForm().findField('beamt').setValue(sum);
		this.formTotal.getForm().findField('vat01').setValue(vats);
		this.formTotal.getForm().findField('wht01').setValue(whts);
		var net = this.formTotal.calculate();

		// set value to grid payment
		this.gridPayment.netValue = net;
		// set value to total form
		this.gridItem.vattValue = this.comboTax.getValue();
		this.gridItem.vatValue = this.numberVat.getValue();

		this.gridItem.whtValue = this.numberWHT.getValue();
		var currency = this.trigCurrency.getValue();
		this.gridItem.curValue = currency;
		this.formTotal.getForm().findField('curr1').setValue(currency);
		this.gridItem.customerValue = this.trigCustomer.getValue();

        var sel = this.gridItem.getView().getSelectionModel().getSelection()[0];
        //var id = sel.data[sel.idField.name];
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