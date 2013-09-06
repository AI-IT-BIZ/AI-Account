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
        this.invoiceDialog = Ext.create('Account.Invoice.MainWindow');
        this.quotationDialog = Ext.create('Account.Quotation.MainWindow');
        this.projectDialog = Ext.create('Account.Project.MainWindow');
		this.customerDialog = Ext.create('Account.Customer.MainWindow');
		
		this.invoiceDialog2 = Ext.create('Account.Invoice.MainWindow');
		this.quotationDialog2 = Ext.create('Account.Quotation.MainWindow');
        this.projectDialog2 = Ext.create('Account.Project.MainWindow');
		this.customerDialog2 = Ext.create('Account.Customer.MainWindow');
        
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
		
		this.comboQStatus2 = Ext.create('Ext.form.ComboBox', {
			name : 'statu',
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

		this.comboPSale = Ext.create('Ext.form.ComboBox', {
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
		});
		
		this.trigInvoice = Ext.create('Ext.form.field.Trigger', {
			name: 'invnr',
			labelWidth: 100,
			fieldLabel: 'Invoice Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigInvoice2 = Ext.create('Ext.form.field.Trigger', {
			name: 'invnr',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigQuotation = Ext.create('Ext.form.field.Trigger', {
			name: 'vbeln',
			labelWidth: 100,
			fieldLabel: 'Quotation Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigQuotation2 = Ext.create('Ext.form.field.Trigger', {
			name: 'vbeln2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigProject = Ext.create('Ext.form.field.Trigger', {
			name: 'jobnr',
			labelWidth: 100,
			fieldLabel: 'Project Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigProject2 = Ext.create('Ext.form.field.Trigger', {
			name: 'jobnr2',
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
			name: 'kunnr',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});

		this.items = [{

// Project Code
        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'datefield',
			fieldLabel: 'Date',
			name: 'bldat1',
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
		},{
     	xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigQuotation,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigQuotation2]
// Project Code
	    },{
     	xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigProject,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigProject2]
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
     items :[this.comboPSale,
		{
			xtype: 'displayfield',
		    value: 'To',
		    width:40,
		    margins: '0 0 0 25'
		  },
		this.comboPSale2]  
		},{
			xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.comboQStatus,
		{
			xtype: 'displayfield',
		    value: 'To',
		    width:40,
		    margins: '0 0 0 25'
		  },
		this.comboQStatus2]    
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
							o.setValue(r.data.vbeln);
							
						}else{
							o.markInvalid('Could not find quotation code : '+o.getValue());
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
							o.setValue(r.data.vbeln);
							
						}else{
							o.markInvalid('Could not find quotation code : '+o.getValue());
						}
					}
				});
			}
		}, this);


		_this.invoiceDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigInvoice.setValue(record.data.vbeln);

			grid.getSelectionModel().deselectAll();
			_this.invoiceDialog.hide();
		});
		
		_this.invoiceDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigInvoice2.setValue(record.data.vbeln);

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
							
						}else{
							o.markInvalid('Could not find quotation code : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		this.trigQuotation2.on('keyup',function(o, e){
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
							
						}else{
							o.markInvalid('Could not find quotation code : '+o.getValue());
						}
					}
				});
			}
		}, this);


		_this.quotationDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigQuotation.setValue(record.data.vbeln);

			grid.getSelectionModel().deselectAll();
			_this.quotationDialog.hide();
		});
		
		_this.quotationDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigQuotation2.setValue(record.data.vbeln);

			grid.getSelectionModel().deselectAll();
			_this.quotationDialog2.hide();
		});

		this.trigQuotation.onTriggerClick = function(){
			_this.quotationDialog.show();
		};
		
		this.trigQuotation2.onTriggerClick = function(){
			_this.quotationDialog2.show();
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

						}else{
							o.markInvalid('Could not find project code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.projectDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigProject.setValue(record.data.jobnr);

			grid.getSelectionModel().deselectAll();
			_this.projectDialog.hide();
		});

		this.trigProject.onTriggerClick = function(){
			_this.projectDialog.show();
		};
		
		this.trigProject2.on('keyup',function(o, e){
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

						}else{
							o.markInvalid('Could not find project code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.projectDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigProject2.setValue(record.data.jobnr);

			grid.getSelectionModel().deselectAll();
			_this.projectDialog2.hide();
		});

		this.trigProject2.onTriggerClick = function(){
			_this.projectDialog2.show();
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