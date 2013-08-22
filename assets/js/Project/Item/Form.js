Ext.define('Account.Project.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'project/save',
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
		this.customerDialog = Ext.create('Account.Customer.MainWindow');
		
		this.comboJType = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Project Type',
			name : 'jtype',
			labelWidth: 100,
			//width: 300,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select Type --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'project/loads_tcombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'jtype'
					}
				},
				fields: [
					'jtype',
					'jobtx'
				],
				remoteSort: true,
				sorters: 'jtype ASC'
			}),
			queryMode: 'remote',
			displayField: 'jobtx',
			valueField: 'jtype'
		});
		
		this.comboJStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Project Status',
			name : 'statu',
			labelWidth: 100,
			//width: 300,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select Status --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'project/loads_scombo',
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
		
		this.comboPOwner = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Project Owner',
			name : 'salnr',
			labelWidth: 100,
			width: 300,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select Owner --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'project/loads_ocombo',
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
		
		this.trigCustomer = Ext.create('Ext.form.field.Trigger', {
			name: 'kunnr',
			fieldLabel: 'Customer Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});
		
		this.items = [{
			xtype:'fieldset',
            title: 'Customer Data',
            //collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
     items:[{
                xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'hidden',
			name: 'id'
		},this.trigCustomer,{
			xtype: 'displayfield',
            fieldLabel: '',
            //flex: 3,
            //value: '<span style="color:green;"></span>'
			name: 'name1',
			margins: '0 0 0 6',
            //emptyText: 'Customer
            width: 600,
            allowBlank: true
		}]
		},{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [{
			xtype: 'textarea',
			fieldLabel: 'Address',
			name: 'adr01',
			anchor:'90%',
			width:450,
			allowBlank: true
		},{
            fieldLabel: 'Phone Number',
            labelWidth: 105,
            name: 'telf1',
            width: 205,
            emptyText: 'xxx-xxx-xxxx',
            maskRe: /[\d\-]/,
            regex: /^\d{3}-\d{3}-\d{4}$/,
            regexText: 'Must be in the format xxx-xxx-xxxx'
         
         }]
         }]
        },{
         xtype: 'fieldset',
         title: 'Project Detail',
         defaultType: 'textfield',
         layout: 'anchor',
         defaults: {
                  anchor: '100%'
                },
     items: [{
     	xtype: 'container',
        layout: 'hbox',
        margin: '0 0 5 0',
     items: [{
			xtype: 'textfield',
			fieldLabel: 'Project No',
			name: 'jobnr',
			anchor:'100%',
			labelWidth: 100,
			allowBlank: false
		},this.comboJStatus]
	   },{
     	xtype: 'container',
        layout: 'hbox',
        margin: '0 0 5 0',
     items: [this.comboJType,{
			xtype: 'datefield',
			fieldLabel: 'Project Date',
			name: 'bldat',
			anchor:'100%',
			labelWidth: 100,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			allowBlank: false
	    }]
	   },{
			xtype: 'textfield',
			fieldLabel: 'Project Name',
			name: 'jobtx',
			width: 555,
			labelWidth: 100,
			allowBlank: false
	
	    },{
			xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.comboPOwner,{
			xtype: 'displayfield',
            fieldLabel: '',
            //flex: 3,
            //value: '<span style="color:green;"></span>'
			name: 'name1',
			margins: '0 0 0 6',
            //emptyText: 'Customer',
            allowBlank: true
		}]
	
	    },{
	    	xtype: 'container',
                    layout: 'hbox',
                    margin: '0 0 5 0',
     items: [{
			xtype: 'numberfield',
			fieldLabel: 'Project Amount',
			name: 'pramt',
			anchor:'100%',
			labelWidth: 100,
			allowBlank: true
	    },{
			xtype: 'numberfield',
			fieldLabel: 'Estimate Cost',
			name: 'esamt',
			anchor:'100%',
			labelWidth: 100,
			allowBlank: true
	    }]
	   },{
	   	xtype: 'container',
                    layout: 'hbox',
                    margin: '0 0 5 0',
     items: [{
			xtype: 'datefield',
			fieldLabel: 'Start Date',
			name: 'stdat',
			anchor:'100%',
			labelWidth: 100,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			allowBlank: true
	    },{
			xtype: 'datefield',
			fieldLabel: 'End Date',
			name: 'endat',
			anchor:'100%',
			labelWidth: 100,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			allowBlank: true
	    },{
			xtype: 'displayfield',
			fieldLabel: '',
			name: 'datam',
			anchor:'100%',
			Width: 30,
			allowBlank: true
	    }]
		}]
		//}]
		}];

		//return this.callParent(arguments);
	//},
	
	// event ///
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
							_this.getForm().findField('name1').setValue(r.data.name1);
							_this.getForm().findField('adr01').setValue(r.data.adr01);
							_this.getForm().findField('telf1').setValue(r.data.telf1);
						}else{
							o.markInvalid('Could not find customer code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.customerDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigCustomer.setValue(record.data.kunnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			_this.getForm().findField('adr01').setValue(record.data.adr01);
			_this.getForm().findField('telf1').setValue(record.data.telf1);

			grid.getSelectionModel().deselectAll();
			_this.customerDialog.hide();
		});

		this.trigCustomer.onTriggerClick = function(){
			_this.customerDialog.show();
		};

		return this.callParent(arguments);
	},
	
	// load //
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'project/load'
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
			url:__site_url+'project/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});