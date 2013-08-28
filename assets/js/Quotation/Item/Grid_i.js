Ext.define('Account.Quotation.Item.Grid_i', {
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
		this.copyAct = new Ext.Action({
			text: 'Copy',
			iconCls: 'b-small-copy'
		});
		this.deleteAct = new Ext.Action({
			text: 'Delete',
			iconCls: 'b-small-minus'
		});
		
		// INIT Material search popup //////////////////////////////////
		this.materialDialog = Ext.create('Account.Material.MainWindow');
		// END Material search popup ///////////////////////////////////

		this.tbar = [this.addAct, this.copyAct, this.deleteAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});
		
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"Quotation/loads_qt_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'vbelp'
				}
			},
			fields: [
			    //'vbeln',
				'vbelp',
				'matnr',
				'maktx',
				'menge',
				'meins',
				'unitp',
				'dismt',
				'itamt',
				'ctype'
			],
			remoteSort: true,
			sorters: ['vbeln ASC']
		});

		this.columns = [
		    {text: "Items", width: 70, dataIndex: 'vbelp', sortable: false,
		    field: {
				type: 'textfield'
			},
		    },
			{text: "Material Code", width: 120, dataIndex: 'matnr', sortable: false,
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				allowBlank : false,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.materialDialog.show();
				}
			},
			},
		    {text: "Description", width: 200, dataIndex: 'maktx', sortable: false,
		    field: {
				type: 'textfield'
			},
		    },
			{text: "Qty", width: 70, dataIndex: 'menge', sortable: false,
			field: {
				type: 'numberfield',
				//decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},
			},
			{text: "Unit", width: 50, dataIndex: 'meins', sortable: false,
			field: {
				type: 'textfield'
			},
			},
			{text: "Price/Unit", width: 120, dataIndex: 'unitp', sortable: false,
			field: {
				type: 'numberfield',
				decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},
			},
			{text: "Discount", width: 100, dataIndex: 'dismt', sortable: false,
			field: {
				type: 'numberfield',
				decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},
			},
			{text: "Amount", width: 120, dataIndex: 'itamt', sortable: false,
			field: {
				type: 'numberfield',
				decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},
			},
			{text: "Currency", width: 100, dataIndex: 'ctype', sortable: false,
			field: {
				type: 'textfield'
			},
		},{
			xtype: 'actioncolumn',
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/delete.gif',
				tooltip: 'Delete QT Item',
				scope: this,
				handler: this.removeRecord
			}]
			}];

		this.plugins = [this.editing];

		// init event
		this.addAct.setHandler(function(){
			_this.addRecord();
		});
		
		this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='matnr'){
				var v = e.value;

				if(Ext.isEmpty(v)) return;

				Ext.Ajax.request({
					url: __site_url+'material/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							var rModel = _this.store.getById(e.record.data.id);

							// change cell code value (use db value)
							rModel.set(e.field, r.data.matnr);

							// Materail text
							rModel.set('maktx', r.data.maktx);

							// Unit
							rModel.set('meins', r.data.meins);
							//rModel.set('amount', 100+Math.random());
							
						}else{
							_this.editing.startEdit(e.record, e.column);
						}
					}
				});
			}
		});

		_this.materialDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			var rModels = _this.getView().getSelectionModel().getSelection();
			if(rModels.length>0){
				rModel = rModels[0];

				// change cell code value (use db value)
				rModel.set('matnr', record.data.matnr);

				// Materail text
				rModel.set('maktx', record.data.maktx);

				// Unit
				rModel.set('meins', record.data.meins);
				//rModel.set('amount', 100+Math.random());

			}
			grid.getSelectionModel().deselectAll();
			_this.materialDialog.hide();
		});

		return this.callParent(arguments);
	},
	
	load: function(options){
		this.store.load(options);
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
		rec = { id:newId, matnr:'',maktx:'',meins:'', ctype:'THB' };
		edit = this.editing;
		edit.cancelEdit();
		var lastRecord = this.store.count();
		this.store.insert(lastRecord, rec);
		edit.startEditByPosition({
			row: lastRecord,
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