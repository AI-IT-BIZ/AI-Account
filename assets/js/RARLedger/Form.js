Ext.define('Account.RARLedger.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
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
		this.customerDialog = Ext.create('Account.SCustomer.MainWindow');
		this.customerDialog2 = Ext.create('Account.SCustomer.MainWindow');
				
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
			fieldLabel: 'Status',
			name : 'statu',
			labelWidth: 100,
			editable: false,
			triggerAction : 'all',
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: 'ALL',
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
			valueField: 'statx',
			value: 'ALL'
		});

		this.items = [{
// Doc Date
        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'datefield',
			fieldLabel: 'Selection Period',
			name: 'start_date',
			labelWidth: 100,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			allowBlank: false
			},{
			xtype: 'displayfield',
		    value: 'To',
		    width:40,
		    margins: '0 0 0 25'
		   	},{
			xtype: 'datefield',
			name: 'end_date',
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
			}]
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

	});
