Ext.define('Account.RPayment.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			//url: __site_url+'quotation/report',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',//'side',
				labelWidth: 105
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
        // INIT Customer search popup ///////////////////////////////////
		

//---Create Selection--------------------------------------------
        this.paymentDialog = Ext.create('Account.SPayment.MainWindow');
		this.paymentDialog2 = Ext.create('Account.SPayment.MainWindow');
		this.apDialog = Ext.create('Account.SAp.MainWindow');
		this.apDialog2 = Ext.create('Account.SAp.MainWindow');
		
		this.vendorDialog = Ext.create('Account.SVendor.MainWindow');
		this.vendorDialog2 = Ext.create('Account.SVendor.MainWindow');
		
		this.trigPayment = Ext.create('Ext.form.field.Trigger', {
			name: 'payno',
			fieldLabel: 'Payment No',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigPayment2 = Ext.create('Ext.form.field.Trigger', {
			name: 'payno2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigAP = Ext.create('Ext.form.field.Trigger', {
			name: 'invnr',
			fieldLabel: 'AP No',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigAP2 = Ext.create('Ext.form.field.Trigger', {
			name: 'invnr2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigVendor = Ext.create('Ext.form.field.Trigger', {
			name: 'lifnr',
			//labelWidth: 90,
			fieldLabel: 'Vendor Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigVendor2 = Ext.create('Ext.form.field.Trigger', {
			name: 'lifnr2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
//---End Create Selection------------------------------------------------------------
//---event triger----------------------------------------------------------------	
		// event trigPayment//
		this.trigPayment.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'payment/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.payno);

						}else{
							o.markInvalid('Could not find Payment : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.paymentDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigPayment.setValue(record.data.payno);

			grid.getSelectionModel().deselectAll();
			_this.paymentDialog.hide();
		});

		this.trigPayment.onTriggerClick = function(){
			_this.paymentDialog.show();
		};
		
		// event trigPayment2//
		this.trigPayment2.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'payment/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.payno);

						}else{
							o.markInvalid('Could not find Payment : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.paymentDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigPayment2.setValue(record.data.payno);

			grid.getSelectionModel().deselectAll();
			_this.paymentDialog2.hide();
		});

		this.trigPayment2.onTriggerClick = function(){
			_this.paymentDialog2.show();
		};
		
        // event trigAP//
		this.trigAP.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'ap/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.invnr);

						}else{
							o.markInvalid('Could not find Invoice : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.apDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigAP.setValue(record.data.invnr);

			grid.getSelectionModel().deselectAll();
			_this.apDialog.hide();
		});

		this.trigAP.onTriggerClick = function(){
			_this.apDialog.show();
		};
		
		// event trigPayment2//
		this.trigAP2.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'ap/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.invnr);

						}else{
							o.markInvalid('Could not find AP : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.apDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigAP2.setValue(record.data.invnr);

			grid.getSelectionModel().deselectAll();
			_this.apDialog2.hide();
		});

		this.trigAP2.onTriggerClick = function(){
			_this.apDialog2.show();
		};
		
		// event trigVendor//
		this.trigVendor.on('keyup',function(o, e){
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
							o.setValue(r.data.lifnr);

						}else{
							o.markInvalid('Could not find vendor code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.vendorDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigVendor.setValue(record.data.lifnr);

			grid.getSelectionModel().deselectAll();
			_this.vendorDialog.hide();
		});

		this.trigVendor.onTriggerClick = function(){
			_this.vendorDialog.show();
		};

		// event trigVendor2//
		this.trigVendor2.on('keyup',function(o, e){
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
							o.setValue(r.data.lifnr);

						}else{
							o.markInvalid('Could not find vendor code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.vendorDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigVendor2.setValue(record.data.lifnr);

			grid.getSelectionModel().deselectAll();
			_this.vendorDialog2.hide();
		});

		this.trigVendor2.onTriggerClick = function(){
			_this.vendorDialog2.show();
		};
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Payment Status',
			name : 'statu',
			//labelWidth: 100,
			editable: false,
			triggerAction : 'all',
			triggerAction : 'all',
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
//---end event triger----------------------------------------------------------------	

		this.items = [{

// Project Code
        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'datefield',
			fieldLabel: 'Document Date',
			name: 'bldat',
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
     items :[this.trigPayment,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigPayment2]
// Vendor Code
		},{
     	xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigAP,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigAP2]
// Vendor Code
		},{
          xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'hidden',
			name: 'id'
		},this.trigVendor,
		
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigVendor2]   
		},{
			xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.comboQStatus,
		{
			
		  }]    
		}];		

		return this.callParent(arguments);
	},

	//load : function(id){
	//	this.getForm().load({
	//		params: { id: id },
	//		url:__site_url+'quotation/load'
	//	});
	//},


});

