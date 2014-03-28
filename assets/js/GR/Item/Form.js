Ext.define('Account.GR.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'gr/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.poDialog = Ext.create('Account.PO.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
		
		// INIT other components ///////////////////////////////////
		this.vendorDialog = Ext.create('Account.SVendor.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
		
		this.currencyDialog = Ext.create('Account.SCurrency.MainWindow');

		this.gridItem = Ext.create('Account.GR.Item.Grid_i',{
			height: 320,
			region:'center'
		});
		this.formTotal = Ext.create('Account.GR.Item.Form_t', {
			border: true,
			split: true,
			title:'GR Total',
			region:'south'
		});
		this.formTotalthb = Ext.create('Account.GR.Item.Form_thb', {
			border: true,
			split: true,
			title:'Exchange Rate->THB',
			region:'south'
		});
		this.formSpec = Ext.create('Account.GR.Item.Form_spec', {
			border: true,
			split: true,
			title:'Asset Detail',
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
			readOnly: !UMS.CAN.APPROVE('GR'),
			fieldLabel: 'GR Status',
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
/*---ComboBox Tax Type----------------------------*/
		this.comboTax = Ext.create('Ext.form.ComboBox', {			
			fieldLabel: 'Vat Type',
			name: 'taxnr',
			width: 240,
			labelAlign: 'right',
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
/*---ComboBox Payment type----------------------------*/
		this.comboPay = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Payments',
			name : 'ptype',
			width: 280,
			editable: false,
			//allowBlank : false,
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
			readOnly: true,
			valueField: 'ptype'
		});
/*-------------------------------*/			
		this.hdnGrItem = Ext.create('Ext.form.Hidden', {
			name: 'mseg',
		});

        this.trigPO = Ext.create('Ext.form.field.Trigger', {
			name: 'ebeln',
			fieldLabel: 'PO No',
			labelAlign: 'letf',
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
			name: 'terms',
			labelAlign: 'right',
			width:170,
			hideTrigger:false,
			readOnly: true,
			align: 'right'//,
			//margin: '0 0 0 35'
         });
         
         this.trigCurrency = Ext.create('Ext.form.field.Trigger', {
			name: 'ctype',
			fieldLabel: 'Currency',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			readOnly: true,
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
			readOnly: true,
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
			items: [this.hdnGrItem, 
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
					},this.trigPO,{
						xtype: 'displayfield',
						//name: 'name1',
						//margins: '0 0 0 6',
						width:290,
						allowBlank: true
					},{
						xtype: 'displayfield',
					    fieldLabel: 'Goods Receipt',
					    name: 'mbeln',
						value: 'GRXXXX-XXXX',
						labelAlign: 'right',
						width:240,
						readOnly: true,
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
							name: 'adr01',
							readOnly: true,
							width: 450, 
							rows:3,
		                }, {xtype: 'container',
							layout: 'hbox',
							margin: '0 0 5 0',
				 			items :[this.comboPay,this.numberVat,{
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
				 			items :[{
								xtype: 'textfield',
								fieldLabel: 'Reference No',
								width: 450, 
								name: 'refnr',
			                },{}]
		                }]
		            },{
		                xtype: 'container',
		                flex: 0,
		                layout: 'anchor',
		            	margin: '0 0 0 70',
		                items: [this.comboPtype,{
							xtype: 'datefield',
							fieldLabel: 'Doc Date',
							name: 'bldat',
							labelAlign: 'right',
							allowBlank: false,
							width:240,
							format:'d/m/Y',
							altFormats:'Y-m-d|d/m/Y',
							submitFormat:'Y-m-d',
		                },{
							xtype: 'datefield',
							fieldLabel: 'GR Date',
							name: 'lfdat',
							labelAlign: 'right',
							allowBlank: false,
							width:240,
							format:'d/m/Y',
							altFormats:'Y-m-d|d/m/Y',
							submitFormat:'Y-m-d',
		                }, this.comboTax,
                		this.trigCurrency,
                		{
			 				xtype: 'container',
							layout: 'hbox',
							margin: '0 0 5 0',
				 			items :[
                		this.numberCredit,{
						xtype: 'displayfield',
						margin: '0 0 0 5',
						width:25,
						value: 'Days'
						}]},
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
			height:170,
			items: [
				this.formTotal,
				this.formTotalthb,
				this.gridPrice,
				this.formSpec
			]
		}
		];	
        
        // event trigPO///
		this.trigPO.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'po/load',
					method: 'POST',
					params: {
						id: v,
						key: 1
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.ebeln);
							_this.getForm().findField('lifnr').setValue(r.data.lifnr);
							_this.getForm().findField('name1').setValue(r.data.name1);			
						    _this.getForm().findField('terms').setValue(r.data.terms);
			                _this.getForm().findField('ptype').setValue(r.data.ptype);
			                _this.getForm().findField('taxnr').setValue(r.data.taxnr);
			                _this.getForm().findField('taxpr').setValue(r.data.taxpr);
			                _this.getForm().findField('ctype').setValue(r.data.ctype);
			                _this.getForm().findField('adr01').setValue(r.data.adr01);
			                _this.getForm().findField('loekz').setValue(r.data.loekz);
			                _this.getForm().findField('exchg').setValue(r.data.exchg);
			                _this.getForm().findField('lfdat').setValue(r.data.lfdat);
			                
			                _this.formTotal.txtDepositVat.setValue(r.data.devat);
			                _this.formTotal.txtDepositWHT.setValue(r.data.dewht);
			                r.data.deamt = r.data.deamt - r.data.devat;
			                r.data.deamt = r.data.deamt + r.data.dewht;
			                _this.formTotal.txtDepositValue.setValue(r.data.deamt);
						    //---Load PRitem to POitem Grid-----------
			                var grdponr = _this.trigPO.value;
			                //alert(grdpurnr);
			                _this.gridItem.load({grdponr: grdponr });
						}else{
							o.setValue('');
							_this.getForm().findField('lifnr').setValue('');
							_this.getForm().findField('name1').setValue('');			
						    _this.getForm().findField('terms').setValue('');
			                _this.getForm().findField('ptype').setValue('');
			                _this.getForm().findField('taxnr').setValue('');
			                _this.getForm().findField('taxpr').setValue('');
			                _this.getForm().findField('ctype').setValue('');
			                _this.getForm().findField('adr01').setValue('');
			                _this.getForm().findField('loekz').setValue('');
			                _this.getForm().findField('exchg').setValue('');
			                _this.getForm().findField('lfdat').setValue('');
			                _this.formTotal.txtDepositValue.setValue(0);
			                _this.formTotal.txtDepositVat.setValue(0);
			                _this.formTotal.txtDepositWHT.setValue(0);
							o.markInvalid('Could not find Purchase no : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		_this.poDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigPO.setValue(record.data.ebeln);
			_this.getForm().findField('lifnr').setValue(record.data.lifnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			
			var v = record.data.ebeln;
			if(Ext.isEmpty(v)) return;
				Ext.Ajax.request({
					url: __site_url+'po/load',
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
			                _this.getForm().findField('exchg').setValue(r.data.exchg);
			                _this.getForm().findField('lfdat').setValue(r.data.lfdat);
			                
			                _this.formTotal.txtDepositVat.setValue(r.data.devat);
			                _this.formTotal.txtDepositWHT.setValue(r.data.dewht);
			                var depamt=parseFloat(r.data.deamt);
			                depamt = depamt - parseFloat(r.data.devat);
			                depamt = depamt + parseFloat(r.data.dewht);
			                _this.formTotal.txtDepositValue.setValue(depamt);
						}
					}
				});
			 
			grid.getSelectionModel().deselectAll();
			//---Load PRitem to POitem Grid-----------
			var grdponr = _this.trigPO.value;
			//alert(grdpurnr);
			_this.gridItem.load({grdponr: grdponr });
			//----------------------------------------
			_this.poDialog.hide();
		});
		
		this.trigPO.onTriggerClick = function(){
			_this.poDialog.show();
		};
		
		// event trigVender///
		this.trigVender.on('keyup',function(o, e){
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
							o.markInvalid('Could not find vendor code : '+o.getValue());
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
		this.numberVat.on('change', this.calculateTotal, this);
        
		return this.callParent(arguments);
	},
	
	onSelectChange: function(selModel, selections){
		var _this=this;
		
        var sel = this.gridItem.getView().getSelectionModel().getSelection()[0];
        if (sel) {

            _this.gridPrice.load({
            	menge:parseFloat(sel.get('upqty')),
            	unitp:parseFloat(sel.get('unitp')),
            	disit:sel.get('disit'),
            	vvat:this.numberVat.getValue(),
            	vat:sel.get('chk01')
            });
            
            var v = sel.get('matnr');
            
			if(Ext.isEmpty(v)) return;
				Ext.Ajax.request({
					url: __site_url+'asset/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							if(sel.get('serno')==''){
								_this.formSpec.getForm().findField('serno').setValue(r.data.serno);
							}else{
								_this.formSpec.getForm().findField('serno').setValue(sel.get('serno'));
							}
							_this.formSpec.getForm().findField('saknr').setValue(r.data.saknr);
						    _this.formSpec.getForm().findField('brand').setValue(r.data.brand);
			                
			                _this.formSpec.getForm().findField('reque').setValue(r.data.reque);
			                _this.formSpec.getForm().findField('model').setValue(r.data.model);
						    _this.formSpec.getForm().findField('specs').setValue(r.data.specs);
			                _this.formSpec.getForm().findField('assnr').setValue(r.data.assnr);
			                _this.formSpec.getForm().findField('reque').setValue(r.data.reque);
			                _this.formSpec.getForm().findField('holds').setValue(r.data.holds);
			                _this.formSpec.getForm().findField('depnr').setValue(r.data.depnr);
						    _this.formSpec.getForm().findField('keepi').setValue(r.data.keepi);
			                _this.formSpec.getForm().findField('resid').setValue(r.data.resid);
			                
			                _this.formSpec.getForm().findField('gltxt').setValue(r.data.sgtxt);
			                _this.formSpec.getForm().findField('asstx').setValue(r.data.asstx);
			                _this.formSpec.getForm().findField('reqtx').setValue(r.data.reqtx);
			                _this.formSpec.getForm().findField('hodtx').setValue(r.data.hodtx);
			                _this.formSpec.getForm().findField('deptx').setValue(r.data.deptx);
						}
					}
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
			url:__site_url+'gr/load',
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
		this.hdnGrItem.setValue(Ext.encode(rsItem));

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
	remove : function(mbeln){
		var _this=this;
		this.getForm().load({
			params: { mbeln: mbeln },
			url:__site_url+'gr/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	reset: function(){
		this.getForm().reset();
		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ mbeln: 0 });
		
		// สร้างรายการเปล่า 5 รายการใน grid item
		//this.gridItem.addDefaultRecord();

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
		var sum = 0;var vats=0; var whts=0;var discounts=0;
		var vattype = this.comboTax.getValue();
		store.each(function(r){
			var qty = parseFloat(r.data['upqty']),
				price = parseFloat(r.data['unitp']),
				reman = parseFloat(r.data['reman']),
				discountValue = 0,
				discount = r.data['disit'];
			qty = isNaN(qty)?0:qty;
			price = isNaN(price)?0:price;
			//discount = isNaN(discount)?0:discount;
            if(qty<=reman){
			var amt = qty * price;//) - discount;
			
			if(vattype =='02'){
				amt = amt * 100;
			    amt = amt / 107;
		    }
		    
		    if(discount!=null && discount!='0.00'){
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
			
			discounts += discountValue;
            
            amt = amt - discountValue;
			
			if(r.data['chk01']==true){
				var vat = _this.numberVat.getValue();
				    vat = (amt * vat) / 100;
				    vats += vat;
			}
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
		this.gridItem.grValue = this.getForm().findField('mbeln').getValue();
		this.gridItem.dateValue = Ext.Date.format(this.getForm().findField('bldat').getValue(),'Y-m-d');
		//this.gridItem.grValue = this.getForm().findField('mbeln').getValue();
		this.formTotal.getForm().findField('curr1').setValue(currency);
		this.formTotalthb.getForm().findField('curr2').setValue(currency);
		this.formTotal.getForm().findField('vat01').setValue(vats);
		
		var rate = this.formTotal.txtRate.getValue();
		var deamt = this.formTotal.getForm().findField('deamt').getValue();
		if(currency != 'THB'){
		  sum = sum * rate;
		  vats = vats * rate;
		  discounts = discounts * rate;
		  deamt = deamt * rate;
		}  
		
		this.formTotalthb.getForm().findField('beamt2').setValue(sum);
		this.formTotalthb.getForm().findField('vat02').setValue(vats);
		this.formTotalthb.getForm().findField('dismt2').setValue(discounts);
		this.formTotalthb.getForm().findField('exchg2').setValue(rate);
		//this.formTotalthb.getForm().findField('deamt2').setValue(deamt);
		var net2 = this.formTotalthb.calculate();
	  
	  // Set value to Condition Price grid
        var sel = this.gridItem.getView().getSelectionModel().getSelection()[0];
        if (sel) {

            _this.gridPrice.load({
            	menge:parseFloat(sel.get('upqty')),
            	unitp:parseFloat(sel.get('unitp')),
            	disit:sel.get('disit'),
            	vvat:this.numberVat.getValue(),
            	vat:sel.get('chk01')
            });
            
            var v = sel.get('matnr');

			if(Ext.isEmpty(v)) return;
				Ext.Ajax.request({
					url: __site_url+'asset/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							if(sel.get('serno')==''){
								_this.formSpec.getForm().findField('serno').setValue(r.data.serno);
							}else{
								_this.formSpec.getForm().findField('serno').setValue(sel.get('serno'));
							}
							_this.formSpec.getForm().findField('saknr').setValue(r.data.saknr);
						    _this.formSpec.getForm().findField('brand').setValue(r.data.brand);
			 
			                _this.formSpec.getForm().findField('reque').setValue(r.data.reque);
			                _this.formSpec.getForm().findField('model').setValue(r.data.model);
						    _this.formSpec.getForm().findField('specs').setValue(r.data.specs);
			                _this.formSpec.getForm().findField('assnr').setValue(r.data.assnr);
			                _this.formSpec.getForm().findField('reque').setValue(r.data.reque);
			                _this.formSpec.getForm().findField('holds').setValue(r.data.holds);
			                _this.formSpec.getForm().findField('depnr').setValue(r.data.depnr);
						    _this.formSpec.getForm().findField('keepi').setValue(r.data.keepi);
			                _this.formSpec.getForm().findField('resid').setValue(r.data.resid);
			                
			                _this.formSpec.getForm().findField('gltxt').setValue(r.data.sgtxt);
			                _this.formSpec.getForm().findField('asstx').setValue(r.data.asstx);
			                _this.formSpec.getForm().findField('reqtx').setValue(r.data.reqtx);
			                _this.formSpec.getForm().findField('hodtx').setValue(r.data.hodtx);
			                _this.formSpec.getForm().findField('deptx').setValue(r.data.deptx);
						}
					}
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