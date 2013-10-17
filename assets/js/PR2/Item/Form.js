Ext.define('Account.PR2.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'pr2/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		this.vendorDialog = Ext.create('Account.Vendor.MainWindow');

		this.gridItem = Ext.create('Account.PR2.Item.Grid_i',{
			height: 320,
			region:'center'
		});
		this.formTotal = Ext.create('Account.PR2.Item.Form_t', {
			border: true,
			split: true,
			region:'south'
		});

		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'QT Status',
			name : 'statu',
			labelAlign: 'right',
			width: 240,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			margin: '0 0 0 -17',
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


/*---ComboBox Tax Type----------------------------*/
		this.comboTaxnr = Ext.create('Ext.form.ComboBox', {
							
			fieldLabel: 'Tax Type',
			name: 'taxnr',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select data --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'pr2/loads_combo/tax1/taxnr/taxtx',  
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
		
		this.hdnPrItem = Ext.create('Ext.form.Hidden', {
			name: 'ebpo',
		});

		this.hdnPpItem = Ext.create('Ext.form.Hidden', {
			name: 'payp',
		});

		this.trigVender = Ext.create('Ext.form.field.Trigger', {
			name: 'lifnr',
			fieldLabel: 'Vendor Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});

		
		var mainFormPanel = {
			xtype: 'panel',
			border: true,
			region:'north',
			bodyPadding: '5 10 0 10',
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',
				labelWidth: 105
			},
			items: [this.hdnPrItem, this.hdnPpItem,
			{
				xtype:'fieldset',
				title: 'Header Data',
				items:[{
					// Project Code
	 				xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
		 			items :[{
						xtype: 'hidden',
						name: 'id'
					},this.trigVender,{
						xtype: 'displayfield',
						name: 'name1',
						margins: '0 0 0 6',
						width:286,
						allowBlank: true
					},{
						xtype: 'displayfield',
					fieldLabel: 'Purchase No',
					name: 'purnr',
						fieldLabel: 'Purchase No',
						name: 'purnr',
						value: 'PRXXXX-XXXX',
						width:232,
						readOnly: true,
						labelStyle: 'font-weight:bold'
					}]
				// Address Bill&Ship
	            },{
	 				xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
            		items:[{
		                xtype: 'container',
		                flex: 0,
		                items :[ this.comboLifnr,{
							xtype: 'textarea',
							fieldLabel: 'Address',
							name: 'adr01',
							width: 455, 
							rows:2,
		                }, {
			 				xtype: 'container',
							layout: 'hbox',
							margin: '0 0 5 0',
				 			items :[{
								xtype: 'textfield',
								fieldLabel: 'Reference No',
								name: 'refnr',
			                }, {
								xtype: 'numberfield',
								fieldLabel: 'Credit Terms',
								name: 'crdit',
								labelWidth: 50,
								margin: '0 0 0 40',
			                }]
		                }]
		            },{
		                xtype: 'container',
		                flex: 0,
		            	margin: '0 0 0 70',
		                items: [{
							xtype: 'datefield',
							fieldLabel: 'PR Date',
							name: 'bldat',
							format:'d/m/Y',
							altFormats:'Y-m-d|d/m/Y',
							submitFormat:'Y-m-d',
		                }, {
							xtype: 'datefield',
							fieldLabel: 'Delivery Date',
							name: 'lfdat',
							format:'d/m/Y',
							altFormats:'Y-m-d|d/m/Y',
							submitFormat:'Y-m-d',
                		}, this.comboTaxnr,{
		                }]
		            }]
				}]

			}]
		};
		
		this.items = [mainFormPanel,this.gridItem,this.formTotal
			
		];	

		// event trigVender///
		this.trigVender.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'vendor/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.kunnr);
							_this.getForm().findField('name1').setValue(r.data.name1);
							var _crdit = r.data.crdit;
							_this.getForm().findField('adr01').setValue(r.data.adr0);
						}else{
							o.markInvalid('Could not find customer code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.vendorDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigVender.setValue(record.data.lifnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			_this.getForm().findField('adr01').setValue(record.data.adr01);

			grid.getSelectionModel().deselectAll();
			_this.vendorDialog.hide();
		});

		this.trigVender.onTriggerClick = function(){
			_this.vendorDialog.show();
		};
		
//---------------------------------------------------------------------
		// grid event
		this.gridItem.store.on('update', this.calculateTotal, this);
		this.gridItem.store.on('load', this.calculateTotal, this);
		this.on('afterLoad', this.calculateTotal, this);

		return this.callParent(arguments);
	},
	load : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'pr2/load',
			success: function(form, act){
				_this.fireEvent('afterLoad', form, act);
			}
		});
	},
	save : function(){
		var _this=this;
		var _form_basic = this.getForm();

		// add grid data to json
		var rsItem = this.gridItem.getData();
		this.hdnPrItem.setValue(Ext.encode(rsItem));
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
	remove : function(purnr){
		var _this=this;
		this.getForm().load({
			params: { purnr: purnr },
			url:__site_url+'pr2/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	reset: function(){
		this.getForm().reset();
		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ purnr: 0 });
		
		// สร้างรายการเปล่า 5 รายการใน grid item
		//this.gridItem.addDefaultRecord();

		// default status = wait for approve
		this.comboQStatus.setValue('01');
	},
	// calculate total functions
	calculateTotal: function(){
		var store = this.gridItem.store;
		var sum = 0;
		store.each(function(r){
			var qty = parseFloat(r.data['menge']),
				price = parseFloat(r.data['unitp']),
				discount = parseFloat(r.data['dismt']);
			qty = isNaN(qty)?0:qty;
			price = isNaN(price)?0:price;
			discount = isNaN(discount)?0:discount;

			var amt = (qty * price) - discount;

			sum += amt;
		});
		this.formTotal.getForm().findField('beamt').setValue(Ext.util.Format.usMoney(sum).replace(/\$/, ''));
		this.formTotal.calculate();
	}
});