Ext.define('Account.Quotation.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'quotation/save',
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

		this.comboPSale = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Saleperson',
			name : 'salnr',
			//labelWidth: 95,
			width: 350,
			editable: false,
			//allowBlank : false,
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
		
		this.comboPay = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Payments',
			name : 'ptype',
			//labelWidth: 95,
			width: 350,
			//anchor:'80%',
			//labelAlign: 'right',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please Select Payments --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'quotation/loads_tcombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'ptype'
					}
				},
				fields: [
					'ptype',
					'paytx'
				],
				remoteSort: true,
				sorters: 'ptype ASC'
			}),
			queryMode: 'remote',
			displayField: 'paytx',
			valueField: 'ptype'
		});
		
		this.comboTax = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Tax',
			name : 'taxnr',
			//labelWidth: 70,
			//anchor:'90%',
			width: 240,
			margin: '0 0 0 5',
			labelAlign: 'right',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select Tax --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'quotation/loads_taxcombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'taxnr'
					}
				},
				fields: [
					'taxnr',
					'taxtx'
				],
				remoteSort: true,
				sorters: 'taxnr ASC'
			}),
			queryMode: 'remote',
			displayField: 'taxtx',
			valueField: 'taxnr'
		});

		this.items = [{
			xtype:'fieldset',
            title: 'Header Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
     items:[{
// Project Code
     	xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'hidden',
			name: 'id'
		},{
			xtype: 'textfield',
			fieldLabel: 'Project Code',
			name: 'jobnr',
			//flex: 2,
			//anchor:'90%',
			labelAlign: 'letf',
			width:240,
			allowBlank: false
		},{
			xtype: 'displayfield',
			//xtype: 'textfield',
            //fieldLabel: 'jobtx',
            //flex: 3,
            //value: '<span style="color:green;"></span>'
			name: 'jobtx',
			width:350,
			margins: '0 0 0 6',
            //emptyText: 'Customer',
            allowBlank: true
		},{
			xtype: 'textfield',
            fieldLabel: 'Quotation No',
            name: 'vbeln',
            //flex: 3,
            value: 'QTxxxx-xxxx',
            labelAlign: 'right',
			//name: 'qt',
			width:240,
			//margins: '0 0 0 10',
            //emptyText: 'Customer',
            allowBlank: true
		}]
// Customer Code
		},{
                xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'textfield',
			fieldLabel: 'Customer Code',
			name: 'kunnr',
			//flex: 2,
			//anchor:'90%',
			width:240,
			labelAlign: 'letf',
			allowBlank: false
		},{
			xtype: 'displayfield',
            //fieldLabel: '',
            //flex: 3,
            //value: '<span style="color:green;"></span>'
			name: 'name1',
			//labelAlign: 'l',
			margins: '0 0 0 6',
			width:350,
            //emptyText: 'Customer',
            allowBlank: true
		},{
			xtype: 'datefield',
			fieldLabel: 'Date',
			name: 'bldat',
			//anchor:'80%',
			labelAlign: 'right',
			width:240,
			allowBlank: true
		}]
// Address Bill&Ship
		},{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [{
			xtype: 'textarea',
			fieldLabel: 'Bill To',
			name: 'adr01',
			anchor:'90%',
			width:350,
			labelAlign: 'top',
			allowBlank: true
		},{
            xtype: 'textarea',
			fieldLabel: 'Ship To',
			name: 'adr01',
			anchor:'90%',
			width:350,
			labelAlign: 'right',
			labelAlign: 'top',
			margin: '0 0 0 135',
			allowBlank: true
         }]
// Sale Person         
         },{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [this.comboPSale ,{
			xtype: 'numberfield',
			fieldLabel: 'Terms',
			name: 'terms',
			//anchor:'80%',
			labelAlign: 'right',
			width:200,
			margin: '0 0 0 25',
			allowBlank: true
		},{
			xtype: 'displayfield',
			//fieldLabel: '%',
			//name: 'taxpr',
			//align: 'right',
			//labelWidth: 5,
			//anchor:'90%',
			margin: '0 0 0 5',
			width:10,
			value: 'Days',
			allowBlank: true
		},this.comboTax]
// Tax&Ref no.
         },{
         xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [this.comboPay,{
            xtype: 'textfield',
			fieldLabel: 'Reference No',
			name: 'refnr',
			//anchor:'90%',
			width:240,
			labelAlign: 'right',
			margin: '0 0 0 25',
			//width:450,
			allowBlank: true
         },{
            xtype: 'textfield',
			fieldLabel: 'Exchg.Rate',
			name: 'exchg',
			//anchor:'80%',
			labelAlign: 'right',
			width:240,
			margin: '0 0 0 -20',
			allowBlank: true
         },{
			xtype: 'displayfield',
			//fieldLabel: '%',
			//name: 'taxpr',
			//align: 'right',
			//labelWidth: 5,
			//anchor:'90%',
			margin: '0 0 0 5',
			width:15,
			value: 'THB/USD',
			allowBlank: true
		}]
         }]

		//}]
		}];

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'project/load'
		});
	},
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
			url:__site_url+'quotation/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});