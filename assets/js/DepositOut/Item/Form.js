Ext.define('Account.DepositOut.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'depositout/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		// INIT search popup ///////////////////////////////
		this.poDialog = Ext.create('Account.PO.MainWindow');
		this.vendorDialog = Ext.create('Account.Vendor.MainWindow');
		this.currencyDialog = Ext.create('Account.SCurrency.MainWindow');
		
		this.gridItem = Ext.create('Account.DepositOut.Item.Grid_i',{
			//title:'Invoice Items',
			height: 320,
			region:'center'
		});
		this.gridGL = Ext.create('Account.DepositOut.Item.Grid_gl',{
			border: true,
			region:'center',
			title: 'GL Posting'
		});
		this.formTotal = Ext.create('Account.DepositOut.Item.Form_t', {
			border: true,
			split: true,
			title:'Total->Deposit',
			region:'south'
		});
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Deposit Status',
			name : 'statu',
			labelAlign: 'right',
			width: 250,
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
		
		this.hdnDpItem = Ext.create('Ext.form.Hidden', {
			name: 'vbdp'
		});
		
		this.hdnGlItem = Ext.create('Ext.form.Hidden', {
			name: 'bcus',
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
		
		this.trigPO = Ext.create('Ext.form.field.Trigger', {
			name: 'ebeln',
			fieldLabel: 'PO No.',
			width:240,
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
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
			items: [this.hdnDpItem,this.hdnGlItem,
			{
			xtype:'fieldset',
            title: 'Heading Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
// Vendor Code            
     items:[{
     	xtype: 'container',
                layout: 'hbox',
                //margin: '0 0 5 0',
     items: [{
                xtype: 'container',
                layout: 'anchor',
// PO Code
     items :[{
     	        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'hidden',
			name: 'id'
		},this.trigPO,
		{
			xtype: 'displayfield',
			//name: 'name1',
			margins: '0 0 0 6',
			width:350,
			allowBlank: true
		}]
		},{
     	        xtype: 'container',
                layout: 'hbox',
                //margin: '0 0 5 0',
     items :[this.trigVendor,{
			xtype: 'displayfield',
			name: 'name1',
			margins: '0 0 0 6',
			width:350,
            allowBlank: true
		}]
		},{
			xtype: 'textarea',
			fieldLabel: 'Bill To',
			name: 'adr01',
			width:400,
			rows:3,
			labelAlign: 'top'
		}]
		},{
			xtype: 'container',
                layout: 'anchor',
     items :[{
			xtype: 'displayfield',
            fieldLabel: 'Deposit No',
            name: 'depnr',
            value: 'DPXXXX-XXXX',
            labelAlign: 'right',
			width:250,
            readOnly: true,
			labelStyle: 'font-weight:bold'
	    },{
			xtype: 'datefield',
			fieldLabel: 'Document Date',
			name: 'bldat',
			labelAlign: 'right',
			width:250,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			allowBlank: false
	    },this.trigCurrency,this.comboQStatus
		 ]
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
		
		// event trigPO///
		this.trigPO.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'po/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.ebeln);
			//_this.getForm().findField('jobtx').setValue(r.data.jobtx);		
			_this.getForm().findField('lifnr').setValue(r.data.lifnr);
			_this.getForm().findField('name1').setValue(r.data.name1);
			_this.getForm().findField('adr01').setValue(r.data.adr01);
			_this.getForm().findField('ctype').setValue(r.data.ctype);
			_this.gridItem.curValue = r.data.ctype;
			//_this.gridItem.amtValue = r.data.netwr;
			//_this.getForm().findField('poamt').setValue(r.data.netwr);
			
			//---Load PRitem to POitem Grid-----------
			var ponr = _this.trigPO.value;
			//console.log(qtnr);
			//alert(qtnr);
			_this.gridItem.load({ponr: ponr });
			//----------------------------------------			
						}else{
							o.markInvalid('Could not find po no : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		_this.poDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigPO.setValue(record.data.ebeln);
			//_this.getForm().findField('jobtx').setValue(record.data.jobtx);
			
			_this.getForm().findField('lifnr').setValue(record.data.lifnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			//_this.getForm().findField('poamt').setValue(record.data.netwr);
			//_this.gridItem.amtValue = record.data.netwr;
            
            Ext.Ajax.request({
					url: __site_url+'po/load',
					method: 'POST',
					params: {
						id: record.data.ebeln
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
			_this.getForm().findField('adr01').setValue(r.data.adr01);
			_this.getForm().findField('ctype').setValue(r.data.ctype);
			_this.gridItem.curValue = r.data.ctype;
			//_this.gridItem.netValue = r.data.netwr;
			       }
				}
				});           
 
			grid.getSelectionModel().deselectAll();
			//---Load PRitem to POitem Grid-----------
			var ponr = _this.trigPO.value;
			//console.log(qtnr);
			//alert(ponr);
			_this.gridItem.load({ponr: ponr });
			//----------------------------------------
			_this.poDialog.hide();
		});

		this.trigPO.onTriggerClick = function(){
			_this.poDialog.show();
		};
		
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
							o.setValue(r.data.kunnr);
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
             //_this.getForm().findField('adr11').setValue(_addr);

			grid.getSelectionModel().deselectAll();
			_this.vendorDialog.hide();
		});

		this.trigVendor.onTriggerClick = function(){
			_this.vendorDialog.show();
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

		return this.callParent(arguments);
	},	
	
	load : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'depositout/load',
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
		this.hdnDpItem.setValue(Ext.encode(rsItem));
		//var rsPayment = _this.gridPayment.getData();
		//this.hdnPpItem.setValue(Ext.encode(rsPayment));
		
		var rsGL = _this.gridGL.getData();
		this.hdnGlItem.setValue(Ext.encode(rsGL));
/*
		this.getForm().getFields().each(function(f){
			//console.log(f.name);
    		 if(!f.validate()){
    		 	var p = f.up();
    		 	console.log(p);
    			 console.log('invalid at : '+f.name);
    		 }
    	 });
*/
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
			url:__site_url+'depositout/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ recnr: 0 });
		//this.gridPayment.load({ recnr: 0 });
		
		// default status = wait for approve
		this.comboQStatus.setValue('01');
		//this.comboTax.setValue('01');
		//this.trigCurrency.setValue('THB');
		this.getForm().findField('bldat').setValue(new Date());
		this.formTotal.getForm().findField('exchg').setValue('1.0000');
	},
	
	// Calculate total functions
	calculateTotal: function(){
		var _this=this;
		var store = this.gridItem.store;
		var sum = 0;
		//var nets = this.numberPOamt.getValue();
		store.each(function(r){
			var itamt = 0;
			//var perct = parseFloat(r.data['perct'].replace(/[^0-9.]/g, ''));
				//pay = parseFloat(r.data['payrc'].replace(/[^0-9.]/g, ''));
			//var nets = _this.amtValue;
			//perct = isNaN(perct)?0:perct;
			//pay = isNaN(pay)?0:pay;
            var itamt = parseFloat(r.data['itamt'].replace(/[^0-9.]/g, ''));
			//var amt = itamt - pay;
			//itamt = nets * perct;
			//itamt = itamt / 100;
			sum += itamt;
		});
		this.formTotal.getForm().findField('beamt').setValue(sum);
		//this.gridItem.poValue = nets;
		var currency = this.trigCurrency.getValue();
		this.gridItem.curValue = currency;
		this.formTotal.getForm().findField('curr1').setValue(currency);
		var net = this.formTotal.calculate();
		
		//var currency = this.trigCurrency.getValue();
		if(currency != 'THB'){
	      var rate = this.formTotal.getForm().findField('exchg').getValue();
		  sum = sum * rate;
		}   
        if(sum>0){
        	//console.log(rsPM);
            _this.gridGL.load({
            	//paym:Ext.encode(rsPM),
            	netpr:sum,
            	//vvat:vats,
            	lifnr:this.trigVendor.getValue(),
            	rate:rate,
            	ptype:'01',
            	dtype:'01'
            }); 
           }
	},
	
	// Load GL functions
	loadGL: function(){
		var _this=this;
		var store = this.gridItem.store;
		var sum = 0;
		store.each(function(r){
			//var itamt = parseFloat(r.data['pramt'].replace(/[^0-9.]/g, '')),
				//pay = parseFloat(r.data['payrc'].replace(/[^0-9.]/g, ''));
			//itamt = isNaN(itamt)?0:itamt;
			//pay = isNaN(pay)?0:pay;
			//var amt = itamt - pay;
			var itamt = parseFloat(r.data['itamt'].replace(/[^0-9.]/g, ''));
			sum += itamt;
		});

		// set value to grid payment
		//var rsPM = _this.gridPayment.getData();
		// Set value to GL Posting grid  
		var currency = this.trigCurrency.getValue();
		if(currency != 'THB'){
	      var rate = this.formTotal.getForm().findField('exchg').getValue();
		  sum = sum * rate;
		}   
        if(sum>0){
        	//console.log(rsPM);
            _this.gridGL.load({
            	//paym:Ext.encode(rsPM),
            	netpr:sum,
            	kunnr:this.trigVendor.getValue(),
            	rate:rate,
            	dtype:'01'
            }); 
           }
	}
	
});