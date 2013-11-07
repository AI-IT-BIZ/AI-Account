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

		// INIT Material search popup //////////////////////////////////
		this.materialDialog = Ext.create('Account.Material.MainWindow');
		// END Material search popup ///////////////////////////////////

		this.tbar = [this.addAct, this.copyAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"quotation/loads_qt_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: function(o){ return o.vbeln+o.vbelp; }//'vbeln,vbelp'
				}
			},
			fields: [
			    'vbeln',
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
				'chk02'
			],
			remoteSort: true,
			sorters: ['vbelp ASC']
		});

		this.columns = [{
			xtype: 'actioncolumn',
			text: " ",
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/bin.gif',
				tooltip: 'Delete QT Item',
				scope: this,
				handler: this.removeRecord
			}]
		},{
			id : 'RowNumber3',
			text : "Items",
			dataIndex : 'vbelp',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},
		{text: "Material Code",
		width: 110,
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
			width: 60,
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
				type: 'textfield'
			},
			},
			{text: "Price/Unit",
			xtype: 'numbercolumn',
			width: 80,
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
			},{text: "Discount",
			xtype: 'numbercolumn',
			width: 70,
			dataIndex: 'disit',
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
            },{
				text: "Amount",
				width: 120,
				dataIndex: 'itamt',
				sortable: false,
				align: 'right',
				renderer: function(v,p,r){
					//alert(parseFloat(r.data['disit']));
					var qty = parseFloat(r.data['menge'].replace(/[^0-9.]/g, '')),
						price = parseFloat(r.data['unitp'].replace(/[^0-9.]/g, '')),
						discount = parseFloat(r.data['disit'].replace(/[^0-9.]/g, '')),
						chk01 = r.data['chk01'],
						chk02 = r.data['chk02'];

					qty = isNaN(qty)?0:qty;
					price = isNaN(price)?0:price;
					discount = isNaN(discount)?0:discount;

					var amt = (qty * price) - discount;
					return Ext.util.Format.usMoney(amt).replace(/\$/, '');
				}
			},
			{text: "Currency",
			width: 70,
			dataIndex: 'ctype',
			sortable: false,
			align: 'center',
			field: {
				type: 'textfield'
			},
		}];

		this.plugins = [this.editing];

		// init event
		this.addAct.setHandler(function(){
			_this.addRecord();
		});

		this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='matnr'){
				var v = e.value;
                var cusno = _this.customerValue;
                //var vatt = _this.vattValue;
				if(Ext.isEmpty(v)) return;

				Ext.Ajax.request({
					url: __site_url+'material/load',
					method: 'POST',
					params: {
						id: v,
						kunnr: cusno
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){

							var rModel = _this.store.getById(e.record.getId());
							console.log(e.record);
							if(rModel){
								/*
								rModel.beginEdit();
								// change cell code value (use db value)
								rModel.set(e.field, r.data.matnr);
								// Materail text
								rModel.set('maktx', r.data.maktx);
								// Unit
								rModel.set('meins', r.data.meins);
								// Cost
								var cost = r.data.cost;
								rModel.set('unitp', cost);

									console.log(cost);
								rModel.endEdit();
								*/
								rModel.beginEdit();
								var result = rModel.set({
									'maktx': r.data.maktx,
									'meins': r.data.meins,
									'unitp': r.data.cost
								});
								rModel.endEdit();
							}
						}else{
							_this.editing.startEdit(e.record, e.column);
						}
					}
				});

			}
		});

		_this.materialDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			var rModels = _this.getView().getSelectionModel().getSelection();
			console.log(rModels);
			if(rModels.length>0){
				//console.log(record);
				//console.log(rModels);
				rModel = rModels[0];
				//alert(record.data.matnr)
				// change cell code value (use db value)
				rModel.set('matnr', record.data.matnr);
				// Materail text
				rModel.set('maktx', record.data.maktx);
				// Unit
				rModel.set('meins', record.data.meins);
				//rModel.set('amount', 100+Math.random());
				var v = record.data.matnr;
                var cusno = _this.customerValue;
                //var vatt = _this.vattValue;
				if(Ext.isEmpty(v)) return;

				Ext.Ajax.request({
					url: __site_url+'material/load',
					method: 'POST',
					params: {
						id: v,
						kunnr: cusno
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success && r.data.cost){
							// Cost
							var cost = r.data.cost;
							rModel.set('unitp', cost);//Ext.util.Format.usMoney(cost).replace(/\$/, ''));
						}
					}
				});

			}
			grid.getSelectionModel().deselectAll();
			_this.materialDialog.hide();
		});

		return this.callParent(arguments);
	},

	load: function(options){
		this.store.load({
			params: options
		});
	},

	addRecord: function(){
		var _this=this;
		// หา record ที่สร้างใหม่ล่าสุด
		var newId = -1;
		this.store.each(function(r){
			if(r.get('id')<newId)
				newId = r.get('id');
		});
		newId--;

        var cur = _this.curValue;
		// add new record
		rec = { id:newId, ctype:cur };
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

		this.getSelectionModel().deselectAll();
	},

	removeRecord: function(grid, rowIndex){
		this.store.removeAt(rowIndex);

		this.runNumRow();

		grid.getSelectionModel().deselectAll();
	},

	runNumRow: function(){
		var row_num = 0;
		this.store.each(function(r){
			r.set('vbelp', row_num++);
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