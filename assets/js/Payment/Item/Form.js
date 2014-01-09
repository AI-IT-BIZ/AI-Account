Ext.define('Account.Payment.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'payment/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.vendorDialog = Ext.create('Account.Vendor.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
		
		//this.vendorDialog = Ext.create('Account.Vendor.MainWindow');
		this.currencyDialog = Ext.create('Account.SCurrency.MainWindow');
		
		this.gridItem = Ext.create('Account.Payment.Item.Grid_i',{
			height: 320,
			region:'center'
		});
		this.gridGL = Ext.create('Account.Payment.Item.Grid_gl',{
			border: true,
			region:'center',
			title: 'GL Posting'
		});
		this.gridPayment = Ext.create('Account.Payment.Item.Grid_pm',{
			border: true,
			region:'center',
			title: 'Payment'
		});
		this.formTotal = Ext.create('Account.Payment.Item.Form_t', {
			border: true,
			split: true,
			title:'Total->Payment',
			region:'south'
		});
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			readOnly: !UMS.CAN.APPROVE('PY'),
			fieldLabel: 'Payment Status',
			name : 'statu',
			labelAlign: 'right',
			width: 245,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			//margin: '0 0 0 6',
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
		
		this.trigCurrency = Ext.create('Ext.form.field.Trigger', {
			name: 'ctype',
			fieldLabel: 'Currency',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			width: 200,
			editable: false,
			labelAlign: 'right',
			allowBlank : false
		});
	
		this.hdnPyItem = Ext.create('Ext.form.Hidden', {
			name: 'ebbp'
		});
		
		this.hdnPpItem = Ext.create('Ext.form.Hidden', {
			name: 'paym',
		});
		
		this.hdnGlItem = Ext.create('Ext.form.Hidden', {
			name: 'bven',
		});
		
		this.trigVendor = Ext.create('Ext.form.field.Trigger', {
			name: 'lifnr',
			labelAlign: 'letf',
			width:240,
			fieldLabel: 'Vendor Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
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
			items: [this.hdnPyItem,this.hdnPpItem,this.hdnGlItem,
			{
			xtype:'fieldset',
            title: 'Heading Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
// Vendor Code            
     items:[{
     	xtype: 'container',
                layout: 'hbox',
     items: [{
                xtype: 'container',
                layout: 'anchor',
     items :[{
     	        xtype: 'container',
                layout: 'hbox',
     items :[{
			xtype: 'hidden',
			name: 'id'
		},this.trigVendor,{
			xtype: 'displayfield',
			name: 'name1',
			margins: '0 0 0 6',
			width:350,
            allowBlank: true
		}]
		},{
			xtype: 'textarea',
			fieldLabel: 'Address',
			name: 'adr01',
			width:350,
			rows:3,
			labelAlign: 'top'
		}]
		},{
			xtype: 'container',
                layout: 'anchor',
     items :[{
			xtype: 'displayfield',
            fieldLabel: 'Payment No',
            name: 'payno',
            value: 'PYXXXX-XXXX',
            labelAlign: 'right',
			width:240,
            readOnly: true,
			labelStyle: 'font-weight:bold'
	    },{
			xtype: 'datefield',
			fieldLabel: 'Document Date',
			name: 'bldat',
			labelAlign: 'right',
			width:245,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			allowBlank: false
	    },{
			xtype: 'datefield',
			fieldLabel: 'Payment Date',
			name: 'duedt',
			labelAlign: 'right',
			width:245,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			allowBlank: false
		},{
					xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 -200',
					items :[this.trigCurrency,this.comboQStatus]
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
				this.gridPayment,
				this.gridGL
			]
		}
			
		];
		
		// event trigVendor///
		this.trigVendor.on('keyup',function(o, e){
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
							
						}else{
							o.markInvalid('Could not find vendor code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.vendorDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigVendor.setValue(record.data.lifnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			
			var _addr = record.data.adr01;
			if(!Ext.isEmpty(record.data.distx))
              _addr += ' '+record.data.distx;
            if(!Ext.isEmpty(record.data.pstlz))
              _addr += ' '+record.data.pstlz;
            if(!Ext.isEmpty(record.data.telf1))
               _addr += '\n'+'Tel: '+record.data.telf1;
             if(!Ext.isEmpty(record.data.telfx))
               _addr += ' '+'Fax: '+record.data.telfx;
             if(!Ext.isEmpty(record.data.email))
               _addr += '\n'+'Email: '+record.data.email;
             _this.getForm().findField('adr01').setValue(_addr);

			grid.getSelectionModel().deselectAll();
			_this.vendorDialog.hide();
			
			// set vendor code to grid item
				_this.gridItem.setVendorCode(record.data.lifnr);
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
		
		this.gridPayment.store.on('update', this.loadGL, this);
		this.gridPayment.store.on('load', this.loadGL, this);
		this.on('afterLoad', this.loadGL, this);
		_this.formTotal.getForm().findField('exchg').on('change',this.loadGL,this);

		return this.callParent(arguments);
	},	
	
	load : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'payment/load',
			success: function(form, act){
				_this.fireEvent('afterLoad', form, act);
				// set vendor code to grid item
				_this.gridItem.setVendorCode(act.result.data.lifnr);
			}
		});
	},
	
	save : function(){
		var _this=this;
		var _form_basic = this.getForm();
		
		// add grid data to json
		var rsItem = this.gridItem.getData();
		this.hdnPyItem.setValue(Ext.encode(rsItem));
		// add grid paym data to json
		var rsPayment = _this.gridPayment.getData();
		this.hdnPpItem.setValue(Ext.encode(rsPayment));
		
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
			params: { id: id },
			url:__site_url+'payment/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ payno: 0 });
		this.gridPayment.load({ recnr: 0 });
		this.gridGL.load({ netpr: 0 });

        // default status = wait for approve
		this.comboQStatus.setValue('01');
		//this.comboTax.setValue('01');
		this.trigCurrency.setValue('THB');
		this.getForm().findField('bldat').setValue(new Date());
		this.getForm().findField('duedt').setValue(new Date());
		this.formTotal.getForm().findField('exchg').setValue('1.0000');
		this.formTotal.getForm().findField('bbb').setValue('0.00');
		this.formTotal.getForm().findField('netwr').setValue('0.00');
	},
	
	// Calculate total functions
	calculateTotal: function(){
		var _this=this;
		var store = _this.gridItem.store;
		var sum = 0;
		store.each(function(r){
			var itamt = parseFloat(r.data['itamt'].replace(/[^0-9.]/g, ''));
				//pay = parseFloat(r.data['payrc'].replace(/[^0-9.]/g, ''));
			itamt = isNaN(itamt)?0:itamt;
			//pay = isNaN(pay)?0:pay;

			var amt = itamt; //- pay;
			sum += amt;
		});
		this.formTotal.getForm().findField('beamt').setValue(sum);
		var currency = this.trigCurrency.getValue();
		this.gridItem.curValue = currency;
		this.formTotal.getForm().findField('curr1').setValue(currency);
		
		var net = this.formTotal.calculate();
		this.gridPayment.netValue = net;
	},
	
	// Load GL functions
	loadGL: function(id){
		var _this=this;
		var store = _this.gridItem.store;
		var sum = 0;var dtype='';var itamt=0;sum2=0;
		var saknr_list = [];var whts=0;var vats=0;
		store.each(function(r){
			    itamt = parseFloat(r.data['itamt'].replace(/[^0-9.]/g, ''));
				//pay = parseFloat(r.data['payrc'].replace(/[^0-9.]/g, ''));
			itamt = isNaN(itamt)?0:itamt;
			//pay = isNaN(pay)?0:pay;

			var amt = itamt; //- pay;
			sum += amt;
			
			//var item = r.data['saknr'] + '|' + amt;
        		//saknr_list.push(item);
        		
        		if(r.data['wht01']>0 && r.data['wht01']!=null){
				var wht = parseFloat(r.data['wht01'].replace(/[^0-9.]/g, ''));
				    whts += wht;
				}
				if(r.data['vat01']>0 && r.data['vat01']!=null){    
				var vat = parseFloat(r.data['vat01'].replace(/[^0-9.]/g, ''));
				    vats += vat;
				}
				dtype = r.data['dtype'];
		});
		
        var discount = this.formTotal.getForm().findField('dismt').getValue();
        sum2 = sum - discount;
		// set value to grid payment
		//var rsPM = _this.gridPayment.getData();
		// Set value to GL Posting grid  
		var currency = this.trigCurrency.getValue();
		if(currency != 'THB'){
	      var rate = this.formTotal.getForm().findField('exchg').getValue();
		  sum = sum * rate;
		  sum2 = sum2 * rate;
		}   
        if(sum>0 && this.trigVendor.getValue()!=''){
        	var r_data = _this.gridPayment.getData();
        	var pay_list = [];
        	for(var i=0;i<r_data.length;i++){
        		if(r_data[i].ptype == '03' || r_data[i].ptype == '04'){
        		    var item = r_data[i].saknr + '|' + r_data[i].payam;
        		}else{
        			var item = r_data[i].ptype + '|' + r_data[i].payam;
        		}
        		saknr_list.push(item);
        	}
        	//console.log(rsPM);
            _this.gridGL.load({
            	//paym:Ext.encode(rsPM),
            	netpr:sum2,
            	vwht:whts,
            	vvat:vats,
            	dtype:dtype,
            	lifnr:this.trigVendor.getValue(),
            	items: saknr_list.join(',')
            }); 
           }
	}
	
});