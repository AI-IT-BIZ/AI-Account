Ext.define('Account.AP.Item.Grid_i', {
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
		// INIT Material search popup //////////////////////////////////
		this.materialDialog = Ext.create('Account.SMatAsset.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
		// END Material search popup ///////////////////////////////////
        this.unitDialog = Ext.create('Account.SUnit.Window');
		this.tbar = [this.addAct, this.copyAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"ap/loads_ap_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'invnr,vbelp'
				}
			},
			fields: [
			    'invnr',
				'vbelp',
				'matnr',
				'maktx',
				'menge',
				'meins',
				'unitp',
				'disit',
				'itamt',
				'ctype',
				'chk01',
				'chk02',
				'saknr'
			],
			remoteSort: true,
			sorters: ['vbelp ASC']
		});

		this.columns = [{
			xtype: 'actioncolumn',
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/bin.gif',
				tooltip: 'Delete AP Item',
				scope: this,
				handler: this.removeRecord
			}]
		},{
			id : 'APiRowNumber',
			header : "Items",
			dataIndex : 'vbelp',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},
		{text: "Material Code",
		width: 80,
		dataIndex: 'matnr',
		sortable: false,
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.materialDialog.show();
				}
			},
			},
		    {text: "Description",
		    width: 220,
		    dataIndex: 'maktx',
		    sortable: false,
		    field: {
				type: 'textfield'
			},
		    },
			{text: "Qty",
			xtype: 'numbercolumn',
			width: 70,
			dataIndex: 'menge',
			sortable: false,
			align: 'right',
			field: {
				type: 'numberfield',
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
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.unitDialog.show();
				}
			},
			},
			{text: "Price/Unit",
			xtype: 'numbercolumn',
			width: 100,
			dataIndex: 'unitp',
			sortable: false,
			align: 'right',
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
			{text: "Discount",
			xtype: 'numbercolumn',
			width: 80,
			dataIndex: 'disit',
			sortable: false,
			align: 'right',
			field: Ext.create('BASE.form.field.PercentOrNumber'),
				renderer: function(v,p,r){
					var regEx = /%$/gi;
					if(regEx.test(v))
						return v;
					else
						return Ext.util.Format.usMoney(v).replace(/\$/, '');
				}
			},{
            xtype: 'checkcolumn',
            text: 'Vat',
            dataIndex: 'chk01',
            width: 30,
            field: {
                xtype: 'checkboxfield',
                listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}}
            },{
            xtype: 'checkcolumn',
            text: 'WHT',
            dataIndex: 'chk02',
            width: 30,
            field: {
                xtype: 'checkboxfield',
                listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}}
            },
			{
				text: "Amount",
				width: 90,
				dataIndex: 'itamt',
				sortable: false,
				align: 'right',
				renderer: function(v,p,r){
					var qty = parseFloat(r.data['menge']),
						price = parseFloat(r.data['unitp']);
						//discount = parseFloat(r.data['dismt']);
					qty = isNaN(qty)?0:qty;
					price = isNaN(price)?0:price;
					//discount = isNaN(discount)?0:discount;

					var amt = qty * price;//) - discount;
					return Ext.util.Format.usMoney(amt).replace(/\$/, '');
				}
			},
			{text: "Currency",
			width: 65,
			dataIndex: 'ctype',
			sortable: false,
			align: 'center',
			field: {
				type: 'textfield'
			},
		},
			{
			dataIndex: 'saknr',
			//width: 55,
			hidden: true,
			sortable: false
		}];

		this.plugins = [this.editing];

		// init event
		this.addAct.setHandler(function(){
			_this.addRecord();
		});
		
		this.copyAct.setHandler(function(){
			_this.copyRecord();
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
							// GL no
							rModel.set('saknr', r.data.saknr);
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
				rModel.set('saknr', record.data.saknr);
				
			}
			grid.getSelectionModel().deselectAll();
			_this.materialDialog.hide();
		});
		
		_this.unitDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			var rModels = _this.getView().getSelectionModel().getSelection();
			if(rModels.length>0){
				rModel = rModels[0];
				// change cell code value (use db value)
				rModel.set('meins', record.data.meins);
			//_this.trigUnit.setValue(record.data.meins);
			}
			grid.getSelectionModel().deselectAll();
			_this.unitDialog.hide();
			
		});
		
		// for set readonly grid
		this.store.on('load', function(store, rs){
			if(_this.readOnly){
				var view = _this.getView();
				var t = _this.getView().getEl().down('table');
				t.addCls('mask-grid-readonly');
				_this.readOnlyMask = new Ext.LoadMask(t, {
					msg:"..."
				});
				_this.readOnlyMask.show();
			}else{
				if(_this.readOnlyMask)
					_this.readOnlyMask.hide();
			}
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
		rec = { id:newId, ctype:'THB' };
		edit = this.editing;
		edit.cancelEdit();
		// find current record
		var sel = this.getView().getSelectionModel().getSelection()[0];
		var selIndex = this.store.indexOf(sel);
		this.store.insert(selIndex+1, rec);
		edit.startEditByPosition({
			row: selIndex+1,
			column: 0
		});

		this.runNumRow();
	},
	
	copyRecord: function(){
		var _this=this;

		var sel = _this.getView().getSelectionModel().getSelection()[0];
		if(sel){
			// หา record ที่สร้างใหม่ล่าสุด
			var newId = -1;
			this.store.each(function(r){
				if(r.get('id')<newId)
					newId = r.get('id');
			});
			newId--;

	        var cur = _this.curValue;
			// add new record
			rec = sel.getData();
			//console.log(rec);
			rec.id = newId;
			//rec = { id:newId, ctype:cur };
			edit = this.editing;
			edit.cancelEdit();
			// find current record
			//var sel = this.getView().getSelectionModel().getSelection()[0];
			var selIndex = this.store.indexOf(sel);
			this.store.insert(selIndex+1, rec);
			edit.startEditByPosition({
				row: selIndex+1,
				column: 0
			});

			this.runNumRow();

			this.getSelectionModel().deselectAll();
		}else{
			Ext.Msg.alert('Warning', 'Please select record to copy.');
		}
	},

	removeRecord: function(grid, rowIndex){
		this.store.removeAt(rowIndex);

		this.runNumRow();
	},

	runNumRow: function(){
		var row_num = 0;
		this.store.each(function(r){
			r.set('ebelp', row_num++);
		});
	},

	getData: function(){
		var rs = [];
		this.store.each(function(r){
			rs.push(r.getData());
		});
		return rs;
	}
});