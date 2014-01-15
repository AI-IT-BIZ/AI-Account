Ext.define('Account.RInvoice.Form', {
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
        this.invoiceDialog = Ext.create('Account.SInvoice.MainWindow');
        //this.saleorderDialog = Ext.create('Account.Saleorder.MainWindow');
        //this.projectDialog = Ext.create('Account.Project.MainWindow');
		this.customerDialog = Ext.create('Account.SCustomer.MainWindow');
		
		this.invoiceDialog2 = Ext.create('Account.SInvoice.MainWindow');
		//this.saleorderDialog2 = Ext.create('Account.Saleorder.MainWindow');
        //this.projectDialog2 = Ext.create('Account.Project.MainWindow');
		this.customerDialog2 = Ext.create('Account.SCustomer.MainWindow');
        
        
           this.dateDoc1 = Ext.create('Ext.form.field.Date', {
			fieldLabel: 'Document Date',
			name: 'bldat',
			labelWidth: 100,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
			});
                        
               this.dateDoc2 = Ext.create('Ext.form.field.Date', {
			name: 'bldat2',
			labelWidth: 100,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
			});
        
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Invoice Status',
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

		/*this.comboPSale = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Saleperson',
			name : 'salnr',
			labelWidth: 100,
			editable: false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select Saleperson --',
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
		
		this.comboPSale2 = Ext.create('Ext.form.ComboBox', {
			name : 'salnr',
			editable: false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select Saleperson --',
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
		});*/
		
		this.trigInvoice = Ext.create('Ext.form.field.Trigger', {
			name: 'invnr',
			labelWidth: 100,
			fieldLabel: 'Invoice No',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigInvoice2 = Ext.create('Ext.form.field.Trigger', {
			name: 'invnr2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		/*this.trigSaleorder = Ext.create('Ext.form.field.Trigger', {
			name: 'ordnr',
			labelWidth: 100,
			fieldLabel: 'So No',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigSaleorder2 = Ext.create('Ext.form.field.Trigger', {
			name: 'ordnr2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});*/

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

		this.items = [{

// Project Code
        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[ this.dateDoc1,{
			xtype: 'displayfield',
		    value: 'To',
		    width:40,
		    margins: '0 0 0 25'
		   }, this.dateDoc2]
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
// Quotation Code
		/*},{
     	xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigSaleorder,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigSaleorder2]*/
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
		},/*{
			
          xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.comboPSale,
		{
			xtype: 'displayfield',
		    value: 'To',
		    width:40,
		    margins: '0 0 0 25'
		  },
		this.comboPSale2]  
		},*/{
			xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.comboQStatus,
		{
			
		  }]    
		}
////////////////////////////////////////////////		
		];
		
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
		
		// event trigQuotation///
		/*this.trigSaleorder.on('keyup',function(o, e){
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
							o.setValue(r.data.vbeln);
							
						}else{
							o.markInvalid('Could not find Saleorder code : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		this.trigSaleorder2.on('keyup',function(o, e){
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
							o.setValue(r.data.vbeln);
							
						}else{
							o.markInvalid('Could not find Saleorder code : '+o.getValue());
						}
					}
				});
			}
		}, this);


		_this.saleorderDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigSaleorder.setValue(record.data.vbeln);

			grid.getSelectionModel().deselectAll();
			_this.saleorderDialog.hide();
		});
		
		_this.saleorderDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigSaleorder2.setValue(record.data.vbeln);

			grid.getSelectionModel().deselectAll();
			_this.saleorderDialog2.hide();
		});

		this.trigSaleorder.onTriggerClick = function(){
			_this.saleorderDialog.show();
		};
		
		this.trigSaleorder2.onTriggerClick = function(){
			_this.saleorderDialog2.show();
		};*/

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