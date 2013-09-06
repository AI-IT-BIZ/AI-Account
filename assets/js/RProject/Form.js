Ext.define('Account.RProject.Form', {
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
        this.projectDialog = Ext.create('Account.Project.MainWindow');
		this.customerDialog = Ext.create('Account.Customer.MainWindow');
		
		this.projectDialog2 = Ext.create('Account.Project.MainWindow');
		this.customerDialog2 = Ext.create('Account.Customer.MainWindow');
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Quotation Status',
			name : 'statu',
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

		this.comboPSale = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Saleperson',
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
		
		this.comboPSale2 = Ext.create('Ext.form.ComboBox', {
			name : 'salnr2',
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
		
		this.trigProject = Ext.create('Ext.form.field.Trigger', {
			name: 'jobnr',
			//labelWidth: 90,
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
			//labelWidth: 90,
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
		}];		

		// event trigCustomer///
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

		return this.callParent(arguments);
	},

	//load : function(id){
	//	this.getForm().load({
	//		params: { id: id },
	//		url:__site_url+'quotation/load'
	//	});
	//},


});

