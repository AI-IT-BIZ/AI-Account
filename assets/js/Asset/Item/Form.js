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
		
		this.typeDialog = Ext.create('Account.Assettype.Window');
		
		this.trigType = Ext.create('Ext.form.field.Trigger', {
			name: 'mtart',
			fieldLabel: 'Asset Type',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true//,
			//width:290
		});
		
		this.grpDialog = Ext.create('Account.Assetgrp.Window');
		
		this.trigGrp = Ext.create('Ext.form.field.Trigger', {
			name: 'matkl',
			fieldLabel: 'Asset Group',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true//,
			//width:290
		});
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
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
		
		this.glnoDialog = Ext.create('Account.GL.MainWindow');
		
		this.trigGlno = Ext.create('Ext.form.field.Trigger', {
			name: 'saknr',
			fieldLabel: 'GL Account',
			triggerCls: 'x-form-search-trigger',
			allowBlank: false,
			enableKeyEvents: true,
			//width:290,
		});
		
		this.unitDialog = Ext.create('Account.Unit.Window');
		
		this.trigUnit = Ext.create('Ext.form.field.Trigger', {
			name: 'meins',
			fieldLabel: 'Unit',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
			//width:290,
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
			value: 'XXXXX'
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
						name: 'matxt',
						margins: '4 0 0 6',
						width:286//,
						//allowBlank: false
                }]
            }, {
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigGrp,{
						xtype: 'displayfield',
						name: 'matxt2',
						margins: '4 0 0 6',
						width:286//,
						//allowBlank: false
                }]
            }, 
		  this.trigUnit,{
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigGlno,{
						xtype: 'displayfield',
						name: 'sgtxt',
						margins: '4 0 0 6',
						width:286//,
						//allowBlank: false
                }]
            }]
		}, {
// Frame number 2	
			xtype:'fieldset',
            title: 'Balance Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            //defaults: {
            //    anchor: '100%'
            //},
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
            //defaults: {
            //    anchor: '100%'
            //},
            items: [{
            xtype: 'container',
            //anchor: '100%',
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
			//anchor:'100%',
			labelWidth: 90,
			allowBlank: true
		},{
			xtype: 'numberfield',
			fieldLabel: 'Cost 2',
			minValue: 0,
			name: 'cost2',
			//anchor:'100%',
			labelWidth: 90,
			allowBlank: true
		},{
			xtype: 'numberfield',
			fieldLabel: 'Cost 3',
			minValue: 0,
			name: 'cost3',
			//anchor:'100%',
			labelWidth: 90,
			allowBlank: true
		}
		]
		}]
		}]
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
			_this.getForm().findField('matxt').setValue(r.data.matxt);
			//_this.getForm().findField('saknr').setValue(r.data.saknr);
			//_this.getForm().findField('sgtxt').setValue(r.data.sgtxt);

						}else{
							o.markInvalid('Could not find asset type : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.typeDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigType.setValue(record.data.mtart);
			_this.getForm().findField('matxt').setValue(record.data.matxt);
			//_this.getForm().findField('saknr').setValue(record.data.saknr);
			//_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

			grid.getSelectionModel().deselectAll();
			_this.typeDialog.hide();
		});

		this.trigType.onTriggerClick = function(){
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
			_this.getForm().findField('matxt2').setValue(r.data.matxt);
			_this.getForm().findField('saknr').setValue(r.data.saknr);
			_this.getForm().findField('sgtxt').setValue(r.data.sgtxt);

						}else{
							o.markInvalid('Could not find asset group : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.grpDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigGrp.setValue(record.data.matkl);
			_this.getForm().findField('matxt2').setValue(record.data.matxt);
			_this.getForm().findField('saknr').setValue(record.data.saknr);
			_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

			grid.getSelectionModel().deselectAll();
			_this.grpDialog.hide();
		});

		this.trigGrp.onTriggerClick = function(){
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
			_this.glnoDialog.show();
		};		
		
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
	}
});