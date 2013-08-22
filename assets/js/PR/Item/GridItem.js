Ext.define('Account.PR.Item.GridItem', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;

		this.addAct = new Ext.Action({
			text: 'Add',
			iconCls: 'b-small-plus'
		});

		// INIT Warehouse search popup ///////////////////////////////////////////////
		this.warehouseDialog = Ext.create('Account.Warehouse.MainWindow');
		// END Warehouse search popup ///////////////////////////////////////////////

		this.tbar = [this.addAct, this.deleteAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"pr/loads_pr_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id'
				}
			},
			fields: [
				{ name:'id', type:'int' },
				'code',
				{ name:'pr_id', type:'int' },
				{ name:'price', type:'float' },
				{ name:'amount', type:'float' }
			],
			remoteSort: false
		});

		this.columns = [{
			text: "Code", flex: true, dataIndex: 'code', sortable: true,
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				allowBlank : false,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.warehouseDialog.show();
				}
			},
			sortable: false
		}, {
			text: "Price", width: 100, dataIndex: 'price', sortable: true,
			field: {
				xtype: 'numberfield',
				decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},
			renderer: function(v,p,r){ return (v)?Ext.util.Format.usMoney(v).replace(/^\$/, ''):''; },
			sortable: false
		}, {
			text: "Amount", width: 100, dataIndex: 'amount', sortable: true,
			field: {
				xtype: 'numberfield',
				decimalPrecision: 2
			},
			renderer: function(v,p,r){ return (v)?Ext.util.Format.usMoney(v).replace(/^\$/, ''):''; },
			sortable: false
		}, {
			xtype: 'actioncolumn',
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/delete.gif',
				tooltip: 'Delete PR Item',
				scope: this,
				handler: this.removeRecord
			}]
		}];

		this.plugins = [this.editing];


		// init event ///////
		this.addAct.setHandler(function(){
			_this.addRecord();
		});

		this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='code'){
				var v = e.value;

				if(Ext.isEmpty(v)) return;

				Ext.Ajax.request({
					url: __site_url+'warehouse/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							var rModel = _this.store.getById(e.record.data.id);

							// change cell code value (use db value)
							rModel.set(e.field, r.data.warnr);

							// change cell price value
							rModel.set('price', 100+Math.random());

							// change cell amount value
							rModel.set('amount', 100+Math.random());
						}else{
							_this.editing.startEdit(e.record, e.column);
						}
					}
				});
			}
		});

		_this.warehouseDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			var rModels = _this.getView().getSelectionModel().getSelection();
			if(rModels.length>0){
				rModel = rModels[0];

				// change cell code value (use db value)
				rModel.set('code', record.data.warnr);

				// change cell price value
				rModel.set('price', 100+Math.random());

				// change cell amount value
				rModel.set('amount', 100+Math.random());
			}
			grid.getSelectionModel().deselectAll();
			_this.warehouseDialog.hide();
		});

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load({
			params: options
		});
	},
	addRecord: function(){
		// หา record ที่สร้างใหม่ล่าสุด
		var newId = -1;
		this.store.each(function(r){
			if(r.get('id')<newId)
				newId = r.get('id');
		});
		newId--;

		// add new record
		rec = { id:newId, code:'', price:0, amount:1 };
		edit = this.editing;
		edit.cancelEdit();
		this.store.insert(0, rec);
		edit.startEditByPosition({
			row: 0,
			column: 0
		});
	},
	removeRecord: function(grid, rowIndex){
		this.store.removeAt(rowIndex);
	},
	getData: function(){
		var rs = [];
		this.store.each(function(r){
			rs.push(r.getData());
		});
		return rs;
	}
});