Ext.define('Account.Asset.Item.Form', {
	extend	: 'Ext.form.Panel',

	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'asset/save',
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
		
		this.typeDialog = Ext.create('Account.SAssettype.Window');
		
		this.trigType = Ext.create('Ext.form.field.Trigger', {
			name: 'mtart',
			fieldLabel: 'Asset Type',
			triggerCls: 'x-form-search-trigger',
			allowBlank: false,
			enableKeyEvents: true
		});
		
		this.grpDialog = Ext.create('Account.SAssetgrp.Window');
		
		this.trigGrp = Ext.create('Ext.form.field.Trigger', {
			name: 'matkl',
			fieldLabel: 'Asset Group',
			triggerCls: 'x-form-search-trigger',
			allowBlank: false,
			enableKeyEvents: true
		});
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			readOnly: !UMS.CAN.APPROVE('FA'),
			fieldLabel: 'Asset Status',
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
			allowBlank: false,
			valueField: 'statu'
		});	
		
		this.glnoDialog = Ext.create('Account.GL.MainWindow');
		
		this.trigGlno = Ext.create('Ext.form.field.Trigger', {
			name: 'saknr',
			fieldLabel: 'GL Account',
			triggerCls: 'x-form-search-trigger',
			allowBlank: false,
			enableKeyEvents: true
		});
		
		this.empDialog = Ext.create('Account.SEmployee.MainWindow');
		
		this.trigEmp = Ext.create('Ext.form.field.Trigger', {
			name: 'reque',
			fieldLabel: 'Requesting By',
			triggerCls: 'x-form-search-trigger',
			allowBlank: false,
			enableKeyEvents: true
		});
		
		this.emp2Dialog = Ext.create('Account.SEmployee.MainWindow');
		
		this.trigEmp2 = Ext.create('Ext.form.field.Trigger', {
			name: 'holds',
			fieldLabel: 'Asset Holder',
			triggerCls: 'x-form-search-trigger',
			allowBlank: false,
			enableKeyEvents: true
		});
		
		this.emp3Dialog = Ext.create('Account.SEmployee.MainWindow');
		
		this.trigEmp3 = Ext.create('Ext.form.field.Trigger', {
			name: 'lastn',
			fieldLabel: 'Last Holder',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.depDialog = Ext.create('Account.SDepartment.MainWindow');
		
		this.trigDep = Ext.create('Ext.form.field.Trigger', {
			name: 'depnr',
			fieldLabel: 'Department',
			triggerCls: 'x-form-search-trigger',
			allowBlank: false,
			enableKeyEvents: true
		});
		
		this.assetDialog = Ext.create('Account.SAsset.MainWindow');
		
		this.trigAsset = Ext.create('Ext.form.field.Trigger', {
			name: 'assnr',
			fieldLabel: 'Under Asset',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
			//width:290,
		});
		
		this.unitDialog = Ext.create('Account.SUnit.Window');
		
		this.trigUnit = Ext.create('Ext.form.field.Trigger', {
			name: 'meins',
			fieldLabel: 'Unit',
			triggerCls: 'x-form-search-trigger',
			editable: false,
			enableKeyEvents: true
			//width:290,
		});
		
		this.txtResidValue = Ext.create('Ext.ux.form.NumericField', {
			xtype: 'textfield',
			fieldLabel: 'Residual Value',
			name: 'resid',
			minValue: 0,
			margins: '3 0 0 5',
			alwaysDisplayDecimals: true
         });
         
         this.txtCostValue = Ext.create('Ext.ux.form.NumericField', {
			xtype: 'textfield',
			fieldLabel: 'Cost Value',
			name: 'costv',
			minValue: 0,
			//readOnly: true,
			alwaysDisplayDecimals: true
         });
         
         this.txtLifeValue = Ext.create('Ext.ux.form.NumericField', {
			xtype: 'textfield',
			fieldLabel: 'Use full life(year)',
			readOnly: true,
			margins: '3 0 0 5',
			name: 'lifes'//,
			//alwaysDisplayDecimals: true
         });
         
         this.txtDepreValue = Ext.create('Ext.ux.form.NumericField', {
			xtype: 'textfield',
			fieldLabel: 'Depreciation(%)',
			minValue:0,
			maxValue:100,
			name: 'depre'//,
			//alwaysDisplayDecimals: true
         });
		
		this.items = [{
						xtype: 'hidden',
						name: 'id'
					},{
            xtype:'fieldset',
            title: 'Asset Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            //defaults: {
            //    anchor: '100%'
            //},
		items: [{
			xtype:'displayfield',
			fieldLabel: 'Asset Code',
			name: 'matnr',
			readOnly: true,
			value: 'FAXXXXX'
		}, {
			xtype: 'textfield',
			fieldLabel: 'Asset Name',
			name: 'maktx',
			width: 400,
			allowBlank: false
		}, {
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigType,{
						xtype: 'displayfield',
						name: 'mtype',
						margins: '3 0 0 5',
						width:286
                }]
            }, {
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigGrp,{
						xtype: 'displayfield',
						name: 'mgrpp',
						margins: '3 0 0 5',
						width:286
                }]
            },{
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigGlno,{
						xtype: 'displayfield',
						name: 'sgtxt',
						margins: '3 0 0 5',
						width:286//,
						//allowBlank: false
                }]
            },{
			xtype: 'textfield',
			fieldLabel: 'Serial No',
			name: 'serno',
			//width: 250
		},{
			xtype: 'textfield',
			fieldLabel: 'Brand',
			name: 'brand',
			//width: 250
		},{
			xtype: 'textfield',
			fieldLabel: 'Model',
			name: 'model',
			//width: 250
		},{
			xtype: 'textfield',
			fieldLabel: 'Specification',
			name: 'specs',
			//width: 250
		},/*{
			xtype: 'textfield',
			fieldLabel: 'Picture',
			name: 'pictu',
			//width: 250
		},*/
		  this.trigUnit]
		}, {
// Frame number 2	
			xtype:'fieldset',
            title: 'General Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
     items :[{
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigAsset,{
						xtype: 'displayfield',
						name: 'asstx',
						margins: '3 0 0 5',
						width:286
                }]
            },{
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigEmp,{
						xtype: 'displayfield',
						name: 'reqtx',
						margins: '3 0 0 5',
						width:286
                }]
            },{
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigEmp2,{
						xtype: 'displayfield',
						name: 'hodtx',
						margins: '3 0 0 5',
						width:286
                }]
            },{
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigEmp3,{
						xtype: 'displayfield',
						name: 'lastx',
						margins: '3 0 0 5',
						width:286
                }]
            },{
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigDep,{
						xtype: 'displayfield',
						name: 'deptx',
						margins: '3 0 0 5',
						width:286
                }]
            },{
                xtype: 'container',
                layout: 'hbox',
                items :[{
			xtype: 'textfield',
			fieldLabel: 'Keeping Area',
			name: 'keepi',
			allowBlank: false
		},this.txtResidValue
		]},{
                xtype: 'container',
                layout: 'hbox',
                items :[this.txtDepreValue,this.txtLifeValue
		]},{
                xtype: 'container',
                layout: 'hbox',
                items :[{
			xtype: 'textfield',
			fieldLabel: 'GR No',
			readOnly: true,
			name: 'ebeln'
			//width: 400
		},{
			xtype: 'datefield',
			fieldLabel: 'GR Date',
			name: 'bldat',
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			margins: '3 0 0 5',
			value: new Date(),
			submitFormat:'Y-m-d'
		}
		]},this.txtCostValue,]
	},this.comboQStatus];
		
		// event trigType//
		this.trigType.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'asset/load_type',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							//o.setValue(r.data.mtart);
							_this.trigType.setValue(r.data.mtart);
			_this.getForm().findField('mtype').setValue(r.data.matxt);


						}else{
							o.markInvalid('Could not find asset type : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.typeDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigType.setValue(record.data.mtart);
			_this.getForm().findField('mtype').setValue(record.data.matxt);

			grid.getSelectionModel().deselectAll();
			_this.typeDialog.hide();
		});

		this.trigType.onTriggerClick = function(){
			_this.typeDialog.grid.load();
			_this.typeDialog.show();
		};	
		
		// event trigGrp//
		this.trigGrp.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'asset/load_grp',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							//o.setValue(r.data.matkl);
							_this.trigGrp.setValue(r.data.matkl);
			_this.getForm().findField('mgrpp').setValue(r.data.matxt);
			_this.getForm().findField('mtart').setValue(r.data.mtart);
			_this.getForm().findField('saknr').setValue(r.data.saknr);
			_this.getForm().findField('sgtxt').setValue(r.data.sgtxt);
			_this.getForm().findField('depre').setValue(r.data.depre);

						}else{
							o.markInvalid('Could not find asset group : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.grpDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigGrp.setValue(record.data.matkl);
			_this.getForm().findField('mgrpp').setValue(record.data.matxt);
			_this.getForm().findField('mtart').setValue(record.data.mtart);
			_this.getForm().findField('saknr').setValue(record.data.saknr);
			_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);
			_this.getForm().findField('depre').setValue(record.data.depre);

			grid.getSelectionModel().deselectAll();
			_this.grpDialog.hide();
		});

		this.trigGrp.onTriggerClick = function(){
			_this.grpDialog.grid.load();
			_this.grpDialog.show();
		};	
    
    
    // event trigUnit//
		this.trigUnit.on('keyup',function(o, e){
			
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

			_this.unitDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigUnit.setValue(record.data.meins);
			//_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);
			
			grid.getSelectionModel().deselectAll();
			_this.unitDialog.hide();
		});

		this.trigUnit.onTriggerClick = function(){
			_this.unitDialog.grid.load();
			_this.unitDialog.show();
		};
		
		// event trigGlno//
		this.trigGlno.on('keyup',function(o, e){
			
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'gl/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.saknr);
							_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

						}else{
							o.markInvalid('Could not find GL Account : '+o.getValue());
						}
					}
				});
			}
		}, this);

			_this.glnoDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigGlno.setValue(record.data.saknr);
			_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);
			
			grid.getSelectionModel().deselectAll();
			_this.glnoDialog.hide();
		});

		this.trigGlno.onTriggerClick = function(){
			_this.glnoDialog.grid.load();
			_this.glnoDialog.show();
		};	
		
		// event trigEmployee//
		this.trigEmp.on('keyup',function(o, e){
			
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'semployee/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.empnr);
							_this.getForm().findField('reqtx').setValue(record.data.name1);

						}else{
							o.markInvalid('Could not find Requesting by : '+o.getValue());
						}
					}
				});
			}
		}, this);

			_this.empDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigEmp.setValue(record.data.empnr);
			_this.getForm().findField('reqtx').setValue(record.data.name1);
			
			grid.getSelectionModel().deselectAll();
			_this.empDialog.hide();
		});

		this.trigEmp.onTriggerClick = function(){
			//_this.empDialog.grid.load();
			_this.empDialog.show();
		};	
		
		// event trigEmployee2//
		this.trigEmp2.on('keyup',function(o, e){
			
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'semployee/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.empnr);
							_this.getForm().findField('hodtx').setValue(record.data.name1);

						}else{
							o.markInvalid('Could not find Holder : '+o.getValue());
						}
					}
				});
			}
		}, this);

			_this.emp2Dialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigEmp2.setValue(record.data.empnr);
			_this.getForm().findField('hodtx').setValue(record.data.name1);
			
			grid.getSelectionModel().deselectAll();
			_this.emp2Dialog.hide();
		});

		this.trigEmp2.onTriggerClick = function(){
			//_this.emp2Dialog.grid.load();
			_this.emp2Dialog.show();
		};
		
		// event trigEmployee3//
		this.trigEmp3.on('keyup',function(o, e){
			
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'semployee/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.empnr);
							_this.getForm().findField('lastx').setValue(record.data.name1);

						}else{
							o.markInvalid('Could not find Last Holder : '+o.getValue());
						}
					}
				});
			}
		}, this);

			_this.emp3Dialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigEmp3.setValue(record.data.empnr);
			_this.getForm().findField('lastx').setValue(record.data.name1);
			
			grid.getSelectionModel().deselectAll();
			_this.emp3Dialog.hide();
		});

		this.trigEmp3.onTriggerClick = function(){
			//_this.emp3Dialog.grid.load();
			_this.emp3Dialog.show();
		};
		
		// event trigAsset//
		this.trigAsset.on('keyup',function(o, e){
			
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'asset/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.matnr);
							_this.getForm().findField('asstx').setValue(record.data.maktx);

						}else{
							o.markInvalid('Could not find Fixed Asset : '+o.getValue());
						}
					}
				});
			}
		}, this);

			_this.assetDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigAsset.setValue(record.data.matnr);
			_this.getForm().findField('asstx').setValue(record.data.maktx);
			
			grid.getSelectionModel().deselectAll();
			_this.assetDialog.hide();
		});

		this.trigAsset.onTriggerClick = function(){
			//_this.assetDialog.grid.load();
			_this.assetDialog.show();
		};
		
		// event trigDepartment//
		this.trigDep.on('keyup',function(o, e){
			
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'sdepartment/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.depnr);
							_this.getForm().findField('deptx').setValue(record.data.deptx);

						}else{
							o.markInvalid('Could not find Department : '+o.getValue());
						}
					}
				});
			}
		}, this);

			_this.depDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigDep.setValue(record.data.depnr);
			_this.getForm().findField('deptx').setValue(record.data.deptx);
			
			grid.getSelectionModel().deselectAll();
			_this.depDialog.hide();
		});

		this.trigDep.onTriggerClick = function(){
			_this.depDialog.grid.load();
			_this.depDialog.show();
		};
		
		this.txtDepreValue.on('change', this.getLife, this);
		
	return this.callParent(arguments);
	},
	
	// load //
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'asset/load'
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
			url:__site_url+'asset/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	getLife: function(){
		var _this=this;
		var life = 0;
		var dep = this.txtDepreValue.getValue();
		if(dep>0){
		life = 1 / ( dep / 100 );
		this.txtLifeValue.setValue(life);
		}
		
	}
});