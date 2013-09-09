Ext.define('Account.RPR.Form', {
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
		
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'PR Status',
			name : 'statu',
			editable: false,
			triggerAction : 'all',
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Select Status --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'po/loads_combo/apov/statu/statx',  //loads_tycombo($tb,$pk,$like)	
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
			name : 'statu2',
			editable: false,
			triggerAction : 'all',
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Select Status --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'po/loads_combo/apov/statu/statx',  //loads_tycombo($tb,$pk,$like)	
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

//---Create Selection--------------------------------------------
		
        this.prDialog = Ext.create('Account.PR2.MainWindow');
		this.prDialog2 = Ext.create('Account.PR2.MainWindow');
		
		this.vendorDialog = Ext.create('Account.Vendor.MainWindow');
		this.vendorDialog2 = Ext.create('Account.Vendor.MainWindow');
		
		
		this.trigPR = Ext.create('Ext.form.field.Trigger', {
			name: 'purnr',
			//labelWidth: 90,
			fieldLabel: 'PR Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigPR2 = Ext.create('Ext.form.field.Trigger', {
			name: 'purnr2',
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
		
		// event trigPR//
		this.trigPR.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'pr2/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.purnr);

						}else{
							o.markInvalid('Could not find purchase requisitions code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.prDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigPR.setValue(record.data.purnr);

			grid.getSelectionModel().deselectAll();
			_this.prDialog.hide();
		});

		this.trigPR.onTriggerClick = function(){
			_this.prDialog.show();
		};
		
		// event trigPR2
		this.trigPR2.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'pr2/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.purnr);

						}else{
							o.markInvalid('Could not find purchase requisitions code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.prDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigPR2.setValue(record.data.purnr);

			grid.getSelectionModel().deselectAll();
			_this.prDialog2.hide();
		});

		this.trigPR2.onTriggerClick = function(){
			_this.prDialog2.show();
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
//---end event triger----------------------------------------------------------------	

		this.items = [{

// Project Code
        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'datefield',
			fieldLabel: 'Date',
			name: 'bldat1',
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
     items :[this.trigPR,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigPR2]
// Customer Code
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
		    width:40,
		    margins: '0 0 0 25'
		  },
		this.comboQStatus2]    
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

