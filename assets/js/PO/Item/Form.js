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
		this.vendorDialog = Ext.create('Account.Vendor.MainWindow');
		this.prDialog = Ext.create('Account.PR.MainWindow');

		this.gridItem = Ext.create('Account.PO.Item.Grid_i',{
			height: 320,
			region:'center'
		});
		this.formTotal = Ext.create('Account.PO.Item.Form_t', {
			title:'PO Total',
			border: true,
			split: true,
			region:'south'
		});
		this.gridPrice = Ext.create('Account.PR.Item.Grid_pc', {
			border: true,
			split: true,
			title:'Item Pricing',
			region:'south'
		});
		// END INIT other components ////////////////////////////////


/*---ComboBox Tax Type----------------------------*/
		this.comboTax = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Tax Type',
			name: 'taxnr',
			//width:185,
			//labelWidth: 80,
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
			valueField: 'taxnr'
		});	
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'PR Status',
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
			valueField: 'ptype'
		});
/*-------------------------------*/			
		this.hdnPrItem = Ext.create('Ext.form.Hidden', {
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
			allowBlank : false
		});
		
		this.numberCredit = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'Credit Terms',
			name: 'crdit',
			labelAlign: 'right',
			width:170,
			hideTrigger:false,
			align: 'right'//,
			//margin: '0 0 0 35'
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

         this.numberVat = Ext.create('Ext.ux.form.NumericField', {
           // xtype: 'numberfield',
			fieldLabel: 'Vat Value',
			name: 'taxpr',
			labelAlign: 'right',
			width:170,
			align: 'right'//,
			//margin: '0 0 0 35'
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
			items: [this.hdnPrItem,
			{
				xtype:'fieldset',
				title: 'Header Data',
				items:[{
	 				xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
		 			items :[{
						xtype: 'hidden',
						name: 'id'
					},this.trigQuotation,{
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
							fieldLabel: 'Address',
							name: 'adr01',
							width: 455, 
							rows:2,
		                }, {
			 				xtype: 'container',
							layout: 'hbox',
							margin: '0 0 5 0',
				 			items :[{
								xtype: 'textfield',
								fieldLabel: 'Reference No',
								name: 'refnr',
								//margin: '0 0 5 0',
			                }, {
								xtype: 'numberfield',
								fieldLabel: 'Credit',
								name: 'crdit',
								//width: 20, 
								labelWidth: 50,
								margin: '0 0 0 40',
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
							format:'d/m/Y',
							altFormats:'Y-m-d|d/m/Y',
							submitFormat:'Y-m-d',
		                }, {
							xtype: 'datefield',
							fieldLabel: 'Delivery Date',
							name: 'lfdat',
							format:'d/m/Y',
							altFormats:'Y-m-d|d/m/Y',
							submitFormat:'Y-m-d',
                		}, this.comboTaxnr,{
		                }]
		            }]
				}]

			}]
		};
		
		this.items = [
			mainFormPanel,
			this.gridItem,
			this.formTotal
			
		];		

		// event trigVender///
		this.trigVender.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'vendor/load',
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
							o.markInvalid('Could not find Vendor code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.vendorDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigVender.setValue(record.data.lifnr);
			_this.getForm().findField('name1').setValue(record.data.name1);

			var _addr = record.data.adr01;
			if(!Ext.isEmpty(record.data.distx))
			  _addr += ' '+record.data.distx;
			if(!Ext.isEmpty(record.data.pstlz))
			  _addr += ' '+record.data.pstlz;
			if(!Ext.isEmpty(record.data.telf1))
				_addr += '\n'+'Tel: '+record.data.telf1;
			 if(!Ext.isEmpty(record.data.telfx))
				_addr += '\n'+'Fax: '+record.data.telfx;
			 if(!Ext.isEmpty(record.data.email))
				_addr += '\n'+'Email: '+record.data.email;
			 _this.getForm().findField('adr01').setValue(_addr);

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
							_this.getForm().findField('lifnr').setValue(record.data.lifnr);
							_this.getForm().findField('name1').setValue(record.data.name1);			
						}else{
							o.markInvalid('Could not find purchase no : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		_this.prDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigPR.setValue(record.data.purnr);
			_this.getForm().findField('lifnr').setValue(record.data.lifnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			
			var _addr = record.data.adr01;
			if(!Ext.isEmpty(record.data.distx))
			  _addr += ' '+record.data.distx;
			if(!Ext.isEmpty(record.data.pstlz))
			  _addr += ' '+record.data.pstlz;
			if(!Ext.isEmpty(record.data.telf1))
				_addr += '\n'+'Tel: '+record.data.telf1;
			 if(!Ext.isEmpty(record.data.telfx))
				_addr += '\n'+'Fax: '+record.data.telfx;
			 if(!Ext.isEmpty(record.data.email))
				_addr += '\n'+'Email: '+record.data.email;
			 _this.getForm().findField('adr01').setValue(_addr);
			 
			grid.getSelectionModel().deselectAll();
			//---Load PRitem to POitem Grid-----------
			var grdpurnr = _this.trigQuotation.value;
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

		return this.callParent(arguments);
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
		this.hdnQtItem.setValue(Ext.encode(rsItem));
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
		//this.comboQStatus.setValue('01');
	},
	// calculate total functions
	calculateTotal: function(){
		var store = this.gridItem.store;
		var sum = 0;
		store.each(function(r){
			var qty = parseFloat(r.data['menge']),
				price = parseFloat(r.data['unitp']),
				discount = parseFloat(r.data['dismt']);
			qty = isNaN(qty)?0:qty;
			price = isNaN(price)?0:price;
			discount = isNaN(discount)?0:discount;

			var amt = (qty * price) - discount;

			sum += amt;
		});
		this.formTotal.getForm().findField('beamt').setValue(Ext.util.Format.usMoney(sum).replace(/\$/, ''));
		this.formTotal.calculate();
	}
});