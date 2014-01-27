Ext.define('Account.RAPLedger.Form', {
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
        // INIT Vendor search popup ///////////////////////////////////
		this.vendorDialog = Ext.create('Account.SVendor.MainWindow');
		this.vendorDialog2 = Ext.create('Account.SVendor.MainWindow');
				
		this.trigVendor = Ext.create('Ext.form.field.Trigger', {
			name: 'lifnr',
			fieldLabel: 'Vendor Code',
			triggerCls: 'x-form-search-trigger',
			labelWidth: 100,
			enableKeyEvents: true
		});
		
		this.trigVendor2 = Ext.create('Ext.form.field.Trigger', {
			name: 'lifnr2',
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
					
		// event trigVendor///
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
							o.markInvalid('Could not find Vendor code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.vendorDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigVendor.setValue(record.data.lifnr);
			//_this.getForm().findField('name1').setValue(record.data.name1);

			grid.getSelectionModel().deselectAll();
			_this.vendorDialog.hide();
		});

		this.trigVendor.onTriggerClick = function(){
			_this.vendorDialog.show();
		};
		
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
							o.markInvalid('Could not find Vendor code : '+o.getValue());
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

		return this.callParent(arguments);
	},

	});
