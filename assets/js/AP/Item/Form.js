Ext.define('Account.AP.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'ap/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		// INIT other components ///////////////////////////////////
		this.vendorDialog = Ext.create('Account.Vendor.MainWindow');
		this.grDialog = Ext.create('Account.GR.MainWindow');

		this.gridItem = Ext.create('Account.AP.Item.Grid_i',{
			height: 320,
			region:'center'
		});
		this.gridGL = Ext.create('Account.AP.Item.Grid_gl',{
			border: true,
			region:'center',
			title: 'GL Posting'
		});
		this.formTotal = Ext.create('Account.AP.Item.Form_t', {
			title:'Total Account Payble',
			border: true,
			split: true,
			region:'south'
		});
		// END INIT other components ////////////////////////////////

/*---ComboBox Tax Type----------------------------*/
		this.comboTaxnr = Ext.create('Ext.form.ComboBox', {
							
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
					url: __site_url+'ap/loads_combo/tax1/taxnr/taxtx',  //loads_tycombo($tb,$pk,$like)
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
/*---ComboBox Payment type----------------------------*/
		this.comboPtype = Ext.create('Ext.form.ComboBox', {
							
			fieldLabel: 'Payment type',
			name: 'ptype',
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
					url: __site_url+'ap/loads_combo/ptyp/ptype/paytx',  //loads_tycombo($tb,$pk,$like)
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
		this.hdnApItem = Ext.create('Ext.form.Hidden', {
			name: 'ebrp',
		});

        this.trigGR = Ext.create('Ext.form.field.Trigger', {
			name: 'mbeln',
			fieldLabel: 'GR No',
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
			items: [this.hdnApItem, this.hdnPpItem,
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
					},this.trigGR,{
						xtype: 'displayfield',
						fieldLabel: 'AP Doc.',
						name: 'invnr',
						value: 'TIXXXX-XXXX',
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
							fieldLabel: 'AP Date',
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
		
		
		this.items = [mainFormPanel,this.gridItem,
		{
			xtype:'tabpanel',
			region:'south',
			activeTab: 0,
			height:170,
			items: [
				this.formTotal,
				this.gridGL
			]
		}
			
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
							o.setValue(r.data.ebeln);
							_this.getForm().findField('name1').setValue(r.data.name1);
							var _crdit = r.data.crdit;
							var _addr = r.data.adr01;
							if(!Ext.isEmpty(r.data.distx))
			                    _addr += ' '+r.data.distx;
							if(!Ext.isEmpty(r.data.pstlz))
								_addr += ' '+r.data.pstlz;
							if(!Ext.isEmpty(r.data.telf1))
								_addr += '\n'+'Tel: '+r.data.telf1;
							if(!Ext.isEmpty(r.data.telfx))
								_addr += '\n'+'Fax: '+r.data.telfx;
							if(!Ext.isEmpty(r.data.email))
							_addr += '\n'+'Email: '+r.data.email;
							_this.getForm().findField('adr01').setValue(_addr);
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
		this.trigGR.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'gr/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.mbeln);
							_this.getForm().findField('lifnr').setValue(record.data.lifnr);
							_this.getForm().findField('name1').setValue(record.data.name1);			
						}else{
							o.markInvalid('Could not find goods recept : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		_this.grDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigGR.setValue(record.data.mbeln);
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
			var grdmbeln = _this.trigGR.value;
			//alert(grdebeln);
			_this.gridItem.load({grdmbeln: grdmbeln });
			//----------------------------------------
			_this.grDialog.hide();
		});

		
		this.trigGR.onTriggerClick = function(){
			_this.grDialog.show();
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
			url:__site_url+'ap/load',
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
	remove : function(invnr){
		var _this=this;
		this.getForm().load({
			params: { invnr: invnr },
			url:__site_url+'ap/remove',
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