Ext.define('Account.PR.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'pr/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'right',
				labelWidth: 130,
				width:300,
				labelStyle: 'font-weight:bold'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		// INIT Warehouse search popup ///////////////////////////////////////////////
		this.warehouseDialog = Ext.create('Account.Warehouse.MainWindow');
		// END Warehouse search popup ///////////////////////////////////////////////

		this.hdnPrItem = Ext.create('Ext.form.Hidden', {
			name: 'pr_item'
		});

		this.trigWarehouse = Ext.create('Ext.form.field.Trigger', {
			name: 'customer_code',
			fieldLabel: 'Warehouse Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});

		this.comboMType = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Choose Material',
			//hiddenName : 'mat',
			name: 'mtart',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select material --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'mattype/loads_combo',
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

		this.items = [
			this.hdnPrItem,
		{
			xtype: 'hidden',
			name: 'id'
		},{
			xtype: 'textfield',
			fieldLabel: 'Code',
			name: 'code',
			allowBlank: false
		},
		this.comboMType,
		{
			xtype: 'datefield',
			fieldLabel: 'วันที่สร้าง',
			name: 'create_date',
			allowBlank: false,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
		},
		this.trigWarehouse,
		{
			xtype: 'textfield',
			fieldLabel: 'Warehouse Text',
			name: 'warehouse_text',
			allowBlank: true
		}];

		// event ///
		this.trigWarehouse.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'warehouse/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.warnr);
							_this.getForm().findField('warehouse_text').setValue(r.data.watxt);
						}else{
							o.markInvalid('Could not find customer code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.warehouseDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigWarehouse.setValue(record.data.warnr);
			_this.getForm().findField('warehouse_text').setValue(record.data.watxt);

			grid.getSelectionModel().deselectAll();
			_this.warehouseDialog.hide();
		});

		this.trigWarehouse.onTriggerClick = function(){
			_this.warehouseDialog.show();
		};

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'pr/load'
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
			url:__site_url+'pr/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});