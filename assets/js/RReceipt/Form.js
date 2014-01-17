Ext.define('Account.RReceipt.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			//url: __site_url+'quotation/loads',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',//'side',
				labelWidth: 105
				//width:300,
				//labelStyle: 'font-weight:bold'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
        // INIT Customer search popup ///////////////////////////////////
        this.receiptDialog = Ext.create('Account.Receipt.MainWindow');
        this.invoiceDialog = Ext.create('Account.SInvoice.MainWindow');
		this.customerDialog = Ext.create('Account.SCustomer.MainWindow');
		
		this.receiptDialog2 = Ext.create('Account.Receipt.MainWindow');
		this.invoiceDialog2 = Ext.create('Account.SInvoice.MainWindow');
		this.customerDialog2 = Ext.create('Account.SCustomer.MainWindow');
		
		this.trigReceipt = Ext.create('Ext.form.field.Trigger', {
			name: 'recnr',
			labelWidth: 100,
			fieldLabel: 'Receipt Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigReceipt2 = Ext.create('Ext.form.field.Trigger', {
			name: 'recnr2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		
		this.trigInvoice = Ext.create('Ext.form.field.Trigger', {
			name: 'invnr',
			labelWidth: 100,
			fieldLabel: 'Invoice Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigInvoice2 = Ext.create('Ext.form.field.Trigger', {
			name: 'invnr2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});

		this.trigCustomer = Ext.create('Ext.form.field.Trigger', {
			name: 'kunnr',
			fieldLabel: 'Customer Code',
			triggerCls: 'x-form-search-trigger',
			labelWidth: 100,
			enableKeyEvents: true
		});
		
		this.trigCustomer2 = Ext.create('Ext.form.field.Trigger', {
			name: 'kunnr2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Receipt Status',
			name : 'statu',
			labelWidth: 100,
			editable: false,
			triggerAction : 'all',
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

		this.items = [{
// Doc Date
        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'datefield',
			fieldLabel: 'Document Date',
			name: 'bldat',
			labelWidth: 100,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
			},{
			xtype: 'displayfield',
		    value: 'To',
		    width:40,
		    margins: '0 0 0 25'
		   },{
			xtype: 'datefield',
			name: 'bldat2',
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
			}]
			},
// Receipt Code			
       {
	    xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigReceipt,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigReceipt2] 
// Invoice Code		
		},{
	    xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigInvoice,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigInvoice2]  
// Customer Code
		},{
          xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'hidden',
			name: 'id'
		},this.trigCustomer,
		
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigCustomer2]   
		},{
			xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.comboQStatus,
		{
			xtype: 'displayfield',
		    value: 'To',
                    hidden:true,
		    width:40,
		    margins: '0 0 0 25'
		  },
		this.comboQStatus2]    
		}
////////////////////////////////////////////////		
		];
		// event trigReceipt///
		this.trigReceipt.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'receipt/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.recnr);
							
						}else{
							o.markInvalid('Could not find receipt code : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		this.trigReceipt2.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'receipt/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.recnr);
							
						}else{
							o.markInvalid('Could not find receipt code : '+o.getValue());
						}
					}
				});
			}
		}, this);


		_this.receiptDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigReceipt.setValue(record.data.recnr);

			grid.getSelectionModel().deselectAll();
			_this.receiptDialog.hide();
		});
		
		_this.receiptDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigReceipt2.setValue(record.data.recnr);

			grid.getSelectionModel().deselectAll();
			_this.receiptDialog2.hide();
		});

		this.trigReceipt.onTriggerClick = function(){
			_this.receiptDialog.show();
		};
		
		this.trigReceipt2.onTriggerClick = function(){
			_this.receiptDialog2.show();
		};
		
		// event trigInvoice///
		this.trigInvoice.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'invoice/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.invnr);
							
						}else{
							o.markInvalid('Could not find invoice code : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		this.trigInvoice2.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'invoice/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.invnr);
							
						}else{
							o.markInvalid('Could not find invoice code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.invoiceDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigInvoice.setValue(record.data.invnr);

			grid.getSelectionModel().deselectAll();
			_this.invoiceDialog.hide();
		});
		
		_this.invoiceDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigInvoice2.setValue(record.data.invnr);

			grid.getSelectionModel().deselectAll();
			_this.invoiceDialog2.hide();
		});

		this.trigInvoice.onTriggerClick = function(){
			_this.invoiceDialog.show();
		};
		
		this.trigInvoice2.onTriggerClick = function(){
			_this.invoiceDialog2.show();
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
							
						}else{
							o.markInvalid('Could not find customer code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.customerDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigCustomer.setValue(record.data.kunnr);
			//_this.getForm().findField('name1').setValue(record.data.name1);

			grid.getSelectionModel().deselectAll();
			_this.customerDialog.hide();
		});

		this.trigCustomer.onTriggerClick = function(){
			_this.customerDialog.show();
		};
		
		this.trigCustomer2.on('keyup',function(o, e){
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
							
						}else{
							o.markInvalid('Could not find customer code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.customerDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigCustomer2.setValue(record.data.kunnr);

			grid.getSelectionModel().deselectAll();
			_this.customerDialog2.hide();
		});

		this.trigCustomer2.onTriggerClick = function(){
			_this.customerDialog2.show();
		};

		return this.callParent(arguments);
	},

	//load : function(id){
	//	this.getForm().load({
	//		params: { id: id },
	//		url:__site_url+'quotation/load'
	//	});
	//},

	});