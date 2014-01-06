Ext.define('Account.Employee.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'employee/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'right',
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
		
		// INIT Warehouse search popup //////
		this.distrDialog = Ext.create('Account.SDistrict.MainWindow');
		this.positDialog = Ext.create('Account.SPosition.MainWindow');
		this.superDialog = Ext.create('Account.SEmployee.MainWindow');
		this.bankDialog = Ext.create('Account.Bankname.MainWindow');

		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Employee Status',
			name : 'statu',
			//labelWidth: 100,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			margin: '0 0 0 43',
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
		
		this.trigDistr = Ext.create('Ext.form.field.Trigger', {
			name: 'distx',
			fieldLabel: 'Province',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			labelAlign: 'left',
			labelWidth:110,
			width:290,
		});
		
		this.trigPosit = Ext.create('Ext.form.field.Trigger', {
			name: 'postx',
			fieldLabel: 'Position',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			labelAlign: 'left',
			labelWidth:110,
			width:290,
		});

// event trigSupervisor//		
		this.trigSuper = Ext.create('Ext.form.field.Trigger', {
			name: 'supnr',
			fieldLabel: 'Supervisor',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			labelAlign: 'left',
			labelWidth:110,
			width:290,
		});
		
// event trigBank//
		this.trigBank = Ext.create('Ext.form.field.Trigger', {
			name: 'bcode',
			fieldLabel: 'Bank Name',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			labelAlign: 'left',
			labelWidth:110,
			width:290,
		});
		
		this.numberSalary = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'Base Salary',
			name: 'salar',
			labelAlign: 'right',
			width:200,
			hideTrigger:false,
			align: 'right',
			margin: '0 0 0 43'
         });
		
     this.items = [{
			xtype:'fieldset',
            title: 'Employee Data',
            //defaultType: 'textfield',
     items:[{
                xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			   xtype: 'textfield',
               fieldLabel: 'Employee Name',
			   name: 'name1',
               width: 400,
               labelWidth:110,
               labelAlign: 'left',
               allowBlank: false
		    },{
                xtype:'displayfield',
				fieldLabel: 'Employee Code',
				name: 'empnr',
                emptyText: 'XXXXX',
				readOnly: true,
				labelAlign: 'left',
				labelWidth:110,
				width:160,
				margin: '0 0 0 15',
				value: 'XXXXX',
				labelStyle: 'font-weight:bold'
            },{
			xtype: 'hidden',
			name: 'id'
		},{
			xtype: 'hidden',
			name: 'depnr'
		},{
			xtype: 'hidden',
			name: 'posnr'
		}]
		},{
			xtype: 'textarea',
			fieldLabel: 'Address',
			labelAlign: 'left',
			name: 'adr01',
			labelWidth:110,
			width:440,
			allowBlank: true
         },{
         	xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigDistr,
             {
			    xtype: 'textfield',
			    fieldLabel: 'Post Code',
		        name: 'pstlz',
		        emptyText: 'xxxxx',
		        labelAlign: 'right',
		        maskRe: /[\d\-]/,
		        regex: /^\d{5}$/,
		        regexText: 'Must be in the format xxxxx',
                margin: '0 0 0 43'
            }]	
	},{
     	xtype: 'container',
        layout: 'hbox',
        margin: '0 0 5 0',
     items: [{
				xtype: 'textfield',
			    fieldLabel: 'Phone Number',
		        name: 'telf1',
		        labelAlign: 'left',
		        labelWidth:110,
		        width: 290//,
		        //emptyText: 'xxx-xxxxxxx',
		        //maskRe: /[\d\-]/,
             },{
				xtype: 'textfield',
			    fieldLabel: 'ID Card',
		        name: 'cidno',
		        labelAlign: 'right',
		        margin: '0 0 0 43'
             }]
	   },{
     	xtype: 'container',
        layout: 'hbox',
        margin: '0 0 5 0',
     items: [{
                 xtype: 'textfield',
				 fieldLabel: 'Email',
				 name: 'email',
				 labelAlign: 'left',
				 labelWidth:110,
		         width: 440
                }, {
                }]
	   }]
        },{
         xtype: 'fieldset',
         title: 'Employee Detail',
         defaultType: 'textfield',
     items: [{
     	xtype: 'container',
        layout: 'hbox',
        margin: '0 0 5 0',
     items: [this.trigPosit, 
                {
                	xtype: 'displayfield',
					fieldLabel: 'Department',
		            name: 'deptx',
		            labelAlign: 'right',
		            margin: '0 0 0 43'
                }]
	   },{
     	xtype: 'container',
        layout: 'hbox',
        margin: '0 0 5 0',
     items: [this.trigSuper,{
					xtype: 'displayfield',
		            name: 'suptx',
		            margin: '0 0 0 5'
                }]
	   },{
			xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
                	xtype: 'datefield',
					fieldLabel: 'Starting Date',
		            name: 'begdt',
		            labelAlign: 'left',
		            labelWidth:110,
		            width: 290
                }, 
                this.numberSalary]
	
	    },{
	    	xtype: 'container',
                    layout: 'hbox',
                    margin: '0 0 5 0',
     items: [this.trigBank,{
					xtype: 'textfield',
					fieldLabel: 'Bank Account',
		            name: 'saknr',
		            labelAlign: 'right',
		            emptyText: 'xxxxxxxxxx',
		            maskRe: /[\d\-]/,
		            margin: '0 0 0 43'
                }]
	   },{
	    	xtype: 'container',
                    layout: 'hbox',
                    margin: '0 0 5 0',
     items: [{
                	xtype: 'textfield',
					fieldLabel: 'Contact Person',
					name: 'pson1',
					labelAlign: 'left',
					labelWidth:110,
		            width: 440
                },{
                }]
	   },{
	    	xtype: 'container',
                    layout: 'hbox',
                    margin: '0 0 5 0',
     items: [{
					xtype: 'textfield',
					fieldLabel: 'Phone Number',
		            name: 'telf2',
		            labelAlign: 'left',
		            labelWidth:110,
		            width: 290//,
		            //emptyText: 'xxx-xxxxxxx',
		           // maskRe: /[\d\-]/,
                },this.comboQStatus
           ]
	   }]
		//}]
		}];
	
// event trigDistr//
		this.trigDistr.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'sdistrict/loads',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							_this.trigDistr.setValue(r.data.distx);

						}else{
							o.markInvalid('Could not find Province : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.distrDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigDistr.setValue(record.data.distx);

			grid.getSelectionModel().deselectAll();
			_this.distrDialog.hide();
		});

		this.trigDistr.onTriggerClick = function(){
			_this.distrDialog.show();
		};

// event trigPosition//		
		this.trigPosit.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'sposition/loads',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							_this.trigPosit.setValue(r.data.postx);
							_this.getForm().findField('depnr').setValue(r.data.depnr);
							_this.getForm().findField('posnr').setValue(r.data.posnr);
							_this.getForm().findField('deptx').setValue(r.data.deptx);

						}else{
							o.markInvalid('Could not find Position : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.positDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigPosit.setValue(record.data.postx);
			_this.getForm().findField('deptx').setValue(record.data.deptx);
			_this.getForm().findField('depnr').setValue(record.data.depnr);
		    _this.getForm().findField('posnr').setValue(record.data.posnr);

			grid.getSelectionModel().deselectAll();
			_this.positDialog.hide();
		});

		this.trigPosit.onTriggerClick = function(){
			_this.positDialog.grid.load();
			_this.positDialog.show();
		};

// event trigSupervisor//
		this.trigSuper.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'semployee/loads',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							_this.trigSuper.setValue(r.data.empnr);
							_this.getForm().findField('suptx').setValue(r.data.name1);

						}else{
							o.markInvalid('Could not find Supervisor : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.superDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigSuper.setValue(record.data.empnr);
			_this.getForm().findField('suptx').setValue(record.data.name1);

			grid.getSelectionModel().deselectAll();
			_this.superDialog.hide();
		});

		this.trigSuper.onTriggerClick = function(){
			_this.superDialog.show();
		};	

// event trigBank//
		this.trigBank.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'bankname/loads',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							_this.trigBank.setValue(r.data.bcode);

						}else{
							o.markInvalid('Could not find Bank Name : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.bankDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigBank.setValue(record.data.bcode);

			grid.getSelectionModel().deselectAll();
			_this.bankDialog.hide();
		});

		this.trigBank.onTriggerClick = function(){
			_this.bankDialog.grid.load();
			_this.bankDialog.show();
		};
		
		return this.callParent(arguments);
	},
	
	// load //
	load : function(id){
		var _this=this;
		
		this.getForm().load({
			params: { id: id },
			url:__site_url+'employee/load'//,
			//success: function(form, act){
			//_this.fireEvent('afterLoad', form, act);
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
			url:__site_url+'employee/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	reset: function(){
		this.getForm().reset();

// default status = wait for approve
		this.comboQStatus.setValue('01');
	}
});