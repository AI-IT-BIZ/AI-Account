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
		this.quotationDialog = Ext.create('Account.Quotation.MainWindow');
		this.customerDialog = Ext.create('Account.Customer.MainWindow');
		
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
		this.formTotal = Ext.create('Account.Invoice.Item.Form_t', {
			border: true,
			split: true,
			title:'Total Invoice',
			region:'south'
		});
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'INV Status',
			name : 'statu',
			labelAlign: 'right',
			//labelWidth: 95,
			width: 240,
			editable: false,
			margin: '0 0 0 -20',
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
			//labelWidth: 95,
			width: 350,
			//anchor:'80%',
			//labelAlign: 'right',
			editable: false,
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
			//labelWidth: 95,
			width: 350,
			//anchor:'80%',
			//labelAlign: 'right',
			editable: false,
			//allowBlank : false,
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
			fieldLabel: 'Tax',
			name : 'taxnr',
			//labelWidth: 70,
			//anchor:'90%',
			width: 240,
			margin: '0 0 0 5',
			labelAlign: 'right',
			editable: false,
			//allowBlank : false,
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

// Partial Payment Period	
		this.comboPeriod = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Partial Payment',
			name : 'paypr',
			width: 240,
			valueField: 'paypr',
			labelAlign: 'left',
			//editable: false,
			allowBlank : true,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Select Period --',
			//listeners:{
           //scope: yourScope,
           //'select': yourFunction
           // },
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'invoice/loads_percombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'paypr'
					}
				},
				fields: [
					'paypr',
					'sgtxt'
				],
				remoteSort: true,
				sorters: 'paypr ASC'
			}),
			queryMode: 'remote',
			//displayField: 'paypr',
			tpl: Ext.create('Ext.XTemplate',
            '<tpl for=".">',
                '<div class="x-boundlist-item">{paypr} - {sgtxt}</div>',
            '</tpl>'
            ),
            // template for the content inside text field
            displayTpl: Ext.create('Ext.XTemplate',
            '<tpl for=".">',
               '{paypr} - {sgtxt}',
            '</tpl>'
            )
	  		
		});
		
		this.hdnIvItem = Ext.create('Ext.form.Hidden', {
			name: 'vbrp'
		});
		
        this.trigQuotation = Ext.create('Ext.form.field.Trigger', {
			name: 'vbeln',
			fieldLabel: 'Quotation No',
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
			items: [this.hdnIvItem,{
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
		},this.trigQuotation,{
			xtype: 'displayfield',
			//xtype: 'textfield',
            //fieldLabel: 'jobtx',
            //flex: 3,
            //value: '<span style="color:green;"></span>'
			name: 'jobtx',
			width:350,
			margins: '0 0 0 6',
            //emptyText: 'Customer',
            allowBlank: true
		},{
			xtype: 'displayfield',
            fieldLabel: 'Invoice No',
            name: 'invnr',
            //flex: 3,
            value: 'IVXXXX-XXXX',
            labelAlign: 'right',
			//name: 'qt',
			width:240,
			//margins: '0 0 0 10',
            //emptyText: 'Customer',
            readOnly: true,
			labelStyle: 'font-weight:bold'
		}]
		},{
// Partial Payment
     	xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.comboPeriod,{
			xtype: 'displayfield',
			//xtype: 'textfield',
            //fieldLabel: 'jobtx',
            //flex: 3,
            //value: '<span style="color:green;"></span>'
			name: 'sgtxt',
			width:350,
			margins: '0 0 0 6',
            //emptyText: 'Customer',
            allowBlank: true
		},{
			xtype: 'datefield',
			fieldLabel: 'Date',
			name: 'bldat',
			//anchor:'80%',
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
            //fieldLabel: '',
            //flex: 3,
            //value: '<span style="color:green;"></span>'
			name: 'name1',
			//labelAlign: 'l',
			margins: '0 0 0 6',
			width:350,
            //emptyText: 'Customer',
            allowBlank: true
		},{
			xtype: 'datefield',
			fieldLabel: 'Due Date',
			name: 'duedt',
			//anchor:'80%',
			labelAlign: 'right',
			width:240,
			//readOnly: true,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'//,
			//allowBlank: false
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
			anchor:'90%',
			width:350,
			rows:2,
			labelAlign: 'top',
			allowBlank: true
		},{
            xtype: 'textarea',
			fieldLabel: 'Ship To',
			name: 'adr11',
			anchor:'90%',
			width:355,
			rows:2,
			labelAlign: 'right',
			labelAlign: 'top',
			margin: '0 0 0 130',
			allowBlank: true
         }]
// Sale Person         
         },{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [this.comboPSale ,{
			xtype: 'numberfield',
			fieldLabel: 'Terms',
			name: 'terms',
			//anchor:'80%',
			labelAlign: 'right',
			width:200,
			margin: '0 0 0 25',
			allowBlank: true
		},{
			xtype: 'displayfield',
			//fieldLabel: '%',
			//name: 'taxpr',
			//align: 'right',
			//labelWidth: 5,
			//anchor:'90%',
			margin: '0 0 0 5',
			width:10,
			value: 'Days',
			allowBlank: true
		},this.comboTax]
// Tax&Ref no.
         },{
         xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [this.comboPay,{
            xtype: 'textfield',
			fieldLabel: 'Reference No',
			name: 'refnr',
			//anchor:'90%',
			width:240,
			labelAlign: 'right',
			margin: '0 0 0 25',
			//width:450,
			allowBlank: true
         },this.comboQStatus
         ]
         },{
         xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [this.comboCond,{
            xtype: 'displayfield',
			//fieldLabel: 'Reference No',
			//name: 'refnr',
			//anchor:'90%',
			width:240,
			labelAlign: 'right',
			margin: '0 0 0 25',
			//width:450,
			allowBlank: true
         }
         ]
       }]
		}]
		};
		
		this.items = [mainFormPanel,this.gridItem,
		{
			xtype:'tabpanel',
			region:'south',
			activeTab: 0,
			height:170,
			//border: false,
			items: [
				this.formTotal,
				this.gridGL
			]
		}
			
		];
		
		// event comboPeriod///
		//this.comboPeriod.on('select',function(o, e){
			
		//}, this);
		
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
							_this.getForm().findField('jobtx').setValue(r.data.jobtx);
							
			_this.getForm().findField('kunnr').setValue(record.data.kunnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			_this.getForm().findField('salnr').setValue(record.data.salnr);				
						}else{
							o.markInvalid('Could not find quotation no : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		_this.quotationDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigQuotation.setValue(record.data.vbeln);
			_this.getForm().findField('jobtx').setValue(record.data.jobtx);
			
			_this.getForm().findField('kunnr').setValue(record.data.kunnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			_this.getForm().findField('salnr').setValue(record.data.salnr);
             
			grid.getSelectionModel().deselectAll();
			_this.quotationDialog.hide();
		});

		this.trigQuotation.onTriggerClick = function(){
			_this.quotationDialog.show();
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
							var _addr = r.data.adr01;
						   if(!Ext.isEmpty(r.data.distx))
                             _addr += ' '+r.data.distx;
                           if(!Ext.isEmpty(r.data.pstlz))
                             _addr += ' '+r.data.pstlz;
                           if(!Ext.isEmpty(r.data.telf1))
                            _addr += '\n'+'Tel: '+r.data.telf1;
                           if(!Ext.isEmpty(r.data.telfx))
                             _addr += ' '+'Fax: '+r.data.telfx;
                           if(!Ext.isEmpty(r.data.email))
                            _addr += '\n'+'Email: '+r.data.email;
                            _this.getForm().findField('adr01').setValue(_addr);
                            _this.getForm().findField('adr11').setValue(_addr);
							
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
             _this.getForm().findField('adr11').setValue(_addr);

			grid.getSelectionModel().deselectAll();
			_this.customerDialog.hide();
		});

		this.trigCustomer.onTriggerClick = function(){
			_this.customerDialog.show();
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
			url:__site_url+'invoice/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ vbeln: 0 });
		//this.gridPayment.load({ vbeln: 0 });

		// default status = wait for approve
		this.comboQStatus.setValue('05');
		this.comboCond.setValue('01');
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