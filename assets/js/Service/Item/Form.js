Ext.define('Account.Service.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'service/save',
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
			fieldLabel: 'Service Grp',
			name : 'matkl',
			//labelWidth: 100,
			//width: 300,
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
			fieldLabel: 'Service Type',
			name : 'mtart',
			//labelWidth: 100,
			//width: 300,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select Type --',
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


		this.items = [{
            xtype:'fieldset',
            title: 'Service Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
		items: [{
			xtype: 'textfield',
			fieldLabel: 'Service Code',
			name: 'matnr',
			allowBlank: false
		}, {
			xtype: 'textfield',
			fieldLabel: 'Service Name',
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
     items :[{
			xtype: 'textfield',
			fieldLabel: 'Unit 1',
			name: 'unit1',
			anchor:'90%',
			allowBlank: true
		},{
			xtype: 'textfield',
			fieldLabel: 'Unit 2',
			name: 'unit2',
			anchor:'90%',
			allowBlank: true
		},{
			xtype: 'textfield',
			fieldLabel: 'Unit 3',
			name: 'unit3',
			anchor:'90%',
			allowBlank: true
		}]
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

		//}]
		}];

		//return this.callParent(arguments);
	//},

		return this.callParent(arguments);
	},
	
	// load //
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'service/load'
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
	
	remove : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'service/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});