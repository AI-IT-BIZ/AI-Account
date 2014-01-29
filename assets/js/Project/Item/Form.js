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
			}
		});
		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		// INIT Warehouse search popup //////
		this.customerDialog = Ext.create('Account.SCustomer.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});

		this.saleDialog = Ext.create('Account.Saleperson.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});

		this.typeDialog = Ext.create('Account.SProjecttype.Window');

		this.trigType = Ext.create('Ext.form.field.Trigger', {
			name: 'jtype',
			fieldLabel: 'Project Type',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			labelWidth: 100,
			labelAlign: 'left',
			width: 250
		});

		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			readOnly: !UMS.CAN.APPROVE('PJ'),
			fieldLabel: 'Project Status',
			name : 'statu',
			labelWidth: 100,
			labelAlign: 'left',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			width: 250,
			clearFilterOnReset: true,
			emptyText: '-- Please Status --',
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
			value: '01',
			valueField: 'statu'//,
			//margins: '0 0 0 2'
		});

		this.trigCustomer = Ext.create('Ext.form.field.Trigger', {
			name: 'kunnr',
			fieldLabel: 'Customer Code',
			triggerCls: 'x-form-search-trigger',
			labelAlign: 'left',
			enableKeyEvents: true,
			allowBlank : false
		});

		this.trigSale = Ext.create('Ext.form.field.Trigger', {
			name: 'salnr',
			fieldLabel: 'Project Owner',
			triggerCls: 'x-form-search-trigger',
			labelWidth: 100,
			labelAlign: 'left',
			width: 250,
			enableKeyEvents: true,
			allowBlank : false
		});

		this.txtAmt = Ext.create('Ext.ux.form.NumericField', {
         	xtype: 'textfield',
			fieldLabel: 'Project Amount',
			name: 'pramt',
			labelAlign: 'left',
			width:250,
			minValue: 0,
			allowBlank: false,
			labelWidth: 100
		});

		this.txtCost = Ext.create('Ext.ux.form.NumericField', {
         	xtype: 'textfield',
			fieldLabel: 'Estimate Cost',
			name: 'esamt',
			align: 'right',
			width:250,
			minValue: 0,
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
			},{
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
     	xtype: 'container',
        layout: 'hbox',
        margin: '0 0 5 0',
     items: [ {
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigType,{
						xtype: 'displayfield',
						name: 'typtx',
						margins: '4 0 0 6',
						width:286//,
						//allowBlank: false
                }]
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
     items :[this.trigSale,{
			xtype: 'displayfield',
            fieldLabel: '',
			name: 'emnam',
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
			allowBlank : false,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
	    },{
			xtype: 'datefield',
			fieldLabel: 'Finish Date',
			name: 'endat',
			labelWidth: 100,
			width: 250,
			allowBlank : false,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
	    }]
		},this.comboQStatus]
		//}]
		}];

		//return this.callParent(arguments);
	//},
	/****************************************************/
    //if(arrPermit === undefined )
    //{

    //}
    //else{
        //if(arrPermit['PJ']['approve'] == "0")
         //  {
         //    this.comboQStatus.setDisabled(true);
         //  }
         //  else{
         //    this.comboQStatus.setDisabled(false);
        //}
   // }

   	/****************************************************/
   	// event trigType//
		this.trigType.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'project/load_type',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.jtype);
							//_this.trigType.setValue(r.data.jtype);
			_this.getForm().findField('typtx').setValue(r.data.typtx);

						}else{
							o.setValue('');
			_this.getForm().findField('typtx').setValue('');
							o.markInvalid('Could not find Project type : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.typeDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigType.setValue(record.data.jtype);
			_this.getForm().findField('typtx').setValue(record.data.typtx);

			grid.getSelectionModel().deselectAll();
			_this.typeDialog.hide();

		});

		this.trigType.onTriggerClick = function(){
			_this.typeDialog.grid.load();
			_this.typeDialog.show();
		};

	// event Customer ///
		this.trigCustomer.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'customer/load2',
					method: 'POST',
					params: {
						id: v,
						key: 1
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.kunnr);
							_this.getForm().findField('name1').setValue(r.data.name1);
                            _this.getForm().findField('adr01').setValue(r.data.adr01);
						}else{
							o.setValue('');
							_this.getForm().findField('name1').setValue('');
                            _this.getForm().findField('adr01').setValue('');
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

			grid.getSelectionModel().deselectAll();
			_this.customerDialog.hide();
		});

		this.trigCustomer.onTriggerClick = function(){
			_this.customerDialog.show();
		};

		// event Saleperson///
		this.trigSale.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'saleperson/load',
					method: 'POST',
					params: {
						id: v,
						key: 1
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.salnr);
							_this.getForm().findField('emnam').setValue(r.data.emnam);

						}else{
							o.setValue('');
							_this.getForm().findField('emnam').setValue('');
							o.markInvalid('Could not find project owner : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.saleDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigSale.setValue(record.data.salnr);
			_this.getForm().findField('emnam').setValue(record.data.emnam);

			grid.getSelectionModel().deselectAll();
			_this.saleDialog.hide();
		});

		this.trigSale.onTriggerClick = function(){
			_this.saleDialog.show();
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
		console.log(this.getInvalidFields());
		if (_form_basic.isValid()) {
			_form_basic.submit({
				success: function(form_basic, action) {
					form_basic.reset();
					_this.fireEvent('afterSave', _this, action);
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
		this.comboQStatus.setValue('01');
		this.getForm().findField('bldat').setValue(new Date());
	},
	getInvalidFields: function() {
	    var invalidFields = [];
	    Ext.suspendLayouts();
	    this.form.getFields().filterBy(function(field) {
	        if (field.validate()) return;
	        invalidFields.push(field);
	    });
	    Ext.resumeLayouts(true);
	    return invalidFields;
	}
});