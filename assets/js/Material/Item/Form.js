Ext.define('Account.Material.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'material/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'right',
				msgTarget: 'qtip',//'side',
				labelWidth: 105,
				//width:300,
				//labelStyle: 'font-weight:bold'
			}
		});
		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		// INIT Warehouse search popup ///////
		//this.customerDialog = Ext.create('Account.Customer.MainWindow');
		
		this.comboMGrp = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Material Grp',
			name : 'matkl',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select Group --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'material/loads_gcombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'matkl'
					}
				},
				fields: [
					'matkl',
					'matxt'
				],
				remoteSort: true,
				sorters: 'matkl ASC'
			}),
			queryMode: 'remote',
			displayField: 'matxt',
			valueField: 'matkl'
		});
		
		this.comboMType = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Material Type',
			name : 'mtart',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Select Type --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'material/loads_tcombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'mtart'
					}
				},
				fields: [
					'mtart',
					'matxt'
				],
				remoteSort: true,
				sorters: 'mtart ASC'
			}),
			queryMode: 'remote',
			displayField: 'matxt',
			valueField: 'mtart'
		});
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Material Status',
			name : 'statu',
			labelAlign: 'right',
			//width: 286,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			margin: '0 0 0 10',
			clearFilterOnReset: true,
			emptyText: '-- Select Status --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'customer/loads_acombo',
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
		
		this.unit1Dialog = Ext.create('Account.Unit.Window');
		
		this.trigUnit1 = Ext.create('Ext.form.field.Trigger', {
			name: 'unit1',
			fieldLabel: 'Unit 1',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
			//width:290,
		});
		
		this.unit2Dialog = Ext.create('Account.Unit.Window');
		
		this.trigUnit2 = Ext.create('Ext.form.field.Trigger', {
			name: 'unit2',
			fieldLabel: 'Unit 2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
			//width:290,
		});
		
		this.unit3Dialog = Ext.create('Account.Unit.Window');
		
		this.trigUnit3 = Ext.create('Ext.form.field.Trigger', {
			name: 'unit3',
			fieldLabel: 'Unit 3',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
			//width:290,
		});
		
		this.items = [{
						xtype: 'hidden',
						name: 'id'
					},{
            xtype:'fieldset',
            title: 'Material Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
		items: [{
			xtype: 'textfield',
			fieldLabel: 'Material Code',
			name: 'matnr',
			allowBlank: false
		}, {
			xtype: 'textfield',
			fieldLabel: 'Material Name',
			name: 'maktx',
			width: 400,
			allowBlank: true
		}, this.comboMGrp,this.comboMType, 
		  {
			xtype: 'textfield',
			fieldLabel: 'Unit',
			name: 'meins',
			allowBlank: true
		}, {
			xtype: 'textfield',
			//xtype: 'filefield',
            id: 'form-file',
            emptyText: 'Select a GL account',
			fieldLabel: 'GL Account',
			name: 'saknr',
			allowBlank: true,
			buttonText: '',
            buttonConfig: {
                iconCls: 'b-small-pencil'
            }
            }]
		}, {
// Frame number 2	
			xtype:'fieldset',
            title: 'Balance Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
     items :[{
		xtype: 'numberfield',
			fieldLabel: 'Beginning Qty',
			name: 'beqty',
			allowBlank: true
		},{
			xtype: 'numberfield',
			fieldLabel: 'Beginning Value',
			name: 'beval',
			allowBlank: true
		}, {
			xtype: 'numberfield',
			fieldLabel: 'Average Cost',
			name: 'cosav',
			allowBlank: true
		}, {
			xtype: 'numberfield',
			fieldLabel: 'Ending Qty',
			name: 'enqty',
			allowBlank: true
		}, {
			xtype: 'numberfield',
			fieldLabel: 'Ending Value',
			name: 'enval',
			allowBlank: true
		}]
	},{
// Frame number 3	
			xtype:'fieldset',
            title: 'Costing Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
            items: [{
            xtype: 'container',
            anchor: '100%',
            layout: 'hbox',
            items:[{
                xtype: 'container',
                flex: 1,
                layout: 'anchor',
        items :[this.trigUnit1,this.trigUnit2,this.trigUnit3]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'anchor',
        items: [{
			xtype: 'numberfield',
			fieldLabel: 'Cost 1',
			name: 'cost1',
			anchor:'100%',
			labelWidth: 90,
			allowBlank: true
		},{
			xtype: 'numberfield',
			fieldLabel: 'Cost 2',
			minValue: 0,
			name: 'cost2',
			anchor:'100%',
			labelWidth: 90,
			allowBlank: true
		},{
			xtype: 'numberfield',
			fieldLabel: 'Cost 3',
			minValue: 0,
			name: 'cost3',
			anchor:'100%',
			labelWidth: 90,
			allowBlank: true
		}
		]
		}]
		}]
		},this.comboQStatus];

	// event trigUnit1//
		this.trigUnit1.on('keyup',function(o, e){
			
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'unit/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.meins);
							//_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

						}else{
							o.markInvalid('Could not find Unit : '+o.getValue());
						}
					}
				});
			}
		}, this);

			_this.unit1Dialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigUnit1.setValue(record.data.meins);
			//_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);
			
			grid.getSelectionModel().deselectAll();
			_this.unit1Dialog.hide();
		});

		this.trigUnit1.onTriggerClick = function(){
			_this.unit1Dialog.show();
		};	
		
		// event trigUnit2//
		this.trigUnit2.on('keyup',function(o, e){
			
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'unit/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.meins);
							//_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

						}else{
							o.markInvalid('Could not find Unit : '+o.getValue());
						}
					}
				});
			}
		}, this);

			_this.unit2Dialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigUnit2.setValue(record.data.meins);
			//_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);
			
			grid.getSelectionModel().deselectAll();
			_this.unit2Dialog.hide();
		});

		this.trigUnit2.onTriggerClick = function(){
			_this.unit2Dialog.show();
		};	
		
		// event trigUnit3//
		this.trigUnit3.on('keyup',function(o, e){
			
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'unit/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.meins);
							//_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

						}else{
							o.markInvalid('Could not find Unit : '+o.getValue());
						}
					}
				});
			}
		}, this);

			_this.unit3Dialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigUnit3.setValue(record.data.meins);
			//_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);
			
			grid.getSelectionModel().deselectAll();
			_this.unit3Dialog.hide();
		});

		this.trigUnit3.onTriggerClick = function(){
			_this.unit3Dialog.show();
		};	
		
	return this.callParent(arguments);
	},
	
	// load //
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'material/load'
		});
	},
	
	// save //
	save : function(){
		var _this=this;
		var _form_basic = this.getForm();
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
	
	reset: function(){
		this.getForm().reset();

		// default status = wait for approve
		this.comboQStatus.setValue('01');
	},
	
	remove : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'material/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});