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
		
		// INIT Warehouse search popup //////
		this.customerDialog = Ext.create('Account.Customer.MainWindow');
		
		this.comboJType = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Project Type',
			name : 'jtype',
			labelWidth: 100,
			labelAlign: 'left',
			width: 250,
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
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			width: 250,
			clearFilterOnReset: true,
			emptyText: '-- Please Status --',
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
			valueField: 'statu',
			margins: '0 0 0 2'
		});
		
		this.comboPOwner = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Project Owner',
			name : 'salnr',
			labelWidth: 100,
			width: 300,
			labelAlign: 'left',
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
			labelAlign: 'left',
			enableKeyEvents: true,
			allowBlank : false
		});
		
		this.txtAmt = Ext.create('Ext.ux.form.NumericField', {
         	xtype: 'textfield',
			fieldLabel: 'Project Amount',
			name: 'pramt',
			labelAlign: 'left',
			width:250,
			labelWidth: 100
		});
		
		this.txtCost = Ext.create('Ext.ux.form.NumericField', {
         	xtype: 'textfield',
			fieldLabel: 'Estimate Cost',
			name: 'esamt',
			align: 'right',
			width:250,
			labelWidth: 100//,
			//margins: '0 0 0 10'
		});
		
     this.items = [{
			xtype:'fieldset',
            title: 'Customer Data',
            //defaultType: 'textfield',
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
			name: 'name1',
			margins: '0 0 0 6',
            width: 400,
            allowBlank: true
		}]
		},{
			xtype: 'textarea',
			fieldLabel: 'Address',
			labelAlign: 'left',
			name: 'adr01',
			width:500,
			allowBlank: true
         }]
        },{
         xtype: 'fieldset',
         title: 'Project Detail',
         defaultType: 'textfield',
     items: [{
     	xtype: 'container',
        layout: 'hbox',
        margin: '0 0 5 0',
     items: [{
			xtype: 'displayfield',
			fieldLabel: 'Project No',
			name: 'jobnr',
			labelAlign: 'left',
			width: 248,
			labelWidth: 100,
			value:'PJXXXX-XXXX',
			readOnly: true,
			labelStyle: 'font-weight:bold'
		},this.comboJStatus]
	   },{
     	xtype: 'container',
        layout: 'hbox',
        margin: '0 0 5 0',
     items: [this.comboJType,{
			xtype: 'datefield',
			fieldLabel: 'Project Date',
			name: 'bldat',
			labelWidth: 100,
			width: 250,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			//margin: '0 0 0 20',
			allowBlank: false
	    }]
	   },{
			xtype: 'textfield',
			fieldLabel: 'Project Name',
			name: 'jobtx',
			labelAlign: 'left',
			width: 500,
			labelWidth: 100,
			allowBlank: false
	
	    },{
			xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.comboPOwner,{
			xtype: 'displayfield',
            fieldLabel: '',
			name: 'name1',
			margins: '0 0 0 6',
		},{xtype: 'hidden',
			name: 'ctype',
			value: 'THB'}]
	
	    },{
	    	xtype: 'container',
                    layout: 'hbox',
                    margin: '0 0 5 0',
     items: [this.txtAmt,this.txtCost]
	   },{
	   	xtype: 'container',
                    layout: 'hbox',
                    margin: '0 0 5 0',
     items: [{
			xtype: 'datefield',
			fieldLabel: 'Start Date',
			name: 'stdat',
			labelAlign: 'left',
			labelWidth: 100,
			width: 250,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
	    },{
			xtype: 'datefield',
			fieldLabel: 'Finish Date',
			name: 'endat',
			labelWidth: 100,
			width: 250,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
	    }]
		}]
		//}]
		}];

		//return this.callParent(arguments);
	//},
	/****************************************************/
    if(arrPermit === undefined )
    {
       
    }
    else{
        if(arrPermit['PJ']['approve'] == "0")
           {
             this.comboJStatus.setDisabled(true);
           }
           else{
                this.comboJStatus.setDisabled(false);
        }
    }
    
   	/****************************************************/
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
							var _addr = r.data.adr01;
						  if(!Ext.isEmpty(r.data.distx))
                             _addr += ' '+r.data.distx;
                           if(!Ext.isEmpty(r.data.pstlz))
                             _addr += ' '+r.data.pstlz;
                           if(!Ext.isEmpty(r.data.telf1))
                            _addr += '\n'+'Tel: '+r.data.telf1;
                           if(!Ext.isEmpty(r.data.telfx))
                             _addr += '\n'+'Fax: '+r.data.telfx;
                           if(!Ext.isEmpty(r.data.email))
                            _addr += '\n'+'Email: '+r.data.email;
                            _this.getForm().findField('adr01').setValue(_addr);
							//_this.getForm().findField('adr01').setValue(r.data.adr01
							//+' '+r.data.distx+' '+r.data.pstlz+'\n'+'Tel '+r.data.telf1+'\n'+'Fax '
							//+r.data.telfx+'\n'+'Email '+r.data.email);
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
			
			var _addr = record.data.adr01;
			if(!Ext.isEmpty(record.data.distx))
              _addr += ' '+record.data.distx;
            if(!Ext.isEmpty(record.data.pstlz))
              _addr += ' '+record.data.pstlz;
            if(!Ext.isEmpty(record.data.telf1))
               _addr += '\n'+'Tel: '+record.data.telf1;
             if(!Ext.isEmpty(record.data.telfx))
               _addr += '\n'+'Fax: '+record.data.telfx;
             if(!Ext.isEmpty(record.data.email))
               _addr += '\n'+'Email: '+record.data.email;
             _this.getForm().findField('adr01').setValue(_addr);
			//_this.getForm().findField('adr01').setValue(record.data.adr01
			//+' '+record.data.distx+' '+record.data.pstlz+'\n'+'Tel '+record.data.telf1+'\n'+'Fax '
			//+record.data.telfx+'\n'+'Email '+record.data.email);

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
		var _this=this;
		
		this.getForm().load({
			params: { id: id },
			url:__site_url+'project/load'//,
			//success: function(form, act){
			//	_this.fireEvent('afterLoad', form, act);
			//}			
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
	},
	
	reset: function(){
		this.getForm().reset();

		// default status = wait for approve
		this.comboJStatus.setValue('01');
		this.getForm().findField('bldat').setValue(new Date());
	}
});